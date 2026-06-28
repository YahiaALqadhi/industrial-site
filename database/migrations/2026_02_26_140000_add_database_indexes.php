<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private function indexExists(string $table, string $indexName): bool
    {
        $db = DB::getDatabaseName();

        $rows = DB::select(
            "SELECT 1
             FROM information_schema.STATISTICS
             WHERE TABLE_SCHEMA = ?
               AND TABLE_NAME = ?
               AND INDEX_NAME = ?
             LIMIT 1",
            [$db, $table, $indexName]
        );

        return !empty($rows);
    }

    private function addIndexIfMissing(string $table, string $indexName, callable $callback): void
    {
        if (!$this->indexExists($table, $indexName)) {
            Schema::table($table, function (Blueprint $t) use ($callback) {
                $callback($t);
            });
        }
    }

    private function dropIndexIfExists(string $table, string $indexName): void
    {
        if ($this->indexExists($table, $indexName)) {
            Schema::table($table, function (Blueprint $t) use ($indexName) {
                $t->dropIndex($indexName);
            });
        }
    }

    public function up(): void
    {
        // =========================
        // categories
        // =========================
        $this->addIndexIfMissing('categories', 'categories_slug_index', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'slug')) {
                $table->index('slug', 'categories_slug_index');
            }
        });

        $this->addIndexIfMissing('categories', 'categories_parent_id_index', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'parent_id')) {
                $table->index('parent_id', 'categories_parent_id_index');
            }
        });

        $this->addIndexIfMissing('categories', 'categories_is_active_index', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'is_active')) {
                $table->index('is_active', 'categories_is_active_index');
            }
        });

        // =========================
        // products
        // =========================
        $this->addIndexIfMissing('products', 'products_slug_index', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'slug')) {
                $table->index('slug', 'products_slug_index');
            }
        });

        $this->addIndexIfMissing('products', 'products_category_id_index', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'category_id')) {
                $table->index('category_id', 'products_category_id_index');
            }
        });

        $this->addIndexIfMissing('products', 'products_is_active_index', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'is_active')) {
                $table->index('is_active', 'products_is_active_index');
            }
        });

        $this->addIndexIfMissing('products', 'products_is_active_created_at_index', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'is_active') && Schema::hasColumn('products', 'created_at')) {
                $table->index(['is_active', 'created_at'], 'products_is_active_created_at_index');
            }
        });

        // =========================
        // services
        // =========================
        $this->addIndexIfMissing('services', 'services_slug_index', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'slug')) {
                $table->index('slug', 'services_slug_index');
            }
        });

        $this->addIndexIfMissing('services', 'services_is_active_index', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'is_active')) {
                $table->index('is_active', 'services_is_active_index');
            }
        });

        // =========================
        // inquiries
        // =========================
        $this->addIndexIfMissing('inquiries', 'inquiries_email_index', function (Blueprint $table) {
            if (Schema::hasColumn('inquiries', 'email')) {
                $table->index('email', 'inquiries_email_index');
            }
        });

        $this->addIndexIfMissing('inquiries', 'inquiries_status_index', function (Blueprint $table) {
            if (Schema::hasColumn('inquiries', 'status')) {
                $table->index('status', 'inquiries_status_index');
            }
        });

        $this->addIndexIfMissing('inquiries', 'inquiries_type_index', function (Blueprint $table) {
            if (Schema::hasColumn('inquiries', 'type')) {
                $table->index('type', 'inquiries_type_index');
            }
        });

        $this->addIndexIfMissing('inquiries', 'inquiries_created_at_index', function (Blueprint $table) {
            if (Schema::hasColumn('inquiries', 'created_at')) {
                $table->index('created_at', 'inquiries_created_at_index');
            }
        });

        $this->addIndexIfMissing('inquiries', 'inquiries_status_created_at_index', function (Blueprint $table) {
            if (Schema::hasColumn('inquiries', 'status') && Schema::hasColumn('inquiries', 'created_at')) {
                $table->index(['status', 'created_at'], 'inquiries_status_created_at_index');
            }
        });

        // =========================
        // users
        // =========================
        $this->addIndexIfMissing('users', 'users_role_index', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->index('role', 'users_role_index');
            }
        });

        $this->addIndexIfMissing('users', 'users_is_active_index', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'is_active')) {
                $table->index('is_active', 'users_is_active_index');
            }
        });

        $this->addIndexIfMissing('users', 'users_email_index', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'email')) {
                $table->index('email', 'users_email_index');
            }
        });

        // =========================
        // product_images
        // =========================
        $this->addIndexIfMissing('product_images', 'product_images_product_id_index', function (Blueprint $table) {
            if (Schema::hasColumn('product_images', 'product_id')) {
                $table->index('product_id', 'product_images_product_id_index');
            }
        });

        $this->addIndexIfMissing('product_images', 'product_images_sort_order_index', function (Blueprint $table) {
            if (Schema::hasColumn('product_images', 'sort_order')) {
                $table->index('sort_order', 'product_images_sort_order_index');
            }
        });

        // =========================
        // product_features
        // =========================
        $this->addIndexIfMissing('product_features', 'product_features_product_id_index', function (Blueprint $table) {
            if (Schema::hasColumn('product_features', 'product_id')) {
                $table->index('product_id', 'product_features_product_id_index');
            }
        });

        $this->addIndexIfMissing('product_features', 'product_features_sort_order_index', function (Blueprint $table) {
            if (Schema::hasColumn('product_features', 'sort_order')) {
                $table->index('sort_order', 'product_features_sort_order_index');
            }
        });
    }

    public function down(): void
    {
        $this->dropIndexIfExists('categories', 'categories_slug_index');
        $this->dropIndexIfExists('categories', 'categories_parent_id_index');
        $this->dropIndexIfExists('categories', 'categories_is_active_index');

        $this->dropIndexIfExists('products', 'products_slug_index');
        $this->dropIndexIfExists('products', 'products_category_id_index');
        $this->dropIndexIfExists('products', 'products_is_active_index');
        $this->dropIndexIfExists('products', 'products_is_active_created_at_index');

        $this->dropIndexIfExists('services', 'services_slug_index');
        $this->dropIndexIfExists('services', 'services_is_active_index');

        $this->dropIndexIfExists('inquiries', 'inquiries_email_index');
        $this->dropIndexIfExists('inquiries', 'inquiries_status_index');
        $this->dropIndexIfExists('inquiries', 'inquiries_type_index');
        $this->dropIndexIfExists('inquiries', 'inquiries_created_at_index');
        $this->dropIndexIfExists('inquiries', 'inquiries_status_created_at_index');

        $this->dropIndexIfExists('users', 'users_role_index');
        $this->dropIndexIfExists('users', 'users_is_active_index');
        $this->dropIndexIfExists('users', 'users_email_index');

        $this->dropIndexIfExists('product_images', 'product_images_product_id_index');
        $this->dropIndexIfExists('product_images', 'product_images_sort_order_index');

        $this->dropIndexIfExists('product_features', 'product_features_product_id_index');
        $this->dropIndexIfExists('product_features', 'product_features_sort_order_index');
    }
};