@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-left">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary">
                    <a href="/profiles/{{$thread->creator->name}}" class="text-white">
                        {{ $thread->creator->name }}
                    </a> posted : 
                    {{ $thread->title }}
                </div>

                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>
            
            @foreach($replies as $reply)
                @include('threads/reply')
            @endforeach
            <div class="row justify-content-center mt-2">{{ $replies->links() }}</div>

            @if (auth()->check())
                <div class="card mt-2">
                    <div class="card-body">
                        <form method="POST" action="{{ $thread->path(). '/replies' }}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="body">コメント : </label>
                                <textarea 
                                    required
                                    name="body" id="" 
                                    placeholder="コメントを入力してください。"
                                    class="form-control" cols="30" rows="10">
                                </textarea>
                            </div>
                            <button type="submit" class="btn btn-defaul">Submit</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="card-header text-center bg-secondary text-white mt-3">
                    <a href="{{ route('login') }}" class="text-white">コメントできるため、ログインしてください</a>
                </div>
            @endif
        </div>
        <div class="col-md-4 pl-0 d-none d-lg-block">
            <div class="card text-white">
                <div class="card-header bg-primary">
                    <p>This thread was published {{ $thread->created_at->diffForHumans() }} <br>
                        <a href="#" class="text-warning">{{ $thread->creator->name }}</a>,
                        and currently has {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection