<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class RecalculateRatingsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reviews:recalculate {--product= : Specific product ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate rating aggregates for products';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($productId = $this->option('product')) {
            $product = Product::findOrFail($productId);
            $product->recalculateRating();
            $this->info("Recalculated ratings for product: {$product->title}");

            return Command::SUCCESS;
        }

        $products = Product::with('reviews')->get();
        $bar = $this->output->createProgressBar($products->count());
        $bar->start();

        foreach ($products as $product) {
            $product->recalculateRating();
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Recalculated ratings for {$products->count()} products.");

        return Command::SUCCESS;
    }
}
