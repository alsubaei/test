@extends('adminlte::page')
@section('title', 'Posts')
@section('content_header')
<link src="{{ asset('css/style.css') }}" >
<h1>Posts</h1>
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

<x-adminlte-modal id="formModal" title="Create Post" size="lg" theme="dark" icon="fas fa-info" v-centered
static-backdrop>
        <div id="error" class="alert alert-danger">
            <ul id="error_list">
            </ul>
        </div>
        <x-adminlte-input name="title" id="title" label="Title" igroup-size="lg" disable-feedback required/>
        <x-adminlte-input name="image" id="image" label="image" igroup-size="lg" disable-feedback required/>
        <x-adminlte-input name="content" id="content" label="content" igroup-size="lg" disable-feedback required/>
        <x-adminlte-select value="{{ old('user') }}" name="user"
        label="User" igroup-size="lg">
        @foreach (App\Models\User::all() as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </x-adminlte-select><x-slot name="footerSlot">
            <x-adminlte-button theme="danger" label="Cancel" data-dismiss="modal" />
            <x-adminlte-button theme="success" label="Save" id="btn-status" data-dismiss="modal"/>
        </x-slot>
    </x-adminlte-modal>
    <x-adminlte-button class="btn-open-status mb-1 text-primary"  value="add" label="Create" data-toggle="modal"
        data-target="#modalCustom" theme="primary" icon="fas fa-plus" />
    <br>
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Title</th>
                <th>Image</th>
                <th>Content</th>
                <th>User</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="post-list">
            @foreach ($posts as $post)
                <tr id="post{{ $post->id }}">
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->image }}</td>
                    <td>{{ $post->content }}</td>
                    <td>{{ $post::find($post->id)->user->name  }}</td>
                    <td>
                        <button data-toggle="modal" post_id="{{ $post->id }}"
                            class="btn-open-status btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                        </button>
                        <button post_id={{ $post->id }}
                            class="btn btn-xs btn-default text-danger mx-1 shadow btn-delete-status" title="Delete">
                            <i class="fa fa-lg fa-fw fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{$posts->links()}}
@stop
@section('js')
    <script src="{{ asset('js/ajax.js') }}" type="text/javascript"></script>
@stop


