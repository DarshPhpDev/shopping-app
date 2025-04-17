<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportFakeStoreApiProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import or sync products from the Fake Store API';

    /**
     * The Products Api url.
     *
     * @var string
     */
    protected $apiUrl = 'https://fakestoreapi.com/products';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fetching products from Fake Store API...');

        /* 
            Use laravel built in Guzzle Http client 
            to make a GET request to the fake store products api.
        */
        $response = Http::get($this->apiUrl);

        /* 
            If the api call was not successful 
            Abort with error message.
        */
        if (!$response->ok()) {
            $this->error('Failed to fetch products from Fake Store API.');
            return;
        }
        
        // retrieve the response json body
        $products = $response->json();
        $productsCount = count($products);

        // nice, user-friendly progress bar
        $bar = $this->output->createProgressBar($productsCount);
        $bar->start();

        foreach ($products as $product) {
            // if product id already exists then update, otherwise create the product
            Product::updateOrCreate(
                ['id' => $product['id']],
                [
                    'title'         => $product['title'],
                    'price'         => $product['price'],
                    'description'   => $product['description'],
                    'category'      => $product['category'],
                    'image'         => $product['image'],
                    'rating_rate'   => $product['rating']['rate'] ?? null,
                    'rating_count'  => $product['rating']['count'] ?? null,
                ]
            );
            
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Successfully imported/updated ' . $productsCount . ' products.');
    }
}
