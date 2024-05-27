@extends('layouts.app')
@section('content')
@section('style')
<!-- Table datatable css -->
<link href="admin/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endsection
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('login') }}">{{ env('APP_NAME') }}</a></li>
                                <li class="breadcrumb-item active">Email</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Email</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="header-title mb-4">List</h4>
                            </div>
                            <div class="col-6" align="right">
                                <a href="{{route('email-add')}}" title="Add"><button type="button" class="btn btn-primary waves-effect waves-light">Add</button></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">

                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Title</th>
                                            <th>Subject</th>
                                            <th>Mail</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- end row -->

                    </div>
                </div>
                <!-- end col -->
            </div>
        </div>
    </div>
@section('script')
    <!-- Datatable plugin js -->
    <script src="admin/libs/datatables/jquery.dataTables.min.js"></script>
    <script src="admin/libs/datatables/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            //$('#profileForm').parsley();

            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: "{{ route('ajax-list') }}",
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'subject',
                        name: 'subject'
                    },
                    {
                        data: 'mail',
                        name: 'mail'
                    },
                    {   data: 'Action',
                        name: 'Action',
                        orderable: false
                    },
                ],
                order: [
                    [0, 'desc']
                ]
            });
        });
    </script>
@endsection
@endsection
