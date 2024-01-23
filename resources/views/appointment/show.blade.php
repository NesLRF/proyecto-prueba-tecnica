@extends('layouts.app')

@section('style')
    <style>
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

        .check {
            color: #03b060;
        }

        .appointment-title-size {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .appointment-title-color {
            color: #0460b2;
        }

        .card-border {
            border-radius: 1.5rem;
        }

        .card-delete {
            background-color: #cc0008 !important;
            color: white;
        }

        .card-time {
            background-color: #37aefc !important;
            color: white;
            margin: 1rem;
        }

        .curp-span {
            color: #959595;
        }

        .card-title {
            color: #144278;
        }

        .astra-zeneca {
            color: #ff8126;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        {{-- @dd($data) --}}

        @if ($data['active_appointment'])
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="mt-5 appointment-title-color appointment-title-size">
                                @if ($data['active_appointment'])
                                    <h2><i class="fa-solid fa-circle-check check"></i> <strong> Registro concluido</strong>
                                    </h2>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mt-5">
                                @if ($data['active_appointment'])
                                    <div class="shadow bg-body card-border card-delete text-center">
                                        <a href="#" style="justify-content: center" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            <h5 class="btn" style="color: white"><i class="fa-regular fa-circle-xmark"></i> Quiero cancelar mi cita</h5>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="shadow p-3 mb-5 bg-body card-border">
                        <div class="mt-4">
                            <div class="row">
                                <div class="col-md-9">
                                    <h6 class=""><span class="curp-span">CURP:</span> {{ $data['user']->curp }}</h6>
                                    <h6 style="margin-left: 3rem">
                                        {{ $data['user']->name }}
                                    </h6>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img src="img/personas.png" class="" alt="personas">
                                        </div>
                                        <div class="col-md-7">
                                            <h6 class="card-title">Personas de 18 y más</h6>
                                            <strong class="blue-color">
                                                <i class="fa-solid fa-circle-info"></i> Segunda Dosis
                                            </strong>
                                            <strong class="astra-zeneca">ATRA ZENECA</strong>
                                            <h6>Zapopan</h6>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="shadow p-3 mb-5 bg-body card-border">
                        <div class="mt-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <h6>
                                        <span class="curp-span">Módulo:</span>
                                        <br>
                                        Auditorio Benito Juarez.
                                    </h6>
                                </div>
                                <div class="col-md-4">
                                    <h6>
                                        <span class="curp-span">Dirección:</span>
                                        <br>
                                        AV. Mariano Barcenas s/n
                                        <br>
                                        Col. Auditorio, 45910
                                        <br>
                                        Zapopan, Jalisco
                                    </h6>
                                </div>
                                <div class="col-md-4">
                                    <h6>
                                        <span class="curp-span">Fecha y hora:</span>
                                    </h6>
                                    <div class="shadow bg-body card-border card-time text-center">
                                        <h5 class="">{{ $data['most_recent_appointment_day'] }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <h5>
                        Ya tienes asegurado el lugar para tu vacunación, ahora, para asegurar tu dosis es muy importante que
                        también te registres en la plataforma federal.
                        Ingresa al <a href="https://mivacuna.salud.gob.mx/">https://mivacuna.salud.gob.mx/</a> para obtener
                        tu expediente de vacunación.
                        <br>
                        Recomendaciones para el día de tu vacunación:
                    </h5>
                </div>
            </div>
        @elseif(!$data['active_appointment'] && count($data) <= 3)
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="mt-5 appointment-title-color appointment-title-size">
                        <h2><i class="fa-solid fa-circle-info"></i> <strong> No se detectaron citas</strong></h2>
                    </div>
                    <a href="{{ route('appointment_register', [$data['user']->curp]) }}" style="justify-content: center">
                        <button class="btn btn-primary">Registrtar cita</button>
                    </a>
                </div>
            </div>
        @endif
        @if (isset($data['appointment_day_history']))
            {{-- Appointments history --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="mt-5 appointment-title-color appointment-title-size">
                                @if (isset($data['appointment_day_history']))
                                    <h2><i class="fa-solid fa-clock-rotate-left"></i> <strong> Historial de citas</strong>
                                    </h2>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    @foreach ($data['appointment_day_history'] as $appointment)
                        <div class="shadow p-3 mb-5 bg-body card-border">
                            <div class="mt-5">
                                <div class="row">
                                    <div class="col-md-9">
                                        <h6 class=""><span class="curp-span">CURP:</span> {{ $data['user']->curp }}
                                        </h6>
                                        <h6 style="margin-left: 3rem">
                                            {{ $data['user']->name }}
                                        </h6>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <img src="img/personas.png" class="" alt="personas">
                                            </div>
                                            <div class="col-md-7">
                                                <h6 class="card-title">Personas de 18 y más</h6>
                                                <strong class="blue-color">
                                                    <i class="fa-solid fa-circle-info"></i> Segunda Dosis
                                                </strong>
                                                <strong class="astra-zeneca">ATRA ZENECA</strong>
                                                <h6>Zapopan</h6>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <h6>
                                            <span class="curp-span">Módulo:</span>
                                            <br>
                                            Auditorio Benito Juarez.
                                        </h6>
                                    </div>
                                    <div class="col-md-4">
                                        <h6>
                                            <span class="curp-span">Dirección:</span>
                                            <br>
                                            AV. Mariano Barcenas s/n
                                            <br>
                                            Col. Auditorio, 45910
                                            <br>
                                            Zapopan, Jalisco
                                        </h6>
                                    </div>
                                    <div class="col-md-4">
                                        <h6>
                                            <span class="curp-span">Fecha y hora:</span>
                                        </h6>
                                        <div class="shadow bg-body card-border card-time text-center">
                                            <h5 class="">{{ $appointment }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Cancelar cita</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('appointment_delete') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <input class="form-control" hidden id="user_curp" name="curp" minlength="18" maxlength="18" required value="{{$data['user']->curp}}">
                            </div>
                            <h3>
                                Esta acción es irreversible, ¿Desea continuar?
                            </h3>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-danger">Continuar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
