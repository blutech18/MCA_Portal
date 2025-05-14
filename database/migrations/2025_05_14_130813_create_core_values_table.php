<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('core_values', function (Blueprint $table) {
            $table->id();
            $table->string('name');    // e.g. 'Maka-Diyos'
            $table->string('slug')->unique();  // e.g. 'maka-diyos'
            $table->timestamps();
        });

        DB::table('core_values')->insert([
            ['name'=>'Maka-Diyos','slug'=>'maka-diyos','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Maka-tao','slug'=>'maka-tao','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Maka-bansa','slug'=>'maka-bansa','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Maka-kalikasan','slug'=>'maka-kalikasan','created_at'=>now(),'updated_at'=>now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('core_values');
    }
};
