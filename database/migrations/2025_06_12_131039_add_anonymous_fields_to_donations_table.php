<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->boolean('is_anonymous')->default(false)->after('nominal');
            $table->string('donor_name')->nullable()->after('is_anonymous');
            $table->text('message')->nullable()->after('donor_name');
        });
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn(['is_anonymous', 'donor_name', 'message']);
        });
    }
};