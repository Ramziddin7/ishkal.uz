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
           <p><a  class="btn btn-primary" href="{{route('university.web.create')}}">Add</a></p>
            <table class="table table- table-hover">
                <thead>
                  <tr>
                    <th scope="col">N</th>
                    <th scope="col">Country</th>
                    <th scope="col">Categories</th>
                    <th scope="col">ContactFile</th>
                    <th scope="col">Name</th>
                    <th scope="col">Min price</th>
                    <th scope="col">Min IELTS</th>
                    <th scope="col">City name</th>
                    <th scope="col">Image</th>
                    <th scope="col">Delete</th>
                    <th scope="col">Edit</th>
                  </tr>
                </thead>
                <tbody>
                   @if(count($universities))
                   @foreach ($universities as $univer)
                   <tr>
                      <th scope="row">
                        {{$loop->index+1}}
                      </th>
                      <td>
                        {{$univer->country->name}}
                      </td>
                      <td>
                        {{$univer->categories}}
                      </td>
                      <td>
                        <a href="{{asset($univer->contactFile)}}">
                        {{asset($univer->contactFile)}}
                      </a>
                      </td>
                      <td>
                        {{$univer->name}}
                      </td>
                      
                      <td>
                        {{$univer->min_price}}
                      </td>
                      <td>
                        {{$univer->min_ielts}}
                      </td>
                      <td>
                        {{$univer->city_name}}
                      </td>
                      <td><a href="{{asset($univer->image)}}">
                        <img width="50%" class="img-responsave img-rounded " src="{{asset($univer->image)}}" />
                      </a>
                      </td>
                      <td>
                        <a class="btn btn-dark" href="{{route('university.web.edit',['id'=>$univer->id])}}">Edit</a>
                      </td>
                      <td>
                        <form action="{{route('university.web.delete',['id'=>$univer->id])}}" method="POST">
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