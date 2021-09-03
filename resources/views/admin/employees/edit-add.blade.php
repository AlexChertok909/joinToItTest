@extends('adminlte::page')

@section('title', 'Employee')

@section('content_header')
    <h1>{{$data['type']}} Employee</h1>
@stop

@section('content')
    <!-- form start -->
    <form id="form-edit-add"
          action="{{$data['type'] == 'Edit' ? route('employees.update', $data['employee']->id) : route('employees.store')}}"
          method="POST"
          enctype="multipart/form-data"
    >
    @if($data['type'] == 'Edit')
        {{ method_field("PUT") }}
    @endif
    <!-- CSRF TOKEN -->
        {{ csrf_field() }}

        <div class="card-body">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <div class="form-group">
                <label for="employee_first_name">First name</label>
                <input type="text" name="employee_first_name" class="form-control" placeholder="Enter employee first name"
                       value="{{isset($data['employee']->first_name) ? $data['employee']->first_name : '' }}">
            </div>
            <div class="form-group">
                <label for="employee_last_name">Last name</label>
                <input type="text" name="employee_last_name" class="form-control" placeholder="Enter employee last name"
                       value="{{isset($data['employee']->last_name) ? $data['employee']->last_name : '' }}">
            </div>

            <div class="form-group">
                <label>Company name</label>
                <select class="form-control" name="employee_company_id">
                    @foreach($data['companies'] as $company)
                        @if($data['type'] == 'Edit' && $company->id == $data['employee']->company_id)
                            <option selected value="{{$company->id}}">{{$company->name}}</option>
                        @else
                            <option value="{{$company->id}}">{{$company->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="cemployee_email">Email address</label>
                <input type="email" name="employee_email" class="form-control" id="employee_email"
                       placeholder="Enter employee  email"
                       value="{{isset($data['employee']->email) ? $data['employee']->email : '' }}">
            </div>
            <div class="form-group">
                <label for="employee_phone">Phone</label>
                <input type="text" name="employee_phone" class="form-control" placeholder="Enter employee phone"
                       value="{{isset($data['employee']->phone) ? $data['employee']->phone : '' }}">
            </div>



        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>


@stop

<!-- Toastr -->
@include('shared.toastr')

@section('css')

@stop

@section('js')
    <!-- jquery-validation -->
    <script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="/vendor/jquery-validation/additional-methods.min.js"></script>

    <script>

        $(function () {

            $('#form-edit-add').validate({
                rules: {
                    employee_first_name: {
                        required: true,
                        maxlength: 254
                    },
                    employee_last_name: {
                        required: true,
                        maxlength: 254
                    },
                    employee_company_id: {
                        required: true,
                    },
                    employee_email: {
                        email: true,
                        maxlength: 254
                    },
                    employee_phone: {
                        maxlength: 254
                    },

                },
                messages: {},
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });

    </script>
@stop


