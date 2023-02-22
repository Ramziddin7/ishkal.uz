@extends('layouts.app')

@section('content')
<div class="container">
      @if ($errors->any())
        <div class="col-sm-12">
            <div class="alert  alert-warning alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    <span><p>{{ $error }}</p></span>
                @endforeach
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
        </div>
      @endif

      @if (session('success'))
        <div class="col-sm-12">
            <div class="alert  alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
        </div>
      @endif
    <div class="row justify-content-center">
        <div class="col-md-12 py-5">
            <form action="{{route('country.web.store')}}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('POST')
                <div class="form-group">
                  <label for="exampleInputEmail1">Country Name</label>
                  <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="Country" placeholder="Country name">
                  <small id="Country" class="form-text text-muted">Please put country name correctly</small>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Country Price</label>
                  <input type="text" name="price" class="form-control" id="exampleInputEmail1" aria-describedby="Country" placeholder="Country Price">
                  <small id="Price" class="form-text text-muted">Please put country Price correctly</small>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Image</label>
                  <input type="file" name="image" class="form-control" id="exampleInputPassword1" placeholder="file">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
    </div>
</div>
@endsection
