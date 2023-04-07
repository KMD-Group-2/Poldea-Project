<x-app-layout>
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <div class="d-flex justify-content-start align-items-center">
                    <nav class="breadcrumb">
                        <span class="breadcrumb-item">QA Coordinator</span>
                        <span class="breadcrumb-item active">Staff</span>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row" style="padding-bottom:30px;">
                            <div class="col-md-12 align-self-center text-right">
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
                                        <th>Staff Name</th>
                                        <th>Email</th>
                                        <th>Department</th>
                                        <th>Job Title</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Participation</th>
                                        <th>Created Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($staffs->total() > 0)
                                        @foreach ($staffs as $staff)
                                            <tr>
                                                <td><img src="{{ $staff->photo ?? '' }} " alt="staff" class=""
                                                        style="width:36px;"> {{ $staff->name }}</td>
                                                <td>{{ $staff->email }}</td>
                                                <td>{{ $staff->department->name }}</td>
                                                <td>{{ $staff->position->name }}</td>
                                                <td>{{ $staff->phone }}</td>
                                                <td>{{ $staff->address }}</td>
                                                <td>
                                                    <span class="label label-info">
                                                        {{ $staff->ideaCount() }}
                                                        Idea{{ $staff->ideaCount() > 1 ? 's' : '' }}                                                      
                                                    </span>
                                                    <span class="label label-info">
                                                        {{ $staff->commentCount() }}
                                                        Comment{{ $staff->commentCount() > 1 ? 's' : '' }}
                                                    </span>
                                                </td>
                                                <td>{{ Carbon\Carbon::parse($staff->created_at)->format('d M Y') }}</td>
                                                <td>
                                                    <a href="{{ route('qa_c.staff.idea.list', $staff->id) }}"
                                                        class="btn waves-effect waves-light btn-rounded btn-sm btn-tag-secondary-blue">View
                                                        Ideas</a>
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
</x-app-layout>
