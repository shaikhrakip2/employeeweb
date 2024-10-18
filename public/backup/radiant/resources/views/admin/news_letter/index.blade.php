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
                        <div class="card-body">
                            <table class="table table-bordered table-striped datatable">
                                <thead>
                                    <tr>
                                        <th>E-Mail</th>
                                        <th class="actionwidth">Inquiry On</th>
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
                ajax: "{{ url('admin/news-letter') }}",
                order: [
                    [1, 'desc']
                ],
                columns: [{
                        data: 'email'
                    },
                    {
                        data: 'created_at'
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
                            url: "news-letter/" + id,
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
