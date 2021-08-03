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
                                data-target="#addVideoModal">
                                <i class="fas fa-plus"></i> Add Video
                            </a>
                        </div>
                        <div class="col-2">
                            <form action="{{ route('videos') }}" method="POST" id="filter-form">
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

            <section id="videos">
                <div class="container">
                    @if (Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}
                        </p>
                    @endif
                    @if (count($videos) == 0)
                        <div style="text-align: center" class="py-3">
                            <b>
                                <h4>No Videos Yet</h4>
                            </b>
                        </div>
                    @else

                        <div class="card">
                            <div class="card-header">
                                <h5>VIDEOS</h5>
                            </div>
                            

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
