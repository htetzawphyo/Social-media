@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between">
        <div class="">
            <a href="" class="h5 ">News feed</a>
            <a href="" class="h5 ">My posts</a>
        </div>
        <a href="{{ route('post.add') }}" class="btn btn-primary">+ Add Post</a>
    </div>
    <div class="row justify-content-center">

        @foreach ([1,2,3,4,5,6, 1,2,3,4,5,6] as $post)     
            <div class="col-lg-4 col-md-6 col-sm-12 g-3 ">
                <div class="card bg-secondary">
                    <div class="card-header">
                        <div class="text-white h4 fw-bold">Title</div>
                    </div>
                    <div class="card-body text-white">
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Hic pariatur velit magni officia accusantium quas ad quidem perferendis nesciunt cumque quae nisi eius maiores esse expedita, libero fugit adipisci ea?
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>
@endsection
