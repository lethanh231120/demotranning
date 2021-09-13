@extends('layouts.master')
@section('title','Creat User')

@section('h1','Create User')
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
        <form action="" id="frmUser" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="card-body">
            <div class="form-group">
              <label for="email">Email address</label>
              <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
              @if ($errors ->has('email'))
              <label class="text-danger">
                  {{ $errors -> first('email')}}
              </label>
              @endif
            </div>
            <div class="form-group">
              <label for="user_name">User_name</label>
              <input type="text" name="user_name" class="form-control" id="user_name " placeholder="User_name">
              @if ($errors ->has('user_name'))
              <label class="text-danger">
                  {{ $errors -> first('user_name')}}
              </label>
              @endif
            </div>
            <div class="form-group">
              <label for="birthday">Birthday</label>
              <input type="date"  name="birthday" class="form-control" id="birthday" placeholder="Birthday">
              @if ($errors ->has('birthday'))
              <label class="text-danger">
                  {{ $errors -> first('birthday')}}
              </label>
              @endif
            </div>
            <div class="form-group">
              <label for="first_name">First_name</label>
              <input type="text" name="first_name" class="form-control" id="first_name" placeholder="First_name">
              @if ($errors ->has('first_name'))
              <label class="text-danger">
                  {{ $errors -> first('first_name')}}
              </label>
              @endif
            </div>
            <div class="form-group">
              <label for="last_name">Last_name</label>
              <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Last_name">
              @if ($errors ->has('last_name'))
              <label class="text-danger">
                  {{ $errors -> first('last_name')}}
              </label>
              @endif
            </div>
            <div class="form-group">
              <label for="password">password</label>
              <input type="password" name="password" class="form-control" id="password" placeholder="password">
              @if ($errors ->has('password'))
              <label class="text-danger">
                  {{ $errors -> first('password')}}
              </label>
              @endif
            </div>
            <div class="form-group">
              <label for="status">Status</label>
              <input type="number" name="status" class="form-control" id="status" placeholder="Status">
              @if ($errors ->has('status'))
              <label class="text-danger">
                  {{ $errors -> first('status')}}
              </label>
              @endif
            </div>
            <div class="form-group">
              <label for="avatar">Avatar</label>
              <input type="file" name="avatar" class="form-control" id="avatar" value="{{old('avatar')}}" >
              <img src="upload/user/avatar.jpg" class="img-fluid img-avatar" alt="avatar" width="100px"
              height="100px" />
              @if ($errors ->has('avatar'))
              <label class="text-danger">
                  {{ $errors -> first('avatar')}}
              </label>
              @endif
            </div>
            <div class="form-group">
              <label for="avatar">Address</label>
              <input type="text" name="address" class="form-control" id="address" placeholder="address">
              @if ($errors ->has('address'))
              <label class="text-danger">
                  {{ $errors -> first('address')}}
              </label>
              @endif
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-4">
                  <label for="province">Tỉnh / Thành phố</label>
                  <select class="form-control" name="province" id="province">
                    <option value="">Tỉnh</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province->id }}">
                        {{ $province->name }}
                        </option>
                    @endforeach
                  </select>
                </div>
                <div class="col-4">
                  <label for="district">Quận / Huyện</label>
                  <select class="form-control" name="district" id="district">
                    <option value="">Huyện</option>
                  </select>
                </div>
                <div class="col-4">
                  <label for="commune">Xã / Phường</label>
                  <select class="form-control" name="commune" id="commune">
                    <option value="">Xã</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>

        <!-- /.card-header -->

        <!-- /.card-body -->
      </div>
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
    <script >
      $('#province').change(function(){
        var cid = $(this).val();
        if(cid){
        $.ajax({
           type:"get",
           url:"/admin/getDistricts/"+cid, //Please see the note at the end of the post**
           success:function(res)
           {
                if(res)
                {
                    $("#district").empty();
                    $("#district").append('<option>Huyện</option>');
                    $.each(res,function(key,value){
                        $("#district").append('<option value="'+value.id+'">'+value.name+'</option>');
                    });
                }else{
                  console.log('ko lấy dc dữ liệu');
                }
           }
        });
        }
      });
      $('#district').change(function(){
          var sid = $(this).val();
          if(sid){
          $.ajax({
            type:"get",
            url:'/admin/getCommunes/'+sid,
            success:function(res)
            {
              if(res)
              {
                $("#commune").empty();
                $("#commune").append('<option>Xã</option>');
                $.each(res,function(key,value){
                    $("#commune").append('<option value="'+value.id+'">'+value.name+'</option>');
                });
              }
            }
          });
          }
      });
    </script>
    <script type="text/javascript" src="{{asset('validateFront/jquery.validate.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('validateFront/additional-methods.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/validateForm/user-Validator.js')}}"></script>
@endpush