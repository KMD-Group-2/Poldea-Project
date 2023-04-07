<x-app-layout>
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <div class="d-flex justify-content-start align-items-center">
                    <nav class="breadcrumb">
                        <span class="breadcrumb-item">{{ Auth::user()->roles()->first()->name }}</span>
                        <span class="breadcrumb-item active">Draft Idea</span>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                    @if (count($ideas) > 0)
                        <div class="row">
                            <div class="col-md-5 align-self-center">
                                
                            </div>
                            <div class="col-md-7 align-self-center text-right">
                                <div
                                    class="d-flex w-100 justify-content-center justify-content-md-end align-items-center">
                                    <div
                                        class="d-flex justify-content-center justify-content-md-end align-items-center">
                                        <span>Showing
                                            1
                                            to
                                            {{ count($ideas) }} of
                                            {{ count($ideas) }} results</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                        <div class="ribbon-wrapper px-0">
                            <div class="table-responsive mt-2">
                                <table id="myTable" class="table table-striped selected-table">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Acadamic Year</th>
                                            <th>Idea Title</th>
                                            <th>Description</th>
                                            <th class="text-center">Created Date</th>
                                            <th class="text-center">Closure Date</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($ideas) > 0)
                                            @foreach ($ideas as $idea)
                                                <tr>
                                                    <td>
                                                        <span class="label label-info">{{ $idea->category }}</span>
                                                    </td>
                                                    <td>
                                                        {{ $idea->academic_year }}
                                                    </td>
                                                    <td>
                                                        {{ Str::limit($idea->title, 20)  }}
                                                    </td>
                                                    <td>
                                                        {!! Str::limit($idea->description, 20) !!}
                                                    </td>
                                                    <td>
                                                        {{ Carbon\Carbon::parse($idea->created_at)->format('d M Y') }}
                                                    </td>
                                                    <td>
                                                        {{ Carbon\Carbon::parse($idea->closure_date)->format('d M Y') }}
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('staff.idea.add-info', $idea->id) }}"
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
    <x-slot name="script">
        <script>
            
        </script>
    </x-slot>
</x-app-layout>
