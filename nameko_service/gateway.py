from nameko.web.handlers import http
from werkzeug.wrappers import Request, Response
from nameko.rpc import RpcProxy
import json

class GatewayService:
    name = "gateway"

    auth_service = RpcProxy("auth_service")

    @http('POST', '/validate-token')
    def validate_token(self, request):
        data = request.json
        token = data.get('token')

        if not token:
            return Response(
                json.dumps({'valid': False, 'reason': 'No token provided'}),
                mimetype='application/json',
                status=400
            )

        result = self.auth_service.validate_token(token)
        return Response(
            json.dumps(result),
            mimetype='application/json'
        )

    @http('POST', '/register')
    def register(self, request):
        data = request.json
        required_fields = ['nama', 'email', 'tanggal_lahir', 'no_hp', 'password']
        for field in required_fields:
            if field not in data:
                return Response(
                    json.dumps({'success': False, 'message': f'{field} is required'}),
                    mimetype='application/json',
                    status=400
                )
        result = self.auth_service.register(data)
        if result.get('success'):
            return Response(
                json.dumps(result),
                mimetype='application/json',
                status=200
            )
        return Response(
            json.dumps(result),
            mimetype='application/json',
            status=400
        )

    @http('POST', '/login')
    def login(self, request):
        data = request.json
        email = data.get('email')
        password = data.get('password')
        if not email or not password:
            return Response(
                json.dumps({'success': False, 'message': 'Email and password required'}),
                mimetype='application/json',
                status=400
            )
        result = self.auth_service.login(email, password)
        if result.get('success'):
            return Response(
                json.dumps(result),
                mimetype='application/json',
                status=200
            )
        return Response(
            json.dumps(result),
            mimetype='application/json',
            status=401
        )

    @http('POST', '/logout')
    def logout(self, request):
        data = request.json
        token = data.get('token')
        if not token:
            return Response(
                json.dumps({'success': False, 'message': 'Token is required'}),
                mimetype='application/json',
                status=400
            )
        result = self.auth_service.logout(token)
        return Response(
            json.dumps(result),
            mimetype='application/json'
        )

    @http('GET', '/profile')
    def get_profile(self, request):
        member_id = None
        if 'member_id' in request.args:
            member_id = request.args.get('member_id')
        if not member_id and request.query_string:
            try:
                from urllib.parse import parse_qs
                query_params = parse_qs(request.query_string.decode('utf-8'))
                if 'member_id' in query_params:
                    member_id = query_params['member_id'][0]
            except Exception:
                pass
        if not member_id and '/' in request.path:
            path_parts = request.path.split('/')
            if len(path_parts) > 2 and path_parts[2]:
                member_id = path_parts[2]
        if not member_id:
            return Response(
                json.dumps({
                    'success': False, 
                    'message': 'Member ID is required',
                    'debug_info': {
                        'url': request.url,
                        'query_string': request.query_string.decode('utf-8') if request.query_string else None,
                        'args': dict(request.args),
                        'path': request.path
                    }
                }),
                mimetype='application/json',
                status=400
            )
        result = self.auth_service.get_profile(member_id)
        if result.get('success'):
            return Response(
                json.dumps(result),
                mimetype='application/json'
            )
        return Response(
            json.dumps(result),
            mimetype='application/json',
            status=404
        )

    @http('POST', '/get-profile')
    def post_get_profile(self, request):
        data = request.json
        member_id = data.get('member_id')
        if not member_id:
            return Response(
                json.dumps({'success': False, 'message': 'Member ID is required'}),
                mimetype='application/json',
                status=400
            )
        result = self.auth_service.get_profile(member_id)
        if result.get('success'):
            return Response(
                json.dumps(result),
                mimetype='application/json'
            )
        return Response(
            json.dumps(result),
            mimetype='application/json',
            status=404
        )

    @http('PUT', '/profile')
    def update_profile(self, request):
        data = request.json
        member_id = data.get('member_id')
        if not member_id:
            return Response(
                json.dumps({'success': False, 'message': 'Member ID is required'}),
                mimetype='application/json',
                status=400
            )
        result = self.auth_service.update_profile(member_id, data)
        if result.get('success'):
            return Response(
                json.dumps(result),
                mimetype='application/json',
                status=200
            )
        return Response(
            json.dumps(result),
            mimetype='application/json',
            status=400
        )

    @http('DELETE', '/profile')
    def delete_profile(self, request):
        member_id = request.args.get('member_id')
        print(f"[GATEWAY] Delete request for member_id: {member_id}")
        if not member_id:
            return Response(
                json.dumps({'success': False, 'message': 'Member ID is required'}),
                mimetype='application/json',
                status=400
            )
        try:
            member_id_int = int(member_id)
        except Exception as e:
            print(f"[GATEWAY] Invalid member_id type: {e}")
            return Response(
                json.dumps({'success': False, 'message': 'Invalid member_id'}),
                mimetype='application/json',
                status=400
            )
        result = self.auth_service.delete_member(member_id_int)
        print(f"[GATEWAY] Delete result: {result}")
        if result.get('success'):
            return Response(
                json.dumps(result),
                mimetype='application/json',
                status=200
            )
        return Response(
            json.dumps(result),
            mimetype='application/json',
            status=404
        )