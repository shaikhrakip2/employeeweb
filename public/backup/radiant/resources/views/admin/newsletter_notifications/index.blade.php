@extends('admin.layouts.main')
@section('header_scripts')
    <link href="{{ CSS }}ajax-datatables.css" rel="stylesheet">
@stop
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-end">
                            <div class="card-title pull-right">
                                <a href="{{url('admin/newsletter-notifications/create')}}" class="btn bg-success"><i class="fa fa-plus"></i> Add Notification</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped datatable">
                                <thead>
                                    <tr>
                                        <th>Subject</th>
                                        <th class="actionwidth">Date</th>
                                        <th class="actionwidth">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th class="non_searchable"></th>
                                    </tr>
                                </tfoot>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal view -->
    <div class="modal fade" id="inquiryModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title mb-0 fw-bold">Notification Details</h4>
                </div>
                <div class="modal-body" id="inquiryContent"></div>
            </div>
        </div>
    </div>

     <!--Add Modal -->

@endsection

@section('footer_scripts')
    <script type="text/javascript">
        var tableObj;
        $(document).ready(function() {
            tableObj = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                cache: true,
                bLengthChange: false,
                type: "GET",
                ajax: "{{ url('admin/newsletter-notifications') }}",
                order: [
                    [1, 'desc']
                ],
                columns: [{
                        data: 'subject'
                    },
                    {
                        data: 'created_at',
                    },
                    {
                        data: 'action',
                        'searchable': false,
                        'orderable': false
                    },
                ],
                initComplete: function() {
                    this.api().columns().every(function() {
                        var column = this;
                        var input = document.createElement("input");
                        $(input).addClass('form-control form-control-sm');
                        $(input).appendTo($(column.footer()).empty()).on('change', function() {
                            column.search($(this).val(), false, false, true).draw();
                        });
                    });
                }
            });
        });

        function callModal(id) {
            $.ajax({
                method: "GET",
                url: "{{ url('admin/newsletter-notifications') }}/" + id,
                success: (result) => {
                    $('#inquiryContent').html(result);
                    $('#inquiryModal').modal('show');
                }
            })
        }

        $('body').on('click', '.delete_record', function() {
            var id = $(this).attr('data-id');
            if (id != null) {
                Swal.fire({
                    title: "Are you sure ?",
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "Yes, Delete it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "DELETE",
                            url: "newsletter-notifications/" + id,
                            data: {
                                '_token': "{{ csrf_token() }}"
                            },
                            success: (result) => {
                                if (result != 0) {
                                    Swal.fire('Deleted!', 'Data has been deleted successfully',
                                        'success');
                                    tableObj.ajax.reload(null, false);
                                } else {
                                    Swal.fire('Error!', 'Failed to delete data', 'error');
                                }
                            }
                        })
                    }
                })
            }
        })
    </script>
@endsection
