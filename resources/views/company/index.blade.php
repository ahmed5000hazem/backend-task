
@extends('theme.app')

@section('content')
    <div class="container">
        <div class="row">
            <h2 class="mt-3 text-center">Compaines</h2>
            <div class="options mb-4">
                <a href="/companies/create" class="btn btn-primary">create</a>
            </div>
            {!! $companies->table(['class' => 'table table-bordered']) !!}
        </div>
    </div>
    {!! $companies->scripts() !!}
@endsection