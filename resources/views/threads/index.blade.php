@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Thread Forum</div>

                <div class="card-body">
                    @include ('threads._list')

                    <div class="mt-3">
                        {{ $threads->render() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection