@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Roles</h1>
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

    $selected = [];
    foreach ($role->permissions->pluck('id') as $permission) {
        array_push($selected, $permission);
    }

    @endphp
    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @method('PUT')
        @csrf
        <x-adminlte-input name="editRoleName" label="Name of Role" :value="$role->name" igroup-size="lg" disable-feedback />
        <x-adminlte-select2 id="sel2Category" name="selectedPermissions[]" label="Permissions" igroup-size="lg"
            :config="$config" multiple>
            <x-adminlte-options :options="$options" :selected="$selected" />
        </x-adminlte-select2>

        <x-adminlte-button class="btn-lg" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save" />
    </form>
@stop
