@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>User</h1>
@stop

@section('content')
    @foreach ($user as $Key => $value)
        <x-adminlte-card :title="$Key" theme="dark" collapsible="collapsed">
            @php echo $value @endphp
        </x-adminlte-card>
    @endforeach
    <x-adminlte-card title="roles" theme="dark" collapsible="collapsed">
        @foreach ($roles->getRoleNames() as $value)
            <x-adminlte-card :title="$value" style="display:inline-block; margin:3px;" />
        @endforeach
    </x-adminlte-card>
@stop
