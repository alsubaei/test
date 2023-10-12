@extends('adminlte::page')
@section('title', 'Posts')
@section('content_header')
<link href="{{ asset('css/style.css') }}"  rel="stylesheet">
<h1>Posts</h1>
@stop

@section('plugins.BsCustomFileInput', true)
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
<x-adminlte-modal id="formModal" title="Add Your Post" size="lg" theme="dark" icon="fas fa-info" v-centered
        static-backdrop>
        <div id="error" class="alert alert-danger">
            <ul id="error_list">
            </ul>
        </div>
        <form id="form">
            <x-adminlte-input id="title" name="title" label="Title:" required />
            <div class="row">
                {{-- Placeholder, sm size and prepend icon --}}
                <x-adminlte-input-file name="image" label="Attachment:" id="attachment"
                fgroup-class="col-md-10" placeholder="Choose a file...">
                <x-slot name="prependSlot">
                        <div class="input-group-text bg-lightblue">
                            <i class="fas fa-upload"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-file>
                    <img id="img" name="attachment" src="" width="100" height="100">
            </div>     
            <x-adminlte-textarea name="content" placeholder="Insert description..." label='Content'/>
            <x-adminlte-select value="{{ old('user') }}" name="user" id="user" label="User"
            igroup-size="lg">
            @foreach (App\Models\User::all() as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </x-adminlte-select>
        </form>

        <x-slot name="footerSlot">
            <x-adminlte-button theme="danger" label="Cancel" data-dismiss="modal" class="text-danger" />
            <x-adminlte-button theme="success" label="Save" id="btn-post" class="text-success"/>
        </x-slot>
    </x-adminlte-modal>
    
    {{-- Example button to open modal --}}
    <x-adminlte-button class="btn-open-post mb-1 text-primary" value="add" label="Add Post" data-toggle="modal"
        data-target="#formModal" theme="primary" icon="fas fa-plus" />
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
                    <td><img src="{{ $post->image}}" alt="img" width="100" height="100"></td>
                    <td>{{ $post->content }}</td>
                    <td>{{ $post::find($post->id)->user->name  }}</td>
                    <td>
                        
                        <button data-toggle="modal" post_id="{{ $post->id }}"
                            data-target="#formModal" class="btn-open-post btn btn-xs btn-default text-primary mx-1 shadow" title="Edit"
                            value="edit">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                        </button>
                        <button post_id={{ $post->id }}
                            class="btn btn-xs btn-default text-danger mx-1 shadow btn-delete-post" title="Delete">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/ajax.js') }}" type="text/javascript"></script>
@stop


