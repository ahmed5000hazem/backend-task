@extends('theme.app')

@section('content')
    <div class="container-fluid">
        <div class="row px-5">
            <h2 class="mt-3 text-center">Employees</h2>
            <div class="options mb-4">
                <a href="/employees/create" class="btn btn-primary">create</a>
                <div class="dropdown mt-4">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown button
                    </button>
                    <ul style="height: 300px" class="dropdown-menu overflow-auto">
                        <li><a class="dropdown-item" href="/employees"> all </a></li>
                        @foreach ($companies as $company)
                            <li><a class="dropdown-item" href="?company_id={{$company->id}}"> {{$company->name}} </a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            {!! $employees->table(['class' => 'table table-bordered']) !!}
        </div>
    </div>
    {!! $employees->scripts() !!}
@endsection