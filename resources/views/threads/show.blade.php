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
            @include ('threads._question')
            <replies @added="repliesCount++" @removed="repliesCount--"></replies>
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