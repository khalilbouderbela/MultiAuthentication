@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title','Profile')

@section('content')

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">{{Auth::user()->name}}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="../../dist/img/avatar5.png"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{Auth::user()->name}}</h3>

                <p class="text-muted text-center">{{Auth::user()->email}}</p>


                <a class="btn btn-primary btn-block"><b>{{Auth::user()->phone}}</b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->

            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#save_changes" data-toggle="tab">Save Changes</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <!-- /.tab-pane -->
                  <div class="active tab-pane" id="save_changes">
                  <form class="form-horizontal" method="POST" action="{{ route('update-user',$user->id) }}" >
                  @if ( Session::get('success'))
									 <div class="alert alert-success">
										 {{ Session::get('success') }}
									 </div>
								@endif
								@if ( Session::get('error'))
									 <div class="alert alert-danger">
										 {{ Session::get('error') }}
									 </div>
								@endif
                                @csrf
                                @method('PUT')
                      <div class="form-group row">
                        <label for="username" class="col-sm-2 col-form-label">User Name</label>
                        <div class="col-sm-10">
                          <input type="text" value="{{  old('userrole') ?  old('userrole') : $user->name }}" class="form-control" id="username" name="username">
                          <span class="text-danger">@error('username'){{ $message }}@enderror</span>

                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="useremail" class="col-sm-2 col-form-label">User Email</label>
                        <div class="col-sm-10">
                          <input type="email" value="{{ old('useremail') ?  old('useremail') : $user->email }}" class="form-control" id="useremail"  name="email">
                          <span class="text-danger">@error('useremail'){{ $message }}@enderror</span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="userphone" class="col-sm-2 col-form-label">User Phone Number</label>
                        <div class="col-sm-10">
                          <input type="number" value="{{ old('userphone') ?  old('userphone') : $user->phone }}" class="form-control" id="userphone" name="phone">
                          <span class="text-danger">@error('userphone'){{ $message }}@enderror</span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="userrole" class="col-sm-2 col-form-label">User Role</label>
                        <div class="col-sm-10">
                          <select class="ui dropdown" name="role">
                              <option value="2" {{  old('userrole') ?  old('userrole') == '2' ? 'selected' : '' : $user->role == '2' ? 'selected' : '' }}>User</option>
                              <option value="3" {{  old('userrole') ?  old('userrole') == '3' ? 'selected' : '' : $user->role == '3' ? 'selected' : '' }}>Manager</option>
                        </select>
                          <span class="text-danger">@error('userrole'){{ $message }}@enderror</span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Update User</button>
                        </div>
                      </div>
                    </form>
                </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
@endsection