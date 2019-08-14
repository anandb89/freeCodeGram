<?php

namespace App\Http\Controllers;
//importing the user class to avoid including path everytime
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
Use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{
    //Earlier version: public function index($user)
    //required   $user=User::findOrFail($user); to fetch user
    public function index(\App\User $user)
    {
        //If the user is authenticated, then grab
        //Is the authenticated user following contains user being passed?
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        //Counting the number of posts, moved from index View to the Controller

        /* Before Caching*/
        //$postCount=$user->posts->count();
        //$followersCount=$user->profile->followers->count();
        //$followingCount=$user->following->count();
        //Use remberForever to cache forever

        /* After Caching*/
        $postCount = Cache::remember(
            'count.posts.'.$user->id,
            now()->addSeconds(30),
            function() use ($user) {
            return $user->posts->count();
        });

        $followersCount = Cache::remember(
            'count.followers.'.$user->id,
            now()->addSeconds(30),
            function() use ($user) {
            return $user->profile->followers->count();
        });

        $followingCount = Cache::remember(
            'count.following.'.$user->id,
            now()->addSeconds(30),
            function() use ($user) {
            return $user->following->count();
        });


        //dd($follows);
        //find the user of handle the error instead of crashing the app
       //$user=User::findOrFail($user);
       //user will be the variable name inside the home view
        //return view('profiles.index',['user' => $user,]);
        //refactor return view using compact function
        return view('profiles.index', compact('user','follows','postCount', 'followersCount','followingCount'));

    }

    //An easier method to grab user and error checking
    //Just fetches the profile
    //Actual update is done in the update() function
    public function edit(\App\User $user)
    {
        //After creating a ProfilePolicy for update
        //We are authorizing the update, all it needs is a profile
        //WO login, it would result in 403 error
        $this->authorize('update', $user->profile);

        return view('profiles.edit', compact('user'));
    }

    //
    public function update(User $user)
    {
        $this->authorize('update', $user->profile);

        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);

        //if we now dd data we can see what data is being passed
        //dd($data);


        /* Copied from posts controller */
        //Setting the uploaded image as DP instead of the hardcoded one
        //If request has image then change it, otherwise keep the default one
        if (request('image')){
            //
            //method to store the image - /uploads is where the image will get stored - public is the root directory, file will end up under the storage directory
            //php artisan storage:link would create the public link so that the image can be accessed via the URL
            //After the artisan linking, we can use http://127.0.0.1:8000/storage/uploads/PHQjvPuwJHwxdHAQv3YzeAvBYumv9ddrSmghWSuk.jpeg to see the image
            $imagePath = request('image')->store('profile', 'public');

            //Image class of intervention, will be used to resize the uploaded image
            //fit method to resize, width, height arguments
            //It's not actual resize though, no cutting involved, just fitting in a square
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000,1000);
            $image->save();
            $imageArray =  ['image'=> $imagePath];
        }

           //Prev version:  $user->profile->update($data); any user could update the profile without no login, new version: only auth user can
        // We will also protect it using a policy
        //moved to the bottom after adding image, as data should only be sent after all data is processed
        //removed auth as it was giving error auth()->$user->profile->update(array_merge
        //if  imageArray is not set, default to an empty array - as setting the profile picture should not be mandatory every time 'Edit Profile' is used
      $user->profile->update(array_merge(
            $data,
            $imageArray ?? []
        ));

        return redirect("/profile/{$user->id}");
    }


}
