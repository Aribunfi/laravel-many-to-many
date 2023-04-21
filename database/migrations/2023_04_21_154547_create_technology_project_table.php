<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technology_project', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('project_id')
            ->constrained()
            ->cascadeOnDelete();
            
            $table->foreignId('technology_id')
            ->constrained()
            ->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('technology_project');
    }
};
