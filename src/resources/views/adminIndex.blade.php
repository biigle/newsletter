<div class="col-sm-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <a href="{{route('newsletter.admin.index')}}">
                    Newsletter subscribers
                </a>
                <span class="pull-right text-muted" title="Total subscribers">
                    {!! number_format(Biigle\Modules\Newsletter\NewsletterSubscriber::count()) !!}
                </span>
            </h3>
        </div>
        <div class="panel-body">
            <p class="h1 text-center" title="Verified subscribers">{!! number_format(Biigle\Modules\Newsletter\NewsletterSubscriber::verified()->count()) !!}</p>
        </div>
    </div>
</div>
