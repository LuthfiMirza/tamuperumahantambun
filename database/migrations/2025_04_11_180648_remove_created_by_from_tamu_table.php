<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tamu', function (Blueprint $table) {
            if (Schema::hasColumn('tamu', 'created_by')) {
                // Coba drop FK jika ada
                try {
                    $table->dropForeign(['created_by']);
                } catch (\Exception $e) {
                    // Foreign key tidak ada, jadi abaikan error
                }

                $table->dropColumn('created_by');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tamu', function (Blueprint $table) {
            //
        });
    }
};
