@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Create Role</h1>
@stop
@section('plugins.Select2', true)
@section('content')
    @php
    $config = [
        'placeholder' => 'Select multiple options...',
        'allowClear' => true,
    ];

    $options = [];
    foreach (Spatie\Permission\Models\permission::all() as $permission) {
        $options[$permission->id] = $permission->name;
    }

    @endphp

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        {{-- With label, invalid feedback disabled and form group class --}}
        <x-adminlte-input name="createRoleName" label="Name of Role" igroup-size="lg" disable-feedback />

        {{-- With multiple slots, and plugin config parameter --}}

        <x-adminlte-select2 id="sel2Category" name="selectedPermissions[]" label="Permissions" igroup-size="lg"
            :config="$config" multiple>
            <x-adminlte-options :options="$options" />
        </x-adminlte-select2>

        <x-adminlte-button class="btn-lg" type="submit" label="Save" theme="success" icon="fas fa-lg fa-save" />
    </form>
@stop
