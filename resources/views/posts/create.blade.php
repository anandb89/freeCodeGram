<!-- Base app layout views are created by stacking layouts, see app.blade.layout for more info-->
@extends('layouts.app')

@section('content')
<div class="container">

   <form action="/p" enctype="multipart/form-data" method="post">

    <!-- Security feature - use to get rid of 419 page expired error, CSRF allows laravel to limit who can post to our form, adds key for each form for validation  -->
    @csrf
        <div class="row">
                <div class="col-8 offset-2">
                        <div class="row">
                            <h1>Add New Post</h1>
                        </div>
                        <div class="form-group row">
                                <label for="caption" class="col-md-4 col-form-label">Post Caption</label>


                                    <input id="caption"
                                    type="text"
                                    class="form-control @error('caption') is-invalid @enderror"
                                    name="caption"
                                    caption="caption"
                                    value="{{ old('caption') }}"
                                    autocomplete="caption" autofocus>

                                    @error('caption')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="row">
                                        <label for="image" class="col-md-4 col-form-label">Post Image</label>
                                    <input type="file" class="form-control-file" id="image" name="image">

                                    @error('image')

                                        <strong>{{ $message }}</strong>

                                @enderror

                                </div>

                             <div class="row pt-4">
                                 <button class="btn btn-primary">
                                    Add New Post
                                 </button>
                            </div>
                </div>
            </div>
   </form>

</div>
@endsection
