<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/Logo.png')}}"/>
  <title>Posts - {{env('APP_NAME')}}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/auth.css')}}">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('images/Logo.png')}}" alt="AdminLTELogo" height="60" width="60">
  </div>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('admin.dashboard')}}" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      @if(!Auth::user())
      <li class="nav-item">
        <a class="nav-link" href="{{route('login')}}">Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('register')}}">Register</a>
      </li>
      @else
      <li class="nav-item">
        <a class="nav-link" href="{{route('auth.logout')}}">Log out</a>
      </li>
      @endif
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin.dashboard')}}" class="brand-link">
      <img src="{{asset('images/Logo.png')}}" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
      <span class="brand-text font-weight-light">GoodQuestion</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      @if(Auth::user())
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{Auth::user()->profile_photo}}" class="img-circle elevation-2" alt="User-Image">
        </div>
        <div class="info">
          <a href="{{route('admin.profile')}}" class="d-block">{{Auth::user()->login}}</a>
        </div>
      </div>
      @endif

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

     <!-- Sidebar Menu -->
     <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
              <a href="{{route('admin.dashboard')}}" class="nav-link">
                <i class="fa fa-home"></i>
                <p>Home</p>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{route('users.list')}}" class="nav-link">
                <i class="fa fa-user"></i>
                <p>Manage Users</p>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{route('posts.list')}}" class="nav-link active">
                <i class="fa fa-book"></i>
                <p>Manage Posts</p>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{route('categories.list')}}" class="nav-link">
                <i class="fas fa fa-list-alt"></i>
                <p>Manage Categories</p>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{route('comments.list')}}" class="nav-link">
                <i class="far fa-comment"></i>
                <p>Manage Comments</p>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{route('likes.list')}}" class="nav-link">
                <i class="fas fa-thumbs-up"></i>
                <p>Manage Likes</p>
              </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Posts</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Contacts</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    @if(Session::get('success'))
      <div class="form-group">
        <p class="success">{{Session::get('success')}}</p>
      </div>
    @endif
    @if(Session::get('fail'))
      <div class="form-group">
        <p class="fail">{{Session::get('fail')}}</p>
      </div>
    @endif
    @if(Session::get('fail-arr'))
      <div class="input-field">
        @foreach(Session::get('fail-arr') as $key => $err)
          <p class="fail">{{$key . ': ' . $err[0]}}</p>
        @endforeach
      </div>
    @endif
    <a href="{{route('posts.create.view')}}" class="btn btn-primary m-2"><i class="fas fa-plus mr-2"></i>Create post</a>
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body pb-0">
          <div class="row">
            @foreach($data as $d)
            <div class="col-12  col-md-6 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-body pt-0">
                <div class="post">
                  <form action="{{route('comments.create' , ['post_id' => $d['post']->id])}}" method="POST">   
                    @csrf
                      <div class="user-block mt-3">
                        <img class="img-circle img-bordered-sm" src="{{$d['author']->profile_photo}}" alt="user image">
                        <span class="username">
                          <a href="{{route('users.update.view', ['user' => $d['author']->id])}}">{{$d['post']->author}}</a>
                          @if($d['post']->status == "active")
                          <span class="float-right btn-tool text-success">{{$d['post']->status}}</span>
                          @else
                          <span class="float-right btn-tool text-danger">{{$d['post']->status}}</span>
                          @endif
                        </span>
                        <span class="description">Shared publicly - {{$d['post']->created_at}}</span>
                      </div>
                      <!-- /.user-block -->
                      <p class="text-center lead font-weight-bold text-muted">{{$d['post']->title}}</p>
                      <p>
                      {{$d['post']->content}}
                      </p>
                      <div class="col-lg-10">
                        <div class="row">
                      @if($d['post']->images)
                        @foreach($d['images'] as $img)
                          @if($img != "")
                            <div class="col-lg-6">
                              <img class="img-fluid mb-3" src="{{$img}}" alt="Photo">
                            </div>
                          @endif
                        @endforeach            
                      @endif 
                        </div>
                      </div>
                      
                      <div class="input-group mb-2">
                        <input class="form-control form-control-sm" name="comment" type="text" placeholder="Type a comment" require>
                        <button type="submit" class="btn btn-sm btn-default"><i class="fa fa-arrow-right"></i></button>
                      </div>
                  </form> 
                  <p>
                    <div class="input-group">
                      <form action="{{route('like.post.create', ['post_id' => $d['post']->id])}}" method="POST">
                        @csrf
                        <button type="submit" class="link-black text-sm like-btn"><i class="@if(\App\Models\Like::where(['post_id' => $d['post']->id, 'type' => 'like', 'author' => Auth::user()->login])->first())fas fa-thumbs-up @else far fa-thumbs-up @endif mr-1"></i> Like({{count($d['likes'])}})</button>
                      </form>
                      <form action="{{route('dislike.post.create',['post_id' => $d['post']->id])}}" method="POST">
                        @csrf
                        <button type="submit" class="link-black text-sm ml-2 like-btn"><i class="@if(\App\Models\Like::where(['post_id' => $d['post']->id, 'type' => 'dislike', 'author' => Auth::user()->login])->first())fas fa-thumbs-up @else far fa-thumbs-up @endif mr-1"></i> Dislike({{count($d['dislikes'])}})</button>
                      </form>
                    </div>
                    <span class="float-right">
                      <a class="link-black text-sm" data-toggle="collapse" href="#comment-{{$d['post']->id}}" role="button" aria-expanded="false" aria-controls="comment-{{$d['post']->id}}">
                        <i class="far fa-comments mr-1"></i> Comments ({{count($d['comments'])}})
                      </a>
                    </span><br>
                  </p> 
                      <div class="collapse" id="comment-{{$d['post']->id}}">
                        @foreach($d['comments'] as $comment)
                        <div class="card card-body">
                          <div>
                              <div>
                                <img class="img-circle img-sm img-bordered-sm" src="{{\App\Models\User::where('login', $comment->author)->first()->profile_photo}}" alt="user image">  
                                <a class="ml-1" href="{{route('users.update.view', ['user' => \App\Models\User::where('login', $comment->author)->first()->id])}}">{{$comment->author}}</a>
                                <span class="text-muted text-sm text-right">{{$comment->created_at}}</span>
                                @if($comment->status == "active")
                                  <span class="float-right btn-tool text-success">{{$comment->status}}</span>
                                @else
                                  <span class="float-right btn-tool text-danger">{{$comment->status}}</span>
                                @endif
                              </div>
                              <div class="mt-1 ml-2">
                                <span>{{$comment->content}}</span>
                              </div>
                              <div class="input-group">
                                <form action="{{route('like.comment.create', ['comment_id' => $comment->id])}}" method="POST">
                                  @csrf
                                  <button type="submit" class="link-black text-sm like-btn"><i class="@if(\App\Models\Like::where(['comment_id' => $comment->id, 'type' => 'like', 'author' => Auth::user()->login])->first())fas fa-thumbs-up @else far fa-thumbs-up @endif mr-1"></i> Like({{count(\App\Models\Like::where(['comment_id' => $comment->id, 'type' => 'like'])->get())}})</button>
                                </form>
                                <form action="{{route('dislike.comment.create',['comment_id' => $comment->id])}}" method="POST">
                                  @csrf
                                  <button type="submit" class="link-black text-sm ml-2 like-btn"><i class="@if(\App\Models\Like::where(['comment_id' => $comment->id, 'type' => 'dislike', 'author' => Auth::user()->login])->first())fas fa-thumbs-up @else far fa-thumbs-up @endif mr-1"></i> Dislike({{count(\App\Models\Like::where(['comment_id' => $comment->id, 'type' => 'dislike'])->get())}})</button>
                                </form>
                              </div>
                              <div class="d-flex justify-content-end">
                                 <a class="link-black mr-3" href="" data-toggle="modal" data-target="#modal-edit-{{$comment->id}}">Edit</a>
                                 <a class="link-black" href="" data-toggle="modal" data-target="#modal-deleteComment-{{$comment->id}}">Remove</a>
                              </div>
                          </div>                         
                        </div>
                        <div class="modal fade" id="modal-deleteComment-{{$comment->id}}">
                          <div class="modal-dialog">
                            <div class="modal-content bg-danger">
                              <div class="modal-header">
                                <h4 class="modal-title">Confirmation</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <p>You are about to delete a post. Are you sure? </p>
                              </div>
                              <form action="{{route('comments.delete', $comment->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-outline-light">Delete</button>
                                </div>
                              </form>
                            </div>
                              <!-- /.modal-content -->
                          </div>
                          <!-- /.modal-dialog -->
                        </div>
                        <div class="modal fade" id="modal-edit-{{$comment->id}}">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title">Update Category</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <form action="{{route('comments.update', $comment->id)}}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="status">Comment's status</label>
                                        <select id="status" name="status" class="form-control custom-select">
                                            <option selected disabled>{{$comment->status}}</option>
                                            <option>active</option>
                                            <option>inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                              </form>
                            </div>
                              <!-- /.modal-content -->
                          </div>
                            <!-- /.modal-dialog -->
                        </div>
                        @endforeach
                      </div>                  
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                    <a href="{{route('posts.update.view', $d['post']->id)}}" class="btn btn-sm bg-teal mr-2">
                      <i class="fas fa-pen"></i>Edit
                    </a>
                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-danger-{{$d['post']->id}}">
                      <i class="fas fa-times"></i> Delete
                    </button>
                  </div>
                </div>
                <div class="modal fade" id="modal-danger-{{$d['post']->id}}">
                  <div class="modal-dialog">
                    <div class="modal-content bg-danger">
                      <div class="modal-header">
                        <h4 class="modal-title">Confirmation</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p>You are about to delete a post. Are you sure? </p>
                      </div>
                      <form action="{{route('posts.delete', $d['post']->id)}}" method="POST">
                      @csrf
                      @method('DELETE')
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-outline-light">Delete</button>
                        </div>
                      </form>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
        <!-- /.card-body -->

        <!-- /.card-footer -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.1.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
</body>
</html>
