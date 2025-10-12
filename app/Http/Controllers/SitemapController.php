<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $sitemap .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        // Static pages
        $sitemap .= '  <sitemap>'."\n";
        $sitemap .= '    <loc>'.route('sitemap.static').'</loc>'."\n";
        $sitemap .= '    <lastmod>'.now()->toISOString().'</lastmod>'."\n";
        $sitemap .= '  </sitemap>'."\n";

        // Products
        $sitemap .= '  <sitemap>'."\n";
        $sitemap .= '    <loc>'.route('sitemap.products').'</loc>'."\n";
        $sitemap .= '    <lastmod>'.now()->toISOString().'</lastmod>'."\n";
        $sitemap .= '  </sitemap>'."\n";

        // Members
        $sitemap .= '  <sitemap>'."\n";
        $sitemap .= '    <loc>'.route('sitemap.members').'</loc>'."\n";
        $sitemap .= '    <lastmod>'.now()->toISOString().'</lastmod>'."\n";
        $sitemap .= '  </sitemap>'."\n";

        $sitemap .= '</sitemapindex>';

        return response($sitemap, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }

    public function static()
    {
        $urls = [
            [
                'loc' => route('home'),
                'lastmod' => now()->toISOString(),
                'changefreq' => 'daily',
                'priority' => '1.0',
            ],
            [
                'loc' => route('products.index'),
                'lastmod' => now()->toISOString(),
                'changefreq' => 'daily',
                'priority' => '0.9',
            ],
            [
                'loc' => route('members.index'),
                'lastmod' => now()->toISOString(),
                'changefreq' => 'daily',
                'priority' => '0.8',
            ],
            [
                'loc' => route('terms'),
                'lastmod' => now()->toISOString(),
                'changefreq' => 'monthly',
                'priority' => '0.3',
            ],
            [
                'loc' => route('privacy'),
                'lastmod' => now()->toISOString(),
                'changefreq' => 'monthly',
                'priority' => '0.3',
            ],
        ];

        return $this->generateSitemap($urls);
    }

    public function products()
    {
        $products = Product::where('status', 'published')
            ->select('slug', 'updated_at')
            ->get();

        $urls = $products->map(function ($product) {
            return [
                'loc' => route('products.show', $product->slug),
                'lastmod' => $product->updated_at->toISOString(),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        })->toArray();

        return $this->generateSitemap($urls);
    }

    public function members()
    {
        $members = User::where('is_active', true)
            ->whereHas('seller')
            ->select('id', 'updated_at')
            ->get();

        $urls = $members->map(function ($member) {
            return [
                'loc' => route('members.show', $member->id),
                'lastmod' => $member->updated_at->toISOString(),
                'changefreq' => 'weekly',
                'priority' => '0.6',
            ];
        })->toArray();

        return $this->generateSitemap($urls);
    }

    private function generateSitemap(array $urls)
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($urls as $url) {
            $sitemap .= '  <url>'."\n";
            $sitemap .= '    <loc>'.htmlspecialchars($url['loc']).'</loc>'."\n";
            $sitemap .= '    <lastmod>'.$url['lastmod'].'</lastmod>'."\n";
            $sitemap .= '    <changefreq>'.$url['changefreq'].'</changefreq>'."\n";
            $sitemap .= '    <priority>'.$url['priority'].'</priority>'."\n";
            $sitemap .= '  </url>'."\n";
        }

        $sitemap .= '</urlset>';

        return response($sitemap, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}
