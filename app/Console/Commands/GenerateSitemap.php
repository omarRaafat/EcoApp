<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'generate:sitemap';
    protected $description = 'Generate the sitemap';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Create a new sitemap
        $sitemap = Sitemap::create();
        $sitemap->add(Url::create(config('app.url')));
        // Add static pages
        $sitemap->add(config('app.url') . '/home');
        $sitemap->add(config('app.url') . '/about');
        $sitemap->add(config('app.url') . '/faq');
        $sitemap->add(config('app.url') . '/blog');
        $sitemap->add(config('app.url') . '/usage');
        $sitemap->add(config('app.url') . '/policy');
        $sitemap->add(config('app.url') . '/contact');

        $categories = Category::where('is_active',1)->get();
        foreach ($categories as $category) {
            $sitemap->add('/category/' . $category->id .'/'.$category->getTranslation("name", "ar"));
        }

        $products = Product::where('is_active',1)->where('status','accepted')->where('is_visible',1)->get();
        foreach ($products as $product) {
            $sitemap->add('/product/' . $product->id .'/'.$product->getTranslation("name", "ar"));
        }

        $vendors = Vendor::where('is_active',1)->where('approval','approved')->get();
        foreach ($vendors as $vendor)
        {
            $sitemap->add('/vendors/'. $vendor->id .'/'.$vendor->getTranslation("name", "ar"));
        }

        // Write the sitemap to the file
        $sitemap->writeToFile(public_path('sitemap.xml'));
        $this->info('Sitemap generated successfully!');
    }
}
