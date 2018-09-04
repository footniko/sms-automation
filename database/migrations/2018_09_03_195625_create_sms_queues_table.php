<?php

use App\Enums\SmsQueueStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_queues', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sms_campaign_id');
            $table->string('phone_number', 20);
            $table->string('status')->default(SmsQueueStatus::WAITING);

            $table->foreign('sms_campaign_id')
                ->references('id')
                ->on('sms_campaigns')
                ->onUpdate('cascade')
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
        Schema::dropIfExists('sms_queues');
    }
}
