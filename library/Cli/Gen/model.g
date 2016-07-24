<?php

namespace App\Models;

use Illustrator\Database\Migrations\Schema;
use Illustrator\Database\Migrations\SchemaPrint;

class dummyClass extends Schema
{
	/**
	 * run the migrations
	 */
	public function up()
	{
        $this->create('dummyTable', function(SchemaPrint $table) {
            //
        });
	}

	/**
	 * reverse migrations
	 */
	public function down()
	{
        $this->down('dummyTable');
	}

}