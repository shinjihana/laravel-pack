@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-left">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-default border-success">
                    <h4>
                        Profile's {{ $profileUser->name }}
                    <small>Since {{ $profileUser->created_at->diffForHumans()}}</small>
                    </h4>
                </div>
                <div class="card-body">
                   @foreach($threads as $thread)
                   <div class="card mt-2 border-primary">
                        <div class="card-header">
                            <div class="d-flex">
                                <div>
                                    <h2>
                                        <a href="{{ $thread->path() }}">
                                            {{ $thread->title }}
                                        </a>
                                    </h2>
                                </div>
                                <div class="ml-auto">
                                    <strong>created at {{$thread->created_at->diffForHumans()}}</strong> | 
                                    <strong>
                                        <a href="{{ $thread->path() }}">{{ $thread->replies_count }} reply</a>
                                    </strong>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $thread->body }}
                        </div>
                        <div class="card-footer bg-transparent border-success">
                            <div class="d-flex">
                                <div class="ml-auto">
                                    <button type="text" class="btn btn-link">編集</button>
                                </div>
                                <div>
                                    <form action="{{ $thread->path() }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-link">削除</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                   @endforeach
                   <div class="mt-2">{{$threads->links()}}</div>
                </div>
            </div>
        </div>
        @include('layouts.sidebar')
    </div>
</div>

@endsection
