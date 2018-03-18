@component('profiles.activities.activity')
    @slot('heading')
        <div>
            <h5>
                {{ $profileUser->name }} published a 
                <a href="{{$activity->subject->path()}}"> {{$activity->subject->title}}</a>
            </h5>
        </div>
        <div class="ml-auto">
            {{--  <strong>created at {{$thread->created_at->diffForHumans()}}</strong> | 
            <strong>
                <a href="{{ $thread->path() }}">{{ $thread->replies_count }} reply</a>
            </strong>  --}}
        </div>
    @endslot
    
    @slot('body')
        {{ $activity->subject->body}}
    @endslot
@endcomponent