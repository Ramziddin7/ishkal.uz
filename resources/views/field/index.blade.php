@extends('layouts.app')

@section('content')
<div class="container">
        @if (session('errors'))
        <div class="col-sm-12">
            <div class="alert  alert-danger alert-dismissible fade show" role="alert">
                {{ session('errors') }}
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
    <div class="row justify-content-between">
        <div class="col-md-12">
           <p><a  class="btn btn-primary" href="{{route('field.web.create')}}">Add</a></p>
            <table class="table table- table-hover">
                <thead>
                  <tr>
                    <th scope="col">N</th>
                    <th scope="col">University</th>
                    <th scope="col">Field Name</th>
                    <th scope="col">Category(rate)</th>
                    <th scope="col">Price</th>
                    <th scope="col">Duration</th>
                    <th scope="col">Description</th>
                    <th scope="col">Delete</th>
                    <th scope="col">Edit</th>
                  </tr>
                </thead>
                <tbody>
                   @if(count($fields))
                   @foreach ($fields as $field)
                   <tr>
                      <th scope="row">
                        {{$loop->index+1}}
                      </th>
                      <td>
                        {{$field->university->name}}
                      </td>
                      <td>
                        {{$field->name}}
                      </td>
                      <td>
                        {{$field->category}}
                      </td>
                      
                      <td>
                        {{$field->price}}
                      </td>
                      <td>
                        {{$field->duration}}
                      </td>
                      <td>
                        {{$field->description}}
                      </td>
                      <td>
                        <a class="btn btn-dark" href="{{route('field.web.edit',['id'=>$field->id])}}">Edit</a>
                      </td>
                      <td>
                        <form action="{{route('field.web.delete',['id'=>$field->id])}}" method="POST">
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