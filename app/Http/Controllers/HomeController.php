<?php

// Assuming this is in HomeController.php or a similar controller

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $apiConsumerController;

    public function __construct(ApiConsumerController $apiConsumerController)
    {
        $this->apiConsumerController = $apiConsumerController;
    }

    public function index()
    {
        // Fetch products from the API
        $products = $this->apiConsumerController->getProducts();

        // Pass products to the view
        return view('index', compact('products'));
    }

    public function clickForMoreInfoButton()
    {
        // Fetch products from the API
        $products = $this->apiConsumerController->getProducts();

        // Pass products to the view
        return view('index', compact('products'));
    }

}

