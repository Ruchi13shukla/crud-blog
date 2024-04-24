@extends('layouts.app')

@section('main')

    <div class="container">
        <div class="text-right">
        <a href="products/create" class="btn btn-primary mt-3">New Product</a>
        </div>
   

        <table class="table table-hover mt-4">
          <thead>
            <tr>
              <th>Sno.</th>
              <th>Name</th>
              <th>Image</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($products as $product )
             <tr>
              <td> {{ $loop->index+1 }}</td>
              <td><a href="products/{{$product->id}}/show">{{ $product->name }}</a></td>
              <td>
                <img src="products/{{ $product->image }}" class="rounded-circle"
                width="35" height="35"/>
              </td>
              <td>
                <a href="products/{{ $product->id }}/edit" class="btn btn-primary btn-sm">
                Edit</a>

                <a href="products/{{ $product->id }}/delete" class="btn btn-danger btn-sm">
                  Delete</a> 

              
               </td>
            </tr> 
             @endforeach 
          </tbody>

          
        </table> 
        {{ $products->links() }} 
        <!-- Script for AJAX pagination -->
<script>
  var page = 2; // Initial page number for pagination

  $(window).scroll(function() {
      if($(window).scrollTop() == $(document).height() - $(window).height()) {
          loadMoreData();
      }
  });

  function loadMoreData() {
      $.ajax({
          url: '/load-more-employees',
          type: "get",
          data: {page: page},
          success: function (response) {
              if(response.html == "") {
                  // No more records
                  $('#load-more').html("No more records found");
              } else {
                  $('#employee-list').append(response.html);
                  page++;
              }
          }
      });
  }
</script>   
    </div>

@endsection