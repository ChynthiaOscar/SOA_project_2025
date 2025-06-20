<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NamekoClient
{
    /**
     * The base URL for the Nameko HTTP gateway.
     * 
     * @var string
     */
    protected $baseUrl;    /**
     * The API path prefix.
     * 
     * @var string
     */
    protected $apiPrefix;
    
    /**
     * Create a new NamekoClient instance.
     * 
     * @param string $baseUrl
     * @param string $apiPrefix
     * @return void
     */
    public function __construct($baseUrl, $apiPrefix = 'api/')
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->apiPrefix = $apiPrefix;
    }

    /**
     * Make a GET request to the Nameko HTTP gateway.
     * 
     * @param string $endpoint
     * @param array $params
     * @return mixed
     */    public function get($endpoint, $params = [])
    {
        // Tambahkan prefix API jika endpoint tidak dimulai dengan 'api/'
        if (!str_starts_with($endpoint, 'api/')) {
            $endpoint = $this->apiPrefix . $endpoint;
        }
        
        $url = $this->baseUrl . '/' . ltrim($endpoint, '/');
        try {
            Log::info("NamekoClient: Making GET request to {$url}", ['params' => $params]);
            
            // Set a shorter timeout to avoid long waits
            $response = Http::timeout(5)->get($url, $params);
            
            Log::info("NamekoClient: Received response from {$url}", [
                'status' => $response->status(),
                'success' => $response->successful(),
                'headers' => $response->headers()
            ]);
            
            return $this->processResponse($response);
        } catch (\Exception $e) {
            Log::error('Nameko GET request failed: ' . $e->getMessage());
            
            $errorMessage = 'Failed to connect to service: ' . $e->getMessage();
            
            // Provide more specific messages for common errors
            if (strpos($e->getMessage(), 'cURL error 28') !== false) {
                $errorMessage = "Connection timed out. Please check that the Nameko service is running at {$this->baseUrl}";
            } elseif (strpos($e->getMessage(), 'Connection refused') !== false) {
                $errorMessage = "Connection refused. The Nameko service at {$this->baseUrl} is not running or is not accessible.";
            }
            
            return [
                'success' => false, 
                'message' => $errorMessage
            ];
        }
    }

    /**
     * Make a POST request to the Nameko HTTP gateway.
     * 
     * @param string $endpoint
     * @param array $data
     * @return mixed
     */    public function post($endpoint, $data = [])
    {
        // Tambahkan prefix API jika endpoint tidak dimulai dengan 'api/'
        if (!str_starts_with($endpoint, 'api/')) {
            $endpoint = $this->apiPrefix . $endpoint;
        }
        
        $url = $this->baseUrl . '/' . ltrim($endpoint, '/');
        try {
            $response = Http::post($url, $data);
            return $this->processResponse($response);
        } catch (\Exception $e) {
            Log::error('Nameko POST request failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to connect to service: ' . $e->getMessage()];
        }
    }

    /**
     * Make a PUT request to the Nameko HTTP gateway.
     * 
     * @param string $endpoint
     * @param array $data
     * @return mixed
     */    public function put($endpoint, $data = [])
    {
        // Tambahkan prefix API jika endpoint tidak dimulai dengan 'api/'
        if (!str_starts_with($endpoint, 'api/')) {
            $endpoint = $this->apiPrefix . $endpoint;
        }
        
        $url = $this->baseUrl . '/' . ltrim($endpoint, '/');
        try {
            $response = Http::put($url, $data);
            return $this->processResponse($response);
        } catch (\Exception $e) {
            Log::error('Nameko PUT request failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to connect to service: ' . $e->getMessage()];
        }
    }

    /**
     * Make a DELETE request to the Nameko HTTP gateway.
     * 
     * @param string $endpoint
     * @return mixed
     */    public function delete($endpoint)
    {
        // Tambahkan prefix API jika endpoint tidak dimulai dengan 'api/'
        if (!str_starts_with($endpoint, 'api/')) {
            $endpoint = $this->apiPrefix . $endpoint;
        }
        
        $url = $this->baseUrl . '/' . ltrim($endpoint, '/');
        try {
            $response = Http::delete($url);
            return $this->processResponse($response);
        } catch (\Exception $e) {
            Log::error('Nameko DELETE request failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to connect to service: ' . $e->getMessage()];
        }
    }

    /**
     * Process the HTTP response.
     * 
     * @param \Illuminate\Http\Client\Response $response
     * @return mixed
     */    protected function processResponse($response)
    {
        if ($response->successful()) {
            try {
                // Ambil raw content untuk debug
                $rawContent = $response->body();
                Log::info('Raw response from Nameko service:', [
                    'length' => strlen($rawContent),
                    'sample' => substr($rawContent, 0, 100) . (strlen($rawContent) > 100 ? '...' : '')
                ]);
                
                // Decode JSON
                $jsonResponse = $response->json();
                
                // Normalisasi respons
                if (is_array($jsonResponse)) {
                    // Jika sudah dalam format yang diharapkan
                    if (isset($jsonResponse['success'])) {
                        // Tidak perlu melakukan apa-apa
                    } 
                    // Jika langsung array items (tidak ada success/data keys)
                    else if (isset($jsonResponse[0])) {
                        $jsonResponse = [
                            'success' => true,
                            'data' => $jsonResponse
                        ];
                    }
                    // Format lain yang tidak diharapkan
                    else {
                        $jsonResponse = [
                            'success' => true,
                            'data' => [$jsonResponse]
                        ];
                    }
                    
                    // Handle nilai desimal
                    array_walk_recursive($jsonResponse, function(&$value) {
                        if (is_object($value) && method_exists($value, '__toString')) {
                            $value = (string)$value;
                        }
                    });
                }
                
                return $jsonResponse;
            } catch (\Exception $e) {
                Log::error('Failed to parse JSON response: ' . $e->getMessage());
                Log::error('Raw content causing JSON parse error:', ['content' => $response->body()]);
                
                // If JSON parsing fails, return the raw content
                return [
                    'success' => false,
                    'message' => 'Invalid JSON response from service: ' . $e->getMessage(),
                    'raw_content' => $response->body()
                ];
            }
        }

        Log::error('Nameko request failed with status: ' . $response->status());
        
        return [
            'success' => false,
            'message' => 'Service returned an error: ' . $response->status(),
            'error' => $response->body()
        ];
    }
}
