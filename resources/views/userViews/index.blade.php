@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Users</h1>
@stop

@section('content')
    {{-- modal --}}
    <x-adminlte-modal id="passModal" title="Edit User Password" size="lg" theme="dark" icon="fas fa-user-lock fa-fw"
        v-centered static-backdrop>
        <x-adminlte-input id="password" name="editUserPassword" type="password" label="New Password of the User"
            igroup-size="lg" disable-feedback />
        <x-slot name="footerSlot">
            <x-adminlte-button theme="danger" label="Cancel" data-dismiss="modal" />
            <x-adminlte-button theme="success" label="Save" data-dismiss="modal" id="btn-update" />
        </x-slot>
    </x-adminlte-modal>
    
    @if (Auth::user()->hasRole('Super Admin'))
        <a href="{{ route('users.create') }}">
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
                <th>Email</th>
                <th>Roles</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr id="user{{ $user->id }}">
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td style="display: none">{{ $user->password }}</td>
                    <td style="display: none">
                        @if ($user->roles->first())
                            {{ $user->roles->first()->name }}
                        @endif
                    </td>
                    <td>
                        @foreach ($user->getRoleNames() as $role)
                            {{ $role }}
                            <br>
                        @endforeach
                    </td>
                    <td>
                        {{-- Example button to open modal --}}
                        <button data-toggle="modal" user-id="{{ $user->id }}"
                            class="btn-pass btn btn-xs btn-default mx-1 shadow" title="Reset Password">
                            <i class="fa-lg fa-fw fas fa-key"></i>
                        </button>
                        @if (Auth::user()->hasRole('Super Admin'))
                            <a href="{{ route('users.edit', $user->id) }}">
                                <button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                    <i class="fa fa-lg fa-fw fa-pen"></i>
                                </button>
                            </a>
                        @endif
                        @if (Auth::user()->hasRole('Super Admin'))
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow"
                                    title="Delete">
                                    <i class="fa fa-lg fa-fw fa-trash"></i>
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('users.show', $user->id) }}">
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
@section('js')
    <script src="{{ asset('js/reset_password.js') }}" type="text/javascript"></script>
@stop
