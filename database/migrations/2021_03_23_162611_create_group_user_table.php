<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_user', function (Blueprint $table) 
        {
            $table->id(); 
            $table->foreignId('user_id')->constrained()->onDelete('cascade');         
            $table->foreignId('group_id')->constrained()->onDelete('cascade');         
        });

         // Insert some stuff
         DB::table('group_user')->insert(
            array(
                [
                    'user_id' => '1',
                    'group_id' => '1',
                ],
                [
                    'user_id' => '1',
                    'group_id' => '2',
                ],
                [
                    'user_id' => '1',
                    'group_id' => '3',
                ],
                [
                    'user_id' => '2',
                    'group_id' => '2',
                ],
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
        Schema::dropIfExists('group_user');
    }
}
