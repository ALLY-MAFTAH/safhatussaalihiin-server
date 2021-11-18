@extends('layouts.app')
@section('scripts')

@endsection

@section('content')
    <div class="col py-5">
        <div class="">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @if (session('errors'))
                <div class="alert alert-danger" role="alert">
                    {{ session('errors') }}
                </div>
            @endif

            <!-- ACTIONS -->
            <section id="actions" class=" mb-2 ">
                <div class="container">

                    <div class="row"
                        style="margin:2px;padding-top:20px;background-color: rgb(247, 232, 206); border-radius: 5px">

                        <div class="col-md-2">
                            <button onclick="history.back()" class="btn btn-primary btn-outline">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="text-center"
                                style="border-radius: 20px; width:200px; height:33px; background-color:rgb(240, 214, 160);">
                                <i class="fas fa-calendar px-2" style="font-size: 20px; color: gray"></i><span
                                    style="color: rgb(13, 4, 131); font-size:20px"><b>{{ $month->name }},
                                        {{ $thisYear }}</b></span>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <p style="font-size: 20px"><b> PICTURES AND VIDEOS</b></p>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-1 text-right">

                        </div>

                    </div>
                </div>
            </section>
            <section id="pictures">
                <div class=" container">
                    @if (Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}
                        </p>
                    @endif
                    <ul class="row nav nav-tabs text-center" id="myTab"
                        style="">
                        <li class=" col-6">
                            <a href="#PicturesTab" style="background-color: rgb(235, 199, 146)" class="nav-link active"
                                data-toggle="tab" id="picturesTab">
                                <b style="font-size: 25px;">Pictures</b>

                            </a>
                        </li>
                        <li class=" col-6">
                            <a href="#VideosTab" style="background-color: rgb(235, 199, 146)" class="nav-link"
                                data-toggle="tab" id="videosTab">
                                <b style="font-size: 25px;">Videos</b>

                            </a>
                        </li>

                    </ul>

                    <div class="tab-content">
                        <div id="PicturesTab" class="tab-pane fade tabcontent show active">
                            <table class="table table-responsive-lg table-striped">
                                <thead class="thead">
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Title</th>
                                        <th>Picture File</th>
                                        <th></th>
                                        <th><a href="#" class="btn btn-primary btn-outline" data-toggle="modal"
                                                data-target="#addPictureModal-{{ $month->id }}">
                                                <i class="fas fa-plus"></i> Add
                                            </a></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pictures as $index => $picture)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>

                                            <td>{{ $picture->date }}</td>
                                            <td>{{ $picture->title }}</td>
                                            <td class=""><img class="zoom-image"
                                                    src="{{ asset('storage/' . $picture->file) }}" alt="Image File"
                                                    style="width: 30px; height:30px"></td>
                                            <td>
                                                <a href="#" class="btn btn-outline-primary" data-toggle="modal"
                                                    data-target="#editPictureModal-{{ $picture->id }}">
                                                    <i class="fas fa-edit">
                                                        Edit</i>
                                                </a>

                                                <!-- EDIT PICTURE MODAL -->
                                                <div class="modal fade" id="editPictureModal-{{ $picture->id }}">
                                                    <div class="modal-dialog modal-md">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-primary text-white">
                                                                <h5 class="modal-title">Edit Picture</h5>
                                                                <button class="close" data-dismiss="modal">
                                                                    <span>&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST"
                                                                    action="{{ route('edit_picture', $picture->id) }}"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')

                                                                    <div class="form-group row">
                                                                        <label for="date"
                                                                            class="col-md-4 col-form-label text-md-right">{{ __('Date') }}</label>
                                                                        <div class="col-md-6">
                                                                            <input id="date" type="date"
                                                                                class="form-control @error('year') is-invalid @enderror"
                                                                                name="date"
                                                                                value="{{ old('date', $picture->date) }}"
                                                                                required autocomplete="date">
                                                                            @error('date')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="title"
                                                                            class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
                                                                        <div class="col-md-6">
                                                                            <input id="title" type="text"
                                                                                class="form-control @error('year') is-invalid @enderror"
                                                                                name="title"
                                                                                value="{{ old('title', $picture->title) }}"
                                                                                required autocomplete="title">
                                                                            @error('title')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="file"
                                                                            class="col-md-4 col-form-label text-md-right">{{ __('Image File') }}</label>
                                                                        <div class="col-md-6">
                                                                            <input id="file" type="file"
                                                                                class="form-control @error('file') is-invalid @enderror"
                                                                                name="file" value="{{ old('file') }}"
                                                                                autocomplete="file">
                                                                            @error('file')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row mb-0">
                                                                        <div class="col-md-6 offset-md-4">
                                                                            <button type="submit" class="btn btn-primary">
                                                                                Save
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('delete_picture', $picture->id) }}"
                                                    onclick="return confirm('This picture will be deleted')"
                                                    class="btn btn-outline-danger">
                                                    <i class="fas fa-trash"> Delete</i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div id="VideosTab" class="tab-pane fade tabcontent">
                            <table class="table table-responsive-lg table-striped">
                                <thead class="thead">
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Title</th>
                                        <th>Video File</th>
                                        <th></th>
                                        <th><a href="#" class="btn btn-primary btn-outline" data-toggle="modal"
                                                data-target="#addVideoModal-{{ $month->id }}">
                                                <i class="fas fa-plus"></i> Add
                                            </a></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($videos as $index => $video)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>


                                            <td>{{ $video->date }}</td>
                                            <td>{{ $video->title }}</td>
                                            <td>
                                                <a href="#" class="btn btn-outline-success" data-toggle="modal"
                                                    data-target="#playVideoModal-{{ $video->id }}"><i
                                                        class="fas fa-play">
                                                        Play</i></a>
                                                <!-- PLAY VIDEO MODAL -->
                                                <div class="modal fade" id="playVideoModal-{{ $video->id }}">
                                                    <div class="modal-dialog ">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-success text-white">
                                                                <h5 class="modal-title">Play Video</h5>
                                                                <button class="close" data-dismiss="modal">
                                                                    <span>&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="">
                                                                    <video src="{{ asset('storage/' . $video->file) }}"
                                                                        controls style="width: 100%;height:100%"></video>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-outline-primary" data-toggle="modal"
                                                    data-target="#editVideoModal-{{ $video->id }}">
                                                    <i class="fas fa-edit">
                                                        Edit</i>
                                                </a>

                                                <!-- EDIT VIDEO MODAL -->
                                                <div class="modal fade" id="editVideoModal-{{ $video->id }}">
                                                    <div class="modal-dialog modal-md">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-primary text-white">
                                                                <h5 class="modal-title">Edit Video</h5>
                                                                <button class="close" data-dismiss="modal">
                                                                    <span>&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST"
                                                                    action="{{ route('edit_video', $video->id) }}"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')

                                                                    <div class="form-group row">
                                                                        <label for="date"
                                                                            class="col-md-4 col-form-label text-md-right">{{ __('Date') }}</label>
                                                                        <div class="col-md-6">
                                                                            <input id="date" type="date"
                                                                                class="form-control @error('year') is-invalid @enderror"
                                                                                name="date"
                                                                                value="{{ old('date', $video->date) }}"
                                                                                required autocomplete="date">
                                                                            @error('date')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="title"
                                                                            class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
                                                                        <div class="col-md-6">
                                                                            <input id="title" type="text"
                                                                                class="form-control @error('year') is-invalid @enderror"
                                                                                name="title"
                                                                                value="{{ old('title', $video->title) }}"
                                                                                required autocomplete="title">
                                                                            @error('title')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="file"
                                                                            class="col-md-4 col-form-label text-md-right">{{ __('Image File') }}</label>
                                                                        <div class="col-md-6">
                                                                            <input id="file" type="file"
                                                                                class="form-control @error('file') is-invalid @enderror"
                                                                                name="file" value="{{ old('file') }}"
                                                                                autocomplete="file">
                                                                            @error('file')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row mb-0">
                                                                        <div class="col-md-6 offset-md-4">
                                                                            <button type="submit" class="btn btn-primary">
                                                                                Save
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('delete_video', $video->id) }}"
                                                    onclick="return confirm('This video will be deleted')"
                                                    class="btn btn-outline-danger">
                                                    <i class="fas fa-trash"> Delete</i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            <!-- ADD PICTURE MODAL -->
            <div class="modal fade" id="addPictureModal-{{ $month->id }}">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Add Picture</h5>
                            <button class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('add_picture', $month->id) }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <label for="date"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Date') }}</label>
                                    <div class="col-md-6">
                                        <input id="date" type="date"
                                            class="form-control @error('date') is-invalid @enderror" name="date"
                                            value="{{ old('date') }}" required autocomplete="date" autofocus>
                                        @error('date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="title"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
                                    <div class="col-md-6">
                                        <input id="title" type="text"
                                            class="form-control @error('year') is-invalid @enderror" name="title"
                                            value="{{ old('title') }}" required autocomplete="title">
                                        @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="file"
                                        class="col-md-4 col-form-label text-md-right">{{ __('File') }}</label>
                                    <div class="col-md-6">
                                        <input id="file" type="file"
                                            class="form-control @error('file') is-invalid @enderror" name="file"
                                            value="{{ old('file') }}" required autocomplete="file">
                                        @error('file')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ADD VIDEO MODAL -->
            <div class="modal fade" id="addVideoModal-{{ $month->id }}">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Add Video</h5>
                            <button class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('add_video', $month->id) }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <label for="date"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Date') }}</label>
                                    <div class="col-md-6">
                                        <input id="date" type="date"
                                            class="form-control @error('date') is-invalid @enderror" name="date"
                                            value="{{ old('date') }}" required autocomplete="date" autofocus>
                                        @error('date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="title"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
                                    <div class="col-md-6">
                                        <input id="title" type="text"
                                            class="form-control @error('year') is-invalid @enderror" name="title"
                                            value="{{ old('title') }}" required autocomplete="title">
                                        @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="file"
                                        class="col-md-4 col-form-label text-md-right">{{ __('File') }}</label>
                                    <div class="col-md-6">
                                        <input id="file" type="file"
                                            class="form-control @error('file') is-invalid @enderror" name="file"
                                            value="{{ old('file') }}" required autocomplete="file">
                                        @error('file')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .tab {
                    overflow: hidden;
                    border: 1px solid #ccc;
                    background-color: #ecdfc3;
                    /* display: block; */
                    /* position: relative; */
                }

                #PicturesTab {
                    background-color: rgb(243, 229, 203);
                }

                #VideosTab {
                    background-color: rgb(243, 229, 203);
                }

                th {
                    font-size: 20px;
                }

            </style>
            <script>
                $(document).ready(function() {
                    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
                        localStorage.setItem('activeTab', $(e.target).attr('href'));
                    });
                    var activeTab = localStorage.getItem('activeTab');
                    if (activeTab) {
                        $('#myTab a[href="' + activeTab + '"]').tab('show');
                    }
                    console.log(activeTab);
                    selectedTab = activeTab;
                    if (selectedTab == "#Total") {
                        document.getElementById('monthFilter').style.display = "none";
                        document.getElementById('printBtn1').style.display = "block";
                        document.getElementById('printBtn2').style.display = "none";
                    } else {
                        document.getElementById('monthFilter').style.display = "block";
                        document.getElementById('printBtn2').style.display = "block";
                        document.getElementById('printBtn1').style.display = "none";
                    }
                });
            </script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
                integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
                crossorigin="anonymous" />

        </div>
    </div>
@endsection
