<?php

use App\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class InitDb extends Migration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->schema->create('notes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('text');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->schema->drop('notes');
    }
}
