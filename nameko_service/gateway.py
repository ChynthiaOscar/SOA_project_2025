from flask import Flask, request, jsonify
from nameko.standalone.rpc import ClusterRpcProxy

app = Flask(__name__)

NAMEKO_CONFIG = {'AMQP_URI': "amqp://guest:guest@localhost"}

@app.route('/validate-token', methods=['POST'])
def validate_token():
    data = request.get_json()
    token = data.get('token')
    if not token:
        return jsonify({'valid': False, 'reason': 'No token provided'}), 400

    with ClusterRpcProxy(NAMEKO_CONFIG) as rpc:
        result = rpc.auth_service.validate_token(token)
    return jsonify(result)

if __name__ == '__main__':
    app.run(port=8001)