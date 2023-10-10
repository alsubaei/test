@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Edit the User</h1>
@stop
@section('content')
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @method('POST')
        @csrf
        <x-adminlte-input type="text" name="editUserName" label="Name of User" :value="$user->name" igroup-size="lg"
            disable-feedback />
        <x-adminlte-input type="email" name="editUserEmail" label="Email of User" :value="$user->email" igroup-size="lg"
            disable-feedback />
        <x-adminlte-input name="editUserPassword" type="hidden" label="Password of User" :value="$user->password" igroup-size="lg"
            disable-feedback />
        <x-adminlte-select id="roles" name="selectedRoles[]" label="Roles: " fgroup-class="request">
            @foreach (Spatie\Permission\Models\Role::all() as $role)
            
                @if ($user->roles->first() && $role->id == $user->roles->first()->id)
                    <option id="flexCheckDefault{{ $role->id }}" value=" {{ $role->id }}" selected>
                        {{ $role->name }}</option>
                @else
                    <option id="flexCheckDefault{{ $role->id }}"value=" {{ $role->id }}">{{ $role->name }}
                    </option>
                @endif
            @endforeach
        </x-adminlte-select>
        <br>
        <x-adminlte-button class="btn-lg" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save" />
    </form>

@stop
