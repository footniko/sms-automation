<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SmsQueue
 * ==============
 *
 * Represents a db model, that is responsible for sms queues
 *
 * @package App
 */
class SmsQueue extends Model
{
    /**
     * Disable timestamps for this model (as we don't have created_at/updated_at fields)
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Fields that will be allowed for mass assignment
     *
     * @var array
     */
    protected $fillable = ['sms_campaign_id', 'phone_number', 'status'];

    /**
     * Relation to sms campaign model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign() {
        return $this->belongsTo(SmsCampaign::class);
    }
}
