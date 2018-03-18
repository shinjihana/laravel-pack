<div class="card mt-2 border-primary">
    <div class="card-header">
        <div class="d-flex">
            {{ $heading }}
        </div>
    </div>
    <div class="card-body">
        {{ $body }}
    </div>
    <div class="card-footer bg-transparent border-success">
        <div class="d-flex">
            <div class="ml-auto">
                <button type="text" class="btn btn-link">編集</button>
            </div>
            <div>
                {{--  <form action="{{ $thread->path() }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-link">削除</button>
                </form>  --}}
            </div>
        </div>
    </div>
</div>