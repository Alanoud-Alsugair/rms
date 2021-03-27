<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) 
        {

            $table->id();

            $table->string('name');
            $table->text('desc');

            $table->foreignId('group_id')->constrained()->onDelete('cascade');

            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            
        });

        DB::table('reports')->insert(
            array(
                [
                    'name' => 'aaaaa',
                    'desc' => 'desc1' ,
                    'group_id' => 1 ,
                    'created_by' => 1 ,
                ],
                [
                    'name' => 'bbbbb',
                    'desc' => 'desc2' ,
                    'group_id' => 1 ,
                    'created_by' => 2 ,
                ],
                [
                    'name' => 'ccccc',
                    'desc' => 'desc3' ,
                    'group_id' => 2 ,
                    'created_by' => 1 ,
                ],
                [
                    'name' => 'ddddd',
                    'desc' => 'desc4' ,
                    'group_id' => 1 ,
                    'created_by' => 1 ,
                ]
            )
        );


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
