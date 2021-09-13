@extends('layouts.master')

@section('title','Create product')
@section('h1','Create product')
@section('container')
<div class="wrapper">
  <!-- Navbar -->
	@include('layouts.menu')
  <!-- /.navbar -->
	<aside class="main-sidebar sidebar-dark-primary elevation-4">
		<!-- Brand Logo -->
		<a href="/index3.html" class="brand-link">
			<img src="/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
			<span class="brand-text font-weight-light">Project Demo</span>
		</a>
		<!-- Sidebar -->
		@include('layouts.aside')
		<!-- /.sidebar -->
	</aside>
  <!-- Main Sidebar Container -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts.header')
    <!-- Main content -->
    <div class="card">
      <form action="" id="frmProduct" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="name">{{__('Name')}}</label>
            <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}" style="width: 100%" placeholder="{{__('Enter product name')}}">
            @if ($errors ->has('name'))
            <label class="text-danger">
                {{ $errors -> first('name')}}
            </label>
            @endif
          </div>
          <div class="form-group">
            <label for="avatar">{{__('Avatar')}}</label>
            <input type="file" name="avatar" class="form-control" id="avatar" placeholder="{{__('Avatar')}}">
            @if ($errors ->has('avatar'))
            <label class="text-danger">
              {{ $errors -> first('avatar')}}
            </label>
            @endif
          </div>
          <div class="form-group">
            <label for="sku">{{__('Sku')}}</label>
            <input type="text" class="form-control" value="{{old('sku')}}" id="sku" name="sku" placeholder="{{__('Enter Sku')}}">
            @if ($errors ->has('sku'))
              <label class="text-danger">
                  {{ $errors -> first('sku')}}
              </label>
            @endif
          </div>
          <div class="form-group">
              <label for="stock">{{__('Stock')}}</label>
              <input type="number" id="stock" name="stock" class="form-control" value="{{old('stock')}}" style="width: 100%" placeholder="{{__('Enter Stock')}}">
              @if ($errors ->has('stock'))
              <label class="text-danger">
                  {{ $errors -> first('stock')}}
              </label>
              @endif
          </div>
          <div class="form-group">
              <label for="exprired_at">{{__('Exprired_at')}}</label>
              <input type="date" id="exprired_at" name="exprired_at" class="form-control" value="{{old('exprired_at')}}" style="width: 100%">
              @if ($errors ->has('exprired_at'))
              <label class="text-danger">
                  {{ $errors -> first('exprired_at')}}
              </label>
              @endif
          </div>
          <div class="form-group">
              <label for="category_id">{{__('Category name')}}</label>
              <select name="category_id" id="category_id" class="form-control">
                  @foreach ($categories as $category)
                      <option value="{{ $category -> id}}" @if (old('category_id') == $category -> id)
                          {{ __('selected')}}
                      @endif>{{ $category -> name}}</option>
                  @endforeach
              </select>
              @if ($errors ->has('category_id'))
              <label class="text-danger">
                  {{ $errors -> first('category_id')}}
              </label>
              @endif
          </div>
          <div class="form-group">
            <label for="price">{{__('Price')}}</label>
            <input type="number" id="price" name="price" class="form-control" placeholder="{{__('Enter  Price')}}" value="{{old('price')}}" style="width: 100%">
            @if ($errors ->has('price'))
            <label class="text-danger">
                {{ $errors -> first('price')}}
            </label>
            @endif
        </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
          <div class="btn btn-secondary" id="preview" data-toggle="modal" data-target="#modal">{{__('Preview')}}</div>
        </div>
      </form>
     </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @include('user.product.modal')
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
@endsection
@push('appjs')
    <script src="{{asset('js/modal.js')}}"></script>
    @push('appjs')
    <script type="text/javascript" src="{{asset('validateFront/jquery.validate.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('validateFront/additional-methods.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/validateForm/product_Validator.js')}}"></script>
@endpush
@endpush


