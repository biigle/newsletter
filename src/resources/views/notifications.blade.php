@extends('app')

@section('title', "Newsletter archive")

@section('content')
<div class="container">
    @include('partials.notification-tabs')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <ul class="list-unstyled">
                @forelse ($newsletters as $newsletter)
                    <li>
                        <strong><a href="{{route('newsletter.show', $newsletter->id)}}">{{$newsletter->subject}}</a></strong>
                        <p class="text-muted">Published {{$newsletter->published_at->diffForHumans()}}</p>
                    </li>
                @empty
                    <li class="text-muted">
                        There are no newsletters yet.
                    </li>
                @endforelse
            </ul>
            <nav class="text-center">
                {{$newsletters->links()}}
            </nav>
        </div>
    </div>
</div>
@endsection
