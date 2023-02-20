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
            <form action="{{route('university.web.store')}}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('POST')
                <div class="form-group">
                  <label for="country">Depended Country</label>
                  <select name="country_id" class="form-control" aria-label="Default select example">
                    <option selected>Please select country</option>
                    @if(count($country))
                     @foreach($country as $country)
                     <option value="{{$country->id}}">{{$country->name}}</option>
                     @endforeach
                    @else
                    No any country
                    @endif
                  </select>
                </div>
                <div class="form-group">
                  <label for="category">Categories multy</label>
                  <select name="categories[]" class="form-control" multiple aria-label="multiple select example">
                    <option selected>Select Categories</option>
                    <option value="Camp(lager)">Camp (Lager)</option>
                    <option value="Language cource">Language Cource</option>
                    <option value="Exhibition ko'rgazma">Exhibition ko'rgazma</option>
                    <option value="ELPS olimpiyada ">ELPS olimpiyada </option>
                    <option value="Expo ta`lim ">Expo ta`lim </option>
                    <option value="Master">Master</option>
                    <option value="Bachelor">Bachelor</option>
                    <option value="PHD">PHD</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="contact file">Contact File</label>
                  <input type="file" name="contractFile" value="{{old('contractFile')}}" class="form-control" id="contact file" aria-describedby="" placeholder="Contact file">
                </div>
                <div class="form-group">
                  <label for="university name">University Name</label>
                  <input type="text" name="name" value="{{old('name')}}"  class="form-control" id="university name" aria-describedby="" placeholder="university name">
                </div>
                <div class="form-group">
                  <label for="min price">Min price </label>
                  <input type="text" name="min_price" value="{{old('min_price')}}" class="form-control" id="min price " aria-describedby="" placeholder="Min price">
                </div>
                <div class="form-group">
                  <label for="min ielts">Min IELTS</label>
                  <input type="text" name="min_ielts" value="{{old('min_ielts')}}" class="form-control" id="min IELTS" aria-describedby="min ielts" placeholder="MIn IELTS">
                </div>
                <div class="form-group">
                  <label for="city name">City name</label>
                  <input type="text" name="city_name" value="{{old('city_name')}}" class="form-control" id="city_name" aria-describedby="Country" placeholder="City name">
                </div>
                <div class="form-group">
                  <label for="image">image</label>
                  <input type="file" name="image" value="{{old('image')}}" class="form-control" id="image" aria-describedby="image" >
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
    </div>
</div>
@endsection
