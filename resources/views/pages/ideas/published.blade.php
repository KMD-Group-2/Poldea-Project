@inject('request', 'Illuminate\Http\Request')

<x-app-layout>
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-5 align-self-center">
                <nav class="breadcrumb">
                    <span class="breadcrumb-item">{{ Auth::user()->roles()->first()->name }}</span>
                    <span class="breadcrumb-item active">Published Ideas</span>
                </nav>
            </div>
            <div class="col-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <a class="btn btn-info m-l-15" href="{{ route('staff.idea.add-info') }}"><i
                            class="fa fa-plus-circle"></i>
                        Create New Idea</a>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12 border-left">
                        <x-auth-session-status class="mb-4 alert alert-danger alert-rounded" :status="$errors->first('create-idea')" />

                        <div class="d-flex no-block justify-content-between align-items-center">
                            <div class="btn-group m-b-10 m-r-10" role="group"
                                aria-label="Button group with nested dropdown">

                                <button type="button" class="btn btn-secondary">Sort by</button>

                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ $request['sortby'] ? ($request['sortby'] == 'most_popular' ? 'Most Popular Ideas' : ($request['sortby'] == 'most_viewed' ? 'Most Viewed Ideas' : 'Latest Ideas')) : 'Latest Ideas' }}
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                        <a class="dropdown-item" href="{{ $filterArray[0] }}">Latest Ideas</a>
                                        <a class="dropdown-item" href="{{ $filterArray[1] }}">Most Popular Ideas</a>
                                        <a class="dropdown-item" href="{{ $filterArray[2] }}">Most Viewed Ideas</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-2">
                            @if (count($ideas) > 0)
                                @foreach ($ideas as $idea)
                                    <div class="card b-all shadow-none">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-8 align-self-center">
                                                    <h5 class="card-title m-b-0">{{ $idea->title ?? '' }}</h5>
                                                </div>
                                                <div class="col-md-4 align-self-center text-left text-md-right mt-2">
                                                    @if (count($idea->documents) > 0)
                                                        @php
                                                            $file_count = $idea->documents->whereIn('type', config('app.file_type'))->count();
                                                            $image_count = $idea->documents->whereIn('type', config('app.image_type'))->count();
                                                        @endphp
                                                        <span class="label label-info m-r-10">
                                                            <i class="fa fa-paperclip mr-2"></i>
                                                            {{ $image_count > 0 ? $image_count . ' photo' : '' }}{{ $image_count > 1 ? 's' : '' }}
                                                            {{ $image_count > 0 && $file_count > 0 ? ', ' : '' }}
                                                            {{ $file_count > 0 ? $file_count . ' file' : '' }}{{ $file_count > 1 ? 's' : '' }}
                                                        </span>
                                                    @endif
                                                    <span
                                                        class="label label-info m-r-10">{{ $idea->category->name ?? '' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <hr class="m-t-0">
                                        </div>
                                        <div class="card-body p-t-0">
                                            <div class="row m-b-10">
                                                <div class="col-md-8 d-flex no-block">
                                                    <div class="align-self-center">
                                                        <a href="javascript:void(0)"><img
                                                                src="{{ ($idea->anonymous)?url('assets/images/anonymous.png'):($idea->user->staff->photo ?? url('assets/images/default-user.png')) }}"
                                                                alt="user" width="40" class="img-circle" /></a>
                                                    </div>
                                                    <div class="p-l-10">
                                                        <h6 class="m-b-0">{{ ($idea->anonymous)?"anonymous":$idea->user->staff->name }}</h6>
                                                        <small class="text-muted">
                                                            Job Title: {{ $idea->user->staff->position->name ?? '' }} /
                                                            Department: {{ $idea->user->staff->department->name ?? '' }}
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 align-self-center text-left text-md-right mt-2 mt-md-0">
                                                    <small class="text-muted">Published at:
                                                        {{ Carbon\Carbon::parse($idea->posted_at)->format('d M Y') }} | Academic Year: {{ $idea->academic_year->academic_year }}</small>
                                                </div>
                                            </div>
                                            <div class="mb-2 cut-text">
                                                {!! $idea->description !!}
                                            </div>
                                            <div>
                                                <hr class="m-t-0">
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8 align-self-center">
                                                    <div class="like-comm">
                                                        <a href="javascript:void(0)" class="link m-r-10">
                                                            <i class="fas fa-comment-alt text-primary"></i>
                                                            {{ $idea->comments->count() }}
                                                            Comment{{ $idea->comments->count() > 1 ? 's' : '' }}
                                                        </a>
                                                        <a href="javascript:void(0)" class="link m-r-10">
                                                            <i class="fas fa-thumbs-up text-info"></i>
                                                            {{ $idea->like_unlikes->where('like_unlike', 1)->count() }}
                                                            Like{{ $idea->like_unlikes()->where('like_unlike', 1)->count() > 1? 's': '' }}
                                                        </a>
                                                        <a href="javascript:void(0)" class="link m-r-10">
                                                            <i class="fas fa-thumbs-down text-danger"></i>
                                                            {{ $idea->like_unlikes->where('like_unlike', 0)->count() }}
                                                            Unlike{{ $idea->like_unlikes->where('like_unlike', 0)->count() > 1 ? 's' : '' }}
                                                        </a>
                                                        <a href="javascript:void(0)" class="link m-r-10">
                                                            <i class="fas fa-eye text-cyan"></i>
                                                            {{ $idea->views->count() }}
                                                            View{{ $idea->views->count() > 1 ? 's' : '' }}
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 align-self-center text-left text-md-right mt-2 mt-md-0">
                                                    <a class="text-info"
                                                        href="{{ route('idea.detail', $idea->id) }}"><span
                                                            class="hide-menu">View
                                                            Detail</span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="card b-all shadow-none">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 align-self-center">
                                                <h5 class="card-title m-b-0">No data Available!</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mt-2 d-flex justify-content-center justify-content-md-end align-items-center no-block">
                            {{ $ideas->links('vendor.pagination.bootstrap4-pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
    </div>
</x-app-layout>
