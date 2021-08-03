@extends('layouts.app')
@section('scripts')
    <script>
        $("#date").on("change", function(e) {
            e.preventDefault();
            var url = $("#filter-form").attr("action");
            var newUrl = `${url}?date=${$(e.target).val()}`;
            window.location.assign(newUrl);
        });

    </script>
@endsection

@section('content')
    <div class="col py-4">
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
            <section id="actions" class="py-4 mb-2 ">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <a href="#" class="btn btn-primary btn-outline" data-toggle="modal"
                                data-target="#addPictureModal">
                                <i class="fas fa-plus"></i> Add Picture
                            </a>
                        </div>
                        <div class="col-2">
                            <form action="{{ route('pictures') }}" method="POST" id="filter-form">
                                @csrf
                                <input id="date" type="date" class="form-control @error('date') is-invalid @enderror"
                                    name="date" value="{{ $date }}" required>
                                @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </form>
                        </div>
                    </div>
                </div>
            </section>

            <section id="pictures">
                <div class="container">
                    @if (Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}
                        </p>
                    @endif
                    @if (count($pictures) == 0)
                        <div style="text-align: center" class="py-3">
                            <b>
                                <h4>No Pictures Yet</h4>
                            </b>
                        </div>
                    @else

                        <div class="card">
                            <div class="card-header">
                                <h5>PICTURES</h5>
                            </div>
                            <table class="table table-responsive-lg table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Date</th>
                                        <th>Title</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pictures as $index => $picture)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td class=""><img class="zoom" src="{{ URL::to('storage/' . $picture->file) }}"
                                                    alt="Image File" style="width: 30px; height:30px"></td>
                                            <td>{{ $picture->date }}</td>
                                            <td>{{ $picture->title }}</td>

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
                                                                    action="{{ route('edit_picture', $picture->id) }}" enctype="multipart/form-data">
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
                                                                                name="file"
                                                                                value="{{ old('file', URL::to('storage/' . $picture->file)) }}"
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
                    @endif

                </div>
            </section>

           
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
                integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
                crossorigin="anonymous" />

        </div>
    </div>
@endsection
