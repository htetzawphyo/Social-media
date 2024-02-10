@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between">
        <h3 class="h4 text-dark fw-bold">Edit Post Form</h3>
        <a href="" class="btn btn-primary">< Back</a>
    </div>
    <div class="row justify-content-center mt-5">

        <div class="col-12 col-lg-10">
            <div class="card">
                <div class="card-body ">
                    <form action="{{ route('post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        <div class="mb-3">
                            <label for="title" class="fw-bold">Title</label>
                            <input type="text" name="title" class="form form-control" placeholder="Title" value="{{ old('title', $post->title) }}">
                            @error('title')
                                <span class="text-danger text-itelic" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="body">Body</label>
                            <textarea name="body" id="body" cols="30" rows="5" class="form form-control" placeholder="Body">
                            {{ old('body', $post->body) }}
                            </textarea>
                            @error('body')
                                <span class="text-danger text-itelic" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
