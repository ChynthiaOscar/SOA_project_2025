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
MEMBERS = {}  # Storage for member data

class AuthService:
    name = "auth_service"

    @rpc
    def handle_login(self, data):
        """
        Store login token information
        Now as RPC instead of consume
        """
        print("Received login:", data)
        member_id = data.get('member_id')
        token = data.get('token')
        token_expires_at = data.get('token_expires_at')
        if member_id and token:
            TOKENS[token] = {
                "member_id": member_id,
                "expires_at": token_expires_at,
                "email": data.get('email')
            }
            print(f"Token stored for member {member_id}")
            return {"success": True, "message": "Token stored successfully"}
        return {"success": False, "message": "Invalid login data"}
    
    @rpc
    def handle_profile_update(self, data):
        """
        Handle profile update
        Now as RPC instead of consume
        """
        print("Received profile update:", data)
        member_id = data.get('member_id')
        if member_id:
            MEMBER_PROFILES[member_id] = {
                "email": data.get('email'),
                "no_hp": data.get('no_hp')
            }
            # Update member record if it exists
            if str(member_id) in MEMBERS:
                MEMBERS[str(member_id)]['email'] = data.get('email')
                MEMBERS[str(member_id)]['no_hp'] = data.get('no_hp')
            print(f"Profile updated for member {member_id}")
            return {"success": True, "message": "Profile updated successfully"}
        return {"success": False, "message": "Invalid profile data"}

    @rpc
    def validate_token(self, token):
        info = TOKENS.get(token)
        if not info:
            return {"valid": False, "reason": "Token not found"}
        
        # Parse the expiration time string to a datetime object
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
        """
        Register a new member (langsung ke database, hash password dengan bcrypt)
        """
        try:
            conn = self.get_db_connection()
            cursor = conn.cursor(dictionary=True)
            # Cek email sudah terdaftar
            cursor.execute("SELECT id FROM members WHERE email = %s", (data['email'],))
            if cursor.fetchone():
                cursor.close()
                conn.close()
                return {"success": False, "message": "Email already registered"}
            # Hash password dengan bcrypt
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
                # Tangkap error duplicate entry
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
        """
        Authenticate a member and generate a token (verifikasi password dengan bcrypt)
        """
        try:
            conn = self.get_db_connection()
            cursor = conn.cursor(dictionary=True)
            cursor.execute("SELECT * FROM members WHERE email = %s", (email,))
            member = cursor.fetchone()
            cursor.close()
            conn.close()
            if not member:
                return {"success": False, "message": "Invalid credentials"}
            # Verifikasi password dengan bcrypt
            if not bcrypt.checkpw(password.encode(), member['password'].encode()):
                return {"success": False, "message": "Invalid credentials"}
            # Generate token
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
        """
        Invalidate a token
        """
        if token in TOKENS:
            del TOKENS[token]
            return {"success": True, "message": "Logged out successfully"}
        return {"success": False, "message": "Invalid token"}
    
    def get_db_connection(self):
        return mysql.connector.connect(
            host='localhost',         # ganti jika host MySQL Anda berbeda
            user='root',              # ganti sesuai user MySQL Anda
            password='',              # ganti sesuai password MySQL Anda
            database='soa_project_2025'  # ganti sesuai nama database Anda
        )

    @rpc
    def get_profile(self, member_id):
        """
        Get member profile data
        """
        # Cek di memory dulu
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
        # Jika tidak ada di memory, cek ke database
        try:
            conn = self.get_db_connection()
            cursor = conn.cursor(dictionary=True)
            cursor.execute("SELECT id, nama, email, tanggal_lahir, no_hp FROM members WHERE id = %s", (member_id,))
            row = cursor.fetchone()
            cursor.close()
            conn.close()
            if row:
                # Konversi tanggal_lahir ke string agar bisa di-serialize ke JSON
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
        """
        Update member profile
        """
        if str(member_id) not in MEMBERS:
            return {"success": False, "message": "Member not found"}
        
        # Update fields
        for field in ['nama', 'email', 'tanggal_lahir', 'no_hp']:
            if field in data:
                MEMBERS[str(member_id)][field] = data[field]
        
        return {"success": True, "message": "Profile updated successfully"}