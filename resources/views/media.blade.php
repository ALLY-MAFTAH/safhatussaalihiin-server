@extends('layouts.app')


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
            <section id="actions" class=" mb-2">
                <div class="container">
                    <div class="row"
                        style="margin:2px;padding-top:20px;background-color: rgb(247, 232, 206); border-radius: 5px">

                        <div class="col">
                            <button onclick="history.back()" class="btn btn-primary btn-outline">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                        </div>
                        <div class="col text-center">
                            <p style="font-size: 20px"><b> PICTURES AND VIDEOS</b></p>
                        </div>
                        <div class="col text-right">
                            <a href="#" class="btn btn-primary btn-outline" data-toggle="modal" data-target="#addYearModal">
                                <i class="fas fa-plus"></i> New Year
                            </a>
                        </div>

                    </div>
                </div>
            </section>

            <section id="today">
                <div class="container">
                    @if (Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}
                        </p>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h5> Years</h5>
                        </div>
                        <div class="row">
                            <table class="table table-responsive-lg">
                                <tbody>
                                    <div class="row ext-div px-3">
                                        @foreach ($years as $index => $year)
                                            <div class=""
                                                style="border-radius:5px;padding:15px;background-color:rgb(212, 193, 149); margin-left:25px; margin-top:15px">
                                                <div class="row">
                                                    <div class="col"><a href="{{ route('year', $year->id) }}"
                                                            class=" zoom fas fa-folder"
                                                            style="font-size: 65px; color:rgb(179, 124, 7); text-decoration:none">
                                                            <h5 style="margin:auto;color:rgb(3, 3, 119); text-align:center">
                                                                <b>{{ $year->name }}</b><br>
                                                            </h5>
                                                        </a></div>
                                                    <div class="col">
                                                        <div class="btn-group dropdown">
                                                            <button type="button" class="btn fas fa-ellipsis-v"
                                                                data-toggle="dropdown" aria-haspopup="false"
                                                                aria-expanded="false">
                                                            </button>
                                                            <div class="dropdown-menu" style="width: 10px !important;">
                                                                <div><a style="text-decoration: none" href="#"
                                                                        data-toggle="modal"
                                                                        data-target="#editYearModal-{{ $year->id }}">
                                                                        <div style=" margin:5px;"> Edit</div>
                                                                    </a></div>
                                                                <div><a style="text-decoration: none;"
                                                                        href="{{ route('delete_year', $year->id) }}"
                                                                        onclick="return confirm('This year will be deleted')">
                                                                        <div style=" margin:5px;color:red"> Delete</div>
                                                                    </a></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- EDIT YEAR MODAL -->
                                            <div class="modal fade" id="editYearModal-{{ $year->id }}">
                                                <div class="modal-dialog modal-md">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title">Edit Year</h5>
                                                            <button class="close" data-dismiss="modal">
                                                                <span>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST"
                                                                action="{{ route('edit_year', $year->id) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="form-group row">
                                                                    <label for="name"
                                                                        class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                                                    <div class="col-md-6">
                                                                        <input id="name" type="number"
                                                                            class="form-control @error('date') is-invalid @enderror"
                                                                            name="name"
                                                                            value="{{ old('name', $year->name) }}"
                                                                            required autocomplete="name" autofocus>
                                                                        @error('name')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row mb-0">
                                                                    <div class="col-md-6 offset-md-4">
                                                                        <button type="submit" class="btn btn-primary">
                                                                            Submit
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ADD YEAR MODAL -->
            <div class="modal fade" id="addYearModal">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Add Year</h5>
                            <button class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('add_year') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                    <div class="col-md-6">
                                        <input id="name" type="number"
                                            class="form-control @error('date') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required autocomplete="name" autofocus>
                                        @error('name')
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


            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
                integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
                crossorigin="anonymous" />
        </div>
    </div>
@endsection
