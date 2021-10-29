@extends('dashboards.users.layouts.user-dash-layout')
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


                <a href="#" class="btn btn-primary btn-block"><b>{{Auth::user()->phone}}</b></a>
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
                  <li class="nav-item"><a class="nav-link active" href="#add_project" data-toggle="tab">Add Project</a></li>
                  <li class="nav-item"><a class="nav-link" href="#projects_list" data-toggle="tab">Projects List</a></li>
                  <li class="nav-item"><a class="nav-link" href="#change_password" data-toggle="tab">Change Password</a></li>
                </ul>
              </div><!-- /.card-header -->
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
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="add_project">
                    <form class="form-horizontal" method="POST" action="{{ route('userCreateProject') }}" enctype="multipart/form-data">
                @csrf
                      <div class="form-group row">
                        <label for="projectname" class="col-sm-2 col-form-label">Project Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" value="{{ old('projectname') }}" name="projectname" placeholder="Enter Project Name">
									        <span class="text-danger">@error('projectname'){{ $message }}@enderror</span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="projectimage" class="col-sm-2 col-form-label">Project Image</label>
                        <div class="col-sm-10">
                          <input type="file" class="form-control"  name="projectimage">
									        <span class="text-danger">@error('projectimage'){{ $message }}@enderror</span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="projectvideo" class="col-sm-2 col-form-label">Project Video</label>
                        <div class="col-sm-10">
                          <input type="file" class="form-control" name="projectvideo">
									        <span class="text-danger">@error('projectvideo'){{ $message }}@enderror</span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="additionaldocument" class="col-sm-2 col-form-label">Additional Document (optional)</label>
                        <div class="col-sm-10">
                          <input type="file" class="form-control" name="additionaldocument">
									        <span class="text-danger">@error('additionaldocument'){{ $message }}@enderror</span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="projectdescription" class="col-sm-2 col-form-label">Project Description</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" value="{{ old('projectdescription') }}" name="projectdescription" placeholder="Enter Project Description">
									        <span class="text-danger">@error('projectdescription'){{ $message }}@enderror</span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="projectgit" class="col-sm-2 col-form-label">Project Git Link</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="projectgit" value="{{ old('projectgit') }}"  placeholder="Enter Project Git Link">
									        <span class="text-danger">@error('projectgit'){{ $message }}@enderror</span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="projectstatus" class="col-sm-2 col-form-label" >Project Status</label>
                        <select class="ui dropdown" name="projectstatus">
                              <option value="Active"  {{ old('projectstatus') == 'Active' ? 'selected' : '' }}>Active</option>
                              <option value="Incomplete" {{ old('projectstatus') == 'Incomplete' ? 'selected' : '' }}>Incomplete</option>
                              <option value="Ongoing" {{ old('projectstatus') == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                              <option value="Stuck" {{ old('projectstatus') == 'Stuck' ? 'selected' : '' }}>Stuck</option>
                        </select>
									        <span class="text-danger">@error('projectstatus'){{ $message }}@enderror</span>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger" style="background-color: #36C95D">Save Project</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="tab-pane" id="projects_list">
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
      <th scope="col">Edit</th>
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
      <td>
       <a href="{{route('project.ViewUpdate',$projects->id)}}" class="btn btn-primary btn-sm" style="background-color: #36C95D">Edit</a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="change_password">
                  <form class="form-horizontal" method="POST" action="{{ route('userChangePassword') }}" id="changePasswordUserForm">
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
                          <button type="submit" class="btn btn-danger" style="background-color: #36C95D">Update Password</button>
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