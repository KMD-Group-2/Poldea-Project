<x-app-layout>
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-6 align-self-center">
                <div class="d-flex justify-content-start align-items-center">
                    <nav class="breadcrumb">
                        <span class="breadcrumb-item">Admin</span>
                        <span class="breadcrumb-item active">Staff</span>
                    </nav>
                </div>
            </div>
            <div class="col-md-6 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <button type="button" class="btn btn-info d-lg-block m-l-15" data-toggle="modal"
                            data-target="#AddNewStaffModal"><i class="fa fa-plus-circle"></i> Add New Staff</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row" style="padding-bottom:30px;">
                            <div class="col-md-5 align-self-center">
                                <a href="javascript:void(0)" class="select-all">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                        style="stroke: #494949;stroke-width: 1px;stroke-linejoin: round;"
                                        class="off-select" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M14 0H2C0.89 0 0 0.89 0 2V16C0 16.5304 0.210714 17.0391 0.585786 17.4142C0.960859 17.7893 1.46957 18 2 18H16C16.5304 18 17.0391 17.7893 17.4142 17.4142C17.7893 17.0391 18 16.5304 18 16V2C18 1.46957 17.7893 0.960859 17.4142 0.585786C17.0391 0.210714 16.5304 0 16 0Z"
                                            fill="#fff" />
                                    </svg>
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                        class="on-select" style="display: none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M14 10H4V8H14M16 0H2C0.89 0 0 0.89 0 2V16C0 16.5304 0.210714 17.0391 0.585786 17.4142C0.960859 17.7893 1.46957 18 2 18H16C16.5304 18 17.0391 17.7893 17.4142 17.4142C17.7893 17.0391 18 16.5304 18 16V2C18 1.46957 17.7893 0.960859 17.4142 0.585786C17.0391 0.210714 16.5304 0 16 0Z"
                                            fill="#0561FC" />
                                    </svg>
                                </a>
                                Selected (<span class="select-count">0</span>) <img
                                    src="{{ asset('assets/images/divider.svg') }}" style="padding-left:20px;" />
                                <button class="btn" data-delete="selected" onclick="showDeleteModal(this)"
                                    action="{{ route('admin.staff.massDestroy') }}" method="POST"><i
                                        class="ti-trash"></i> Delete
                                    Staff</button>
                                <span class="ids-message"></span>
                            </div>
                            <div class="col-md-7 align-self-center text-right">
                                <div class="d-flex justify-content-end align-items-center">
                                    <span>Showing
                                        {{ ($staffs->currentPage() - 1) * $staffs->perPage() + ($staffs->total() ? 1 : 0) }}
                                        to
                                        {{ ($staffs->currentPage() - 1) * $staffs->perPage() + count($staffs) }} of
                                        {{ $staffs->total() }} results</span>

                                    {{ $staffs->links('vendor.pagination.custom') }}
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped selected-table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Staff Name</th>
                                        <th>Email</th>
                                        <th>Department</th>
                                        <th>Job Title</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Created Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($staffs->total() > 0)
                                        @foreach ($staffs as $staff)
                                            <tr data-entry="{{ $staff }}">
                                                <td><input type="checkbox" class="select-checkbox mt-2"></td>
                                                <td><img src="{{ $staff->photo ?? '' }} " alt="staff" class=""
                                                        style="width:36px;"> {{ $staff->name }}</td>
                                                <td>{{ $staff->email }}</td>
                                                <td>{{ $staff->department->name }}</td>
                                                <td>{{ $staff->position->name }}</td>
                                                <td>{{ $staff->phone }}</td>
                                                <td>{{ $staff->address }}</td>
                                                <td>{{ Carbon\Carbon::parse($staff->created_at)->format('d M Y') }}
                                                </td>
                                                <td class="right-side-toggle">
                                                    <button type="button" class="btn" title="Edit">
                                                        <svg width="19" height="19" viewBox="0 0 19 19"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M16.3 6.925L12.05 2.725L13.45 1.325C13.8333 0.941667 14.3043 0.75 14.863 0.75C15.421 0.75 15.8917 0.941667 16.275 1.325L17.675 2.725C18.0583 3.10833 18.2583 3.571 18.275 4.113C18.2917 4.65433 18.1083 5.11667 17.725 5.5L16.3 6.925ZM14.85 8.4L4.25 19H0V14.75L10.6 4.15L14.85 8.4Z"
                                                                fill="#B6B6BB" />
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9">No data Available!</td>
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
                <b>Staff Details</b>
                <span>
                    <i class="ti-close right-side-toggle"></i>
                </span>
                <hr>
            </div>
            <div class="r-panel-body mb-5 pt-0">
                <form action="{{ route('admin.staff.update', ['staff' => ':id']) }}" method="POST"
                    id="UpdateStaffForm" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="key" disabled>

                    <div class="form-group text-center" style="margin-bottom: 5px">
                        <label for="col-form-label" onclick="OpenFile(this)">
                            <img src="" class="rounded user-photo"
                                style="height:100px; width:100px; cursor:pointer;" title="Click to Change the Photo.">
                        </label>
                        <input class="d-none" name="photo" type="file" id="filePhoto" accept="image/jpeg, image/png" onchange="OnChangeFile(this)">
                    </div>

                    <div class="form-group" style="margin-bottom: 5px">
                        <label class="col-form-label" for="txtStaffName">Name:</label>
                        <input type="text" class="form-control" id="txtStaffName" name="name">
                    </div>
                    <div class="form-group" style="margin-bottom: 5px">
                        <label class="col-form-label" for="txtEmail">Email:</label>
                        <input type="email" class="form-control" id="txtEmail" name="email">
                    </div>

                    <div class="form-group" style="margin-bottom: 5px">
                        <label class="col-form-label">Department:</label>
                        <select class="form-control" name="department_id">
                            <option value="">Select Department</option>
                            @if (count($departments) > 0)
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom: 5px">
                        <label class="col-form-label">Job Title:</label>
                        <select class="form-control" name="position_id">
                            <option value="">Select Job Title</option>
                            @if (count($positions) > 0)
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group" style="margin-bottom: 5px">
                        <label class="col-form-label" for="txtPhone">Phone:</label>
                        <input type="text" class="form-control" id="txtPhone" name="phone">
                    </div>

                    <div class="form-group" style="margin-bottom: 5px">
                        <label class="col-form-label" for="txtAddress">Address:</label>
                        <textarea name="address" id="txtAddress" class="form-control" rows="3"></textarea>
                    </div>
                </form>

                <div class="row justify-content-center">
                    <div class="col-10">
                        <hr>
                        <h4 class="text-center text-muted">Staff Deletion</h4>
                        <hr>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-outline-danger" data-delete="no-select"
                            onclick="showDeleteModal(this);"
                            action="{{ route('admin.staff.destroy', ['staff' => ':id']) }}" method="DELETE">Delete
                            Staff</button>
                    </div>
                </div>

                <hr>

                <div class="d-flex w-100 no-block">
                    <button type="button"
                        class="btn btn-default ml-auto rounded btn-block close-sidebar">Cancel</button>
                    <button type="submit" class="btn btn-primary mr-auto rounded btn-block" form="UpdateStaffForm"
                        id="UpdateFormBtn">Save</button>
                </div>

            </div>
        </div>
    </div>

    <div id="AddNewStaffModal" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title">Add New Staff</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.staff.store') }}" method="POST" id="StoreStaffForm"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="form-group text-center" style="margin-bottom: 5px">
                            <label for="col-form-label upload-photo" onclick="OpenFile(this)">
                                <img src="{{ asset('assets/images/default-user.png') }}"
                                    class="rounded user-photo" style="height:100px; width:100px; cursor:pointer;"
                                    title="Click to Change the Photo.">
                            </label>
                            <input name="photo" id="filePhoto" type="file" onchange="OnChangeFile(this)"
                                accept="image/jpeg, image/png" style="display: none;">
                        </div>

                        <div class="form-group" style="margin-bottom: 5px">
                            <label class="col-form-label" for="txtStaffName">Name:</label>
                            <input type="text" class="form-control" id="txtStaffName" name="name">
                        </div>
                        <div class="form-group" style="margin-bottom: 5px">
                            <label class="col-form-label" for="txtEmail">Email:</label>
                            <input type="email" class="form-control" id="txtEmail" name="email">
                        </div>

                        <div class="form-group" style="margin-bottom: 5px">
                            <label class="col-form-label">Department:</label>
                            <select class="form-control" name="department_id">
                                <option value="">Select</option>
                                @if (count($departments) > 0)
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group" style="margin-bottom: 5px">
                            <label class="col-form-label">Job Title:</label>
                            <select class="form-control" name="position_id">
                                <option value="">Select</option>
                                @if (count($positions) > 0)
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group" style="margin-bottom: 5px">
                            <label class="col-form-label" for="txtPhone">Phone:</label>
                            <input type="text" class="form-control" id="txtPhone" name="phone">
                        </div>

                        <div class="form-group" style="margin-bottom: 5px">
                            <label class="col-form-label" for="txtAddress">Address:</label>
                            <textarea name="address" id="txtAddress" class="form-control" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info waves-effect waves-light" form="StoreStaffForm"
                        id="StoreStaffBtn">Add New</button>
                </div>
            </div>
        </div>
    </div>

    <div id="DeleteStaffModal" class="modal fade" role="dialog" aria-labelledby="mySmallModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="" method="" id="DeleteStaffForm" data-delete="">
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
            $("#StoreStaffForm").on('submit', function(e) {
                e.preventDefault();

                $("#StoreStaffBtn").attr('disabled', true);

                $(".error-message").remove();

                var formData = new FormData(this);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        if (res.success) {
                            location.reload();
                        }
                    },
                    error: function(err) {
                        if (err.status == 422) { // when status code is 422, it's a validation issue
                            $("#StoreStaffBtn").attr('disabled', false);
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

            $("#UpdateStaffForm").on('submit', function(e) {
                e.preventDefault();

                $("#UpdateFormBtn").attr('disabled', true);

                $(".error-message").remove();

                var formData = new FormData(this);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: $(this).attr('action').replace(':id', $(this).find('input[name=key]').val()),
                    method: $(this).attr('method'),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
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

            $("#DeleteStaffForm").on('submit', function(e) {
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
                } else {
                    $('.selected-table tbody tr.selected').each(function() {
                        ids.push($(this).data('entry').id);
                    })

                    formData = {
                        "ids" : ids,
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

            $("#AddNewStaffModal").on("hidden.bs.modal", function() {
                $(".error-message").remove();
                $(this).find('form').trigger('reset');
            });

            $(".right-side-toggle").click(function() {
                $(".error-message").remove();

                $(".right-sidebar").slideDown(50);
                $(".right-sidebar").toggleClass("shw-rside");

                var data = $(this).closest("tr").data("entry");

                var _side = $(document)
                    .find(".right-sidebar");

                _side.find('input[name=key]').val(data.id);
                _side.find('.user-photo').attr('src', data.photo);
                _side.find('input[name=name]').val(data.name);
                _side.find('input[name=email]').val(data.email);
                _side.find('input[name=phone]').val(data.phone);
                _side.find('textarea[name=address]').val(data.address);
                _side.find('.created-at').html(new Date(data.created_at).toLocaleString("en-US"));
                _side.find('select[name=department_id]').val(data.department.id);
                _side.find('select[name=position_id]').val(data.position.id);
            });

            function showDeleteModal(_this) {
                var el = $(document).find('.ids-message');
                el.html('');
                if ($(_this).data('delete') == 'selected' && !$('.selected-table .select-checkbox:checked').length > 1) {
                    el.html($('<span class="text-danger error-message">Select At Least Two Rows!</span>'));
                    return false;
                }
                $('#DeleteStaffModal').modal('show');
                $('#DeleteStaffModal form').attr('action', $(_this).attr('action')).attr('method', $(_this).attr('method'))
                    .attr(
                        'data-delete', $(_this).data('delete'));
            }

            // ==============================================================
            // Image Selector
            // ==============================================================
            function OpenFile(label) {
                $(label).closest('div').find("#filePhoto").click();
            }

            function OnChangeFile(input) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $(input).closest('form').find('.user-photo').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        </script>
    </x-slot>
</x-app-layout>
