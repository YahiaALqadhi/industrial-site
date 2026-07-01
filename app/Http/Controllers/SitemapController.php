<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class SitemapController extends Controller
{
    public function index()
    {
        $xml = new \XMLWriter();

        $xml->openMemory();
        $xml->startDocument('1.0', 'UTF-8');

        $xml->setIndent(true);
        $xml->setIndentString('    ');

        $xml->startElement('urlset');
        $xml->writeAttribute(
            'xmlns',
            'http://www.sitemaps.org/schemas/sitemap/0.9'
        );

        // Home
        $xml->startElement('url');
        $xml->writeElement('loc', url('/'));
        $xml->writeElement('changefreq', 'daily');
        $xml->writeElement('priority', '1.0');
        $xml->endElement();

        foreach ([
            route('about'),
            route('services'),
            route('contact'),
            route('products.index'),
        ] as $page) {
            $xml->startElement('url');
            $xml->writeElement('loc', $page);
            $xml->endElement();
        }

        foreach (Category::all() as $category) {
            $xml->startElement('url');
            $xml->writeElement('loc', route('products.category', $category->slug));
            $xml->endElement();
        }

        foreach (Product::all() as $product) {
            $xml->startElement('url');
            $xml->writeElement('loc', route('products.show', $product->slug));
            $xml->endElement();
        }

        $xml->endElement();

        return response(
            $xml->outputMemory(),
            200,
            [
                'Content-Type' => 'application/xml; charset=UTF-8'
            ]
        );
    }
}