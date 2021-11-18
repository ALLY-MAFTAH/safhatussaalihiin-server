@extends('layouts.app')

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
            <section id="actions" class="py-4 mb-2">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="#" class="btn btn-primary btn-outline" data-toggle="modal"
                                data-target="#addStreamModal">
                                <i class="fas fa-plus"></i> Create Radio
                            </a>

                        </div>
                        <div class="col-md-6 text-right">
                            <div class="dropdown">
                                <a class="dropdown-toggle btn btn-primary btn-outline" data-toggle="dropdown" href="#">Radio
                                    Names </a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel"
                                    style="padding-left: 10px;padding-right: 40px;">
                                    @foreach ($radioNames as $radioName)
                                        <li>
                                            <div class="row">
                                                <div class="col-6">{{ $radioName->name }}</div>
                                                <div class="col-3">
                                                     <span style="padding-left: 50px;"><a
                                                        href="{{ route('delete_radio_name', $radioName->id) }}"
                                                        onclick="return confirm('This Radio Name Will Be Deleted')" class="">
                                                        <i style="color: red" class="fas fa-trash"></i>
                                                    </a></span>
                                                </div>
                                            </div>
                                            <hr>
                                        </li>

                                    @endforeach
                                    <div class="text-center">
                                        <a href="#" class="btn btn-primary btn-outline" data-toggle="modal"
                                            data-target="#addRadioNames">
                                            <i class="fas fa-plus"></i> Add
                                        </a>
                                    </div>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </section>

            <section id="streams">
                <div class="container">
                    @if (Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}
                        </p>
                    @endif
                    @if (count($streams) == 0)
                        <div style="text-align: center" class="py-3">
                            <b>
                                <h4>No Radio Links Yet</h4>
                            </b>
                        </div>
                    @else

                        <div class="card">
                            <div class="card-header">
                                <h5>Radios</h5>
                            </div>
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Type</th>
                                        <th>Cover</th>
                                        <th>Url</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Switch</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($streams as $index => $stream)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>

                                            <td>{{ $stream->type }}</td>
                                            <td class=""><img class="zoom-image"
                                                    src="{{ asset('storage/' . $stream->cover) }}" alt="Cover File"
                                                    style="width: 30px; height:30px"></td>
                                            <td>{{ $stream->url }}</td>
                                            <td>
                                                <a href="#" class="btn btn-outline-success" data-toggle="modal"
                                                    data-target="#playStreamModal-{{ $stream->id }}"><i
                                                        class="fas fa-play">
                                                        Play</i></a>
                                                <!-- PLAY AUDIO MODAL -->
                                                <div class="modal fade" id="playStreamModal-{{ $stream->id }}">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-success text-white">
                                                                <h5 class="modal-title">Live Stream</h5>
                                                                <button class="close" data-dismiss="modal">
                                                                    <span>&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="">
                                                                    <audio src="{{ $stream->url }}" controls
                                                                        style="width: 100%"></audio>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-outline-primary" data-toggle="modal"
                                                    data-target="#editStreamModal-{{ $stream->id }}">
                                                    <i class="fas fa-edit">
                                                        Edit</i>
                                                </a>

                                                <!-- EDIT STREAM MODAL -->
                                                <div class="modal fade" id="editStreamModal-{{ $stream->id }}">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-primary text-white">
                                                                <h5 class="modal-title">Edit Stream</h5>
                                                                <button class="close" data-dismiss="modal">
                                                                    <span>&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST"
                                                                    action="{{ route('edit_stream', $stream->id) }}"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="form-group row">
                                                                        <label for="type"
                                                                            class="col-md-4 col-form-label text-md-right">{{ __('Radio Name') }}</label>
                                                                        <div class="col-md-6">
                                                                            <select name="type" id="type" required
                                                                                class="form-control">
                                                                                @foreach ($radioNames as $radioName)
                                                                                    <option
                                                                                        value="{{ $radioName->name }}"
                                                                                        {{ $stream->type == $radioName->name ? 'selected' : '' }}>
                                                                                        {{ $radioName->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            @error('type')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="cover"
                                                                            class="col-md-4 col-form-label text-md-right">{{ __('Cover') }}</label>
                                                                        <div class="col-md-6">
                                                                            <input id="cover" type="file"
                                                                                class="form-control @error('cover') is-invalid @enderror"
                                                                                name="cover"
                                                                                value="{{ old('cover', $stream->cover) }}"
                                                                                autocomplete="cover" autofocus>
                                                                            @error('cover')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <label for="url"
                                                                            class="col-md-4 col-form-label text-md-right">{{ __('Url') }}</label>
                                                                        <div class="col-md-6">
                                                                            <input id="url" type="text"
                                                                                class="form-control @error('year') is-invalid @enderror"
                                                                                name="url"
                                                                                value="{{ old('url', $stream->url) }}"
                                                                                required autocomplete="url">
                                                                            @error('url')
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
                                                <a href="{{ route('delete_stream', $stream->id) }}"
                                                    onclick="return confirm('This stream will be deleted')"
                                                    class="btn btn-outline-danger">
                                                    <i class="fas fa-trash"> Delete</i>
                                                </a>
                                            </td>
                                            <td>
                                                <form id="status-{{$stream->id}}" method="POST"
                                                    action="{{ route('toggle_status', $stream->id) }}">
                                                    @csrf @method('PUT')
                                                    <div class="switch switch-primary d-inline m-r-10">
                                                        <input type="hidden" name="status" value="0">
                                                        <input type="checkbox" name="status"
                                                            id="status-switch-{{ $stream->id }}" class="status-switch"
                                                            @if ($stream->status) checked @endif value="1"
                                                            onclick="this.form.submit()" />
                                                        <label for="status-switch-{{ $stream->id }}" class="cr"></label>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </section>


            <!-- ADD STREAM MODAL -->
            <div class="modal fade" id="addStreamModal">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Create Radio</h5>
                            <button class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('add_stream') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label for="type"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Radio Name') }}</label>
                                    <div class="col-md-6">
                                        <select name="type" id="type" required class="form-control">
                                            <option value="">--Select--</option>
                                            @foreach ($radioNames as $radioName)
                                                <option value="{{ $radioName->name }}">{{ $radioName->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="cover"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Cover File') }}</label>
                                    <div class="col-md-6">
                                        <input id="cover" type="file"
                                            class="form-control @error('cover') is-invalid @enderror" name="cover"
                                            value="{{ old('cover') }}" required autocomplete="cover" autofocus>
                                        @error('cover')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="url"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Url') }}</label>
                                    <div class="col-md-6">
                                        <input id="url" type="text" class="form-control @error('year') is-invalid @enderror"
                                            name="url" value="{{ old('url') }}" required autocomplete="url">
                                        @error('url')
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
            <!-- ADD RADIO TYPE MODAL -->
            <div class="modal fade" id="addRadioNames">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Add Radio Name</h5>
                            <button class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('add_radio_name') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                    <div class="col-md-6">
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required autocomplete="name">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="description"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>
                                    <div class="col-md-6">
                                        <input id="description" type="text"
                                            class="form-control @error('description') is-invalid @enderror"
                                            name="description" value="{{ old('description') }}" required
                                            autocomplete="description">
                                        @error('description')
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
