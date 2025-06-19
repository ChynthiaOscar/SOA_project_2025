from nameko.rpc import rpc
import json
import time
import datetime
import uuid
import hashlib
import mysql.connector
import bcrypt

TOKENS = {}
MEMBER_PROFILES = {}
MEMBERS = {}

class AuthService:
    name = "auth_service"

    @rpc
    def handle_login(self, data):
        member_id = data.get('member_id')
        token = data.get('token')
        token_expires_at = data.get('token_expires_at')
        if member_id and token:
            TOKENS[token] = {
                "member_id": member_id,
                "expires_at": token_expires_at,
                "email": data.get('email')
            }
            return {"success": True, "message": "Token stored successfully"}
        return {"success": False, "message": "Invalid login data"}
    
    @rpc
    def handle_profile_update(self, data):
        member_id = data.get('member_id')
        if member_id:
            MEMBER_PROFILES[member_id] = {
                "email": data.get('email'),
                "no_hp": data.get('no_hp')
            }
            if str(member_id) in MEMBERS:
                MEMBERS[str(member_id)]['email'] = data.get('email')
                MEMBERS[str(member_id)]['no_hp'] = data.get('no_hp')
            return {"success": True, "message": "Profile updated successfully"}
        return {"success": False, "message": "Invalid profile data"}

    @rpc
    def validate_token(self, token):
        info = TOKENS.get(token)
        if not info:
            return {"valid": False, "reason": "Token not found"}
        try:
            expires_at = datetime.datetime.strptime(info["expires_at"], '%Y-%m-%d %H:%M:%S')
            now = datetime.datetime.now()
            if now > expires_at:
                return {"valid": False, "reason": "Token expired"}
            return {"valid": True, "member_id": info["member_id"], "email": info["email"]}
        except Exception as e:
            return {"valid": False, "reason": f"Error validating token: {str(e)}"}
    
    @rpc
    def register(self, data):
        try:
            conn = self.get_db_connection()
            cursor = conn.cursor(dictionary=True)
            cursor.execute("SELECT id FROM members WHERE email = %s", (data['email'],))
            if cursor.fetchone():
                cursor.close()
                conn.close()
                return {"success": False, "message": "Email already registered"}
            password_hash = bcrypt.hashpw(data['password'].encode(), bcrypt.gensalt()).decode()
            try:
                cursor.execute(
                    "INSERT INTO members (nama, email, tanggal_lahir, no_hp, password) VALUES (%s, %s, %s, %s, %s)",
                    (data['nama'], data['email'], data['tanggal_lahir'], data['no_hp'], password_hash)
                )
                conn.commit()
                member_id = cursor.lastrowid
                cursor.close()
                conn.close()
                return {"success": True, "message": "Registration successful", "member_id": member_id}
            except Exception as e:
                if "Duplicate entry" in str(e):
                    cursor.close()
                    conn.close()
                    return {"success": False, "message": "Email already registered"}
                cursor.close()
                conn.close()
                return {"success": False, "message": f"Database error: {str(e)}"}
        except Exception as e:
            return {"success": False, "message": f"Database error: {str(e)}"}

    @rpc
    def login(self, email, password):
        try:
            conn = self.get_db_connection()
            cursor = conn.cursor(dictionary=True)
            cursor.execute("SELECT * FROM members WHERE email = %s", (email,))
            member = cursor.fetchone()
            cursor.close()
            conn.close()
            if not member:
                return {"success": False, "message": "Invalid credentials"}
            if not bcrypt.checkpw(password.encode(), member['password'].encode()):
                return {"success": False, "message": "Invalid credentials"}
            token = str(uuid.uuid4())
            expires_at = datetime.datetime.now() + datetime.timedelta(seconds=300)
            expires_at_str = expires_at.strftime('%Y-%m-%d %H:%M:%S')
            TOKENS[token] = {
                "member_id": member['id'],
                "expires_at": expires_at_str,
                "email": member['email']
            }
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
    def logout(self, token):
        if token in TOKENS:
            del TOKENS[token]
            return {"success": True, "message": "Logged out successfully"}
        return {"success": False, "message": "Invalid token"}
    
    def get_db_connection(self):
        return mysql.connector.connect(
            host='localhost',
            user='root',
            password='',
            database='soa_project_2025'
        )

    @rpc
    def get_profile(self, member_id):
        if str(member_id) in MEMBERS:
            member = MEMBERS[str(member_id)]
            return {
                "success": True,
                "member": {
                    "id": member_id,
                    "nama": member.get('nama', ''),
                    "email": member.get('email', ''),
                    "tanggal_lahir": member.get('tanggal_lahir', ''),
                    "no_hp": member.get('no_hp', '')
                }
            }
        try:
            conn = self.get_db_connection()
            cursor = conn.cursor(dictionary=True)
            cursor.execute("SELECT id, nama, email, tanggal_lahir, no_hp FROM members WHERE id = %s", (member_id,))
            row = cursor.fetchone()
            cursor.close()
            conn.close()
            if row:
                if 'tanggal_lahir' in row and row['tanggal_lahir'] is not None:
                    row['tanggal_lahir'] = str(row['tanggal_lahir'])
                return {
                    "success": True,
                    "member": row
                }
            else:
                return {"success": False, "message": "Member not found"}
        except Exception as e:
            return {"success": False, "message": f"Database error: {str(e)}"}
    
    @rpc
    def update_profile(self, member_id, data):
        try:
            conn = self.get_db_connection()
            cursor = conn.cursor()
            fields = []
            values = []
            for field in ['nama', 'email', 'tanggal_lahir', 'no_hp']:
                if field in data:
                    fields.append(f"{field} = %s")
                    values.append(data[field])
            if not fields:
                cursor.close()
                conn.close()
                return {"success": False, "message": "No data to update"}
            values.append(member_id)
            sql = f"UPDATE members SET {', '.join(fields)} WHERE id = %s"
            cursor.execute(sql, tuple(values))
            conn.commit()
            affected = cursor.rowcount
            cursor.close()
            conn.close()
            if affected == 0:
                return {"success": False, "message": "Member not found"}
            return {"success": True, "message": "Profile updated successfully"}
        except Exception as e:
            return {"success": False, "message": f"Database error: {str(e)}"}
    
    @rpc
    def delete_member(self, member_id):
        try:
            conn = self.get_db_connection()
            cursor = conn.cursor()
            cursor.execute("DELETE FROM members WHERE id = %s", (member_id,))
            conn.commit()
            affected = cursor.rowcount
            cursor.close()
            conn.close()
            if affected == 0:
                return {"success": False, "message": "Member not found"}
            return {"success": True, "message": "Member deleted successfully"}
        except Exception as e:
            return {"success": False, "message": f"Database error: {str(e)}"}