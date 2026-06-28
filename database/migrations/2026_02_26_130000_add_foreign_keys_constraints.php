<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private function fkExists(string $table, string $fkName): bool
    {
        $db = DB::getDatabaseName();

        $rows = DB::select(
            "SELECT CONSTRAINT_NAME
             FROM information_schema.TABLE_CONSTRAINTS
             WHERE CONSTRAINT_SCHEMA = ?
               AND TABLE_NAME = ?
               AND CONSTRAINT_NAME = ?
               AND CONSTRAINT_TYPE = 'FOREIGN KEY'
             LIMIT 1",
            [$db, $table, $fkName]
        );

        return !empty($rows);
    }

    private function addFkIfMissing(string $table, string $fkName, callable $callback): void
    {
        if (!$this->fkExists($table, $fkName)) {
            Schema::table($table, function (Blueprint $t) use ($callback) {
                $callback($t);
            });
        }
    }

    private function dropFkIfExists(string $table, string $fkName, array $cols): void
    {
        if ($this->fkExists($table, $fkName)) {
            Schema::table($table, function (Blueprint $t) use ($cols) {
                $t->dropForeign($cols);
            });
        }
    }

    public function up(): void
    {
        // categories.parent_id -> categories.id
        $this->addFkIfMissing('categories', 'categories_parent_id_foreign', function (Blueprint $table) {
            $table->foreign('parent_id', 'categories_parent_id_foreign')
                ->references('id')->on('categories')
                ->onDelete('cascade');
        });

        // products.category_id -> categories.id
        $this->addFkIfMissing('products', 'products_category_id_foreign', function (Blueprint $table) {
            $table->foreign('category_id', 'products_category_id_foreign')
                ->references('id')->on('categories')
                ->onDelete('restrict');
        });

        // product_images.product_id -> products.id
        $this->addFkIfMissing('product_images', 'product_images_product_id_foreign', function (Blueprint $table) {
            $table->foreign('product_id', 'product_images_product_id_foreign')
                ->references('id')->on('products')
                ->onDelete('cascade');
        });

        // product_features.product_id -> products.id
        $this->addFkIfMissing('product_features', 'product_features_product_id_foreign', function (Blueprint $table) {
            $table->foreign('product_id', 'product_features_product_id_foreign')
                ->references('id')->on('products')
                ->onDelete('cascade');
        });

        // inquiries.* foreign keys
        $this->addFkIfMissing('inquiries', 'inquiries_product_id_foreign', function (Blueprint $table) {
            $table->foreign('product_id', 'inquiries_product_id_foreign')
                ->references('id')->on('products')
                ->onDelete('set null');
        });

        $this->addFkIfMissing('inquiries', 'inquiries_service_id_foreign', function (Blueprint $table) {
            $table->foreign('service_id', 'inquiries_service_id_foreign')
                ->references('id')->on('services')
                ->onDelete('set null');
        });

        $this->addFkIfMissing('inquiries', 'inquiries_replied_by_foreign', function (Blueprint $table) {
            $table->foreign('replied_by', 'inquiries_replied_by_foreign')
                ->references('id')->on('users')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        $this->dropFkIfExists('categories', 'categories_parent_id_foreign', ['parent_id']);
        $this->dropFkIfExists('products', 'products_category_id_foreign', ['category_id']);
        $this->dropFkIfExists('product_images', 'product_images_product_id_foreign', ['product_id']);
        $this->dropFkIfExists('product_features', 'product_features_product_id_foreign', ['product_id']);
        $this->dropFkIfExists('inquiries', 'inquiries_product_id_foreign', ['product_id']);
        $this->dropFkIfExists('inquiries', 'inquiries_service_id_foreign', ['service_id']);
        $this->dropFkIfExists('inquiries', 'inquiries_replied_by_foreign', ['replied_by']);
    }
};
