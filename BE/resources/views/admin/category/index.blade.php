@extends('layouts.master')
@section('title','Dashboard  Admin')
@section('home','/admin')
@section('dashboard','/admin')
@section('h1','Admin')
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
  @include('layouts.header')
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <div class="row">
          <h3 class="card-title col-1">Admin</h3>
              <form action="" class=" col-10" id="form-search">
                  <div class="form-group">
                      <div class="input-group">
                          <input type="text" class="form-control" name="search" placeholder="Tìm kiếm user...">
                          <div class="input-group-append">
                              <button type="submit" class="btn btn-default">
                                  <i class="fa fa-search"></i>
                              </button>
                          </div>
                      </div>
                  </div>
              </form>
            <a href="/admin/create" class="btn btn-danger col-1" style="height:38px;margin-left:90%; leight-height:45px" >THÊM</a>
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
                <th>Id</th>
                <th>email</th>
                <th>user_name</th>
                <th>first_name</th>
                <th>last_name</th>
                <th>status</th>
                <th>avatar</th>
                <th>address</th>
                <th>commune</th>
                <th>district</th>
                <th>province</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data as $cat)
              <tr>
                <td>{{$cat->id}}</td>
                <td>{{$cat->email}}</td>
                <td>{{$cat->user_name}}</td>
                <td>{{$cat->first_name}}</td>
                <td>{{$cat->last_name}}</td>
                <td>{{$cat->status}}</td>
                <td>
                  <img src="/{{$cat->avatar}}"  width="80px" height="80px" alt="">
                </td>
                <td>{{$cat->address}}</td>
                <td>{{$cat->commune_name}}</td>
                <td>{{$cat->district_name}}</td>
                <td>{{$cat->province_name}}</td>
                <td class="text-right">
                    <a href="/admin/edit/{{$cat->id}}" class="btn btn-sm btn-success" style="width:30px;height:30px">
                      <i class="fas fa-edit"></i>
                    </a>
                    <button  data-id={{ $cat ->id}} value = "<?= $cat->id; ?>" class="btn btn-sm btn-danger  btn-delete" style="width:30px;height:30px">
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

