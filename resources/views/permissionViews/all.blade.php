@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>permissions</h1>
@stop

@section('content')
    <p>display all permissions.</p>
    {{-- Setup data for datatables --}}
    {{--  --}}
    @php
    $heads = ['ID', 'Name'];
    $data = [];
    foreach ($permissions as $permission) {
        array_push($data, [$permission->id, $permission->name, '<nobr>']);
    }
    $config = ['data' => $data];
    @endphp

    {{-- Compressed with style options / fill data using the plugin config --}}
    <x-adminlte-datatable id="table2" :heads="$heads" head-theme="dark" :config="$config" striped hoverable bordered
        compressed />
@stop
