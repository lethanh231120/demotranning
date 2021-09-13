@extends('layouts.master')
@section('title','Edit Category')
@section('h1','Edit category')
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
      @if (isset($category))
          <form action="" id="frmCatogory" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label for="name">{{__('Category name')}}</label>
                <input type="text" name="name" value="{{$category->name}}" class="form-control" id="name" placeholder="Enter Category name">
                @if ($errors ->has('name'))
                    <label class="text-danger">
                        {{ $errors -> first('name')}}
                    </label>
                @endif
              </div>
              <div class="form-group">
                <label for="parent_id">{{__('Parent name')}}</label>
                <select class="form-control" name="parent_id" id="parent_id">
                    <option value="0" @if (!$category -> parent_id){{ __('selected')}} @endif >Không
                    </option>
                    @foreach ($parent as $item)
                    <option value="{{ $item -> id }}" {{
                            (old('parent_id') == $item -> id || $category -> parent_id == $item -> id) ? 'selected' : ''
                        }}>{{ $item -> name }}</option>
                    @endforeach
                </select>
                @if ($errors ->has('parent_id'))
                <label class="text-danger">
                    {{ $errors -> first('parent_id')}}
                </label>
                @endif
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
      @endif
      @if (isset($error))
        <div class="text-center text-danger h4">{{$error}}</div>
      @endif
     </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
@endsection
@push('appjs')
    <script type="text/javascript" src="{{asset('validateFront/jquery.validate.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('validateFront/additional-methods.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/validateForm/category-Validator.js')}}"></script>
@endpush
