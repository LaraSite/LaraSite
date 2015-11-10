<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned()->nullable();
            $table->string('title');
            $table->text('body');
            $table->string('status');
            $table->dateTime('published_at');
            $table->timestamps();

            $table->foreign('category_id')
              ->references('id')->on('categories')
              ->onDelete('set null');
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('upload_files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('extension');
            $table->integer('size');
            $table->timestamps();
        });

        Schema::create('article_tag', function(Blueprint $table) {
            $table->integer('article_id')->unsigned()->index();
            $table->integer('tag_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('article_id')
              ->references('id')->on('articles')
              ->onDelete('cascade');
            $table->foreign('tag_id')
              ->references('id')->on('tags')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('article_tag');
        Schema::drop('upload_files');
        Schema::drop('tags');
        Schema::drop('categories');
        Schema::drop('articles');
    }
}
