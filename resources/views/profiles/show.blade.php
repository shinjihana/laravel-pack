@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-left">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-default border-success">
                    <avatar-form :user="{{ $profileUser }}"></avatar-form>
                </div>
                <div class="card-body">
                   @forelse($activities as $date => $activity)
                        <h3 class="card-title">{{$date}}</h3>
                        @foreach($activity as $record)
                            @if (view()->exists("profiles.activities.{$record->type}"))
                                @include ("profiles.activities.{$record->type}", ['activity' => $record])
                            @endif
                        @endforeach
                    @empty
                    <p>There is no activity for this user</p>
                   @endforelse
                </div>
            </div>
        </div>
        @include('layouts.sidebar')
    </div>
</div>

@endsection
