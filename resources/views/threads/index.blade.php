@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Thread Forum</div>

                <div class="card-body">
                    @forelse ($threads as $thread)
                    <div class="card mt-2 border-primary">
                        <div class="card-header">
                            <div class="d-flex">
                                <div>
                                    <h2>
                                        <a href="{{ $thread->path() }}">
                                            @if ($thread->hasUpdatesFor(auth()->user()))
                                                <strong>
                                                    {{ $thread->title }}
                                                </strong>
                                            @else
                                                {{ $thread->title }}
                                            @endif
                                        </a>
                                    </h2>
                                </div>
                                <div class="ml-auto">
                                    <strong>
                                        <a href="{{ $thread->path() }}">{{ $thread->replies_count }} reply</a>
                                    </strong>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $thread->body }}
                        </div>
                    </div>
                    @empty
                    <p>There are no relevant results at this time. </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection