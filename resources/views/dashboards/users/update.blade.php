@extends('dashboards.users.layouts.user-dash-layout')
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
                  <li class="nav-item"><a class="nav-link active" href="#update_project" data-toggle="tab">Update Project</a></li>
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
                    <form class="form-horizontal" method="POST" action="{{ Auth::user()->role == 1 ? route('userUpdateProjectAdmin',$project->id) :  route('userUpdateProject',$project->id) }}" enctype="multipart/form-data">
                @csrf
                      <div class="form-group row">
                        <label for="projectname" class="col-sm-2 col-form-label">Project Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" value="{{ old('projectname') ? old('projectname') : $project->name }}" name="projectname" placeholder="Enter Project Name">
									        <span class="text-danger">@error('projectname'){{ $message }}@enderror</span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="projectimage" class="col-sm-2 col-form-label">Project Image </label>

                        <div class="col-sm-7">
                          <input type="file" class="form-control"  name="projectimage">
                          
									        <span class="text-danger">@error('projectimage'){{ $message }}@enderror</span>
                        </div>
                        <div class="col-sm-3">

                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#viewProjectImg">View Old Image</button>
</div>
                      </div>
                      <div class="form-group row">
                        <label for="projectvideo" class="col-sm-2 col-form-label">Project Video</label>
                        <div class="col-sm-7">
                          <input type="file" class="form-control" name="projectvideo">
									        <span class="text-danger">@error('projectvideo'){{ $message }}@enderror</span>
                        </div>
                        
                        <div class="col-sm-3">

                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#viewProjectVid">View Old Video</button>
</div>
                      </div>
                      <div class="form-group row">
                        <label for="additionaldocument" class="col-sm-2 col-form-label">Additional Document (optional)</label>
                        <div class="col-sm-7">
                          <input type="file" class="form-control" name="additionaldocument">
									        <span class="text-danger">@error('additionaldocument'){{ $message }}@enderror</span>
                        </div>
                        
                        
                        <div class="col-sm-3">

                        @if($project->document )
                        <a href="{{  env('PROJECT_UPLOAD_FOLDER').$project->document }}" target="_blank" >View Old Document</a>
                        
          @endif
</div>
                      </div>
                      <div class="form-group row">
                        <label for="projectdescription" class="col-sm-2 col-form-label">Project Description</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" value="{{  old('projectdescription') ? old('projectdescription') : $project->description }}" name="projectdescription" placeholder="Enter Project Description">
									        <span class="text-danger">@error('projectdescription'){{ $message }}@enderror</span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="projectgit" class="col-sm-2 col-form-label">Project Git Link</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="projectgit" value="{{ old('projectgit') ? old('projectgit') :$project->git }}"  placeholder="Enter Project Git Link">
									        <span class="text-danger">@error('projectgit'){{ $message }}@enderror</span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="projectstatus" class="col-sm-2 col-form-label" >Project Status</label>
                        <select class="ui dropdown form-select" name="projectstatus">
                              <option value="Active"  {{ old('projectstatus') ?  old('projectstatus') == 'Active' ? 'selected' : '' : $project->status == 'Active' ? 'selected' : '' }}>Active</option>
                              <option value="Incomplete" {{  old('projectstatus') ?  old('projectstatus') == 'Incomplete' ? 'selected' : '' : $project->status == 'Incomplete' ? 'selected' : '' }}>Incomplete</option>
                              <option value="Ongoing" {{  old('projectstatus') ?  old('projectstatus') == 'Ongoing' ? 'selected' : '' : $project->status == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                              <option value="Stuck" {{  old('projectstatus') ?  old('projectstatus') == 'Stuck' ? 'selected' : '' : $project->status == 'Stuck' ? 'selected' : '' }}>Stuck</option>
                        </select>
									        <span class="text-danger">@error('projectstatus'){{ $message }}@enderror</span>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Update Project</button>
                        </div>
                      </div>
                    </form>
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

    <!-- View Project Image Modal -->
<div class="modal fade" id="viewProjectImg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Project Image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <img src="{{  env('PROJECT_UPLOAD_FOLDER').$project->image }}" alt="Project Image" class="centerMe" width="300" height="300" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

    <!-- View Project Video Modal -->
    <div class="modal fade" id="viewProjectVid" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Project Video</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          
        <video width="320" height="240" controls class="centerMe">
            <source src="{{  env('PROJECT_UPLOAD_FOLDER').$project->video }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



@endsection