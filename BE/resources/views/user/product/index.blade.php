@extends('layouts.master')
@section('title','Dashboard product')
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
            <h1>Product</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/user">{{__('Home')}}</a></li>
              <li class="breadcrumb-item active">LE THANH</li>
            </ol>
          </div>
        </div>
      </div>
      <div class="container-fluid">
          <form action="" class="mt-3" id="form-search">
              <div class="row">
                  <div class="col-md-10 offset-md-1">
                      <div class="row">
                          <div class="col-4">
                              <div class="form-group">
                                  <input type="text" class="form-control" name="product_name" placeholder="Nhập tên sản phẩm...">
                              </div>
                          </div>
                          <div class="col-4">
                              <div class="form-group">
                                  <input type="text" class="form-control" name="category_name" placeholder="Nhập tên danh mục...">
                              </div>
                          </div>
                          <div class="col-4">
                              <div class="form-group">
                                  <div class="input-group">
                                      <select class="form-control" name="stock">
                                          <option></option>
                                          <option value="1">Nhỏ hơn 10 </option>
                                          <option value="2">Từ 10 đến 100</option>
                                          <option value="3">Từ 100 đến 200 </option>
                                          <option value="4">Lớn hơn 200</option>
                                      </select>
                                      <div class="input-group-append">
                                          <button type="submit" class="btn btn-default">
                                              <i class="fa fa-search"></i>
                                          </button>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </form>
      </div><!-- /.container-fluid -->
  </div>
    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">{{__('Product')}}</h3>
          <div>
            <a href="/user/product/create" class="btn btn-danger" style="margin-left:70%">{{__('Add')}}</a>
            <a class="btn btn-primary" style="width:70px" href="{{ route('product.exportPDF') }}">PDF</a>
            <a class="btn btn-success" style="width:70px" href="{{ route('product.exportCSV') }}">CSV</a>
            <button class="btn btn-sm btn-default btn-icon" style="width:70px;height:38px">
              <i class="fas fa-search"></i>
            </button>
          </div>
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
                <th>{{__('Stock')}}</th>
                <th>{{__('Exprired_at')}}</th>
                <th>{{__('Avatar')}}</th>
                <th>{{__('Sku')}}</th>
                <th>{{__('Category name')}}</th>
                <th class="text-center">{{__('Action')}}</th>
              </tr>
            </thead>
            <tbody>
              @foreach($products as $pro)
              <tr>
                <td>{{$pro->id}}</td>
                <td>{{$pro->name}}</td>
                <td>{{$pro->stock}}</td>
                <td>{{$pro->exprired_at}}</td>
                <td>
                  <img src="/{{$pro->avatar}}"  width="100px" height="100px" alt="">
                </td>
                <td>{{$pro->sku}}</td>
                <td>{{$pro->category_name}}</td>
                <td class="text-center">
                  <a href="/user/product/edit/{{$pro->id}}" class="btn btn-sm btn-success">
                    <i class="fas fa-edit"></i>
                  </a>
                  <button  data-id={{$pro ->id}} value = "<?= $pro->id; ?>" class="btn btn-sm btn-danger  btn-delete">
                    <i class="fas fa-trash"></i>
                  </button>
              </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <hr>
          {{$products->links('pagination::bootstrap-4')}}
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
    <script src="{{ asset('js/func.js')}}"></script>
@endpush




