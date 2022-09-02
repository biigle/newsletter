@extends('app')
@section('title', 'Newsletter')
@section('show-navbar', false)
@section('content')
<div class="container">
    <div class="row center-form">
        <div class="col-md-4 col-sm-6">
            <div class="info-text">
                <h1 class="logo logo--standalone"><span class="logo__biigle">BIIGLE</span> <span class="text-muted">Newsletter</span></h1>
            </div>
            <p class="lead text-center text-success">
                Success!
            </p>
            <p class="text-center">
                You are now subscribed to the BIIGLE newsletter.
            </p>
        </div>
    </div>
</div>
@include('partials.footer', [
    'positionAbsolute' => true,
    'links' => [
        'Home' => route('home'),
    ],
])
@endsection
