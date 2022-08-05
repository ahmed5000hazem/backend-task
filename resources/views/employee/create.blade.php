
@extends('theme.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h2 class="mt-3 text-center">Compaines</h2>
            <div class="col-6">
                <form action="/employees/store" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                      <label for="name" class="form-label">Name</label>
                      <input type="text" class="form-control" name="name" id="name" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                      <label for="email" class="form-label">Email</label>
                      <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Password confirmaion</label>
                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
                    </div>

                    <div class="mb-3">
                        <label for="company_id" class="form-label">Company Id</label>
                        <input type="number" class="form-control" name="company_id" id="company_id" aria-describedby="emailHelp">
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">image</label>
                        <br>
                        <input type="file" name="image" id="logo">
                    </div>
                    
                    <button type="submit" class="mt-4 btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection