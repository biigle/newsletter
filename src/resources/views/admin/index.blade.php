@extends('admin.base')

@section('title', 'Newsletter subscribers admin area')

@section('admin-content')

<div class="clearfix">
    <div class="pull-right">
        @if ($draft)
            <a class="btn btn-info" href="{{route('newsletter.admin.edit', $draft->id)}}"><i class="fa fa-inbox"></i> Edit draft</a>
        @else
            <a class="btn btn-default" href="{{route('newsletter.admin.create')}}"><i class="fa fa-inbox"></i> Create new draft</a>
        @endif
    </div>
    <form class="form-inline inline-block-form" action="{{route('newsletter.admin.index')}}" method="get">
        <input class="form-control" type="text" name="q" placeholder="Search subscribers" value="{{$query}}">
    </form>
</div>
@if ($query)
    <a href="{{route('newsletter.admin.index')}}" class="btn btn-info" title="Clear filtering"><i class="fas fa-times"></i></a>
@endif

<table class="table table-hover">
    <thead>
        <tr>
            <th>Email</th>
            <th>Subscribed</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse($subscribers as $s)
            <tr>
                <td>
                    <a href="mailto:{{$s->email}}">{{$s->email}}</a>
                </td>
                <td title="{{$s->created_at}}">
                    {{$s->created_at->diffForHumans()}}
                </td>
                <td>
                    <form class="form-inline clearfix" action="{{url('api/v1/newsletter-subscribers', $s->id)}}" method="post" onsubmit="return confirm('Are you sure you want to delete {{$s->email}}?')">
                        <button type="submit" class="btn btn-xs btn-default pull-right" title="Delete subscriber {{$s->email}}"><i class="fa fa-trash"></i></button>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" name="_redirect" value="{{ route('newsletter.admin.index') }}">
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-muted">
                    @if ($query)
                        No subscribers found for query "{{$query}}".
                    @else
                        No subscribers found.
                    @endif
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
<nav class="text-center">
    {{$subscribers->links()}}
</nav>
@endsection
