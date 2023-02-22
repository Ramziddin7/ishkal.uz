@extends('layouts.app')

@section('content')
<div class="container">
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
    <div class="row justify-content-between">
        <div class="col-md-12">
           <p><a  class="btn btn-primary" href="{{route('country.web.create')}}">Adding a new country</a></p>
            <table class="table table- table-hover">
                <thead>
                  <tr>
                    <th scope="col">N</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Image</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                  </tr>
                </thead>
                <tbody>
                   @if(count($country))
                   @foreach ($country as $coun)
                   <tr>
                      <th scope="row">{{$loop->index+1}}</th>
                      <td>{{$coun->name}}</td>
                      <td>{{$coun->price}}</td>
                      <td>
                          <img width="20%" height="10%" class="img-responsave img-rounded" src="{{asset($coun->image)}}" alt="">
                      </td>
                      <td>
                        <a class="btn btn-dark" href="{{route('country.web.edit',['id'=>$coun->id])}}">Edit</a>
                      </td>
                      <td>
                        <form action="{{route('country.web.delete',['id'=>$coun->id])}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                      </td>
                   </tr>
                   @endforeach
                   @else
                   <h5 class="text-center">NO data !</h5>
                   @endif
                </tbody>
              </table>
        </div>
    </div>
</div>
@endsection