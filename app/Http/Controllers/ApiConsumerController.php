<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class ApiConsumerController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('API_BASE_URL', 'http://localhost:8080/api'),
            'headers' => [
                'Accept' => 'application/json',
            ],
            // 'headers' => ['Authorization' => 'Bearer YOUR_ACCESS_TOKEN'] // If authentication is needed
        ]);
    }

    public function addProductToCart($userId, $productId)
    {
        try {
            // Make a POST request to the API endpoint for adding a product to the cart
            $response = $this->client->request('POST', '/api/addProductToCart/' . $userId . '/' . $productId);

            // Decode the JSON response
//            $responseData = json_decode($response->getBody(), true);

            // Handle the response...
        } catch (\Exception $e) {
            // Handle exception...
        }
    }

    public function minusQuantity($userId, $productId)
    {
        try {
            // Make a POST request to the API endpoint for adding a product to the cart
            $response = $this->client->request('POST', '/api/minusQuantity/' . $userId . '/' . $productId);

            // Decode the JSON response
//            $responseData = json_decode($response->getBody(), true);

            // Handle the response...
        } catch (\Exception $e) {
            // Handle exception...
        }
    }

    public function getCartProducts($userId){
        try {
            $response = $this->client->request('GET', '/api/cart/' . $userId);
            $responseData = json_decode($response->getBody(), true);

            if ($response->getStatusCode() == 200 && isset($responseData['cartItems'])) {
                return $responseData['cartItems'];
            } else {
                return []; // Return an empty array in case of error or no cart items
            }
        } catch (\Exception $e) {
            // Optionally log the error or handle it as required
            return []; // Return an empty array in case of exception
        }
    }


    public function checkoutPagePost($userId, $formData) {
        try {
            // Make a POST request to the API endpoint for checkout
            $response = $this->client->request('POST', '/api/checkoutPage/' . $userId, [
                'form_params' => $formData
            ]);


            // Decode the JSON response
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
//            dd($e);
            return ['success' => false, 'message' => 'Exception occurred: ' . $e->getMessage()];
        }
    }





    public function getProducts()
    {
        try {
            $response = $this->client->request('GET', '/api/products');
            $productsData = json_decode($response->getBody(), true);

            $products = collect(); // Create an empty collection to hold Product models

            foreach ($productsData as $productData) {
                $product = new Product($productData); // Create a Product model instance
                $products->push($product); // Add the Product model to the collection
            }

            return $products;
        } catch (\Exception $e) {
//            dd($e);
            return []; // Return an empty array in case of error
        }
    }

    public function getProductById($productId)
    {
        try {
            $response = $this->client->request('GET', '/api/products/' . $productId);
            $productData = json_decode($response->getBody(), true);

            if (!$productData) {
                return null; // Return null if no product data is found
            }

            $product = new Product($productData);
            return $product;
        } catch (\Exception $e) {
            // Handle exception or log error
            return null; // Return null in case of error
        }
    }












    // ... other methods to interact with different API endpoints
}
