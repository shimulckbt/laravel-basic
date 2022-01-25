<x-app-layout>
   <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
         <!-- {{ __('Dashboard') }} -->
         Multiple Image
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
                     All Images
                  </div>
                  <div class="row">
                     @foreach($images as $multi)
                     <div class="col-md-4 mt-5">
                        <img src="{{asset($multi->image)}}" style="height: 80;width:120px;">
                     </div>
                     @endforeach
                  </div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="card">
                  <div class="card-header">
                     Add Images
                  </div>
                  <div class="card-body">
                     <form action="{{route('multiple-image.add')}}" enctype="multipart/form-data" method="POST">
                        @csrf

                        <div class="mb-3">
                           <input type="file" name="multiple_image[]" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" multiple="">
                           @error('multiple_image')
                           <span class="text-danger">{{$message}}</span>
                           @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Add Multiple Image</button>
                     </form><br>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</x-app-layout>