<!-- Base app layout views are created by stacking layouts, see app.blade.layout for more info-->
@extends('layouts.app')

@section('content')
<div class="container">
<form action="/profile/{{ $user->id }}" enctype="multipart/form-data" method="post">

            <!-- Security feature - use to get rid of 419 page expired error, CSRF allows laravel to limit who can post to our form, adds key for each form for validation  -->
            @csrf
            <!-- We need to post with method Patch, patch can't be directly used in as form method -->
            @method ('PATCH')
                <div class="row">
                        <div class="col-8 offset-2">
                                <div class="row">
                                    <h1>Edit Profile</h1>
                                </div>
                                <div class="form-group row">
                                        <label for="title" class="col-md-4 col-form-label">Title</label>


                                            <input id="title"
                                            type="text"
                                            class="form-control @error('title') is-invalid @enderror"
                                            name="title"
                                            caption="title"
                                            value="{{ old('title') ?? $user->profile->title }}"
                                            autocomplete="title" autofocus>

                                            @error('title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group row">
                                                <label for="description" class="col-md-4 col-form-label">Description</label>


                                                    <input id="description"
                                                    type="text"
                                                    class="form-control @error('description') is-invalid @enderror"
                                                    name="description"
                                                    caption="description"
                                                    value="{{ old('description') ?? $user->profile->description }}"
                                                    autocomplete="description" autofocus>

                                                    @error('description')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group row">
                                                        <label for="url" class="col-md-4 col-form-label">URL</label>


                                                            <input id="url"
                                                            type="text"
                                                            class="form-control @error('url') is-invalid @enderror"
                                                            name="url"
                                                            caption="url"
                                                            value="{{ old('url') ?? $user->profile->url }}"
                                                            autocomplete="url" autofocus>

                                                            @error('url')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>


                                        <div class="row">
                                                <label for="image" class="col-md-4 col-form-label">Profile Image</label>
                                            <input type="file" class="form-control-file" id="image" name="image">

                                            @error('image')

                                                <strong>{{ $message }}</strong>

                                        @enderror

                                        </div>

                                     <div class="row pt-4">
                                         <button class="btn btn-primary">
                                            Save Profile
                                         </button>
                                    </div>
                        </div>
                    </div>
           </form>
</div>
@endsection
