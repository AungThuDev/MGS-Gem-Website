@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Products Detail Page</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <a href="{{route('products.edit',$product->id)}}" class="btn btn-success me-3">Edit</a>
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
        <div class="card">
            <div class="card-header">
                <h4>Product Detail Page</h4>
            </div>
            <div class="card-body">
                <img src="{{ asset('storage/images/' . $product->image) }}" class="card-image-top img-fluid" alt="news photo" width="auto" height="300">
                <div class="row mt-3">
                    @foreach($product->images as $image)
                    <div class="col-4 me-4">
                      <img src="{{ asset('storage/images/'. $image->photo) }}" alt="Image" width="463" height="300">
                    </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h5>Name : {{$product->name}}</h5>
                    </div>
                    <div class="col-md-6">
                        <h5 style="float:right;">Type : {{$product->type}}</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h5>BuyDate : {{$product->buy_date}}</h5>
                    </div>
                    <div class="col-md-6">
                        <h5 style="float:right;">SellDate : {{$product->sell_date}}</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h5>Length : {{$product->length}}</h5>
                    </div>
                    <div class="col-md-6">
                        <h5 style="float:right;">Width : {{$product->width}}</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h5>Height : {{$product->height}}</h5>
                    </div>
                    <div class="col-md-6">
                        <h5 style="float:right;">Weight : {{$product->weight}}</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h5>Origin : {{$product->origin}}</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h5>Description : {{$product->description}}</h5>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
@endsection