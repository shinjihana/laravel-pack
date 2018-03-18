@component('profiles.activities.activity')
    @slot('heading')
        <div>
            <h5>
                {{ $profileUser->name }} replied to 
            <a href="{{$activity->subject->thread->path()}}">{{ $activity->subject->thread->title}}</a>
            </h5>
        </div>
        <div class="ml-auto">
            @if(isset($activity->subject->created_at))
            <strong>created at {{$activity->subject->created_at->diffForHumans()}}</strong> |
            @endif
            <strong>
                {{--  <a href="#">{{ $activity->subject->replies_count }} reply</a>  --}}
            </strong>
        </div>
    @endslot
    
    @slot('body')
        {{ $activity->subject->body}}
    @endslot
@endcomponent