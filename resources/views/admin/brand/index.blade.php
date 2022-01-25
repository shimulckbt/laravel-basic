@extends('admin.admin_master')

@section('admin')
<div class="py-12">
   <!-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
         <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
               <x-jet-welcome />
         </div>
      </div> -->

   <div class="container">
      <div class="row">
         <div class="col-md-8">
            <div class="card">
               @if(session('success'))
               <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>{{session('success')}}</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
               </div>
               @endif
               <div class="card-header">
                  All Brands
               </div>
               <table class="table">
                  <thead>

                     <tr>
                        <th scope="col">SL NO</th>
                        <th scope="col">BRAND NAME</th>
                        <th scope="col">BRAND IMAGE</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($brands as $brand)
                     <tr>
                        <th scope="row">{{$brands->firstItem()+$loop->index}}</th>
                        <td>{{$brand->brand_name}}</td>
                        <td><img src="{{asset($brand->brand_image)}}" style="height:40px;width: 60px;"></td>
                        <td>
                           @if($brand->created_at == NULL)
                           <span class="text-danger">Date not set..!</span>
                           @else
                           {{$brand->created_at->diffForHumans()}}
                           @endif
                        </td>
                        <td>
                           <a href="{{url('brand/edit/'.$brand->id)}}" class="btn btn-info">Edit</a>
                           <a href="{{url('brand/delete/'.$brand->id)}}" onclick="return confirm('Are you sure to delete..?')" class="btn btn-danger">Delete</a>
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
               {{$brands->links()}}
            </div>
         </div>
         <div class="col-md-4">
            <div class="card">
               <div class="card-header">
                  Add Brands
               </div>
               <div class="card-body">
                  <form action="{{route('add.brand')}}" enctype="multipart/form-data" method="POST">
                     @csrf
                     <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Brand Name</label>
                        <input type="text" name="brand_name" class="form-control" id="exampleInputEmail1">
                        @error('brand_name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                     </div>

                     <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Brand Image</label>
                        <input type="file" name="brand_image" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        @error('brand_image')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                     </div>
                     <button type="submit" class="btn btn-primary">Add Brand</button>
                  </form><br>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection