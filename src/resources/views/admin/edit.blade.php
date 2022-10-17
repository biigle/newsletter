@extends('admin.base')

@section('title', 'Edit Newsletter Draft')

@section('admin-content')
<div class="row">
    <div class="col-md-offset-3 col-md-6">
        <h4>Edit newsletter draft</h4>

        <form role="form" method="POST" action="{{ url('api/v1/newsletters', $newsletter->id) }}">
            <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                <label for="subject">Subject</label>
                <input type="text" class="form-control" name="subject" id="subject" value="{{ $newsletter->subject }}" required @if($readOnly) readonly @endif>
                @if($errors->has('subject'))
                    <span class="help-block">{{ $errors->first('subject') }}</span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                <div class="clearfix">
                    <a class="btn btn-default btn-xs pull-right" href="">Preview</a>
                    <label for="body">Body</label>
                </div>
                <textarea name="body" class="form-control" rows="15" @if($readOnly) readonly @endif>{{$newsletter->body}}</textarea>
                @if($errors->has('body'))
                    <span class="help-block">{{ $errors->first('body') }}</span>
                @endif
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="PUT">

            <a href="{{ route('newsletter.admin.index') }}" class="btn btn-default">Back</a>
            <span class="pull-right">
                @if($readOnly)
                    <input type="button" class="btn btn-default" value="Save draft" disabled title="This newsletter was published and cannot be modified">
                @else
                    <input type="submit" class="btn btn-default" value="Save draft">
                @endif
            </span>
        </form>
    </div>
</div>
@endsection
