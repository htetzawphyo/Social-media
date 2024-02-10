@extends("layouts.app")

@section("content")
    <div class="container">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $post->title }}</h5>
                <div class="card-subtitle mb-2 text-muted small">
                By <b>{{ $post->user->name }}</b>, {{ $post->created_at->diffForHumans() }}
                </div>
                <p class="card-text">{{ $post->body }}</p>
            </div>
        </div>

        @if(session('message'))
            <p class="alert alert-info">{{ session('message') }}</p>
        @endif
        @if(session('error'))
            <p class="alert alert-danger">{{ session('error') }}</p>
        @endif

        <ul class="list-group mb-4">
            <li class="list-group-item active bg-secondary">
                <b>Comments ({{ $comments->count() }})</b>
            </li>
            
            @foreach($comments as $key => $comment)
                <li class="list-group-item">
                    @if (Auth::user()->id === $post->user_id || Auth::user()->id === $comment->user_id)
                        <form action="{{ route('comment.delete', $comment->id) }}" method="POST" >
                            @csrf
                            @method('DELETE')
                            <span class="btn delete-confirm{{$comment->id}} float-end" onclick="deleteComment('{{ $comment->id }}', event)">
                                <img src="{{ asset('./delete.svg') }}" alt="delete">
                            </span>
                        </form>
                    @endif

                    @if (Auth::user()->id === $comment->user_id)
                        <form action="{{ route('comment.delete', $comment->id) }}" method="POST" >
                            @csrf
                            @method('DELETE')
                            <span class="btn float-end edit-button{{$comment->id}}" onclick="toggleCommentBox('{{ $comment->id }}', 'show')">
                                <img src="{{asset('./edit.svg')}}" alt="edit" class="">
                            </span>
                        </form>
                    @endif
                    
                    <p>
                        {{ $comment->text }}
                    </p>
                    
                    <span class="btn float-end d-none hide-edit-comment-box{{$comment->id}}" onclick="toggleCommentBox('{{ $comment->id }}', 'hide')">
                        <img src="{{ asset('./delete.svg') }}" alt="delete">
                    </span>

                    <!-- Begin::Comment Edit Form -->
                    <form action="{{route('comment.update', $comment->id)}}" method="POST">
                        @csrf
                        @method('PATCH')
                        <textarea name="text" id="" cols="" rows="2" class="form-control edit-comment-box{{$comment->id}} d-none mb-2"></textarea>
                        <button type="submit" class="btn btn-sm btn-info edit-comment-box{{$comment->id}} d-none">Update</button>
                    </form>
                    <!-- Begin::Comment Edit Form -->


                    <div class="small mt-2">
                        By <b>{{ $comment->user->name }}</b>,
                        {{ $comment->created_at->diffForHumans() }}
                    </div>
                </li>
            @endforeach
        </ul>

        <form action="{{ route('comment.create') }}" method="post">
            @csrf
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <label for="comment" class="fw-bold">Add Comment</label>
            <textarea name="text" class="form-control mb-2" placeholder="New Comment"></textarea>
            @error('text')
                <div class="text-danger text-itelic" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
            @enderror
            <button type="submit" class="btn btn-secondary">Add Comment</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        let deleteComment = (id, event) => {
            let delBtn = document.querySelector(`.delete-confirm${id}`);
            if (confirm('Are you sure you want to delete this comment?')) {
                event.preventDefault();
                delBtn.closest('form').submit();
            }
        }

        let toggleCommentBox = (id, text) => {
            let delBtn = document.querySelector(`.delete-confirm${id}`);
            let editBtn = document.querySelector(`.edit-button${id}`);
            let toggleCloseBtn = document.querySelector(`.hide-edit-comment-box${id}`);
            let cmtBox = document.querySelectorAll(`.edit-comment-box${id}`);

            if(text == 'show'){
                cmtBox[0].classList.remove('d-none');
                cmtBox[1].classList.remove('d-none');
                toggleCloseBtn.classList.remove('d-none');
                delBtn.classList.add('d-none');
                editBtn.classList.add('d-none');

                getComment(id);
            }else{
                cmtBox[0].classList.add('d-none');
                cmtBox[1].classList.add('d-none');
                toggleCloseBtn.classList.add('d-none');
                delBtn.classList.remove('d-none');
                editBtn.classList.remove('d-none');
            }
        }

        async function getComment(id) {
            let cmtBox = document.querySelectorAll(`.edit-comment-box${id}`);

            const response = await fetch(`/comment/${id}`);
            const data = await response.json();

            cmtBox[0].textContent = data.text;
        }
    </script>
@endpush