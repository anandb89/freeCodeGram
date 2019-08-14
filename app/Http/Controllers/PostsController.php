<?php

namespace App\Http\Controllers;
use App\Post;
use Illuminate\Http\Request;
//Automatically added when we type image and select Intervation/Image/ Facade
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
    //Earlier it was possible to access add new post form without logging in. to prevent that, we use middleware
    //Constructor with auth middleware means that every single route below would require authorization
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //Fetching user ids we're following
        $users = auth()->user()->following()->pluck('profiles.user_id');

        //Fetching posts of the user ids we are following
        //Same thing: $posts = Post::whereIn('user_id', $users)->orderBy('created_at', 'DESC')->get();
        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(5);

        return view('posts.index',compact('posts'));
    }

    public function create()
    {
        //. can also be used instead of forward slash
        return view('posts.create');
    }

    public function store()
    {
        //Throw the data, validate and give back all the validated data
        //Check validation rules on Laravel documentation for validating image
        $data=request()->validate([
            'caption' => 'required',
            //can also be wrapped into an array like 'image'=>['required','image'],
            'image' => 'required|image',
        ]);
            //method to store the image - /uploads is where the image will get stored - public is the root directory, file will end up under the storage directory
            //php artisan storage:link would create the public link so that the image can be accessed via the URL
            //After the artisan linking, we can use http://127.0.0.1:8000/storage/uploads/PHQjvPuwJHwxdHAQv3YzeAvBYumv9ddrSmghWSuk.jpeg to see the image
            $imagePath = request('image')->store('uploads', 'public');

            //Image class of intervention, will be used to resize the uploaded image
            //fit method to resize, width, height arguments
            //It's not actual resize though, no cutting involved, just fitting in a square
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200,1200);
            $image->save();
        //getting the authenticated user, otherwise there would be an sql error as it expects a user id in the Posts migration table
        //Grab the authenticated user, go into their posts and create, laravel behind the scenes gonna add the id, because it knows about the relationship
        auth()->user()->posts()->create(
            [
                    'caption' => $data['caption'],
                    'image' => $imagePath,

            ]);

        //\App\Post::create($data);

        //dd(request()->all());
        //Redirect to the profile of the authenticated user
        return redirect('/profile/' .auth()->user()->id);
    }

    //show method is for displaying the post when clicked on the thumbnail, see laravel methods doc for details
    //earlier version  public function show($post) just gave the ID,
    //Adding \app\post, fetches entire post instead of just the ID
    //for this to work, $post here and $post in web.php route should match
    //no need to findorfail, this automatically does it
    public function show(\App\Post $post)
    {
        //dd($post); for checking if post ID has been fetched
        /*
        return view('posts.show', //[
            'post' => $post,
        ]); */
        //Compact version of above function
        return view('posts.show', compact('post'));
    }
}
