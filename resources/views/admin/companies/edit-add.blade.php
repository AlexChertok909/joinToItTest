@extends('adminlte::page')

@section('title', 'Company')

@section('content_header')
    <h1>{{$data['type']}} Company</h1>
@stop

@section('content')
    <!-- form start -->
    <form id="form-edit-add"
          action="{{$data['type'] == 'Edit' ? route('companies.update', $data['company']->id) : route('companies.store')}}"
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
                <label for="company_name">Name</label>
                <input type="text" name="company_name" class="form-control" placeholder="Enter company name"
                       value="{{isset($data['company']->name) ? $data['company']->name : '' }}">
            </div>
            <div class="form-group">
                <label for="company_email">Email address</label>
                <input type="email" name="company_email" class="form-control" id="company_email"
                       placeholder="Enter company  email"
                       value="{{isset($data['company']->email) ? $data['company']->email : '' }}">
            </div>
            <div class="form-group">
                <label for="company_website">Website</label>
                <input type="text" name="company_website" class="form-control" placeholder="Enter company website"
                       value="{{isset($data['company']->website) ? $data['company']->website : '' }}">
            </div>
            <div class="form-group">
                <label for="company_logo">Logo</label>
                @php
                    if(isset($data['company']->logo))
                        $file = json_decode($data['company']->logo)
                @endphp
                @if(!empty($file) && !empty($file[0]))
                    <div>
                        <img src="{{url('storage/' . $file[0]->download_link) ?: '' }}"/>
                    </div>
                    <div data-field-name="logo">
                        <a class="fileType" target="_blank"
                        href="{{url('storage/' . $file[0]->download_link) ?: '' }}"
                        data-file-name="{{ $file[0]->original_name }}" data-id="{{ $data['company']->id }}">
                        {{ $file[0]->original_name ?: '' }}
                        </a>
                    </div>
                @endif

                <input type="file" name="company_logo" class="form-control">
            </div>


        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>


@stop


@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@stop

@section('js')
    <!-- jquery-validation -->
    <script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="/vendor/jquery-validation/additional-methods.min.js"></script>
    <!-- Toastr -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>

        $(function () {

            $('#form-edit-add').validate({
                rules: {
                    company_name: {
                        required: true,
                        maxlength: 254
                    },
                    company_email: {
                        email: true,
                        maxlength: 254
                    },
                    company_website: {
                        maxlength: 254
                    },
                    company_logo: {
                        extension: "jpg|png"
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

        <!-- Toastr -->
        @if(Session::has('message'))
            toastr.options =
            {
                "closeButton": true,
                "progressBar": true
            }
        toastr.success("{{ session('message') }}");
        @endif

        @if(Session::has('error'))
            toastr.options =
            {
                "closeButton": true,
                "progressBar": true
            }
        toastr.error("{{ session('error') }}");
        @endif

        @if(Session::has('info'))
            toastr.options =
            {
                "closeButton": true,
                "progressBar": true
            }
        toastr.info("{{ session('info') }}");
        @endif

        @if(Session::has('warning'))
            toastr.options =
            {
                "closeButton": true,
                "progressBar": true
            }
        toastr.warning("{{ session('warning') }}");
        @endif

    </script>
@stop


