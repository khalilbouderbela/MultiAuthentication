@extends('dashboards.managers.layouts.manager-dash-layout')
@section('title','Profile')

@section('content')

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Welcome User {{Auth::user()->name}}!</h1>
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
                  <li class="nav-item"><a class="nav-link active" href="#projects_list" data-toggle="tab">Projects List</a></li>
                  <li class="nav-item"><a class="nav-link" href="#change_password" data-toggle="tab">Change Password</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="projects_list">
                  <table class="table">
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Image</th>
      <th scope="col">Video</th>
      <th scope="col">Document</th>
      <th scope="col">Description</th>
      <th scope="col">Git</th>
      <th scope="col">Status</th>

    </tr>
  </thead>
  <tbody>
    @foreach ($project as $projects)

    <tr>
      <td>{{ $projects->name }}</td>
      <td><img src="{{  env('PROJECT_UPLOAD_FOLDER').$projects->image  }}" width="70px" height="70px" alt="Image"></td>
      <td>
        <video width="250" height="200" controls >
              <source src="{{  env('PROJECT_UPLOAD_FOLDER').$projects->video }}" type="video/mp4">
              Your browser does not support the video tag.
          </video>
      </td>
      <td>
        @if($projects->document )
                        <a href="{{  env('PROJECT_UPLOAD_FOLDER').$projects->document }}" target="_blank" >View Document</a>
        @else
          There is no document
          @endif

                      </td>
      <td>{{ $projects->description }}</td>
      <td>{{ $projects->git }}</td>
      <td>{{ $projects->status }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="change_password">
                  <form class="form-horizontal" method="POST" action="{{ route('managerChangePassword') }}" id="changePasswordManagerForm">
                  {{ csrf_field() }}
                      <div class="form-group row">
                        <label for="oldpassword" class="col-sm-2 col-form-label">Old Password</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="oldpassword" placeholder="Enter current password" name="oldpassword">
                          <span class="text-danger error-text oldpassword_error"></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="newpassword" class="col-sm-2 col-form-label">New password</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="newpassword" placeholder="Enter new password" name="newpassword">
                          <span class="text-danger error-text newpassword_error"></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="cnewpassword" class="col-sm-2 col-form-label">Confirm New Password</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="cnewpassword" placeholder="ReEnter new password" name="cnewpassword">
                          <span class="text-danger error-text cnewpassword_error"></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Update Password</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
@endsection