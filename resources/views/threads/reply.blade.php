<div class="card mt-2">
    <div class="card-header bg-success">
        <a href="#" class="text-white">{{ $reply->owner->name }}</a>
        said {{ $reply->created_at->diffForHumans() }}...
    </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>