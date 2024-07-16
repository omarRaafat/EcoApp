<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class MediaFileOptimizeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:MediaFileOptimizeCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $product = Product::find(3632);
        $product->addMedia(ossStorageUrl($product->image))->toMediaCollection(Product::mediaCollectionName);
    }
}
