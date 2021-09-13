@extends('layouts.master')
@section('title','Dashboard Category')
@section('h1','CATEGORY')
@section('english')
<ul class="navbar-nav ml-auto">
   <!-- Language Dropdown Menu -->
   <li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
      <i class="flag-icon flag-icon-vn"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right p-0">
      <a href="{{ route('language.index',['locale'=> 'en'])}}" class="dropdown-item active">
        <i class="flag-icon flag-icon-us mr-2"></i> English
      </a>
      <a href="{{ route('language.index',['locale' => 'vi'])}}" class="dropdown-item">
        <i class="flag-icon flag-icon-vn mr-2"></i> Việt Nam
      </a>
    </div>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
      <i class="fas fa-expand-arrows-alt"></i>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
      <i class="fas fa-th-large"></i>
    </a>
  </li>
</ul>
@endsection
@section('aside')
      <a class="nav-link" href="{{ route('user.get.category') }}">{{__('Category')}}</a>
      <a class="nav-link" href="{{ route('user.get.product') }}">{{__('Product')}}</a>
      <a class="nav-link" href="{{ route('user.get.order') }}">{{__('Order')}}</a>
@endsection
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
    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">{{__('Category')}}</h3>
					<a href="/user/category/create" class="btn btn-danger" style="margin-left:90%">{{__('Add')}}</a>
          <input type="hidden" name="_token" value="{{ csrf_token() }}" id="csrf-token">
        </div>
        @if(session('thongbao'))
          <div class="alert alert-success">
            {{session('thongbao')}}
          </div>
        @endif
        <!-- /.card-header -->
        <div class="card-body table-responsive">
          <table class="table table-light" border= "1px">
            <thead class="thead-light">
              <tr>
                <th>{{__('ID')}}</th>
                <th>{{__('Name')}}</th>
                <th>{{__('Parent_name')}}</th>
                <th class="text-center">{{__('Action')}}</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data as $category)
              <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->name}}</td>
                <td>{{$category->parent_name}}</td>
                <td class="text-center">
                  <a href="/user/category/edit/{{$category->id}}" class="btn btn-sm btn-success">
                    <i class="fas fa-edit"></i>
                  </a>
                  <button class="btn btn-danger btn-sm btn-delete" value = "<?= $category->id; ?>" data-id="{{ $category -> id}}">
                    <i class="fas fa-trash"></i>
                </button>
              </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <hr>
          {{$data->links('pagination::bootstrap-4')}}
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </section>
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
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js')}}"></script>
    <script src="{{ asset('js/deleteSweetAlert.js')}}"></script>
@endpush

