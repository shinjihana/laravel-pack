@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <a href="#" class="text-white">{{ $thread->creator->name }}</a> posted : 
                    {{ $thread->title }}
                </div>

                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center pt-5">
        @foreach($thread->replies as $reply)
            @include('threads/reply')
        @endforeach
    </div>
    @if (auth()->check())
    <div class="row justify-content-center pt-2">
        <div class="col-md-12">
            <div class="card">
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
        </div>
    </div>
    @else
    <div class="row justify-content-center pt-2">
        <div class="col-md-12">
            <div class="card-header text-center bg-secondary text-white">
                <a href="{{ route('login') }}" class="text-white">コメントできるため、ログインしてください</a>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection