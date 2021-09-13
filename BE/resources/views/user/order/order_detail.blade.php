@extends('layouts.master')
@section('title','Dashboard product')
@section('h1','PRODUCT')
@section('title','Dashboard Product')
@section('h1','Product')
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
                <th>{{__('Product_name')}}</th>
                <th>{{__('Quantity')}}</th>
                <th>{{__('Price')}}</th>
                <th>{{__('Export')}}</th>
              </tr>
            </thead>
            <tbody>
							@foreach($data as $rows)
							<tr class="odd">
								<td class="dtr-control sorting_1" tabindex="1">{{$rows->id}}</td>
								<td >{{$rows->product_name}}</td>
								<td >{{$rows->quantity}}</td>
								<td>{{$rows->price}}</td>
                <td><a href="{{ route('use.export-pdf-order',$rows->id)}}" class="btn btn-info" target="_blank">{{__('exportPDF')}}</a></td>
							</tr>
							@endforeach
						</tbody>
          </table>
          <hr>

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

