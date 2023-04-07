<x-app-layout>
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <div class="d-flex justify-content-start align-items-center">
                    <nav class="breadcrumb">
                        <span class="breadcrumb-item">{{ Auth::user()->roles()->first()->name }}</span>
                        <span class="breadcrumb-item active">Idea Report</span>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5 align-self-center">
                                <button class="right-side-toggle btn btn-info ml-2 my-1">
                                    <i class="fas fa-search"></i>   Search
                                </button>
                                <div class="filter_list text-white">
                                    @if (count(request()->all()) > 0)
                                        @foreach (request()->all() as $key => $filter)
                                            @if (is_array($filter))
                                                @foreach ($filter as $v)
                                                    @if ($v)
                                                        <span
                                                            class="btn waves-effect waves-light btn-rounded btn-sm btn-tag-secondary-blue ml-2 my-1">
                                                            @if ($key == 'academic_years')
                                                                {{ $academic_years->filter(function ($item) use ($v) {return $item->id == $v;})->values()->first()->academic_year }}
                                                            @elseif ($key == 'categories')
                                                                {{ $categories->filter(function ($item) use ($v) {return $item->id == $v;})->values()->first()->name }}
                                                            @elseif ($key == 'departments')
                                                                @hasanyrole('Admin|QA Manager')
                                                                    {{ $departments->filter(function ($item) use ($v) {return $item->id == $v;})->values()->first()->name }}
                                                                @endhasanyrole
                                                            @endif
                                                        </span>
                                                    @endif
                                                @endforeach
                                            @else
                                                @if ($filter && $key != 'page')
                                                    <span
                                                        class="btn waves-effect waves-light btn-rounded btn-sm btn-tag-secondary-blue ml-2 my-1">{{ $filter }}</span>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-7 align-self-center text-right">
                                <div
                                    class="d-flex w-100 justify-content-center justify-content-md-end align-items-center">
                                    <div
                                        class="d-flex justify-content-center justify-content-md-end align-items-center">
                                        <span>Showing
                                            {{ ($ideas->currentPage() - 1) * $ideas->perPage() + ($ideas->total() ? 1 : 0) }}
                                            to
                                            {{ ($ideas->currentPage() - 1) * $ideas->perPage() + count($ideas) }} of
                                            {{ $ideas->total() }} results</span>
                                        {{ $ideas->links('vendor.pagination.custom') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="{{ count(request()->all()) < 1 && $last_academic_year ? 'ribbon-wrapper' : '' }} px-0">
                            @if (count(request()->all()) < 1 && $last_academic_year)
                                <div class="ribbon ribbon-bookmark ribbon-primary">Academic Year:
                                    {{ $last_academic_year->academic_year }}</div>
                            @endif
                            <div class="table-responsive mt-2">
                                <table id="myTable" class="table table-striped selected-table">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Department</th>
                                            <th>Idea Owner</th>
                                            <th>Status</th>
                                            <th>QA Coordinator Read</th>
                                            <th class="text-center">Comments</th>
                                            <th class="text-center">Published Date</th>
                                            <th class="text-center">Closure Date</th>
                                            <th class="text-center">Export</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($ideas->total() > 0)
                                            @foreach ($ideas as $idea)
                                                <tr data-entry="{{ $idea }}">
                                                    <td>
                                                        <span
                                                            class="label label-info">{{ $idea->category->name ?? '' }}</span>
                                                    </td>
                                                    <td>
                                                        <b>{{ $idea->publisher_department->name ?? '' }}</b>
                                                    </td>
                                                    <td>
                                                        @if ($idea->anonymous == 1)
                                                            <div class="report-idea-staff d-flex align-items-center">
                                                                <img src="{{ asset('assets/images/default-user.png') }}"
                                                                    class="report-idea-staff-img" />
                                                                <div class="report-idea-staff-text ml-2">
                                                                    <span> <b>Anonymous</b></span>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="report-idea-staff">
                                                                <img src="{{ $idea->user->staff->photo ?? asset('assets/images/default-user.png') }}"
                                                                    class="report-idea-staff-img" />
                                                                <div class="report-idea-staff-text ml-2">
                                                                    <span> <b>
                                                                            {{ $idea->user->staff->name ?? '' }}</b></span>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="label {{ now()->diffInDays(Carbon\Carbon::parse($idea->academic_year->final_closure_date), false) >= 0 ? 'label-success' : 'label-danger' }}">
                                                            {{ now()->diffInDays(Carbon\Carbon::parse($idea->academic_year->final_closure_date), false) >= 0 ? 'Open' : 'Expired' }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        @if($idea->qa_c_read==1)
                                                            <i class='fas fa-eye text-cyan mr-2' title="read"></i>
                                                        @else
                                                            <i class='fas fa-eye-slash text-cyan mr-2' title="unread"></i>
                                                        @endif
                                                    </td>
                                                    <td class="text-center"><b>{{ $idea->comments->count() }}</b></td>
                                                    <td class="text-center"><b>{{ Carbon\Carbon::parse($idea->posted_at)->format('d M Y') }}</b>
                                                    </td>
                                                    <td class="text-center"><b>{{ Carbon\Carbon::parse($idea->academic_year->closure_date)->format('d M Y') }}</b>
                                                    </td>
                                                    <td class="text-center">
                                                        <form action="{{ route('idea_report.export-zip') }}" method="POST">
                                                        @csrf
                                                            <input type="hidden" name="idea_id" value="{{ $idea->id }}">
                                                            <button class="btn"
                                                            @if (count($idea->documents) > 0)
                                                            type="submit"
                                                            @else
                                                            type="button" style="cursor:not-allowed;opacity:0.6;" data-toggle="tooltip" data-placement="top" title="This idea is not include any documents."
                                                            @endif>
                                                                <img src={{ asset('assets/images/export.png') }}
                                                                    class="mr-1" alt="Export" />
                                                                Zip
                                                            </button>
                                                        </form>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('idea.detail', $idea->id) }}"
                                                            class="btn waves-effect waves-light btn-rounded btn-sm btn-tag-secondary-blue">View
                                                            Detail</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="10">No data Available!</td>
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
    </div>
    <div class="right-sidebar" style="margin-top: 67px;">
        <div class="slimscrollright">
            <div class="rpanel-title bg-white text-dark pb-0">
                <b>Advanced Search</b>
                <span>
                    <i class="ti-close right-side-toggle"></i>
                </span>
                <hr>
            </div>
            <div class="r-panel-body mb-5 pt-0">
                @hasrole('Admin')
                    <form action="{{ route('admin.idea_report') }}" method="GET" id="FilterForm">
                    @endhasrole

                    @hasrole('QA Manager')
                        <form action="{{ route('qa_m.idea_report') }}" method="GET" id="FilterForm">
                        @endhasrole

                        @hasrole('QA Coordinator')
                            <form action="{{ route('qa_c.idea_report') }}" method="GET" id="FilterForm">
                            @endhasrole

                            <div class="form-group" style="margin-bottom: 5px">
                                <label class="col-form-label">Academic Years:</label>
                                <select name="academic_years[]" class="select2 m-b-10 select2-multiple"
                                    style="width: 100%" multiple="multiple" data-placeholder="Choose">
                                    @if (count($academic_years) > 0)
                                        @foreach ($academic_years as $year)
                                            <option value="{{ $year->id }}"
                                                {{ isset(request()->academic_years) ? (in_array($year->id, request()->academic_years) ? 'selected' : '') : '' }}
                                                {{ count(request()->all()) < 1 && $last_academic_year ? ($last_academic_year->id == $year->id  ? 'selected' : '') : '' }}>
                                                {{ $year->academic_year }}</option>
                                        @endforeach
                                    @else
                                        <option disabled>No academic year exist!</option>
                                    @endif
                                </select>
                            </div>

                            <div class="form-group" style="margin-bottom: 5px">
                                <label class="col-form-label">Date Range:</label>
                                <div class='input-group mb-3'>
                                    <input type='text' class="form-control date-ranger-picker" name="date_range"
                                        value="{{ request()->date_range ?? '' }}" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <span class="ti-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" style="margin-bottom: 5px">
                                <label class="col-form-label">Categories:</label>
                                <select name="categories[]" class="select2 m-b-10 select2-multiple" style="width: 100%"
                                    multiple="multiple" data-placeholder="Choose">
                                    @if (count($categories) > 0)
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ isset(request()->categories) ? (in_array($category->id, request()->categories) ? 'selected' : '') : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    @else
                                        <option disabled>No category exist!</option>
                                    @endif
                                </select>
                            </div>

                            @hasanyrole('Admin|QA Manager')
                                <div class="form-group" style="margin-bottom: 5px">
                                    <label class="col-form-label">Departments:</label>
                                    <select name="departments[]" class="select2 m-b-10 select2-multiple"
                                        style="width: 100%" multiple="multiple" data-placeholder="Choose">
                                        @if (count($departments) > 0)
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}"
                                                    {{ isset(request()->departments) ? (in_array($department->id, request()->departments) ? 'selected' : '') : '' }}>
                                                    {{ $department->name }}</option>
                                            @endforeach
                                        @else
                                            <option disabled>No department exist!</option>
                                        @endif
                                    </select>
                                </div>
                            @endhasanyrole

                            <div class="form-group" style="margin-bottom: 5px">
                                <label class="col-form-label">Status:</label>
                                <select name="status" class="form-control">
                                    <option value=""></option>
                                    <option value="open"
                                        {{ isset(request()->status) && request()->status == 'open' ? 'selected' : '' }}>
                                        Open</option>
                                    <option value="expired"
                                        {{ isset(request()->status) && request()->status == 'expired' ? 'selected' : '' }}>
                                        Expired</option>
                                </select>
                            </div>

                            <div class="form-group" style="margin-bottom: 20px">
                                <label class="col-form-label">Post Type:</label>
                                <select name="post_type" class="form-control">
                                    <option value="all">All</option>
                                    <option value="author"
                                        {{ isset(request()->post_type) && request()->post_type == 'author' ? 'selected' : '' }}>
                                        Author</option>
                                    <option value="anonymous"
                                        {{ isset(request()->post_type) && request()->post_type == 'anonymous' ? 'selected' : '' }}>
                                        Anonymous</option>
                                </select>
                            </div>

                            <div class="form-group" style="margin-bottom: 20px">
                                <label class="custom-control custom-checkbox m-b-0">
                                    <input type="checkbox" class="custom-control-input" name="idea_without_comment"
                                        {{ isset(request()->idea_without_comment) ? 'checked' : '' }}>
                                    <span class="custom-control-label">Idea without comments</span>
                                </label>
                            </div>

                            <hr>

                            <div class="d-flex w-100 no-block">
                                <button type="button"
                                    class="btn btn-default ml-auto rounded btn-block close-sidebar">Cancel</button>
                                <button type="submit" class="btn btn-primary mr-auto rounded btn-block"
                                    id="FilterFormBtn">Filter</button>
                            </div>
                        </form>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script>
            $(".right-side-toggle").click(function() {
                $(".error-message").remove();

                $(".right-sidebar").slideDown(50);
                $(".right-sidebar").toggleClass("shw-rside");
            });

            $('.date-ranger-picker').daterangepicker({
                autoUpdateInput: false,
                cancelClass: "btn-danger",
                showDropdowns: true,
                linkedCalendars: false,
                locale: {
                    format: 'DD MMM YYYY',
                    cancelLabel: 'Clear'
                }
            });

            $('.date-ranger-picker').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD MMM YYYY') + ' ~ ' + picker.endDate.format('DD MMM YYYY'));
            });

            $('.date-ranger-picker').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

            $('#FilterForm').on('submit', function(e) {
                e.preventDefault();
                $('#FilterFormBtn').attr('disabled', true);

                $(this)[0].submit();
            })
        </script>
    </x-slot>
</x-app-layout>
