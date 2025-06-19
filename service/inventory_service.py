from nameko.rpc import rpc
from nameko_sqlalchemy import DatabaseSession
from sqlalchemy import Column, Integer, String, Float, DateTime, ForeignKey, Date, func 
from sqlalchemy.orm import relationship, joinedload 
from sqlalchemy.ext.declarative import declarative_base
import datetime

Base = declarative_base()

class InventoryCategory(Base):
    __tablename__ = 'inventory_categories'
    inventoryCategory_id = Column('inventoryCategory_id', Integer, primary_key=True)
    inventoryCategory_name = Column('inventoryCategory_name', String(255))
    inventoryCategory_description = Column('inventoryCategory_description', String(255), nullable=True)
    items = relationship(
        'InventoryItem', 
        back_populates='category',
        foreign_keys='InventoryItem.inventoryCategory_inventoryCategory_id',
        cascade="all, delete-orphan" 
    )

class InventoryItem(Base):
    __tablename__ = 'inventory_items'
    inventoryItem_id = Column('inventoryItem_id', Integer, primary_key=True)
    inventoryItem_name = Column('inventoryItem_name', String(255))
    inventoryItem_description = Column('inventoryItem_description', String(255), nullable=True)
    inventoryCategory_inventoryCategory_id = Column(
        'inventoryCategory_inventoryCategory_id', 
        Integer, 
        ForeignKey('inventory_categories.inventoryCategory_id', ondelete='SET NULL'), 
        nullable=True
    )
    inventoryItem_currentQuantity = Column('inventoryItem_currentQuantity', Float)
    inventoryItem_unitOfMeasure = Column('inventoryItem_unitOfMeasure', String(255))
    inventoryItem_reorderPoint = Column('inventoryItem_reorderPoint', Float, nullable=True)
    inventoryItem_initialStockLevel = Column('inventoryItem_initialStockLevel', Float, nullable=True)
    inventoryItem_lastUpdated = Column('inventoryItem_lastUpdated', Date, default=datetime.date.today, onupdate=datetime.date.today)
    created_at = Column(DateTime, default=datetime.datetime.utcnow, nullable=True)
    updated_at = Column(DateTime, default=datetime.datetime.utcnow, onupdate=datetime.datetime.utcnow, nullable=True)
    category = relationship(
        'InventoryCategory', 
        back_populates='items',
        foreign_keys=[inventoryCategory_inventoryCategory_id]
    )

class InventoryService:
    name = "inventory_service"
    db = DatabaseSession(Base)

    def _get_next_available_id(self, model_class, id_column_attribute):
        session = self.db
        existing_ids = [row[0] for row in session.query(id_column_attribute).order_by(id_column_attribute).all()]
        if not existing_ids:
            return 1
        expected_id = 1
        for current_id in existing_ids:
            if current_id > expected_id:
                return expected_id
            expected_id = current_id + 1
        return expected_id

    @rpc
    def get_items(self):
        items = self.db.query(InventoryItem).options(joinedload(InventoryItem.category)).all() 
        return [
            {
                "id": item.inventoryItem_id,
                "name": item.inventoryItem_name,
                "description": item.inventoryItem_description,
                "category_name": item.category.inventoryCategory_name if item.category else None,
                "category_id": item.inventoryCategory_inventoryCategory_id,
                "quantity": item.inventoryItem_currentQuantity,
                "unit": item.inventoryItem_unitOfMeasure,
                "reorder_point": item.inventoryItem_reorderPoint,
                "initial_stock": item.inventoryItem_initialStockLevel,
                "last_updated": item.inventoryItem_lastUpdated.strftime('%Y-%m-%d') if item.inventoryItem_lastUpdated else None,
                "created_at": item.created_at.strftime('%Y-%m-%d %H:%M:%S') if item.created_at else None,
                "updated_at": item.updated_at.strftime('%Y-%m-%d %H:%M:%S') if item.updated_at else None
            } for item in items
        ]

    @rpc
    def get_item(self, item_id_param):
        item = self.db.query(InventoryItem).options(joinedload(InventoryItem.category)).filter(InventoryItem.inventoryItem_id == item_id_param).first()
        if not item:
            return {"error": "Item not found", "id": item_id_param}
        return {
            "id": item.inventoryItem_id,
            "name": item.inventoryItem_name,
            "description": item.inventoryItem_description,
            "category_id": item.inventoryCategory_inventoryCategory_id,
            "category_name": item.category.inventoryCategory_name if item.category else None,
            "quantity": item.inventoryItem_currentQuantity,
            "unit": item.inventoryItem_unitOfMeasure,
            "reorder_point": item.inventoryItem_reorderPoint,
            "initial_stock": item.inventoryItem_initialStockLevel,
            "last_updated": item.inventoryItem_lastUpdated.strftime('%Y-%m-%d') if item.inventoryItem_lastUpdated else None
        }

    @rpc
    def create_item(self, data):
        if not data.get('name') or not data.get('unit') or data.get('quantity') is None:
            return {"error": "Name, unit, and quantity are required for an item."}
        
        try:
            next_id = self._get_next_available_id(InventoryItem, InventoryItem.inventoryItem_id)
        except Exception as e:
             self.db.rollback() 
             return {"error": f"Failed to determine next available item ID: {str(e)}"}

        new_item = InventoryItem(
            inventoryItem_id=next_id,
            inventoryItem_name=data.get('name'),
            inventoryItem_description=data.get('description'),
            inventoryCategory_inventoryCategory_id=data.get('category_id') if data.get('category_id') else None,
            inventoryItem_currentQuantity=float(data.get('quantity')),
            inventoryItem_unitOfMeasure=data.get('unit'),
            inventoryItem_reorderPoint=float(data.get('reorder_point')) if data.get('reorder_point') is not None else None,
            inventoryItem_initialStockLevel=float(data.get('initial_stock')) if data.get('initial_stock') is not None else None,
            inventoryItem_lastUpdated=datetime.date.today()
        )
        try:
            self.db.add(new_item)
            self.db.commit()
            return {"id": new_item.inventoryItem_id, "message": "Item created successfully"}
        except Exception as e:
            self.db.rollback()
            error_message = str(e.orig) if hasattr(e, 'orig') else str(e)
            if "Duplicate entry" in error_message and f"'{next_id}' for key" in error_message:
                 return {"error": f"Concurrency issue or ID {next_id} was just taken. Please try again."}
            return {"error": f"Failed to create item: {error_message}"}

    @rpc
    def update_item(self, item_id_param, data):
        item = self.db.query(InventoryItem).filter(InventoryItem.inventoryItem_id == item_id_param).first()
        if not item:
            return {"error": "Item not found", "id": item_id_param}
        
        if 'name' in data: item.inventoryItem_name = data['name']
        if 'description' in data: item.inventoryItem_description = data['description']
        if 'category_id' in data: 
            item.inventoryCategory_inventoryCategory_id = data['category_id'] if data['category_id'] else None
        if 'quantity' in data and data['quantity'] is not None: item.inventoryItem_currentQuantity = float(data['quantity'])
        if 'unit' in data: item.inventoryItem_unitOfMeasure = data['unit']
        if 'reorder_point' in data: 
            item.inventoryItem_reorderPoint = float(data['reorder_point']) if data['reorder_point'] is not None else None
        
        try:
            self.db.commit()
            self.db.refresh(item)
            return {"id": item.inventoryItem_id, "message": "Item updated successfully"}
        except Exception as e:
            self.db.rollback()
            error_message = str(e.orig) if hasattr(e, 'orig') else str(e)
            return {"error": f"Failed to update item: {error_message}"}

    @rpc
    def delete_item(self, item_id_param):
        item = self.db.query(InventoryItem).filter(InventoryItem.inventoryItem_id == item_id_param).first()
        if not item:
            return {"error": "Item not found", "id": item_id_param}
        try:
            self.db.delete(item)
            self.db.commit()
            return {"result": "deleted", "message": f"Item {item_id_param} deleted successfully"}
        except Exception as e:
            self.db.rollback()
            error_message = str(e.orig) if hasattr(e, 'orig') else str(e)
            return {"error": f"Failed to delete item: {error_message}"}


    @rpc
    def get_categories(self):
        categories = self.db.query(InventoryCategory)\
                             .options(joinedload(InventoryCategory.items))\
                             .order_by(InventoryCategory.inventoryCategory_name)\
                             .all()
        
        result = []
        for cat in categories:
            category_data = {
                "id": cat.inventoryCategory_id,
                "name": cat.inventoryCategory_name,
                "description": cat.inventoryCategory_description,
                "items_count": len(cat.items), 
                "items": [] 
            }
            sorted_items = sorted(cat.items, key=lambda item: item.inventoryItem_name)
            
            for item in sorted_items: 
                category_data["items"].append({
                    "id": item.inventoryItem_id,
                    "name": item.inventoryItem_name,
                    "description": item.inventoryItem_description,
                    "quantity": item.inventoryItem_currentQuantity,
                    "unit": item.inventoryItem_unitOfMeasure
                })
            result.append(category_data)
        return result


    @rpc
    def get_category(self, category_id_param):
        cat = self.db.query(InventoryCategory)\
                    .options(joinedload(InventoryCategory.items))\
                    .filter(InventoryCategory.inventoryCategory_id == category_id_param)\
                    .first()
        if not cat:
            return {"error": "Category not found", "id": category_id_param}
        
        items_data = []
        sorted_items = sorted(cat.items, key=lambda item: item.inventoryItem_name)

        for item in sorted_items:
            items_data.append({
                "id": item.inventoryItem_id,
                "name": item.inventoryItem_name,
                "description": item.inventoryItem_description,
                "quantity": item.inventoryItem_currentQuantity,
                "unit": item.inventoryItem_unitOfMeasure
            })

        return {
            "id": cat.inventoryCategory_id,
            "name": cat.inventoryCategory_name,
            "description": cat.inventoryCategory_description,
            "items_count": len(cat.items),
            "items": items_data
        }

    @rpc
    def create_category(self, data):
        if not data.get('name'):
            return {"error": "Category name is required."}
        
        try:
            next_id = self._get_next_available_id(InventoryCategory, InventoryCategory.inventoryCategory_id)
        except Exception as e:
            self.db.rollback()
            return {"error": f"Failed to determine next available category ID: {str(e)}"}

        new_cat = InventoryCategory(
            inventoryCategory_id=next_id,
            inventoryCategory_name=data.get('name'),
            inventoryCategory_description=data.get('description')
        )
        try:
            self.db.add(new_cat)
            self.db.commit()
            return {"id": new_cat.inventoryCategory_id, "message": "Category created successfully"}
        except Exception as e:
            self.db.rollback()
            error_message = str(e.orig) if hasattr(e, 'orig') else str(e)
            if "Duplicate entry" in error_message and f"'{next_id}' for key" in error_message:
                 return {"error": f"Concurrency issue or ID {next_id} was just taken for category. Please try again."}
            return {"error": f"Failed to create category: {error_message}"}

    @rpc
    def update_category(self, category_id_param, data):
        cat = self.db.query(InventoryCategory).filter(InventoryCategory.inventoryCategory_id == category_id_param).first()
        if not cat:
            return {"error": "Category not found", "id": category_id_param}
        
        if 'name' in data: cat.inventoryCategory_name = data['name']
        if 'description' in data: cat.inventoryCategory_description = data['description']
        
        try:
            self.db.commit()
            self.db.refresh(cat)
            return {"id": cat.inventoryCategory_id, "message": "Category updated successfully"}
        except Exception as e:
            self.db.rollback()
            error_message = str(e.orig) if hasattr(e, 'orig') else str(e)
            return {"error": f"Failed to update category: {error_message}"}

    @rpc
    def delete_category(self, category_id_param):
        cat = self.db.query(InventoryCategory).filter(InventoryCategory.inventoryCategory_id == category_id_param).first()
        if not cat:
            return {"error": "Category not found", "id": category_id_param}
        try:
            self.db.delete(cat)
            self.db.commit()
            return {"result": "deleted", "message": f"Category '{cat.inventoryCategory_name}' (ID: {category_id_param}) deleted successfully"}
        except Exception as e:
            self.db.rollback()
            error_message = str(e.orig) if hasattr(e, 'orig') else str(e)
            return {"error": f"Failed to delete category: {error_message}"}
