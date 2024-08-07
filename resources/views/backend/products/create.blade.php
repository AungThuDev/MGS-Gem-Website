@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Create Product</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <a href="{{route('products.create')}}" class="btn btn-secondary">Create Product</a>
            </ol >
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <form action="{{route('products.store')}}" method="post" enctype="multipart/form-data" class="mb-3">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="type">Product Type</label>
                        <input type="text" name="type" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="buy_date">Buy Date</label>
                        <input type="date" name="buy_date" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="sell_date">Sell Date</label>
                        <input type="date" name="sell_date" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="length">Length</label>
                        <input type="text" name="length" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="width">Width</label>
                        <input type="text" name="width" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="height">Height</label>
                        <input type="text" name="height" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="weight">Weight</label>
                            <input type="text" name="weight" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="origin">Origin</label>
                        <input type="text" name="origin" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="image">Featured Image</label>
                        <input type="file" name="image">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                <div class="form-group">
                    <label for="imagess">Images</label>
                    <div class="col-md-12">
                        <div id="imageInputs">
                          <input type="file" class="@error('images.*') is-invalid @enderror" name="images[]" autocomplete="images" multiple value="{{ old('images.0') }}"><br>
      
                            @error('images.*')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <button type="button" class="btn btn-success addImageInput mt-3">Add NewPhoto</button>
                    </div>
                </div>
                </div>
              </div>
            <button class="btn btn-primary" type="submit">Create Product</button>
        </form>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.addImageInput').addEventListener('click', function() {
      var inputContainer = document.getElementById('imageInputs');

      var row = document.createElement('div');
      row.className = 'row image-row';

      var col1 = document.createElement('div');
      col1.className = 'col-6';

      var input = document.createElement('input');
      input.type = 'file';
      input.className = 'mt-3';
      input.name = 'images[]';
      input.required = true;
      input.autocomplete = 'off'; // disable autocomplete to prevent browser from auto-filling the file input

      col1.appendChild(input);

      var col2 = document.createElement('div');
      col2.className = 'col-6';

      var removeButton = document.createElement('button');
      removeButton.type = 'button';
      removeButton.className = 'btn btn-warning removeImageInput';
      removeButton.style.borderRadius = '50%'; // Adjust margin for better alignment
      removeButton.innerHTML = '<i class="fas fa-times"></i>';
      removeButton.addEventListener('click', function() {
        row.remove(); // Remove the entire row when remove button is clicked
      });

      col2.appendChild(removeButton);

      row.appendChild(col1);
      row.appendChild(col2);

      inputContainer.appendChild(row);
    });

    // Event delegation for dynamically added remove buttons
    document.getElementById('imageInputs').addEventListener('click', function(e) {
      if (e.target.classList.contains('removeImageInput')) {
        e.target.closest('.image-row').remove();
      }
    });
  });
</script>
@endsection