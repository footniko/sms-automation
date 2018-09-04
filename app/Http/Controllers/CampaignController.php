<?php

namespace App\Http\Controllers;

use App\Enums\SmsCampaignStatus;
use App\Enums\SmsQueueStatus;
use App\Http\Resources\CampaignResource;
use App\Models\SmsCampaign;
use App\Models\SmsQueue;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CampaignController extends Controller
{
    /**
     * Returns all campaigns available
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return CampaignResource::collection(SmsCampaign::all());
    }

    /**
     * Creates new campaign
     *
     * @param Request $request
     * @return CampaignResource
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', ['max' => 3]],
            'message' => ['required'],
            'receivers' => ['required', 'array'],
        ]);

        // Need to validate specified phone numbers
        foreach ($request->receivers as $phone) {
            if (!preg_match("/^\+380[0-9]{9}$/", $phone)) {
                throw ValidationException::withMessages([
                    'receivers' => ['Phone numbers should be with the following format: +380XXXXXXXXX']
                ]);
            }
        }

        $receivers = implode(';', $request->receivers);

        // Create a campaign
        $campaign = SmsCampaign::create([
            'title' => $request->title,
            'message' => $request->message,
            'receivers' => $receivers,
            'status' => SmsCampaignStatus::ACTIVE,
        ]);

        // Now add the phone numbers with messages to queue that will be handled further
        foreach ($request->receivers as $receiver) {
            SmsQueue::create([
                'sms_campaign_id' => $campaign->id,
                'phone_number' => $receiver,
                'status' => SmsQueueStatus::WAITING
            ]);
        }

        return new CampaignResource($campaign);
    }

    /**
     * Returns a campaign by its id
     *
     * @param SmsCampaign $id
     * @return CampaignResource
     */
    public function show(SmsCampaign $id)
    {
        return new CampaignResource($id);
    }
}
