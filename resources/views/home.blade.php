@extends('layouts.app')

@section('meta')
    {{-- get the current authenticated user's id and set in meta --}}
    <meta name="user-id" content="{{ Auth::user()->id }}">
@endsection

@section('content')
<div class="pad">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <dashboard></dashboard>
        </div>
    </div>
</div>
@endsection
