<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>@yield('h1')</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="@yield('home')">{{__('Home')}}</a></li>
					<li class="breadcrumb-item active">LE THANH</li>
				</ol>
			</div>
		</div>

		{{-- @if(count($errors)>0)
			<div class="alert alert-danger">
				@foreach($errors ->all() as $err)
					{{$err}}<br>
				@endforeach
			</div>
		@endif --}}
	</div><!-- /.container-fluid -->
</section>
