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
                            <p style="font-size: 20px"><b> POSTS</b></p>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-1 text-right">
                        </div>
                    </div>
                </div>
            </section>
            <section id="posts">
                <div class=" container">
                    @if (Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}
                        </p>
                    @endif
                    <div class="tab-content">
                        <div id="PostsTab" class="tab-pane fade tabcontent show active">
                            <table class="table table-responsive-lg table-striped">
                                <thead class="thead">
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Title</th>
                                        <th>Picture 01</th>
                                        <th>Picture 02</th>
                                        <th>Picture 03</th>
                                        <th>Video 01</th>
                                        <th>Video 02</th>
                                        <th></th>
                                        <th><a href="#" class="btn btn-primary btn-outline" data-toggle="modal"
                                                data-target="#addPostModal-{{ $month->id }}">
                                                <i class="fas fa-plus"></i> Add
                                            </a></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $index => $post)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>

                                            <td>{{ $post->date }}</td>
                                            <td>{{ $post->title }}</td>
                                            <td class="">
                                                @if ($post->picture_file_1 == '')
                                                    <i class="fas fa-exclamation-triangle" style="color: red"> Empty</i>
                                                @else

                                                    <img class="zoom-image"
                                                        src="{{ asset('storage/' . $post->picture_file_1) }}"
                                                        alt="Image File" style="width: 30px; height:30px">
                                                @endif
                                            </td>
                                            <td class="">
                                                @if ($post->picture_file_2 == '')
                                                    <i class="fas fa-exclamation-triangle" style="color: red"> Empty</i>
                                                @else<img class="zoom-image"
                                                        src="{{ asset('storage/' . $post->picture_file_2) }}"
                                                        alt="Image File" style="width: 30px; height:30px">
                                                @endif
                                            </td>
                                            <td class="">
                                                @if ($post->picture_file_3 == '')
                                                    <i class="fas fa-exclamation-triangle" style="color: red"> Empty</i>
                                                @else<img class="zoom-image"
                                                        src="{{ asset('storage/' . $post->picture_file_3) }}"
                                                        alt="Image File" style="width: 30px; height:30px">
                                                @endif
                                            </td>
                                            <td> @if ($post->video_file_1 == '')
                                                <i class="fas fa-exclamation-triangle" style="color: red"> Empty</i>
                                                @else
                                                <a href="#" class="btn btn-outline-success" data-toggle="modal"
                                                data-target="#playVideo1Modal-{{ $post->id }}"><i
                                                class="fas fa-play">
                                                Play</i></a>
                                                <!-- PLAY VIDEO MODAL -->
                                                <div class="modal fade" id="playVideo1Modal-{{ $post->id }}">
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
                                                                    <video
                                                                        src="{{ asset('storage/' . $post->video_file_1) }}"
                                                                        controls style="width: 100%;height:100%"></video>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($post->video_file_2 == '')
                                                <i class="fas fa-exclamation-triangle" style="color: red"> Empty</i>
                                                @else
                                                <a href="#" class="btn btn-outline-success" data-toggle="modal"
                                                data-target="#playVideo2Modal-{{ $post->id }}"><i
                                                class="fas fa-play">
                                                Play</i></a>
                                                <!-- PLAY VIDEO MODAL -->
                                                <div class="modal fade" id="playVideo2Modal-{{ $post->id }}">
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
                                                                    <video
                                                                        src="{{ asset('storage/' . $post->video_file_2) }}"
                                                                        controls style="width: 100%;height:100%"></video>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </td>
                                                <td>
                                                <a href="#" class="btn btn-outline-primary" data-toggle="modal"
                                                    data-target="#editPostModal-{{ $post->id }}">
                                                    <i class="fas fa-edit">
                                                        Edit</i>
                                                </a>

                                                <!-- EDIT POST MODAL -->
                                                <div class="modal fade" id="editPostModal-{{ $post->id }}">
                                                    <div class="modal-dialog modal-md">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-primary text-white">
                                                                <h5 class="modal-title">Edit Post</h5>
                                                                <button class="close" data-dismiss="modal">
                                                                    <span>&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST"
                                                                    action="{{ route('edit_post', $post->id) }}"
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
                                                                                value="{{ old('date', $post->date) }}"
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
                                                                                value="{{ old('title', $post->title) }}"
                                                                                required autocomplete="title">
                                                                            @error('title')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="picture_file_1"
                                                                            class="col-md-4 col-form-label text-md-right">{{ __('Picture 01') }}</label>
                                                                        <div class="col-md-6">
                                                                            <input id="picture_file_1" type="file"
                                                                                class="form-control @error('picture_file_1') is-invalid @enderror"
                                                                                name="picture_file_1"
                                                                                value="{{ old('picture_file_1')?? $post->picture_file_1 }}"
                                                                                autocomplete="picture_file_1">
                                                                            @error('picture_file_1')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="picture_file_2"
                                                                            class="col-md-4 col-form-label text-md-right">{{ __('Picture 02') }}</label>
                                                                        <div class="col-md-6">
                                                                            <input id="picture_file_2" type="file"
                                                                                class="form-control @error('picture_file_2') is-invalid @enderror"
                                                                                name="picture_file_2"
                                                                                value="{{ old('picture_file_2') }}"
                                                                                autocomplete="picture_file_2">
                                                                            @error('picture_file_2')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="picture_file_3"
                                                                            class="col-md-4 col-form-label text-md-right">{{ __('Picture 03') }}</label>
                                                                        <div class="col-md-6">
                                                                            <input id="picture_file_3" type="file"
                                                                                class="form-control @error('picture_file_3') is-invalid @enderror"
                                                                                name="picture_file_3"
                                                                                value="{{ old('picture_file_3') }}"
                                                                                autocomplete="picture_file_3">
                                                                            @error('picture_file_3')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="video_file_1"
                                                                            class="col-md-4 col-form-label text-md-right">{{ __('Video 01') }}</label>
                                                                        <div class="col-md-6">
                                                                            <input id="video_file_1" type="file"
                                                                                class="form-control @error('video_file_1') is-invalid @enderror"
                                                                                name="video_file_1"
                                                                                value="{{ old('video_file_1') }}"
                                                                                autocomplete="video_file_1">
                                                                            @error('video_file_1')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="video_file_2"
                                                                            class="col-md-4 col-form-label text-md-right">{{ __('Video 02') }}</label>
                                                                        <div class="col-md-6">
                                                                            <input id="video_file_2" type="file"
                                                                                class="form-control @error('video_file_2') is-invalid @enderror"
                                                                                name="video_file_2"
                                                                                value="{{ old('video_file_2') }}"
                                                                                autocomplete="video_file_2">
                                                                            @error('video_file_2')
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
                                                <a href="{{ route('delete_post', $post->id) }}"
                                                    onclick="return confirm('This post will be deleted')"
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
            </section>
            <!-- ADD POST MODAL -->
            <div class="modal fade" id="addPostModal-{{ $month->id }}">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Add Post</h5>
                            <button class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('add_post', $month->id) }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <label for="date"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Date') }}</label>
                                    <div class="col-md-6">
                                        <input id="date" type="date"
                                            class="form-control @error('date') is-invalid @enderror" name="date"
                                            value="<?php echo date('Y-m-d'); ?>" required autocomplete="date" autofocus>
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
                                    <label for="picture_file_1"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Picture 01') }}</label>
                                    <div class="col-md-6">
                                        <input id="picture_file_1" type="file" required
                                            class="form-control @error('picture_file_1') is-invalid @enderror"
                                            name="picture_file_1" value="{{ old('picture_file_1') }}"
                                            autocomplete="picture_file_1">
                                        @error('picture_file_1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="picture_file_2"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Picture 02') }}</label>
                                    <div class="col-md-6">
                                        <input id="picture_file_2" type="file"
                                            class="form-control @error('picture_file_2') is-invalid @enderror"
                                            name="picture_file_2" value="{{ old('picture_file_2') }}"
                                            autocomplete="picture_file_2">
                                        @error('picture_file_2')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="picture_file_3"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Picture 03') }}</label>
                                    <div class="col-md-6">
                                        <input id="picture_file_3" type="file"
                                            class="form-control @error('picture_file_3') is-invalid @enderror"
                                            name="picture_file_3" value="{{ old('picture_file_3') }}"
                                            autocomplete="picture_file_3">
                                        @error('picture_file_3')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="video_file_1"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Video 01') }}</label>
                                    <div class="col-md-6">
                                        <input id="video_file_1" type="file" required
                                            class="form-control @error('video_file_1') is-invalid @enderror"
                                            name="video_file_1" value="{{ old('video_file_1') }}"
                                            autocomplete="video_file_1">
                                        @error('video_file_1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="video_file_2"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Video 02') }}</label>
                                    <div class="col-md-6">
                                        <input id="video_file_2" type="file"
                                            class="form-control @error('video_file_2') is-invalid @enderror"
                                            name="video_file_2" value="{{ old('video_file_2') }}"
                                            autocomplete="video_file_2">
                                        @error('video_file_2')
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

                #PostsTab {
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
