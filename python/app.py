from flask import Flask, request, jsonify
import tiktoken

app = Flask(__name__)

def num_tokens_from_string(string: str, encoding_name: str) -> int:
      """Returns the number of tokens in a text string."""
      encoding = tiktoken.get_encoding(encoding_name)
      num_tokens = len(encoding.encode(string))
      return num_tokens

@app.route('/')
def home():

    num_tokens = num_tokens_from_string("tiktoken is great!", "cl100k_base")

    return f"The number of tokens is: {num_tokens}"

@app.route('/process', methods=['POST'])
def process():
    data = request.get_json()
    # Process the data
    print(data)
    num_tokens = num_tokens_from_string(data['string_to_test'], "cl100k_base")

    encoding = tiktoken.get_encoding("cl100k_base")
    encoding = tiktoken.encoding_for_model('gpt-3.5-turbo')
    encoded = encoding.encode(data['string_to_test'])
    # print(encoded)

    data['num_tokens'] = num_tokens
    data['encoded'] = encoded
    response = {'status': 'success', 'data': data}
    return jsonify(response)

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5001)
