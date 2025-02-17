<!-- Base app layout views are created by stacking layouts, see app.blade.layout for more info-->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 p-5">
        <img src="{{ $user->profile->profileImage() }}" alt="not found" class="rounded-circle w-100">
        </div>

        <div class="col-9 pt-5">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="d-flex align-items-center pb-3">
                        <div class="h4">{{ $user->username }}</div>

                        <!-- Refers to Vue component of button, see FollowButton.vue and app.js-->
                <follow-button user-id="{{ $user->id }}" follows="{{$follows}}">

                        </follow-button>
                </div>


            <!-- can directive only makes link visible if the user is auth-->
            @can('update', $user->profile)
            <a href="/p/create">Add New Post</a>
            @endcan


            </div>
            <!-- can directive only makes link visible if the user is auth-->
            @can('update', $user->profile)
            <a href="/profile/{{ $user->id }}/edit">Edit Profile</a>
            @endcan

            <div class="d-flex">
                <div class="pr-5"><strong>{{$postCount}} </strong>posts</div>
            <div class="pr-5"><strong>{{$followersCount}} </strong>followers</div>
                <div class="pr-5"><strong>{{$followingCount}} </strong>following</div>
            </div>
            <div class="pt-4 font-weight-bold">{{$user->profile->title}} </div>
            <div>
                {{$user->profile->description}}
            </div>
            <!-- Gimme the URL or ?? print N/A-->
            <div> <a href="#">{{$user->profile->url ?? 'N/A' }}</a> </div>
        </div>
    </div>

    <div class="row pt-5">
        @foreach($user->posts as $post)
        <div class="col-4 pb-4">
        <a href="/p/{{$post->id}}">
                    <img src="/storage/{{ $post->image }}" class="w-100">
            </a>

        </div>
        @endforeach


    </div>
</div>
@endsection
