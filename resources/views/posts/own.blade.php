@extends('layouts.app')

@section('content')
<div class="container">
    
    {{ $posts->links() }} 

    <div class="row justify-content-start">

        @if ($posts->count() == 0)
            <div class="card">
                <div class="card-body text-center">
                    <h4>Nothing posts</h4>
                </div>
            </div>
        @endif
        @foreach ($posts as $post)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5 class=" h4 fw-bold">{{ $post->title }} </h5>

                        @if (Auth::check() && Auth::user()->id === $post->user->id)
                            <form action="{{ route('post.delete', $post->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <span class="btn btn-warning delete-confirm{{$post->id}}" onclick="deletePost('{{ $post->id }}', event)">Delete</span>
                            </form>
                        @endif
                    </div>

                    <div class="card-subtitle mb-2 text-muted small">
                        {{ $post->created_at->diffForHumans() }}
                    </div>
                    
                    <p>{{ $post->body }}</p>

                    <a class="card-link"  href="{{ route('post.edit', $post->id) }}">
                        Edit &raquo;
                    </a>
                </div>
            </div>
        @endforeach

    </div>
</div>
@endsection

@push('scripts')
    <script>
        let deletePost = (id, event) => {
            let delBtn = document.querySelector(`.delete-confirm${id}`);
            if (confirm('Are you sure you want to delete this post?')) {
                event.preventDefault();
                delBtn.closest('form').submit();
            }
        }
    </script>
@endpush