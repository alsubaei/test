@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Roles</h1>
@stop

@section('content')
    @if (Auth::user()->hasRole('Super Admin'))
        <a href="{{ route('roles.create') }}">
            <x-adminlte-button label="Create" theme="primary" icon="fas fa-plus" />
        </a>
        <br>
        <br>
    @endif
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Permissions</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>{{ str_replace(['"', '[', ']'], [' ', '', ''], $role->permissions->pluck('name')) }}</td>
                    <td>
                        @if (Auth::user()->hasRole('Super Admin'))
                            <a href="{{ route('roles.edit', $role->id) }}">
                                <button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                    <i class="fa fa-lg fa-fw fa-pen"></i>
                                </button>
                            </a>
                        @endif
                        @if (Auth::user()->hasRole('Super Admin'))
                            <form class="form" action="{{ route('roles.destroy', $role->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow"
                                    title="Delete">
                                    <i class="fa fa-lg fa-fw fa-trash"></i>
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('roles.show', $role->id) }}">
                            <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details"><i
                                    class="fa fa-lg fa-fw fa-eye">
                                </i>
                            </button>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
