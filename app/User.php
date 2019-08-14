<?php

namespace App;

use App\Mail\NewUserWelcomeMail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //This method gets called when we are booting up the model
    protected static function boot()
    {
        parent::boot();

        //created event gets fired whenever a new user gets created
        //Based on Eloquent Model events from Laravel doc
        static::created(function ($user) {
            $user->profile()->create([
                'title' => $user->username,
            ]);

            Mail::to($user->email)->send(new NewUserWelcomeMail());

        });
    }

    //User and post - many to many relationship defined here
    public function posts()
    {
        //Orderby added to show the latest post first, by default it's ASC
        //Created at column gets added to the database automatically
        return $this->hasMany(Post::class)->orderBy('created_at', 'DESC');
    }

    //User can follow many profiles
    public function following()
    {
        return $this->belongsToMany(Profile::class);
    }

    //a profile belongs to a user and a user has a profile
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}
