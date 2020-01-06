<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHelpdeskTicketMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('helpdesk_ticket_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('helpdesk_ticket_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('from',255);
            $table->text('message')->nullable();
            $table->text('html')->nullable();
            $table->timestamps();

            $table->foreign('helpdesk_ticket_id')->references('id')->on('helpdesk_tickets')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('helpdesk_ticket_messages');
    }
}
