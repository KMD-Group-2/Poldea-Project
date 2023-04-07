<x-app-layout>
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-6 align-self-center">
                <div class="d-flex justify-content-start align-items-center">
                    <nav class="breadcrumb">
                        <span class="breadcrumb-item">{{ Auth::user()->roles()->first()->name ?? '' }}</span>
                        <span class="breadcrumb-item active">Academic Year {{ Auth::user()->roles()->first()->name=="Admin"?"":"Report" }}</span>
                    </nav>
                </div>
            </div>
            @hasrole('Admin')
            <div class="col-md-6 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                <button type="button" class="btn btn-info d-lg-block m-l-15" data-toggle="modal"
                        data-target="#AddNewAcademicYearModal"><i class="fa fa-plus-circle"></i> Add New Academic
                        Year</button>
                </div>
            </div>
            @endhasrole
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row" style="padding-bottom:30px;">
                            <div class="col-md-5 align-self-center">

                            </div>
                            <div class="col-md-7 align-self-center text-right">
                                <div
                                    class="d-flex w-100 justify-content-center justify-content-md-end align-items-center">
                                    <div
                                        class="d-flex justify-content-center justify-content-md-end align-items-center">
                                        <span>Showing
                                            {{ ($years->currentPage() - 1) * $years->perPage() + ($years->total() ? 1 : 0) }}
                                            to
                                            {{ ($years->currentPage() - 1) * $years->perPage() + count($years) }} of
                                            {{ $years->total() }} results</span>

                                            {{ $years->links('vendor.pagination.custom') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped selected-table">
                                <thead class="text-center">
                                    <tr>
                                        <th>Academic Year</th>
                                        <th>Total Categories</th>
                                        <th>Total Participants</th>
                                        <th>Total Ideas</th>
                                        <th>Status</th>
                                        <th>Closure Date</th>
                                        <th>Final Closure Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @if (count($years) > 0)
                                        @foreach ($years as $year)
                                            <tr data-id="{{ $year->id }}" data-name="{{ $year->academic_year }}"
                                                data-closure-date="{{ $year->closure_date }}"
                                                data-final-closure-date="{{ $year->final_closure_date }}">
                                                <td>{{ $year->academic_year }}</td>
                                                <td>{{ $year->total_category ?? 0 }}</td>
                                                <td>{{ $year->total_participants ?? 0 }}</td>
                                                <td>{{ $year->total_post ?? 0 }}</td>
                                                <td>
                                                    <span
                                                        class="label {{ now()->diffInDays(Carbon\Carbon::parse($year->final_closure_date), false) >= 0 ? 'label-success' : 'label-danger' }}">
                                                        {{ now()->diffInDays(Carbon\Carbon::parse($year->final_closure_date), false) >= 0 ? 'Open' : 'Expired' }}
                                                    </span>
                                                </td>
                                                <td>{{ Carbon\Carbon::parse($year->closure_date)->format('d M Y') }}
                                                </td>
                                                <td>{{ Carbon\Carbon::parse($year->final_closure_date)->format('d M Y') }}
                                                </td>
                                                <td>
                                                    <div class="d-flex no-block align-items-center">
                                                        @hasrole('Admin')
                                                            <button type="button" class="btn right-side-toggle"
                                                                title="Edit">
                                                                <svg width="19" height="19" viewBox="0 0 19 19"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M16.3 6.925L12.05 2.725L13.45 1.325C13.8333 0.941667 14.3043 0.75 14.863 0.75C15.421 0.75 15.8917 0.941667 16.275 1.325L17.675 2.725C18.0583 3.10833 18.2583 3.571 18.275 4.113C18.2917 4.65433 18.1083 5.11667 17.725 5.5L16.3 6.925ZM14.85 8.4L4.25 19H0V14.75L10.6 4.15L14.85 8.4Z"
                                                                        fill="#B6B6BB" />
                                                                </svg>
                                                            </button>
                                                        @endhasrole
                                                        @hasrole('QA Manager')
                                                            <form action="{{ route('idea_report.export-file') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="academic_year_id"
                                                                    value="{{ $year->id }}">
                                                                <button @if (now()->diffInDays(Carbon\Carbon::parse($year->final_closure_date), false) < 0)
                                                                type="submit"
                                                                @else
                                                                type="button" style="cursor:not-allowed;opacity:0.6;" data-toggle="tooltip" data-placement="top" title="You will be able to download only after final closure date of this academic year."
                                                                @endif
                                                                    class="btn btn-sm text-primary pl-2">
                                                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAADT0lEQVR4nMWV+0uTYRTH+60/I4j+kQhCSigsCAM1TVIRHaXppnmj1ATnnHltezfvm5vTTae9XjOt8JJ5rZmppehMcyrOa9N943lkLyOvezftwBfOzvO85/M855zxXLjwv624pllQw3ZluaKKunZGqWP1boHZzk9NcNEmZ8yYnJ5Hsa5p+NzBy6tWWFas/OGsG2BivOGsm2DecNYJPGYZR9+vfqq1nf3Ec1YzF3PoXzAvOOsEJpCJlSmqTdsWjS1vLXMxhw4DuwxnncDklgREZNuz0Rg5gCPmEAG/7R5Ez5DpgPQtH+zpcpXgTEp93H5SiUxG630iWGIoH6npb4anVPnRiCSFPOhEsKA0fdlfHgNPKkomEZ0aHFaWhJ6pIVjWVzA2P4VntdlcInVPAxbXLDCvLKKyu57Gkg2vaOypJoP+Hpn9Bl1/k+tgbR+L1U0r4mskGJwx4at5giZJrJXS3klbSiHv1FKf7HmojMPO7h8UdqjwqCQBe/Y9SFtKXAc3DHfgx9Is/VBQmQpRtZj6L+rzKSzJkINAhQiJeikFkbXRuXE0f3mP9IYiCg4tTXIP7O+kACYW7aZuervvCz+R317BrVX1NmJicRqavkZMLEzz63HDEWCHyC3J1NrtdjxWp+23QS+FbddGW2MYaEWqIRfJRTmITEkbDAiLy/ILFWZf8wm8fCzYONSBGYuZJnz9rooehPipxgJ0Tw4iUCFEtCaDlj3FkMtVw7q9QcucZixEcrkEEkUt5NVtVMS/ftvP+1hwVrOSnp5M9vr2Bmo/t9DkT9TpNDnpJyk1meRgZTxXid6pYWzbdhCkEPED+8tjINKJwXRV01s6lzm8PIVOb25bOTdA3DfVYmQ0yvb/YnzB/m7KJTDL45E4an9P3wA/8Nwpn0Xn/YxWjYIKFUo1dRDnKSEt1nNg4t8NFGjIhBPduhcS7bHXqarTgNS8Eg52lJLFzMJN35AbHi21ut4ICaM7Epop1277+EUKPVpqR0xSWIx81ZsD0EIVC9/gqLJje+yO2Wy7SMuWQaZt5aDEDwiP67ji5XXxzMDEfi9Z8DxLzoEjhC9NV33uXzp0qmUao7CirrXIE1Ib25kiVd1oQiZjOTBM52F3HkTEEh22+BcsuvzZwrz7KQAAAABJRU5ErkJggg==">
                                                                </button>
                                                            </form>
                                                        @endhasrole
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7">No Data Avaliable!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="right-sidebar" style="margin-top: 67px;">
        <div class="slimscrollright">
            <div class="rpanel-title bg-white text-dark pb-0">
                <b>Academic Year Details</b>
                <span>
                    <i class="ti-close right-side-toggle"></i>
                </span>
                <hr>
            </div>
            <div class="r-panel-body mb-5 pt-0">
                <input type="hidden" name="key" disabled>

                <form action="{{ route('admin.academic-year.update', ['academic_year' => ':id']) }}" method="PUT"
                    id="UpdateAcademicYearForm">
                    @csrf
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="form-group" style="margin-bottom: 5px">
                                <label class="col-form-label">Academic Year:</label>
                                <input type="text" name="academic_year" class="form-control">
                            </div>

                            <div class="form-group" style="margin-bottom: 5px">
                                <label class="col-form-label" for="name">Closure Date:</label>
                                <div class="input-group">
                                    <input type="text" name="closure_date" class="form-control datepicker" placeholder="Select">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" style="margin-bottom: 5px">
                                <label class="col-form-label" for="name">Final Closure Date:</label>
                                <div class="input-group">
                                    <input type="text" name="final_closure_date" class="form-control datepicker" placeholder="Select">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row justify-content-center mt-4">
                    <div class="col-10">
                        <hr>
                        <h4 class="text-center text-muted">Academic Year Deletion</h4>
                        <hr>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-outline-danger" data-delete="no-select"
                            onclick="showDeleteModal(this);"
                            action="{{ route('admin.academic-year.destroy', ['academic_year' => ':id']) }}"
                            method="DELETE">Delete
                            Academic Year</button>
                    </div>
                </div>

                <hr>

                <div class="d-flex w-100 no-block">
                    <button type="button"
                        class="btn btn-default ml-auto rounded btn-block close-sidebar">Cancel</button>
                    <button type="submit" class="btn btn-primary mr-auto rounded btn-block"
                        form="UpdateAcademicYearForm" id="UpdateFormBtn">Save</button>
                </div>

            </div>
        </div>
    </div>

    <div id="AddNewAcademicYearModal" class="modal fade" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title">Add New Academic Year</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.academic-year.store') }}" method="POST"
                        id="StoreAcademicYearForm">
                        @csrf

                        <span class="text-danger email-error"></span>

                        <div class="form-group" style="margin-bottom: 5px">
                            <label class="col-form-label" for="name">Academic Year:</label>
                            <input type="text" name="academic_year" class="form-control" id="name">
                        </div>

                        <div class="form-group" style="margin-bottom: 5px">
                            <label class="col-form-label" for="name">Closure Date:</label>
                            <div class="input-group">
                                <input type="text" name="closure_date" class="form-control datepicker"
                                    placeholder="Select">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 5px">
                            <label class="col-form-label" for="name">Final Closure Date:</label>
                            <div class="input-group">
                                <input type="text" name="final_closure_date" class="form-control datepicker"
                                    placeholder="Select">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info waves-effect waves-light" form="StoreAcademicYearForm"
                        id="StoreAcademicYearBtn">Add New</button>
                </div>
            </div>
        </div>
    </div>

    <div id="DeleteAcademicYearModal" class="modal fade" role="dialog" aria-labelledby="mySmallModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="" method="" id="DeleteAcademicYearForm" data-delete="">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h4 class="modal-title" id="mySmallModalLabel">Deleting</h4>
                    </div>
                    <div class="modal-body text-center">
                        <i class="mdi mdi-information-outline fa-6x text-danger"></i>
                        <h3>Are You Sure, You want to delete? </h3>
                        <p>You won't be able to revert this!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-info waves-effect waves-light">Yes</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <x-slot name="script">
        <script>
            $("#StoreAcademicYearForm").on('submit', function(e) {
                e.preventDefault();

                $("#StoreAcademicYearBtn").attr('disabled', true);

                $(".error-message").remove();

                var formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: formData,
                    success: function(res) {
                        if (res.success) {
                            location.reload();
                        } else if (res.error) {
                            $("#StoreAcademicYearBtn").attr('disabled', false);
                            $('.email-error').html(res.error);
                        }
                    },
                    error: function(err) {
                        if (err.status == 422) { // when status code is 422, it's a validation issue
                            $("#StoreAcademicYearBtn").attr('disabled', false);
                            // display errors on each form field
                            $.each(err.responseJSON.errors, function(i, error) {
                                var el = $(document).find('[name="' + i + '"]');
                                if(el.hasClass('datepicker')) {
                                    el.closest('.input-group').after($('<span class="text-danger error-message">' + error[0] +
                                    '</span>'));
                                }else{
                                    el.after($('<span class="text-danger error-message">' + error[0] +
                                    '</span>'));
                                }
                            });
                        }
                    }
                })
            })

            $("#UpdateAcademicYearForm").on('submit', function(e) {
                e.preventDefault();

                $("#UpdateFormBtn").attr('disabled', true);
                let action = $(this).attr('action');
                let formAction = action.replace(':id', $(document).find('.r-panel-body input[name=key]').val());

                $(".error-message").remove();
                var formData = $(this).serializeArray();

                $.ajax({
                    url: formAction,
                    method: $(this).attr('method'),
                    data: formData,
                    success: function(res) {
                        if (res.success) {
                            location.reload();
                        }
                    },
                    error: function(err) {
                        if (err.status == 422) { // when status code is 422, it's a validation issue
                            $("#UpdateFormBtn").attr('disabled', false);
                            // display errors on each form field
                            $.each(err.responseJSON.errors, function(i, error) {
                                var el = $(document).find('[name="' + i + '"]');
                                el.after($('<span class="text-danger error-message">' + error[0] +
                                    '</span>'));
                            });
                        }
                    }
                })
            })

            $("#DeleteAcademicYearForm").on('submit', function(e) {
                e.preventDefault();
                var ids = [];
                var _this = $(this);

                $(this).find('button[type=submit]').attr('disabled', true);

                var action = $(this).attr('action');
                var formData = {};

                if ($(this).data('delete') == 'no-select') {
                    action = action.replace(':id', $(document).find('.r-panel-body input[name=key]').val());

                    $(".error-message").remove();

                    formData = {
                        "_token": "{{ csrf_token() }}",
                    };
                }

                $.ajax({
                    url: action,
                    method: $(this).attr('method'),
                    data: formData,
                    success: function(res) {
                        if (res.success) {
                            location.reload();
                        }
                    },
                    error: function(err) {
                        $(_this).find('button[type=submit]').attr('disabled', false);
                        console.log(err);
                    }
                })
            })

            $("#AddNewAcademicYearModal").on("hidden.bs.modal", function() {
                $(".error-message").remove();
            });

            $(".right-side-toggle").click(function() {
                $(".error-message").remove();

                $(".right-sidebar").slideDown(50);
                $(".right-sidebar").toggleClass("shw-rside");

                var _side = $(document)
                    .find(".right-sidebar");
                _side.find('input[name=key]').val($(this).closest("tr").data("id"));
                _side.find('input[name=academic_year]').val($(this).closest("tr").data("name"));
                _side.find('input[name=closure_date]').val($(this).closest("tr").data("closure-date"));
                _side.find('input[name=final_closure_date]').val($(this).closest("tr").data("final-closure-date"));
            });

            function showDeleteModal(_this) {
                $('#DeleteAcademicYearModal').modal('show');
                $('#DeleteAcademicYearModal form').attr('action', $(_this).attr('action')).attr('method', $(_this).attr(
                    'method')).attr(
                    'data-delete', $(_this).data('delete'));
            }
        </script>
    </x-slot>
</x-app-layout>
