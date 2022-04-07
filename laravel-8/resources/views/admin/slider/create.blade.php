@extends('admin.admin_master')

@section('admin')

<div class="col-lg-12">
   <div class="card card-default">
      <div class="card-header card-header-border-bottom">
         <h2>Slider Information</h2>
      </div>
      <div class="card-body">
         <form action="{{route('save.slider')}}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="form-group">
               <label for="exampleFormControlInput1">Slider Title</label>
               <input type="text" name="title" class="form-control" placeholder="Enter Title">
            </div>
            <div class="form-group">
               <label for="exampleFormControlTextarea1">Slider Description</label>
               <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div class="form-group">
               <label for="exampleFormControlFile1">Slider Image</label>
               <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1">
            </div>
            <div class="form-footer pt-5 mt-4 border-top">
               <button type="submit" class="btn btn-primary btn-default">Submit</button>
               <button type="submit" class="btn btn-secondary btn-default">Cancel</button>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection