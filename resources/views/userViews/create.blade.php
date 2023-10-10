@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Create User</h1>
@stop
@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <x-adminlte-input name="name" type="text" label="Name" placeholder="Enter your name" />
        <x-adminlte-input name="email" type="email" label="Email" placeholder="mail@example.com" />
        <x-adminlte-input name="password" type="password" label="Password" placeholder="******************" />
        <x-adminlte-select id="role" name="roles[]" label="Roles: " fgroup-class="request">
            @foreach (Spatie\Permission\Models\Role::all() as $role)
                @if ($role->id == 1)
                    <option value=" {{ $role->id }}" selected>{{ $role->name }}</option>
                @else
                    <option value=" {{ $role->id }}">{{ $role->name }}</option>
                @endif
            @endforeach
        </x-adminlte-select>
        <br>
        <x-adminlte-button class="btn-lg" type="submit" label="Save" theme="success" icon="fas fa-lg fa-save" />
    </form>
@stop
