@extends('adminlte::page')

@section('title', 'Company')

@section('content_header')
    <h1>Company</h1>
@stop

@section('content')
    <form>
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" placeholder="Enter ..." disabled="" value="{{isset($data['company']->name) ? $data['company']->name : '' }}">
        </div>
        <div class="form-group">
            <label>Email address</label>
            <input type="text" class="form-control" placeholder="Enter ..." disabled="" value="{{isset($data['company']->email) ? $data['company']->email : '' }}">
        </div>
        <div class="form-group">
            <label>Website</label>
            <input type="text" class="form-control" placeholder="Enter ..." disabled="" value="{{isset($data['company']->website) ? $data['company']->website : '' }}">
        </div>
        <div class="form-group">
            <label for="company_logo">Logo</label>
            @php
                if(isset($data['company']->logo))
                    $file = json_decode($data['company']->logo)
            @endphp
            @if(!empty($file) && !empty($file[0]))
                <div>
                    <img src="{{url($file[0]->download_link) ?: '' }}"/>
                </div>
                <div data-field-name="logo">
                    <a class="fileType" target="_blank"
                       href="{{url($file[0]->download_link) ?: '' }}"
                       data-file-name="{{ $file[0]->original_name }}" data-id="{{ $data['company']->id }}">
                        {{ $file[0]->original_name ?: '' }}
                    </a>
                </div>
            @endif
        </div>
    </form>
@stop
