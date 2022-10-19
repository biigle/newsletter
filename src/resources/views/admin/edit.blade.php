@extends('admin.base')

@section('title', 'Edit Newsletter Draft')

@section('admin-content')
<div class="row">
    <div class="col-md-offset-3 col-md-6">
        <h4 class="clearfix">
            Edit newsletter draft

            @unless($readOnly)
                <span class="pull-right">
                    <form method="POST" action="{{ url('api/v1/newsletters', $newsletter->id) }}" onsubmit="return confirm('Are you sure you want to discard this draft?');">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-default btn-xs" title="Discard this draft"><i class="fa fa-trash-alt"></i></button>
                    </form>
                </span>
            @endunless
        </h4>

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
                    <a class="btn btn-default btn-xs pull-right" href="{{route('newsletter.show', $newsletter->id)}}">
                        @if ($readOnly)
                            Show
                        @else
                            Preview
                        @endif
                    </a>
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
                    <input type="submit" class="btn btn-success" value="Publish" disabled title="This newsletter was already published">
                    <input type="button" class="btn btn-default" value="Save" disabled title="This newsletter was published and cannot be modified">
                @else
                    <input type="submit" form="publish-form" class="btn btn-success" value="Publish">
                    <input type="submit" class="btn btn-default" value="Save">
                @endif
            </span>
        </form>

        @unless($readOnly)
            <form id="publish-form" method="POST" action="{{ url('api/v1/newsletters', $newsletter->id) }}/publish" onsubmit="return confirm('Are you sure you want to publish this draft?');">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="POST">
            </form>
        @endunless
    </div>
</div>
@endsection
