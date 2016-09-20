<?php

use Phinx\Migration\AbstractMigration;
use Database\InitCapsuleTrait;
use Illuminate\Database\Schema\Blueprint;

class InitDb extends AbstractMigration
{
    use InitCapsuleTrait;

    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->schema->create('notes', function (Blueprint $table) {
            $table->increments('id');
            $table->text('text');
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
