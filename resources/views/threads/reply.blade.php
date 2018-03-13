<div class="col-md-12 pt-1">
    <div class="card">
        <div class="card-header bg-success">
            <a href="#" class="text-white">{{ $reply->owner->name }}</a>
            said {{ $reply->created_at->diffForHumans() }}...
        </div>
        <div class="card-body">
            {{ $reply->body }}
        </div>
    </div>
</div>