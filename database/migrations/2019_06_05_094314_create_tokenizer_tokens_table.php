<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class CreateTokenizerTokensTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create('tokenizer_tokens', function(Blueprint $table) {
            $table->increments('id');

            $table->string('token')->unique();
            $table->morphs('tokenizeable');

            $table->boolean('require_user')->default(false);
            $table->unsignedBigInteger('user_id')->nullable()->index();

            $table->integer('session_limit')->nullable();
            $table->integer('session_duration')->nullable();
            $table->integer('session_count')->nullable();

            $table->dateTime('expired_at')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tokenizer_tokens');
    }
}