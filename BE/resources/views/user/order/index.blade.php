@extends('layouts.master')
@section('title','Dashboard order')
@section('h1','PRODUCT')
@section('title','Dashboard Product')
@section('h1','Product')
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
     <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Order</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/user">{{__('Home')}}</a></li>
              <li class="breadcrumb-item active">LE THANH</li>
            </ol>
          </div>
        </div>
      </div>
  </div>
    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">{{__('Order')}}</h3>
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
                <th>{{__('Customer_name')}}</th>
                <th>{{__('Quantity')}}</th>
                <th>{{__('Price')}}</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
							@foreach($order as $rows)
							<tr class="odd" id="list{{$rows->id}}">
								<td class="dtr-control sorting_1" tabindex="1">{{$rows->id}}</td>
								<td>{{$rows->customer_name}}</td>
								<td>{{$rows->quantity}}</td>
								<td>{{$rows->total}}</td>
								<td style="text-align:center;">
									<a class="btn btn-info" href="{{ route('user.get.order-detail',$rows->id)}}" style="margin-right: 5px;">{{__('Detail')}}</a>
								</td>
							</tr>
							@endforeach
						</tbody>
          </table>
          <hr>
          {{$order->links('pagination::bootstrap-4')}}
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
