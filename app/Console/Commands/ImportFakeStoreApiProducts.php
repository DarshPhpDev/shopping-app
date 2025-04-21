<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

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

    private const API_URL = 'https://fakestoreapi.com/products';

    /**
     * Create or get category by name.
     *
     * @param string $categoryName
     * @return int category_id
     */
    private function getOrCreateCategoryId(string $categoryName): int{
        return Category::firstOrCreate(['name' => $categoryName])->id;
    }

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
        $response = Http::get(self::API_URL);

        /*
            If the api call was not successful
            Abort with error message and return proper response.
        */
        if (!$response->ok()) {
            $this->error('Failed to fetch products from Fake Store API.');
            return Command::FAILURE;
        }

        // retrieve the response json body
        $products = $response->json();

        $productsCount = count($products);

        $this->info('Fetched ' . $productsCount . ' products.');
        $bar = $this->output->createProgressBar($productsCount);

        $bar->start();

        $validProducts = [];        // placeholder array to add validated products and use later for insertion/update

        foreach ($products as $product) {
            // Validate product main fields before insert (id, title, price, category, image)
            $validator = Validator::make($product, [
                'id'            => 'required|integer',
                'title'         => 'required|string|max:255',
                'price'         => 'required|numeric|min:0',
                'category'      => 'required|string',
                'image'         => 'required|url',
            ]);

            if ($validator->fails()) {
                $this->newLine();
                $this->warn("Skipping invalid product With ID: {$product['id']}");
                $bar->advance();
                continue;
            }

            $validProducts [] = [
                'id'            => $product['id'],
                'title'         => $product['title'],
                'price'         => $product['price'],
                'description'   => $product['description'] ?? '',
                'category_id'   => $this->getOrCreateCategoryId($product['category']),
                'image'         => $product['image'],
                'rating_rate'   => $product['rating']['rate'] ?? null,
                'rating_count'  => $product['rating']['count'] ?? null,
            ];

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();

        $this->info('Saving valid products to database...');
        // using array_chunk to chunk each 50 products to avoid high memory consumption
        foreach (array_chunk($validProducts, 50) as $chunk) {
            /* 
                Using upsert instead of createOrUpdate 
                to avoid hitting the database with multiple queries
            */
            Product::upsert(
                $chunk, // the list of products to be used in insertion or update
                ['id'], // the unique key, if found then update instead of insert
                ['title', 'price', 'description', 'category_id', 'image', 'rating_rate', 'rating_count'] 
                // fields to update
            );
        }

        $this->info('Successfully imported/updated ' . count($validProducts) . ' products.');
        return Command::SUCCESS;
    }
}
