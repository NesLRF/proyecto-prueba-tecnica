@extends('layouts.app')

@section('style')
    <style>
        .main-div {
            background: linear-gradient(#676d72 50%, #00326c 50%);
            position: relative;
            height: 90vh;
        }

        .margin-card {
            margin: 2rem;
        }

        .capaña-size {
            margin: 1rem;
        }

        .title-color {
            color: #015db1;
        }

        .title2-color {
            color: #51b9fe;
        }

        .card-height {
            max-height: 80%;
            height: 12rem;
        }

        .astra-zeneca {
            color: #ff8126;
        }

        .card-title {
            color: #174579;
        }
    </style>
@endsection

@section('content')
    <div class="main-div">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body margin-card">
                        <h1 class="card-title text-center mb-5 title-color">Campañas activas de vacunación contra Covid-19
                            (ZMG)</h1>
                        <div id="carouselExample" class="carousel slide mt-2 mb-3">
                            <div class="carousel-inner">
                                <div class="carousel-item active justify-content-center">
                                    <div class="row capaña-size">
                                        <div class="col-md-6">
                                            <div class="shadow p-3 mb-5 bg-body rounded card-height">
                                                <img src="{{ asset('img/personas.png') }}" class="" alt="personas">
                                                <h6 class="card-title">Personas de 18 y más</h6>
                                                <strong class=" blue-color">
                                                    <i class="fa-solid fa-circle-info"></i> Primera Dosis
                                                </strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="shadow p-3 mb-5 bg-body rounded card-height">
                                                <img src="{{ asset('img/personas.png') }}" class="" alt="personas">
                                                <h6 class="card-title">Personas de 18 y más</h6>
                                                <strong class=" blue-color">
                                                    <i class="fa-solid fa-circle-info"></i> Segunda Dosis
                                                </strong>
                                                <p class="astra-zeneca">
                                                    <strong>ATRA ZENECA</strong>
                                                    <br>
                                                    Primera dosis aplicada antes del 15 de Agosto
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="margin-card">
                            <h1 class="title2-color">
                                Comenzar ahora
                            </h1>
                            @if (session('status'))
                                <div class="alert alert-{{ session('notify') }}" role="alert">
                                    {{ session('message') }}
                                </div>
                            @endif
                            <h5>
                                Ingresa tu CURP para agendar una cita o <br> para 
                                <u class="title2-color">cancelar una cita</u> 
                                ya registrada.
                            </h5>
                            <br>
                            <form action="{{ route('appointment_get') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3 col-12">
                                            <input class="form-control" id="user_curp" name="curp" minlength="18" maxlength="18" required placeholder="Introduce tu CURP">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary">Continuar</button>
                                    </div>
                                </div>
                            </form>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <p>
                                Si no conoces tu CURP <a href="https://www.gob.mx/curp" target="_blank"> consultala aquí</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
