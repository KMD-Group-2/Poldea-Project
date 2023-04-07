<x-app-layout>
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-6 align-self-center">
                <div class="d-flex justify-content-start align-items-center">
                    <nav class="breadcrumb">
                        <span class="breadcrumb-item">QA Manager</span>
                        <span class="breadcrumb-item active">Category</span>
                    </nav>
                </div>
            </div>
            <div class="col-md-6 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                <button type="button" class="btn btn-info d-lg-block m-l-15" data-toggle="modal"
                        data-target="#AddNewCategoryModal"><i class="fa fa-plus-circle"></i> Add New Category</button>
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
                                    action="{{ route('qa_m.category.massDestroy') }}" method="POST"><i
                                        class="ti-trash"></i> Delete
                                    Category</button>
                                <span class="ids-message"></span>
                            </div>
                            <div class="col-md-7 align-self-center text-right">
                                <div
                                    class="d-flex w-100 justify-content-center justify-content-md-end align-items-center">
                                    <div
                                        class="d-flex justify-content-center justify-content-md-end align-items-center">
                                        <span>Showing
                                            {{ ($categories->currentPage() - 1) * $categories->perPage() + ($categories->total() ? 1 : 0) }}
                                            to
                                            {{ ($categories->currentPage() - 1) * $categories->perPage() + count($categories) }} of
                                            {{ $categories->total() }} results</span>

                                            {{ $categories->links('vendor.pagination.custom') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped selected-table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Category Name</th>
                                        <th class="text-center">Total Ideas</th>
                                        <th class="text-center">Created Date</th>
                                        <th class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($categories) > 0)
                                        @foreach ($categories as $category)
                                            <tr data-id="{{ $category->id }}" data-name="{{ $category->name }}">
                                                <td><input type="checkbox" class="select-checkbox mt-2"></td>
                                                <td>{{ $category->name }}</td>
                                                <td class="text-center">{{ $category->idea_count }}</td>
                                                <td class="text-center">{{ Carbon\Carbon::parse($category->created_at)->format('d M Y') }}</td>
                                                <td class="right-side-toggle text-center">
                                                    <button type="button" class="btn" title="Edit">
                                                        <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M16.3 6.925L12.05 2.725L13.45 1.325C13.8333 0.941667 14.3043 0.75 14.863 0.75C15.421 0.75 15.8917 0.941667 16.275 1.325L17.675 2.725C18.0583 3.10833 18.2583 3.571 18.275 4.113C18.2917 4.65433 18.1083 5.11667 17.725 5.5L16.3 6.925ZM14.85 8.4L4.25 19H0V14.75L10.6 4.15L14.85 8.4Z" fill="#B6B6BB"/>
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9">No Data Avaliable!</td>
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
                <b>Category Details</b>
                <span>
                    <i class="ti-close right-side-toggle"></i>
                </span>
                <hr>
            </div>
            <div class="r-panel-body mb-5 pt-0">
                <input type="hidden" name="key" disabled>

                <form action="{{ route('qa_m.category.update', ['category' => ':id']) }}" method="PUT" id="UpdateCategoryForm">
                    @csrf
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="form-group" style="margin-bottom: 5px">
                                <label class="col-form-label">Category Name:</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row justify-content-center mt-4">
                    <div class="col-10">
                        <hr>
                        <h4 class="text-center text-muted">Category Deletion</h4>
                        <hr>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-outline-danger" data-delete="no-select"
                            onclick="showDeleteModal(this);"
                            action="{{ route('qa_m.category.destroy', ['category' => ':id']) }}" method="DELETE">Delete
                            Category</button>
                    </div>
                </div>

                <hr>

                <div class="d-flex w-100 no-block">
                    <button type="button"
                        class="btn btn-default ml-auto rounded btn-block close-sidebar">Cancel</button>
                    <button type="submit" class="btn btn-primary mr-auto rounded btn-block" form="UpdateCategoryForm"
                        id="UpdateFormBtn">Save</button>
                </div>

            </div>
        </div>
    </div>

    <div id="AddNewCategoryModal" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title">Add New Category</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('qa_m.category.store') }}" method="POST" id="StoreCategoryForm">
                        @csrf

                        <span class="text-danger email-error"></span>

                        <div class="form-group" style="margin-bottom: 5px">
                            <label class="col-form-label" for="name">Category Name:</label>
                            <input type="text" name="name" class="form-control" id="name">
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info waves-effect waves-light" form="StoreCategoryForm"
                        id="StoreCategoryBtn">Add New</button>
                </div>
            </div>
        </div>
    </div>

    <div id="DeleteCategoryModal" class="modal fade" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="" method="" id="DeleteCategoryForm" data-delete="">
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
            $("#StoreCategoryForm").on('submit', function(e) {
                e.preventDefault();

                $("#StoreCategoryBtn").attr('disabled', true);

                $(".error-message").remove();

                var formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: formData,
                    success: function(res) {
                        if (res.success) {
                            location.reload();
                        }else if(res.error){
                            $("#StoreCategoryBtn").attr('disabled', false);
                            $('.email-error').html(res.error);
                        }
                    },
                    error: function(err) {
                        if (err.status == 422) { // when status code is 422, it's a validation issue
                            $("#StoreCategoryBtn").attr('disabled', false);
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

            $("#UpdateCategoryForm").on('submit', function(e) {
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

            $("#DeleteCategoryForm").on('submit', function(e) {
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
                        ids: ids,
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

            $("#AddNewCategoryModal").on("hidden.bs.modal", function() {
                $(".error-message").remove();
            });

            $('.select2').on('select2:select', function(e) {
                if(e.params.data.id != "")
                {
                    let email = $(this).find(':selected').data('email');

                    $(".system-info").removeClass('d-none');
                    $(".system-info .staff-email").html(email);
                }else{
                    $(".system-info").addClass('d-none');
                    $(".system-info .staff-email").html("");
                }
            });

            $(document).on('click','input[name=active]',function(){
                if($(this).is(':checked'))
                {
                    $(document).find('.status-show').html('Active').css('color','#0561FC');;
                }else{
                    $(document).find('.status-show').html('Inactive').css('color','red');;
                }
            })

            $(".right-side-toggle").click(function () {
                $(".error-message").remove();

                $(".right-sidebar").slideDown(50);
                $(".right-sidebar").toggleClass("shw-rside");

                var _side = $(document)
                    .find(".right-sidebar");
                _side.find('input[name=key]').val($(this).closest("tr").data("id"));
                _side.find('input[name=name]').val($(this).closest("tr").data("name"));
            });

            function showDeleteModal(_this) {
                var el = $(document).find('.ids-message');
                el.html('');
                if ($(_this).data('delete') == 'selected' && !$('.selected-table .select-checkbox:checked').length > 1) {
                    el.html($('<span class="text-danger error-message">Select At Least Two Rows!</span>'));
                    return false;
                }
                $('#DeleteCategoryModal').modal('show');
                $('#DeleteCategoryModal form').attr('action', $(_this).attr('action')).attr('method', $(_this).attr('method')).attr(
                    'data-delete', $(_this).data('delete'));
            }
        </script>
    </x-slot>
</x-app-layout>
