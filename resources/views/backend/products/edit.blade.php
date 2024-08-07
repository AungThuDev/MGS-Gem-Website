@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Update Product</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <a href="{{route('products.index')}}" class="btn btn-secondary">Back</a>
            </ol >
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <form action="{{route('products.update',$product->id)}}" method="post" enctype="multipart/form-data" class="mb-3">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" name="name" class="form-control" value="{{$product->name}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="type">Product Type</label>
                        <input type="text" name="type" class="form-control" value="{{$product->type}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="buy_date">Buy Date</label>
                        <input type="date" name="buy_date" class="form-control" value="{{$product->buy_date}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="sell_date">Sell Date</label>
                        <input type="date" name="sell_date" class="form-control" value="{{$product->sell_date}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="length">Length</label>
                        <input type="text" name="length" class="form-control" value="{{$product->length}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="width">Width</label>
                        <input type="text" name="width" class="form-control" value="{{$product->width}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="height">Height</label>
                        <input type="text" name="height" class="form-control" value="{{$product->height}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="weight">Weight</label>
                            <input type="text" name="weight" class="form-control" value="{{$product->weight}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="" cols="30" rows="10" class="form-control">{{$product->description}}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="origin">Origin</label>
                        <input type="text" name="origin" class="form-control" value="{{$product->origin}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="image">Featured Image</label>
                        <input type="file" name="image">
                        <img src="{{ asset('storage/images/' . $product->image) }}" alt="Product Image" width="200" height="130"><br><br>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                <div class="form-group">
                    <label for="images">Images</label>
                    <div class="col-md-12">
                        <div id="imageInputs">
                            @foreach($product->images as $key => $res)
                            
                            <div class="image-input mb-3">
                              <img src="{{asset('storage/images/'.$res->photo)}}" alt="Images" width="200" height="130"><br><br>
                              <div id="newform"></div>
                                <div class="row">
                                    <div class="col-6">
        
                                        <input type="file" class="@error('images.*') is-invalid @enderror" name="{{$res->id}}" autocomplete="images">
                                    </div>
                                    <div class="col-6">
                                        @if ($key > 0)
                                        <button type="button" id="{{$res->id}}" onclick="removeImage(event)" class="btn btn-warning removeImageInput" style="border-radius: 50%;"><i class="fas fa-times"></i></button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @error('images.*')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <button type="button" id="addImageInput" class="btn btn-success"><i class="fas fa-plus-circle"></i>&nbsp;AddNewImage</button>
                    </div>
                </div>
                </div>
              </div>
            <button class="btn btn-primary" type="submit">Update Product</button>
        </form>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
@endsection
@section('scripts')
<script>
  document.getElementById('addImageInput').addEventListener('click', function() {
        var inputContainer = document.getElementById('imageInputs');
        var inputCount = inputContainer.children.length;

        var div = document.createElement('div');
        div.className = 'image-input mb-3';

        var row = document.createElement('div');
        row.className = 'row';

        var col1 = document.createElement('div');
        col1.className = 'col-6';

        var input = document.createElement('input');
        input.type = 'file';
        input.className = 'form-control';
        input.name = 'images[]';
        input.required = true;
        input.autocomplete = 'images';

        col1.appendChild(input);

        var col2 = document.createElement('div');
        col2.className = 'col-6';

        var removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'btn btn-warning removeImageInput' + (inputCount > 0 ? '' : ' d-none'); // Hide the "X" button for the first input field
        removeButton.style.borderRadius = '50%';
        removeButton.innerHTML = '<i class="fas fa-times"></i>';

        col2.appendChild(removeButton);
        row.appendChild(col1);
        row.appendChild(col2);
        div.appendChild(row);

        inputContainer.appendChild(div);
    });
    // Event delegation for dynamically added remove buttons
    document.getElementById('imageInputs').addEventListener('click', function(e) {
      
        if (e.target.classList.contains('removeImageInput') || e.target.closest('.removeImageInput')) {
            e.target.closest('.image-input').remove();
        }
        
    });

    function removeImage(event) {
      console.log(event.currentTarget.id);
      var newform = document.getElementById('newform');
        console.log(newform);
        var form = document.createElement('input');
        newform.appendChild(form);
        form.type = "hidden";
        form.name = "deleted_images[]";
        form.value = event.currentTarget.id;
    }
</script>
@endsection

