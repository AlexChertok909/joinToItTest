@extends('adminlte::page')

@section('title', 'Companies')

@section('content_header')
    <h1>Companies</h1>
@stop

@section('content')

    <a href="{{ route('companies.create') }}" class="btn btn-success btn-add-new">
       <span>Add Company</span>
    </a>

    @php
        $heads = [
            'ID',
            'Name',
            'Email',
            'Website',
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
        ];

        $config = [
            'data' => $data,
            'order' => [[1, 'asc']],
            'columns' => [null, null, null, null, ['orderable' => false]],
        ];

    @endphp

    {{-- Minimal example / fill data using the component slot --}}
    <x-adminlte-datatable id="table1" :heads="$heads">
        @foreach($config['data'] as $row)
            <tr>
                @foreach($row as $cell)
                    <td>{!! $cell !!}</td>
                @endforeach
                @php
                    $btnEdit = '<a href="'. url('admin/companies/'.$row['id'].'/edit') .
                        '" title="Edit" class="btn btn-xs btn-default text-primary mx-1 shadow">
                        <i class="fa fa-lg fa-fw fa-pen"></i></a>';

                    $btnDelete = '<a href="javascript:;" title="Delete" id="'.$row['id'].'"
                        class="btn btn-xs btn-default text-danger mx-1 shadow delete">
                        <i class="fa fa-lg fa-fw fa-trash"></i></a>';

                    $btnDetails = '<a href="'. url('admin/companies/'.$row['id']) .
                        '" title="Details" class="btn btn-xs btn-default text-info mx-1 shadow">
                        <i class="fa fa-lg fa-fw fa-eye"></i></a>';
                @endphp
                <td><nobr> {!! $btnEdit.$btnDelete.$btnDetails !!} </nobr></td>
            </tr>
        @endforeach
    </x-adminlte-datatable>


    {{-- Single delete modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="voyager-trash"></i> Are you sure you want to delete this company?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm" value="Yes, Delete it">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')

    <!-- Toastr -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>

        $('td').on('click', '.delete', function (e) {

            $('#delete_form')[0].action = '{{ route('companies.destroy', '__id') }}'.replace('__id', $(this).attr('id'));
            $('#delete_modal').modal('show');
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
