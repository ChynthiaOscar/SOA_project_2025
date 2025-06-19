import json
from nameko.rpc import RpcProxy
from nameko.web.handlers import http
from werkzeug.wrappers import Response 

class GatewayService:
    name = "gateway_service"
    inventory_rpc = RpcProxy("inventory_service")

    def _cors_response(self, response_data, status_code=200):
        response = Response(
            json.dumps(response_data),
            mimetype='application/json',
            status=status_code
        )
        response.headers.add('Access-Control-Allow-Origin', '*')
        response.headers.add('Access-Control-Allow-Headers', 'Content-Type,Authorization')
        response.headers.add('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE,OPTIONS')
        return response
    
    @http('OPTIONS', '/<path:path>') 
    def options_handler(self, request, path):
        return self._cors_response({})

    @http('GET', '/items')
    def get_items(self, request):
        items = self.inventory_rpc.get_items()
        return self._cors_response(items)

    @http('GET', '/items/<int:item_id>')
    def get_item(self, request, item_id):
        item = self.inventory_rpc.get_item(item_id_param=item_id)
        if "error" in item:
            return self._cors_response(item, status_code=404)
        return self._cors_response(item)

    @http('POST', '/items')
    def create_item(self, request):
        data = request.get_json()
        result = self.inventory_rpc.create_item(data)
        if "error" in result:
            return self._cors_response(result, status_code=400)
        return self._cors_response(result, status_code=201)

    @http('PUT', '/items/<int:item_id>')
    def update_item(self, request, item_id):
        data = request.get_json()
        result = self.inventory_rpc.update_item(item_id_param=item_id, data=data)
        if "error" in result:
            return self._cors_response(result, status_code=404 if "not found" in result.get("error","").lower() else 400)
        return self._cors_response(result)

    @http('DELETE', '/items/<int:item_id>')
    def delete_item(self, request, item_id):
        result = self.inventory_rpc.delete_item(item_id_param=item_id)
        if "error" in result:
             return self._cors_response(result, status_code=404 if "not found" in result.get("error","").lower() else 400)
        return self._cors_response(result)

   
    @http('GET', '/categories')
    def get_categories(self, request):
        categories = self.inventory_rpc.get_categories()
        return self._cors_response(categories)

    @http('GET', '/categories/<int:category_id>') 
    def get_category(self, request, category_id):
        category = self.inventory_rpc.get_category(category_id_param=category_id)
        if "error" in category:
            return self._cors_response(category, status_code=404)
        return self._cors_response(category)

    @http('POST', '/categories')
    def create_category(self, request):
        data = request.get_json()
        result = self.inventory_rpc.create_category(data)
        if "error" in result:
            return self._cors_response(result, status_code=400)
        return self._cors_response(result, status_code=201)

    @http('PUT', '/categories/<int:category_id>')
    def update_category(self, request, category_id):
        data = request.get_json()
        result = self.inventory_rpc.update_category(category_id_param=category_id, data=data)
        if "error" in result:
            return self._cors_response(result, status_code=404 if "not found" in result.get("error","").lower() else 400)
        return self._cors_response(result)

    @http('DELETE', '/categories/<int:category_id>')
    def delete_category(self, request, category_id):
        result = self.inventory_rpc.delete_category(category_id_param=category_id)
        if "error" in result:
            return self._cors_response(result, status_code=404 if "not found" in result.get("error","").lower() else 400)
        return self._cors_response(result)
