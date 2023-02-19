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
            <form action="{{route('field.web.store')}}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('POST')
                <div class="form-group">
                  <label for=" university">Depended UNIVERSITY</label>
                  <select name="university_id" class="form-control" aria-label="Default select example">
                    <option selected>Please select UNIVERSITY</option>
                    @if(count($university))
                     @foreach($university as $university)
                     <option value="{{$university->id}}">{{$university->name}}</option>
                     @endforeach
                    @else
                    No  country
                    @endif
                  </select>
                </div>
                <div class="form-group">
                  <label for="university name">Field Name</label>
                  <input type="text" name="name" value="{{old('name')}}"  class="form-control" id="university name" aria-describedby="" placeholder="university name">
                </div>
                <div class="form-group">
                  <label for="min price">Category</label>
                  <input type="text" name="category" value="{{old('category')}}" class="form-control" id="min price " aria-describedby="" placeholder="category(rate)">
                </div>
                <div class="form-group">
                  <label for="min ielts">Price</label>
                  <input type="text" name="price" value="{{old('price')}}" class="form-control" id="Price" aria-describedby="min ielts" placeholder="Price">
                </div>
                <div class="form-group">
                  <label for="city name">Duration</label>
                  <input type="text" name="duration" value="{{old('duration')}}" class="form-control" id="city_name" aria-describedby="Country" placeholder="Duration">
                </div>
                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea type="text" name="description" value="{{old('description')}}" class="form-control" id="description" aria-describedby="description"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
    </div>
</div>
@endsection
