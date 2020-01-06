<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHelpdeskTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('helpdesk_tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('helpdesk_team_id');
            $table->unsignedBigInteger('user_id')->nullable(); // user assigned to work on the ticket
            $table->string('owner'); //email address who created the ticket from incoming email
            $table->enum('priority', ['low', 'normal', 'high'])->default('normal');
            $table->enum('stage', ['new','in_progress','customer_reply','closed','cancelled'])->default('new');
            $table->string('subject',255)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('helpdesk_team_id')->references('id')->on('helpdesk_teams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('helpdesk_tickets');
    }
}
