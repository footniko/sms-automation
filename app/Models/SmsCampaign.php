<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SmsCampaign
 * =================
 *
 * Represents a db model, that is responsible for sms campaigns
 *
 * @package App
 */
class SmsCampaign extends Model
{
    /**
     * The name of the "updated at" column. We just make it not usable by Laravel
     *
     * @var string
     */
    const UPDATED_AT = null;

    /**
     * Fields that will be allowed for mass assignment
     *
     * @var array
     */
    protected $fillable = ['title', 'message', 'receivers', 'status'];
}
