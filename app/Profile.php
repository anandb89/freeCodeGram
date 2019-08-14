<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    //disabling mass assignment error
    protected $guarded = [];

    //If the image is set by the user, display uploaded image as dp else placeholder image
    public function profileImage()
    {
        $imagePath = ($this->image) ? $this->image:'profile/NBDP97WuszITc1yxlPdeLWV0Gg38IbbATc9hJmWq.png';
        return '/storage/'.$imagePath;
    }

    //a profile can have multiple followers
    public function followers()
    {
        return $this->belongsToMany(User::class);
    }

    //To establish relationship, fetching user_id
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Writing inverse to fetch user->profile, profile->user
}
