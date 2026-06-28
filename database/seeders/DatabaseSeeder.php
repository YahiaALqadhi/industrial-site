<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@industrial.local'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Admin@12345'),
                'role' => User::ROLE_SUPER_ADMIN,
                'is_active' => true,
            ]
        );

        $top = [
            'Industrial engineering solutions',
            'Industrial Automation solutions',
            'AI products and solutions',
            'Equipments and components',
            'Packaging solutions and products',
            'Building materials',
            'Raw materials',
            'Customized sourcing products and solutions',
        ];

        $topCategories = [];
        foreach ($top as $i => $name) {
            $topCategories[$name] = Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'parent_id' => null,
                    'name' => $name,
                    'description' => null,
                    'image' => null,
                    'sort_order' => $i,
                    'is_active' => true,
                ]
            );
        }

        $industrialEngineering = $topCategories['Industrial engineering solutions'];
        $buildingMaterials = $topCategories['Building materials'];

        $dailyChemical = Category::updateOrCreate(
            ['slug' => Str::slug('Daily Chemical')],
            [
                'parent_id' => $industrialEngineering->id,
                'name' => 'Daily Chemical',
                'description' => null,
                'image' => null,
                'sort_order' => 0,
                'is_active' => true,
            ]
        );

        Category::updateOrCreate(
            ['slug' => Str::slug('Petrochemicals')],
            [
                'parent_id' => $industrialEngineering->id,
                'name' => 'Petrochemicals',
                'description' => null,
                'image' => null,
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        Category::updateOrCreate(
            ['slug' => Str::slug('Steel Structure Solution')],
            [
                'parent_id' => $buildingMaterials->id,
                'name' => 'Steel Structure Solution',
                'description' => null,
                'image' => null,
                'sort_order' => 0,
                'is_active' => true,
            ]
        );

        $steelMaterials = Category::updateOrCreate(
            ['slug' => Str::slug('Steel Materials')],
            [
                'parent_id' => $buildingMaterials->id,
                'name' => 'Steel Materials',
                'description' => null,
                'image' => null,
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        $products = [
            ['Washing Powder Production Line', $dailyChemical],
            ['Liquid Detergent', $dailyChemical],
            ['Galvanized Steel', $steelMaterials],
            ['Preprinted Steel', $steelMaterials],
        ];

        foreach ($products as [$name, $category]) {
            Product::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'category_id' => $category->id,
                    'name' => $name,
                    'short_desc' => null,
                    'description' => null,
                    'cover_image' => null,
                    'brochure_pdf' => null,
                    'is_active' => true,
                ]
            );
        }

        $services = [
            'Technical communication',
            'Acceptance and delivery',
            'Contract signing',
            'Business negotiation',
            'Design',
            'Factory loading and shipment',
        ];

        foreach ($services as $i => $title) {
            Service::updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'title' => $title,
                    'short_desc' => null,
                    'description' => null,
                    'image' => null,
                    'is_active' => true,
                    'sort_order' => $i,
                ]
            );
        }

        $settings = [
            'company_phone' => null,
            'company_email' => null,
            'company_whatsapp' => null,
            'company_address' => null,
            'social_facebook' => null,
            'social_linkedin' => null,
            'social_instagram' => null,
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
