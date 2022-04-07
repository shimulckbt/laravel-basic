<x-app-layout>
   <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
         <!-- {{ __('Dashboard') }} -->
         Edit Category <b></b>
         <b style="float:right;">Total Categories:
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
                     Edit Category
                  </div>
                  <div class="card-body">
                     <form action="{{url('category/update/'.$category_id->id)}}" method="POST">
                        @csrf
                        <div class="mb-3">
                           <label for="exampleInputEmail1" class="form-label">Update Category</label>
                           <input type="text" name="category_name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$category_id->category_name}}">
                           @error('category_name')
                           <span class="text-danger">{{$message}}</span>
                           @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update Category</button>
                     </form><br>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</x-app-layout>