@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="card-header">Thread Forum</div>

                <div class="card-body">
                    @include ('threads._list')

                    <div class="mt-3">
                        {{ $threads->render() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @if (count($trending))
                <div class="card border-primary">
                    <div class="card-header">
                        Trending Threads
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($trending as $thread)
                                <li class="list-group-item">
                                    <a href="{{ url($thread->path) }}">
                                        {{ $thread->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection