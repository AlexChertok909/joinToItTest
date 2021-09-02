@extends('adminlte::page')

@section('title', 'Company')

@section('content_header')
    <h1>Employee</h1>
@stop

@section('content')
    <form>
        <div class="form-group">
            <label>First name</label>
            <input type="text" class="form-control" placeholder="Enter ..." disabled="" value="{{isset($data['employee']->first_name) ? $data['employee']->first_name : '' }}">
        </div>
        <div class="form-group">
            <label>Last name</label>
            <input type="text" class="form-control" placeholder="Enter ..." disabled="" value="{{isset($data['employee']->last_name) ? $data['employee']->last_name : '' }}">
        </div>
        <div class="form-group">
            <label>Company name</label>
            <input type="text" class="form-control" placeholder="Enter ..." disabled="" value="{{isset($data['employee']->company_name) ? $data['employee']->company_name : '' }}">
        </div>
        <div class="form-group">
            <label>Email address</label>
            <input type="text" class="form-control" placeholder="Enter ..." disabled="" value="{{isset($data['employee']->email) ? $data['employee']->email : '' }}">
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input type="text" class="form-control" placeholder="Enter ..." disabled="" value="{{isset($data['employee']->phone) ? $data['employee']->phone : '' }}">
        </div>

    </form>
@stop
