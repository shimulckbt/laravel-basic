<x-app-layout>
   <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
         <!-- {{ __('Dashboard') }} -->
         Edit Brand <b></b>
         <b style="float:right;">Total Brands:
            <span class="">2</span></b>
      </h2>
   </x-slot>

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
                  <div class="card-header">
                     Edit Brand
                  </div>
                  <div class="card-body">
                     <form action="{{url('brand/update/'.$brand_id->id)}}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <input type="hidden" name="old_image" value="{{$brand_id->brand_image}}">
                        <div class="mb-3">
                           <label for="exampleInputEmail1" class="form-label">Update Brand</label>
                           <input type="text" name="brand_name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$brand_id->brand_name}}">
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

                        <div class="mb-3">
                           <img src="{{asset($brand_id->brand_image)}}" style="height: 120px;width: 200px;" alt="">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Brand</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</x-app-layout>