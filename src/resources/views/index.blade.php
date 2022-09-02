@extends('app')
@section('title', 'Newsletter')
@section('show-navbar', false)
@section('content')
<div class="container">
    <div class="row center-form">
        <div class="col-md-4 col-sm-6">
            <div class="info-text">
                <h1 class="logo logo--standalone"><span class="logo__biigle">BIIGLE</span> <span class="text-muted">Newsletter</span></h1>
                <p class="text-muted">
                    Sign up for the BIIGLE newsletter to keep up to date with important news and events around BIIGLE!
                </p>
            </div>
            <form class="well clearfix" role="form" method="POST" action="{{ url('newsletter/subscribe') }}">
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <input type="email" placeholder="{{ trans('form.email') }}" class="form-control" name="email" value="{{ old('email', isset($user) ? $user->email : '') }}" autofocus required>
                    </div>
                    @if($errors->has('email'))
                        <span class="help-block">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                @if (View::exists('privacy'))
                    <div class="form-group{{ $errors->has('privacy') ? ' has-error' : '' }}">
                        <div class="checkbox">
                            <label>
                                <input name="privacy" type="checkbox" value="1" required @checked(old('privacy'))> I have read and agree to the <a href="{{route('privacy')}}">privacy notice</a>.
                            </label>
                        </div>
                        @if($errors->has('privacy'))
                            <span class="help-block">{{ $errors->first('privacy') }}</span>
                        @endif
                    </div>
                @endif
                {!! Honeypot::generate('website', 'homepage') !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="submit" class="btn btn-success btn-block" value="Sign up for the newsletter">
            </form>
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
