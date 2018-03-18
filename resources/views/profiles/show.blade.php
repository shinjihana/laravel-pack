@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-left">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-default border-success">
                    <h4>
                        Profile's {{ $profileUser->name }}
                    </h4>
                </div>
                <div class="card-body">
                   @foreach($activities as $date => $activity)
                        <h3 class="card-title">{{$date}}</h3>
                        @foreach($activity as $record)
                            @include ("profiles.activities.{$record->type}", ['activity' => $record])
                        @endforeach
                   @endforeach
                </div>
            </div>
        </div>
        @include('layouts.sidebar')
    </div>
</div>

@endsection
