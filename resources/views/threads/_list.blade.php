@forelse ($threads as $thread)
<div class="card mt-2 border-primary">
    <div class="card-header">
        <div class="d-flex">
            <div>
                <h2 class="mb-0">
                    <a href="{{ $thread->path() }}">
                        @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                            <strong>
                                {{ $thread->title }}
                            </strong>
                        @else
                            {{ $thread->title }}
                        @endif
                    </a>
                </h2>
            <p class="mb-0"> Posted By : <a href="{{ route('profile', $thread->creator) }}"> {{ $thread->creator->name }}</a></p>
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
    <div class="card-footer">
        {{ $thread->visits }} Visits
    </div>
</div>
@empty
<p>There are no relevant results at this time. </p>
@endforelse