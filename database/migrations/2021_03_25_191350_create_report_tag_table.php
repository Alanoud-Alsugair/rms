<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained()->onDelete('cascade');         
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');         
        });

         // Insert some stuff
         DB::table('report_tag')->insert(
            array(
                [
                    'report_id' => '1',
                    'tag_id' => '1',
                ],
                [
                    'report_id' => '1',
                    'tag_id' => '2',
                ],
                [
                    'report_id' => '2',
                    'tag_id' => '2',
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
        Schema::dropIfExists('report_tag');
    }
}
