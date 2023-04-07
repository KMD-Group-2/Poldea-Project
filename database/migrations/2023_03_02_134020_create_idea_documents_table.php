<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdeaDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('idea_documents', function (Blueprint $table) {
            $table->id();
            $table->string('type',50);
            $table->string('file_path',100);
            $table->string('file_name',50);
            $table->unsignedBigInteger('idea_id');
            $table->timestamps();

            $table->foreign('idea_id')->on('ideas')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('idea_documents');
    }
}
