from nameko.rpc import rpc
from nameko.extensions import DependencyProvider
from database import Database
import json
import time
import datetime
import uuid
import hashlib
import bcrypt

class AuthService:
    name = "auth_service"
    database = Database()

    @rpc
    def register(self, data):
        try:
            member = self.database.get_member_by_email(data['email'])
            if member:
                return {"success": False, "message": "Email already registered"}
            password_hash = bcrypt.hashpw(data['password'].encode(), bcrypt.gensalt()).decode()
            new_member = self.database.register_member(
                data['email'],
                data['nama'],  # Ganti dari nama_lengkap ke nama
                data['tanggal_lahir'],
                data['no_hp'],
                password_hash
            )
            return {"success": True, "message": "Registration successful", "member_id": new_member['id']}
        except Exception as e:
            return {"success": False, "message": f"Database error: {str(e)}"}

    @rpc
    def login(self, email, password):
        try:
            member = self.database.get_member_by_email(email)
            if not member:
                return {"success": False, "message": "Invalid credentials"}
            if not bcrypt.checkpw(password.encode(), member['password'].encode()):
                return {"success": False, "message": "Invalid credentials"}
            token = str(uuid.uuid4())
            expires_at = datetime.datetime.now() + datetime.timedelta(seconds=300)
            expires_at_str = expires_at.strftime('%Y-%m-%d %H:%M:%S')
            self.database.save_token(member['id'], token, expires_at_str)
            return {
                "success": True,
                "member_id": member['id'],
                "token": token,
                "token_expires_at": expires_at_str,
                "email": member['email']
            }
        except Exception as e:
            return {"success": False, "message": f"Database error: {str(e)}"}
    
    @rpc
    def get_profile(self, member_id):
        try:
            member = self.database.get_member_by_id(member_id)
            if member:
                return {"success": True, "member": member}
            else:
                return {"success": False, "message": "Member not found"}
        except Exception as e:
            return {"success": False, "message": f"Database error: {str(e)}"}

    @rpc
    def update_profile(self, member_id, data):
        try:
            updated = self.database.update_member(member_id, data)
            if updated:
                return {"success": True, "message": "Profile updated successfully"}
            else:
                return {"success": False, "message": "Member not found"}
        except Exception as e:
            return {"success": False, "message": f"Database error: {str(e)}"}

    @rpc
    def delete_member(self, member_id):
        try:
            self.database.delete_token(member_id)
            deleted = self.database.delete_member_by_id(member_id)
            if deleted:
                return {"success": True, "message": "Member deleted successfully"}
            else:
                return {"success": False, "message": "Failed to delete member"}
        except Exception as e:
            return {"success": False, "message": f"Database error: {str(e)}"}
    
    @rpc
    def logout(self, token):
        try:
            member = self.database.get_member_by_token(token)
            if not member:
                return {"success": False, "message": "Invalid token"}
            result = self.database.delete_token(member['id'])
            if result:
                return {"success": True, "message": "Logged out successfully"}
            else:
                return {"success": False, "message": "Failed to delete token"}
        except Exception as e:
            return {"success": False, "message": f"Database error: {str(e)}"}

    @rpc
    def validate_token(self, token):
        try:
            member = self.database.get_member_by_token(token)
            if not member:
                return {"valid": False, "reason": "Token not found"}
            expires_at = member.get('token_expires_at')
            if expires_at:
                expires_at = datetime.datetime.strptime(str(expires_at), '%Y-%m-%d %H:%M:%S')
                now = datetime.datetime.now()
                if now > expires_at:
                    # Hapus token jika expired
                    self.database.delete_token(member['id'])
                    return {"valid": False, "reason": "Token expired"}
                return {"valid": True, "member_id": member['id'], "email": member['email']}
            else:
                return {"valid": False, "reason": "No expiry set"}
        except Exception as e:
            return {"valid": False, "reason": f"Error validating token: {str(e)}"}