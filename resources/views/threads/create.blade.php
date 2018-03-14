@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">新しいレコードを作成</div>

                <div class="card-body">
                    <form action="/threads" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="title">タイトル</label>
                            <div class="input-group mb-3">
                                <select class="custom-select" id="channel_id" 
                                    name="channel_id" required>
                                        <option value="">Choose One...</option>
                                    @foreach( Happy\ThreadMan\Channel::all() as $channel)
                                        <option value="{{ $channel->id }}"
                                            {{ old('channel_id') == $channel->id ? 'selected' : ''}}
                                        >{{ $channel->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title">タイトル</label>
                            <input type="text" class="form-control" required
                                placeholder="タイトル入力" name="title" value="{{ old('title') }}">
                        </div>
                        <div class="form-group">
                            <label for="content">コンテンツ</label>
                            <textarea 
                                name="body" placeholder="コンテンツを入力" required
                                class="form-control" id="body" rows="3" value="{{ old('body') }}"></textarea>
                        </div>
                        <!-- <input type="hidden" name="channel_id" value="1"> -->
                        @if(count($errors))
                        <ul class="alert alert-danger">
                            @foreach($errors->all() as $error)
                            <li> {{ $error }}</li>
                            @endforeach
                        </ul>
                        @endif
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection