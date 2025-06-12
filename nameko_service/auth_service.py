from nameko.messaging import consume
from nameko.rpc import rpc
from kombu import Queue
import json
import time

TOKENS = {}
MEMBER_PROFILES = {}

class AuthService:
    name = "auth_service"

    @consume(Queue('auth_login'))
    def handle_login(self, payload):
        if isinstance(payload, bytes):
            payload = payload.decode()
        data = json.loads(payload)
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
    
    @consume(Queue('profile_update'))
    def handle_profile_update(self, payload):
        if isinstance(payload, bytes):
            payload = payload.decode()
        data = json.loads(payload)
        print("Received profile update:", data)
        member_id = data.get('member_id')
        if member_id:
            MEMBER_PROFILES[member_id] = {
                "email": data.get('email'),
                "no_hp": data.get('no_hp')
            }
            print(f"Profile updated for member {member_id}")


    @rpc
    def validate_token(self, token):
        info = TOKENS.get(token)
        if not info:
            return {"valid": False, "reason": "Token not found"}
        now = time.strftime('%Y-%m-%d %H:%M:%S')
        if info["expires_at"] < now:
            return {"valid": False, "reason": "Token expired"}
        return {"valid": True, "member_id": info["member_id"], "email": info["email"]}