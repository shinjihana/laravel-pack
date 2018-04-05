@extends('layouts.app')

@section('header')
    <link href="/css/vendor/jquery.atwho.css" rel="stylesheet">
@endsection

@section('content')
<thread-view
    inline-template
    :thread="{{ $thread }}"
    >
    <div class="container">
        <div class="row justify-content-left">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary">
                        <a href="/profiles/{{$thread->creator->name}}" class="text-white">
                            <img src="{{ $thread->creator->avatar_path }}" 
                            alt="{{ $thread->creator->name }}" width="25" height="25"
                            class="mr-1">
                            {{ $thread->creator->name }}
                        </a> posted : 
                        {{ $thread->title }}
                    </div>
    
                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                    @can('update', $thread)
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
                    @endcan
                </div>
                
                <replies @added="repliesCount++" @removed="repliesCount--"></replies>
                
                {{--  <div class="row justify-content-center mt-2">{{ $replies->links() }}</div>  --}}
    
            </div>
            <div class="col-md-4 pl-0 d-none d-lg-block">
                <div class="card text-white">
                    <div class="card-header bg-primary">
                        <p>This thread was published {{ $thread->created_at->diffForHumans() }} <br>
                            <a href="#" class="text-warning">{{ $thread->creator->name }}</a>,
                            and currently has <span v-text="repliesCount"></span> comments
                        </p>
                        <p>
                            <subscribe-button 
                                :active="{{ json_encode($thread->isSubscribedTo) }}"
                                v-if="signedIn"
                                ></subscribe-button>
                            <button
                                class="btn btn-default"
                                v-if="authorize('isAdmin')"
                                @click="toggleLock"
                                v-text="locked ? 'Unlock' : 'Lock'"
                            ></button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-view>

@endsection