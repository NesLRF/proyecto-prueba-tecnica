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
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="card m-3">
            <div class="card-header">
                Registrar cita
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-{{ session('notify') }}" role="alert">
                        {{ session('message') }}
                    </div>
                @endif
                <form action="{{ route('appointment_create') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input class="form-control" hidden id="user_curp" name="curp" minlength="18" maxlength="18" required value="{{$get_user->curp}}">
                    </div>
                    <div class="mb-3">
                        <input class="form-control" id="user_name" name="name" maxlength="50" required placeholder="Ingresa tu Nombre" @if($get_user->name) hidden value="{{$get_user->name}}"@endif>
                    </div>
                    <div class="mb-3">
                        <input class="form-control" type="email" id="user_email" name="email" required placeholder="Ingresa tu Email" @if($get_user->email) hidden value="{{$get_user->email}}"@endif>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Fecha</label>
                                <input type="date" name="date" class="form-control" required aria-describedby="emailHelp" placeholder="Ingresa la Fecha">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Hora</label>
                                <input type="time" name="hour" class="form-control" required aria-describedby="emailHelp" placeholder="Ingresa la Hora">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar</button>
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
            </div>
        </div>
    </div>
@endsection
