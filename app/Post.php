<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //Laravel prevents upload otherwise
    //Error: Add [caption] to fillable property to allow mass assignment on [App\Post].
    //It's okay to not guard anything
    protected $guarded = [];

   //Inverse of the function defined in User
   public function user()
   {
       //A post only belongs to a single user
       return $this->belongsTo(User::class);
   }

}
