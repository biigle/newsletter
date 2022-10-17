@extends('admin.base')

@section('title', 'New Newsletter')

@section('admin-content')
<div class="row">
    <div class="col-md-offset-3 col-md-6">
        <h4>Create a new newsletter</h4>

        <form role="form" method="POST" action="{{ url('api/v1/newsletters') }}">
            <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                <label for="subject">Subject</label>
                <input type="text" class="form-control" name="subject" id="subject" value="{{ old('subject') }}" required>
                @if($errors->has('subject'))
                    <span class="help-block">{{ $errors->first('subject') }}</span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                <label for="body">Body</label>
                <textarea name="body" class="form-control" rows="15">{{old('body')}}</textarea>
                @if($errors->has('body'))
                    <span class="help-block">{{ $errors->first('body') }}</span>
                @endif
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <a href="{{ route('newsletter.admin.index') }}" class="btn btn-default">Cancel</a>
            <span class="pull-right">
                <input type="submit" class="btn btn-default" value="Create draft" title="Create draft">
            </span>
        </form>
    </div>

</div>

@endsection
