@extends('layouts.master')
@section('title','Create Category')
@section('h1','Create category')
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
      <form action="" id="frmCatogory" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}" style="width: 100%" placeholder="Enter name" required>
            @if ($errors ->has('name'))
              <label class="text-danger">
                  {{ $errors -> first('name')}}
              </label>
              @endif
          </div>

          <div class="form-group">
            <label for="parent_id">Parent Name</label>
            <select  class="form-control" name="parent_id" id="parent_id" required>
                <option value="0"></option>
                @foreach ($parent as $item)
                    <option value="{{ $item -> id }}">{{ $item -> name }}</option>
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
    <script type="text/javascript" src="{{asset('js/validateForm/category_Validator.js')}}"></script>
@endpush

