<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse{{$meta['id']}}" aria-expanded="false" aria-controls="collapseExample">
    {!! $meta['button-html'] !!}
</button>
<div class="collapse" id="collapse{{$meta['id']}}">
    <div class="card card-body">{!! $meta['body-html'] !!}</div>
</div>
