<?php

namespace App\Console\Commands;

use App\Enums\SmsCampaignStatus;
use App\Enums\SmsLogStatus;
use App\Enums\SmsQueueStatus;
use App\Models\SmsCampaign;
use App\Models\SmsLog;
use App\Models\SmsQueue;
use Illuminate\Console\Command;

/**
 * Class SendSms
 * =============
 *
 * Kernel command that executes sending sms that are in queue
 *
 * @package App\Console\Commands
 */
class SendSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send SMS which are in queue';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $limit = config('app.messages_limit');
        $query = SmsQueue::with(['campaign' => function($query) {
            $query->where('status', '=', SmsCampaignStatus::ACTIVE);
        }])
            ->where('status', '=', SmsQueueStatus::WAITING);

        $smsItems = $query->limit($limit)->get();
        $smsItemsCount = $query->count();

        if ($smsItemsCount <= 0) {
            $this->comment('No queued sms messages found.');
        }

        foreach ($smsItems as $item) {
            // @TODO: replace random result with Twilio API
            $failure = rand(0, 1);

            $this->comment("Sending a message to {$item->phone_number}...");
            $smsLog = SmsLog::create([
                'sms_queue_id' => $item->id,
                'message' => $failure
                    ? "Unable to send a message to {$item->phone_number}. Unknown error occurred."
                    : "Success",
                'status' => $failure ? SmsLogStatus::FAILURE : SmsLogStatus::SUCCESS,
            ]);

            SmsQueue::where(['id' => $item->id])
                ->update(['status' => SmsQueueStatus::SENT]);

            $this->comment("{$smsLog->message}.");

            // Mark the whole campaign as finished if it was the last message in it
            if ($limit >= $smsItemsCount) {
                SmsCampaign::where(['id' => $item->sms_campaign_id])
                    ->update(['status' => SmsCampaignStatus::SENT]);

                $this->comment('It was the last message of this campaign.');
            }
        }
    }
}
