@extends($extend_view)

@section('lhtml')
    <div class="{{$class}}" {!! $attributes !!}>{!! $elements !!}</div>
@endsection
