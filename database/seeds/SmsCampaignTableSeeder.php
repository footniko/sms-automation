<?php

use App\Enums\SmsCampaignStatus;
use App\Enums\SmsQueueStatus;
use App\Models\SmsCampaign;
use App\Models\SmsQueue;
use Faker\Factory;
use Illuminate\Database\Seeder;

class SmsCampaignTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        //SmsCampaign::truncate();

        $faker = Factory::create();

        $receivers = ['+380988984390', '+380980313660'];

        // Let's create a campaign in our database
        $campaign = SmsCampaign::create([
            'title' => $faker->name,
            'message' => $faker->sentence,
            'receivers' => implode(';', $receivers),
            'status' => SmsCampaignStatus::ACTIVE
        ]);

        // And now queue
        foreach ($receivers as $receiver) {
            SmsQueue::create([
                'sms_campaign_id' => $campaign->id,
                'phone_number' => $receiver,
                'status' => SmsQueueStatus::WAITING
            ]);
        }
    }
}
