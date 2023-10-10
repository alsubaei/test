@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Roles</h1>
@stop

@section('content')
    @foreach ($role as $Key => $value)
        <x-adminlte-card :title="$Key" theme="dark" collapsible="collapsed">
            @php echo $value @endphp
        </x-adminlte-card>
    @endforeach
    <x-adminlte-card title="permissions" theme="dark" collapsible="collapsed">
        @foreach ($permission->permissions->pluck('name') as $key => $value)
            <x-adminlte-card :title="$value" style="display:inline-block; margin:3px;" />
        @endforeach
    </x-adminlte-card>
@stop
