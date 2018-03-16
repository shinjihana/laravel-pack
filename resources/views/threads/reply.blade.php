<div class="card mt-2">
    <div class="card-header bg-success">
        <div class="d-flex">
            <div>
                <a href="/profiles/{{{{ $reply->owner->name }}}}" class="text-white">
                    {{ $reply->owner->name }}
                </a>
                said {{ $reply->created_at->diffForHumans() }}...
            </div>
            <div class="ml-auto">
                <div class="d-flex">
                    <div>
                        <form method="POST" action="/replies/{{$reply->id}}/favorites">
                            {{ csrf_field()}}
                            <button
                                type="submit" class="btn btn-primary"
                                {{ $reply->isFavorited() ?  'disabled' : '' }}
                            >
                                {{ $reply->favorites_count}} Like
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>