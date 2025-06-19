<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gateway Connection Test</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white p-8">
    <div class="max-w-3xl mx-auto bg-gray-800 p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-6">Gateway Connection Test Results</h1>
        
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Status: 
                <span class="{{ $status == 'success' ? 'text-green-400' : 'text-red-400' }}">
                    {{ ucfirst($status) }}
                </span>
            </h2>
            <p class="text-lg">{{ $message }}</p>
        </div>

        @if(isset($statusCode))
        <div class="mb-4">
            <h3 class="text-lg font-semibold">Status Code:</h3>
            <p class="bg-gray-700 p-3 rounded">{{ $statusCode }}</p>
        </div>
        @endif

        @if(isset($error))
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-red-400">Error:</h3>
            <div class="bg-gray-700 p-3 rounded overflow-auto">
                <pre>{{ $error }}</pre>
            </div>
        </div>
        @endif

        @if(isset($response))
        <div>
            <h3 class="text-lg font-semibold">Response:</h3>
            <div class="bg-gray-700 p-3 rounded overflow-auto max-h-96">
                <pre>{{ json_encode($response, JSON_PRETTY_PRINT) }}</pre>
            </div>
        </div>
        @endif

        <div class="mt-8">
            <a href="/" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
                Back to Home
            </a>
        </div>
    </div>
</body>
</html>