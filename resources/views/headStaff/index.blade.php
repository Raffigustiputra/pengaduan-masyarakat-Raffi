@extends('layout.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        @include('layout.alert')
        <div class="max-w-4xl mx-auto p-4 bg-white shadow-md rounded-lg">
            {!! $chart->container() !!}
        </div>
    </div>

    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}
@endsection
