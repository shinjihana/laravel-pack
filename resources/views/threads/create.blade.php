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
                            <input type="text" class="form-control" placeholder="タイトル入力" name="title">
                        </div>
                        <div class="form-group">
                            <label for="content">コンテンツ</label>
                            <textarea 
                                name="body" placeholder="コンテンツを入力"
                                class="form-control" id="body" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection