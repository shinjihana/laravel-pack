@component('profiles.activities.activity')
    @slot('heading')
        <div>
            <h5>
                <a href="{{ $activity->subject->favorited->path() }}">
                    {{ $profileUser->name }}
                </a> favorited a reply
             </h5>
        </div>
        <div class="ml-auto">
            |
        </div>
    @endslot
    
    @slot('body')
        <strong>{{$activity->subject->favorited->body}}</strong> 
    @endslot
@endcomponent