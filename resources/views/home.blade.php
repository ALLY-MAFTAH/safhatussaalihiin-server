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

            <div class="text-center">
                <h4><b>WELCOME</b> </h4>
            </div>

            <div class="row">
                <div class="col-md-9">

                    <!-- ACTIONS -->
                    <section id="actions" class=" mb-2">
                        <div class="container">
                            <div class="row"
                                style="margin:2px;padding-top:20px;background-color: rgb(247, 232, 206); border-radius: 5px">


                                <div class="col-md-9 text-left">
                                    <p style="font-size: 20px; color:rgb(2, 2, 116)"><b> PICTURES AND VIDEOS</b></p>
                                </div>
                                <div class="col-md-3 text-right">
                                    <form action="{{ route('home') }}" method="POST" id="filter-form">
                                        @csrf
                                        <input id="date" type="date"
                                            class="form-control @error('date') is-invalid @enderror" name="date"
                                            value="{{ $date }}" required>
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


                    <section id="today">
                        <div class="container">
                            @if (Session::has('message'))
                                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">
                                    {{ Session::get('message') }}
                                </p>
                            @endif
                            <div class="card">
                                @if ($date == Carbon\Carbon::now('GMT+3')->toDateString())
                                    <div class="card-header">
                                        <h5>Today's Posts</h5>
                                    </div>
                                @else
                                    <div class="card-header">
                                        <h5> Posts of {{ $date }}</h5>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-8">
                                        <table class="table">
                                            <div class="theader" style="font-size: 18px">
                                                <b>PICTURES</b>
                                            </div>
                                            <tbody>
                                                <div class="row ext-div px-3">
                                                    @foreach ($pictures as $index => $picture)

                                                        <div class="col-6 " style="padding: 2px;">
                                                            <div class="int-div">
                                                                <img src=" {{ asset('storage/' . $picture->file) }}"
                                                                    alt="Picture" style="width: 100%;padding:5px">
                                                                <div class="row" style="padding: 5px">
                                                                    <div class="col-md-6">
                                                                        <h6> <span
                                                                                style="color: rgb(16, 22, 105);font-weight:bolder">{{ $picture->title }}</span>
                                                                        </h6>
                                                                    </div>
                                                                    <div class="col-md-6"
                                                                        style="text-align-last: right">
                                                                        <a href="{{ asset('storage/' . $picture->file) }}"
                                                                            download class="btn btn-outline-primary">
                                                                            <i
                                                                                class="fas fa-download">{{ __(' Download') }}</i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    @endforeach
                                                </div>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-4">
                                        <table class="table">
                                            <div class="theader" style="font-size: 18px">
                                                <b>VIDEO</b>
                                            </div>
                                            <tbody>
                                                <div class="row ext-div px-2">

                                                    @foreach ($videos as $index => $video)

                                                        <div class="col-12 " style="padding: 2px;">
                                                            <div class="int-div">

                                                                <video src="{{ asset('storage/' . $video->file) }}"
                                                                    controls style="width: 100%;padding:5px"></video>
                                                                <div class="row" style="padding: 5px">
                                                                    <div class="col-md-6">
                                                                        <h6> <span
                                                                                style="color: rgb(16, 22, 105);font-weight:bolder">{{ $video->title }}</span>
                                                                        </h6>
                                                                    </div>
                                                                    <div class="col-md-6"
                                                                        style="text-align-last: right">
                                                                        <a href="{{ asset('storage/' . $video->file) }}"
                                                                            download class="btn btn-outline-primary">
                                                                            <i
                                                                                class="fas fa-download">{{ __(' Download') }}</i>
                                                                        </a>
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
                        </div>

                    </section>
                </div>
                <div class="col-md-3">
                    <section id="actions" class=" mb-2">
                        <div class="">
                            <div class="row"
                                style="margin:0px;padding-top:20px;background-color: rgb(247, 232, 206); border-radius: 5px">
                                <div class="col text-center">
                                    <p style="font-size: 20px; color:rgb(2, 2, 116)"><b> RADIOS</b></p>
                                </div>

                            </div>
                        </div>
                    </section>


                    <section id="radios">
                        <div class="">

                            <div class="card">
                                <div class="card-header">
                                    <h5>Available Radios</h5>
                                </div>


                                <div class="row container">
                                    <table class="table">
                                        @if (count($streams) == 0)
                                            <div class="row"
                                                style="font-size:18px; padding-top:50%;padding-bottom:50%; ">
                                                <div class="col-1"></div>
                                                <div class="col-10"><i class="fas fa-exclamation-triangle"></i> No
                                                    Radio
                                                    Links Yet</div>
                                                <div class="col-1"></div>
                                            </div>
                                        @else
                                            <div style="padding: 15px">
                                                <div class="text-left">
                                                    @foreach ($streams as $index => $stream)
                                                        <div><b style="font-size: 16px">
                                                            @if ($stream->status==0)

                                                            <span class="px-1"
                                                            style="border-radius:5px;background:red;color: white;">
                                                            OFF</span>
                                                            @endif
                                                                    {{ ' ' . $index + 1 . '. ' . $stream->type }}</b>
                                                        </div>
                                                        <div class="text-center"> <audio src="{{ $stream->url }}"
                                                                controls style="width: 250px;"></audio>
                                                        </div>
                                                        <hr>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                    </table>
                                </div>

                            </div>
                        </div>

                    </section>
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
