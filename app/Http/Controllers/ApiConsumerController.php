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
        ]);
    }


    public function addProduct($formData) {
        try {
            $response = $this->client->request('POST', '/api/addProductDB', [
                'form_params' => $formData]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Exception occurred: ' . $e->getMessage()];
        }
    }

    public function deleteProduct($productId) {
        try {
            $response = $this->client->request('POST', '/api/deleteProduct/'. $productId);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Exception occurred: ' . $e->getMessage()];
        }
    }



    public function changePassword($userId, $formData) {
        try {
            $response = $this->client->request('POST', '/api/changePassword', [
                'form_params' => array_merge($formData, ['user_id' => $userId])
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Exception occurred: ' . $e->getMessage()];
        }
    }


    public function login($formData) {
        try {
            $response = $this->client->request('POST', '/api/login', [
                'form_params' => $formData
            ]);

            // Decode and return the JSON response
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            // Return an array indicating failure and providing the exception message
            return ['success' => false, 'message' => 'Exception occurred: ' . $e->getMessage()];
        }
    }



    public function userReg($formData) {
        try {
            // Make a POST request to the API endpoint for user registration
            $response = $this->client->request('POST', '/api/userReg', [
                'form_params' => $formData
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Exception occurred: ' . $e->getMessage()];
        }
    }


    public function addProductToCart($userId, $productId)
    {
        try {
            $this->client->request('POST', '/api/addProductToCart/' . $userId . '/' . $productId);


        } catch (\Exception $e) {
        }
    }

    public function minusQuantity($userId, $productId)
    {
        try {
            $response = $this->client->request('POST', '/api/minusQuantity/' . $userId . '/' . $productId);


        } catch (\Exception $e) {
        }
    }

    public function getCartProducts($userId){
        try {
            $response = $this->client->request('GET', '/api/cart/' . $userId);
            $responseData = json_decode($response->getBody(), true);

            if ($response->getStatusCode() == 200 && isset($responseData['cartItems'])) {
                return $responseData['cartItems'];
            } else {
                return []; // Return an empty array in case of no cart items
            }
        } catch (\Exception $e) {
            return []; // Return an empty array in case of exception
        }
    }


    public function checkoutPagePost($userId, $formData) {
        try {
            // Make a POST request to the API endpoint for checkout
            $response = $this->client->request('POST', '/api/checkoutPage/' . $userId, [
                'form_params' => $formData
            ]);


            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
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
            return null; // Return null in case of error
        }
    }


}
