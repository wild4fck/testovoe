<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntriesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('entry_id')->default(null)->nullable();
            $table->string('code');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('entry_id')->references('id')->on('entries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('entries');
    }
}
