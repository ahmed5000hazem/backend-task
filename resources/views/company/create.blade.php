
@extends('theme.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h2 class="mt-3 text-center">Compaines</h2>
            <div class="col-6">
                <form action="/companies/store" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                      <label for="name" class="form-label">Name</label>
                      <input type="text" class="form-control" name="name" id="name" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" name="address" id="address" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">logo</label>
                        <br>
                        <input type="file" name="logo" id="logo">
                    </div>
                    
                    <button type="submit" class="mt-4 btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection