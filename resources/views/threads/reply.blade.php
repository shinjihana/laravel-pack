<reply :attributes="{{ $reply }}" inline-template>
    <div id="reply-{{ $reply->id }}" class="card mt-2">
        <div class="card-header bg-success">
            <div class="d-flex">
                <div>
                    <a href="/profiles/{{ $reply->owner->name }}" class="text-white">
                        {{ $reply->owner->name }}
                    </a>
                    said {{ $reply->created_at->diffForHumans() }}...
                </div>
                @if(Auth::check())
                    <div class="ml-auto">
                        <div class="d-flex">
                            <div>
                                <favorite :reply="{{ $reply }}"></favorite>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div v-if="editting">
                <div class="form-group">
                    <label for="edit">Edit</label>
                    <textarea
                        name="edit" id=""
                        rows="3" class="form-control"
                        v-model="body"
                    ></textarea>
                </div>
                <button class="btn btn-primary" @click="update">Update</button>
                <button class="btn btn-xs" @click="editting = false">Cancel</button>
            </div>
            <div v-else="" v-text="body"></div>
        </div>
        @can('update', $reply)
        <div class="card-header">
            <div class="d-flex">
                <button class="btn btn-xs mr-2" @click="editting = true">Edit</button>
                <button class="btn btn-xs btn-danger mr-2" @click="destroy">Delete</button>
            </div>
        </div>
        @endcan
    </div>
</reply>