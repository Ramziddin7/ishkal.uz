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
          <form action="{{route('university.web.update',['id'=>$university->id])}}" method="POST" enctype="multipart/form-data">    
            @csrf
            @method('PUT')
                <div class="form-group">
                  <label for="university">Depended Country</label>
                  <select name="country_id" class="form-control" aria-label="Default select example">
                    <option selected></option>
                    @if(count($country))
                     @foreach($country as $country)
                     <option value="{{$country->id}}">{{$country->name}}</option>
                     @endforeach
                    @else
                    No any country
                    @endif
                  </select>
                  <small id="university" class="form-text text-muted">If you want not to select a value dont touch we are save old data</small>
                </div>
                <div class="form-group">
                  <label for="category">Categories multy</label>
                  <select name="categories[]" class="form-control" multiple aria-label="multiple select example">
                    <option selected>Select Categories</option>
                    <option value="master">Master</option>
                    <option value="bachelor">Bachelor</option>
                    <option value="PHD">PHD</option>
                  </select>
                  <small id="university" class="form-text text-muted">If you want not to select a value dont touch we are save old data</small>
                </div>
                <div class="form-group">
                  <label for="contact file">Contract File</label>
                  <input type="file" name="contractFile"  class="form-control" id="contact file" aria-describedby="" placeholder="Contact file">
                </div>
                <div class="form-group">
                  <label for="university name">University Name</label>
                  <input type="text" name="name" value="{{$university->name}}"  class="form-control" id="university name" aria-describedby="" placeholder="university name">
                </div>
                <div class="form-group">
                  <label for="min price">Min price </label>
                  <input type="text" name="min_price" value="{{$university->min_price}}" class="form-control" id="min price " aria-describedby="" placeholder="Min price">
                </div>
                <div class="form-group">
                  <label for="min ielts">Min IELTS</label>
                  <input type="text" name="min_ielts" value="{{$university->min_ielts}}" class="form-control" id="min IELTS" aria-describedby="min ielts" placeholder="MIn IELTS">
                </div>
                <div class="form-group">
                  <label for="city name">City name</label>
                  <input type="text" name="city_name" value="{{$university->city_name}}" class="form-control" id="city_name" aria-describedby="Country" placeholder="City name">
                </div>
                <div class="form-group">
                  <label for="image">image</label>
                  <input type="file" name="image" value="{{$university->image}}}" class="form-control" id="image" aria-describedby="image" >
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
    </div>
</div>
@endsection
