{{-- Editing the question. --}}
<div class="card" v-if="editing">
    <div class="card-header bg-primary">
        <input type="text" class="form-control" v-model="form.title">
    </div>

    <div class="card-body">
        <div class="form-group">
            <textarea class="form-control" rows="10" v-model="form.body"></textarea>
        </div>
    </div>
    <div class="card-footer">
        <div class="d-flex">
            <div>
                <button class="btn btn-xs level-item" @click="editing = true" v-show="! editing">Edit</button>
                <button class="btn btn-primary btn-xs level-item" @click="update">Update</button>
                <button class="btn btn-xs level-item" @click="resetForm">Cancel</button>
            </div>
            @can('update', $thread)
            <div class="ml-auto">
                <form action="{{ $thread->path() }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-link">削除</button>
                </form>
            </div>
        @endcan
        </div>
    </div>

    {{--  <div class="row justify-content-center mt-2">{{ $replies->links() }}</div>  --}}
</div>

{{-- Viewing the question. --}}
<div class="card"  v-else>
    <div class="card-header bg-primary">
        <a href="/profiles/{{$thread->creator->name}}" class="text-white">
            <img src="{{ $thread->creator->avatar_path }}" 
            alt="{{ $thread->creator->name }}" width="25" height="25"
            class="mr-1">
            {{ $thread->creator->name }}
        </a> posted : 
        <span v-text="title"></span>
    </div>

    <div class="card-body">
        <div class="panel-body" v-text="body"></div>
    </div>
    @can('update', $thread)
        <div class="card-footer bg-transparent border-success">
                <div class="d-flex">
                    <div class="panel-footer" v-if="authorize('owns', thread)">
                        <button class="btn btn-xs" @click="editing = true">Edit</button>
                    </div>
                </div>
        </div>
    @endcan
</div>