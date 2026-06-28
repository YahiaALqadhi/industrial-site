<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->string('reply_subject')->nullable()->after('message');
            $table->longText('reply_message')->nullable()->after('reply_subject');
            $table->string('reply_channel')->default('internal')->after('reply_message');
            $table->boolean('reply_sent')->default(false)->after('reply_channel');
            $table->text('reply_error')->nullable()->after('reply_sent');
            $table->timestamp('replied_at')->nullable()->after('reply_error');
            $table->foreignId('replied_by')->nullable()->after('replied_at')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropConstrainedForeignId('replied_by');
            $table->dropColumn(['reply_subject', 'reply_message', 'reply_channel', 'reply_sent', 'reply_error', 'replied_at']);
        });
    }
};
