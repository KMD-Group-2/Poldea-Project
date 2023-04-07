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
                    <span class="breadcrumb-item active">Ideas</span>
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
                    <div class="col-lg-3 col-md-4 d-none d-md-block">
                        <div class="card">
                            <div class="card-body inbox-panel">
                                <div class="list-group b-0 mail-list">
                                    <h4 class="card-title">Filter Setting</h4>
                                    <div>
                                        <hr class="m-t-0">
                                    </div>
                                    @if (count($academicYears) > 0 && (count($departments) > 0 || count($categories) > 0))
                                        @if (count($academicYears) > 0)
                                            <h5 class="card-title text-primary mb-0" data-toggle="collapse" data-target="#collapseAcademicYear" aria-expanded="false" aria-controls="collapseAcademicYear">Academic Years <i class="mdi mdi-chevron-down float-right mr-3"></i></h5>
                                            <div class="collapse show mt-3" id="collapseAcademicYear">
                                                @foreach ($academicYears as $year)
                                                    <a href="
                                                    @if ($request['c'] && $request['d'] )
                                                        {{ url()->current() . '?a=' . urlencode($year->academic_year) . '&c=' . urlencode($request['c']) . '&d=' . urlencode($request['d']) . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') . ($request['page'] ? '&page=' . $request['page'] : '') }}
                                                    @elseif ($request['c'])
                                                        {{ url()->current() . '?a=' . urlencode($year->academic_year) . '&c=' . urlencode($request['c']) . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') . ($request['page'] ? '&page=' . $request['page'] : '') }}
                                                    @elseif ($request['d'])
                                                        {{ url()->current() . '?a=' . urlencode($year->academic_year) . '&d=' . urlencode($request['d']) . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') . ($request['page'] ? '&page=' . $request['page'] : '') }}
                                                    @else
                                                        {{ url()->current() . '?a=' . urlencode($year->academic_year) . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') . ($request['page'] ? '&page=' . $request['page'] : '') }}
                                                    @endif
                                                    " class="list-group-item {{ $request['a'] ? ($request['a'] == $year->academic_year ? 'active' : '') : ($year->last ? 'active' : 'false') }}">
                                                        <span class="fa fa-circle text-warning m-r-10"></span>
                                                        <span class="text-primary">{{ $year->academic_year ?? '' }}</span>
                                                    </a>
                                                @endforeach
                                            </div>
                                            <div>
                                                <hr>
                                            </div>
                                        @endif
                                        @if (count($departments) > 0)
                                            <h5 class="card-title text-primary mb-0" data-toggle="collapse" data-target="#collapseDepartment" aria-expanded="false" aria-controls="collapseDepartment">Departments <i class="mdi mdi-chevron-down float-right mr-3"></i></h5>
                                            <div class="collapse show mt-3" id="collapseDepartment">
                                                <a href="
                                                @if ($request['a'] && $request['c'])
                                                    {{ url()->current() . '?a=' . urlencode($request['a']) . '&c=' . urlencode($request['c']) . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') . ($request['page'] ? '&page=' . $request['page'] : '') }}
                                                @elseif ($request['a'])
                                                    {{ url()->current() . '?a=' . urlencode($request['a']) . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') . ($request['page'] ? '&page=' . $request['page'] : '') }}
                                                @elseif ($request['c'])
                                                    {{ url()->current() . '?c=' . urlencode($request['c']) . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') . ($request['page'] ? '&page=' . $request['page'] : '') }}
                                                @else
                                                    {{ url()->current() . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') . ($request['page'] ? '&page=' . $request['page'] : '') }}
                                                @endif
                                                    " class="list-group-item {{ $request['d'] ? ($request['d'] == '' ? 'active' : '') : 'active' }}"><span
                                                        class="fa fa-circle text-success m-r-10"></span>
                                                    All Departments
                                                </a>
                                                @foreach ($departments as $department)
                                                    <a href="
                                                    @if ($request['a'] && $request['c'])
                                                        {{ url()->current() . '?a=' . urlencode($request['a']) . '&c=' . urlencode($request['c']) . '&d=' . urlencode($department->name) . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') . ($request['page'] ? '&page=' . $request['page'] : '') }}
                                                    @elseif ($request['a'])
                                                        {{ url()->current() . '?a=' . urlencode($request['a']) . '&d=' . urlencode($department->name) . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') . ($request['page'] ? '&page=' . $request['page'] : '') }}
                                                    @elseif ($request['c'])
                                                        {{ url()->current() . '?c=' . urlencode($request['c']) . '&d=' . urlencode($department->name) . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') . ($request['page'] ? '&page=' . $request['page'] : '') }}
                                                    @else
                                                        {{ url()->current() . '?d=' . urlencode($department->name) . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') . ($request['page'] ? '&page=' . $request['page'] : '') }}
                                                    @endif
                                                    " class="list-group-item {{ $request['d'] ? ($request['d'] == $department->name ? 'active' : '') : '' }}"><span
                                                            class="fa fa-circle text-info m-r-10"></span><span
                                                            class="text-primary">{{ $department->name ?? '' }}</span>
                                                        {{ $department->ideas_count == 0 ? '' : '('.$department->ideas_count.')' }}
                                                    </a>
                                                @endforeach
                                            </div>
                                            <div>
                                                <hr>
                                            </div>
                                        @endif
                                        @if (count($categories) > 0)
                                            <h5 class="card-title text-primary mb-0" data-toggle="collapse" data-target="#collapseCategory" aria-expanded="false" aria-controls="collapseCategory">Categories <i class="mdi mdi-chevron-down float-right mr-3"></i></h5>
                                            <div class="collapse show mt-3" id="collapseCategory">
                                                <a href="
                                                @if ($request['a'] && $request['d'])
                                                    {{ url()->current() . '?a=' . urlencode($request['a']) . '&d=' . urlencode($request['d']) . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') . ($request['page'] ? '&page=' . $request['page'] : '') }}
                                                @elseif ($request['a'])
                                                    {{ url()->current() . '?a=' . urlencode($request['a']) . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') . ($request['page'] ? '&page=' . $request['page'] : '') }}
                                                @elseif ($request['d'])
                                                    {{ url()->current() . '?d=' . urlencode($request['d']) . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') . ($request['page'] ? '&page=' . $request['page'] : '') }}
                                                @else
                                                    {{ url()->current() . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') . ($request['page'] ? '&page=' . $request['page'] : '') }}
                                                @endif
                                                " class="list-group-item {{ $request['c'] ? ($request['c'] == '' ? 'active' : '') : 'active' }}"><span
                                                        class="fa fa-circle text-success m-r-10"></span>
                                                    All Categories
                                                </a>
                                                @foreach ($categories as $category)
                                                    <a href="
                                                    @if ($request['a'] && $request['d'])
                                                        {{ url()->current() . '?a=' . urlencode($request['a']) . '&c=' . urlencode($category->name) . '&d=' . $request['d'] . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') . ($request['page'] ? '&page=' . $request['page'] : '') }}
                                                    @elseif ($request['a'])
                                                        {{ url()->current() . '?a=' . urlencode($request['a']) . '&c=' . urlencode($category->name) . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') . ($request['page'] ? '&page=' . $request['page'] : '') }}
                                                    @elseif ($request['d'])
                                                        {{ url()->current() . '?c=' . urlencode($category->name) . '&d=' . $request['d'] . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') . ($request['page'] ? '&page=' . $request['page'] : '') }}
                                                    @else
                                                        {{ url()->current() . '?c=' . urlencode($category->name) . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') . ($request['page'] ? '&page=' . $request['page'] : '') }}
                                                    @endif
                                                    " class="list-group-item {{ $request['c'] ? ($request['c'] == $category->name ? 'active' : '') : '' }}"><span
                                                            class="fa fa-circle text-info m-r-10"></span><span
                                                            class="text-primary">{{ $category->name ?? '' }}</span>
                                                        {{ $category->ideas_count == 0 ? '' : '('.$category->ideas_count.')' }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    @else
                                        <div class="row">
                                            <div class="col-md-12 align-self-center">
                                                <h5 class="card-title m-b-0 text-muted">No Filter Available!</h5>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-12 border-left">
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
                            <div class="btn-group m-b-10 m-r-10 d-block d-md-none" role="group"
                                aria-label="Button group with nested dropdown">

                                <button type="button" class="btn btn-secondary right-side-toggle"><i
                                        class="mdi mdi-filter-variant"></i>
                                    Filter</button>
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
                                                        {{ Carbon\Carbon::parse($idea->posted_at)->format('d M Y') }}</small>
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
                                                        <a href="javascript:void(0)" class="link m-r-10 cursor-default">
                                                            <i class="fas fa-comment-alt text-primary"></i>
                                                            {{ $idea->comments->count() }}
                                                            Comment{{ $idea->comments->count() > 1 ? 's' : '' }}
                                                        </a>
                                                        <a href="javascript:void(0)" class="link m-r-10 cursor-default">
                                                            <i class="fas fa-thumbs-up text-info"></i>
                                                            {{ $idea->like_unlikes->where('like_unlike', 1)->count() }}
                                                            Like{{ $idea->like_unlikes()->where('like_unlike', 1)->count() > 1? 's': '' }}
                                                        </a>
                                                        <a href="javascript:void(0)" class="link m-r-10 cursor-default">
                                                            <i class="fas fa-thumbs-down text-danger"></i>
                                                            {{ $idea->like_unlikes->where('like_unlike', 0)->count() }}
                                                            Unlike{{ $idea->like_unlikes->where('like_unlike', 0)->count() > 1 ? 's' : '' }}
                                                        </a>
                                                        <a href="javascript:void(0)" class="link m-r-10 cursor-default">
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
        <div class="right-sidebar" style="margin-top: 67px;">
            <div class="slimscrollright">
                <div class="rpanel-title bg-white text-dark pb-0">
                    <b>Filter Settings</b>
                    <span>
                        <i class="ti-close right-side-toggle"></i>
                    </span>
                    <hr>
                </div>
                <div class="r-panel-body mb-5 pt-0">
                    @if (count($academicYears) > 0 || count($departments) > 0 || count($categories) > 0)
                        @if (count($academicYears) > 0)
                            <h5 class="card-title text-primary mb-0" data-toggle="collapse" data-target="#collapseAcademicYear" aria-expanded="false" aria-controls="collapseAcademicYear">Academic Years <i class="mdi mdi-chevron-down float-right mr-3"></i></h5>
                            <div class="collapse show mt-3" id="collapseAcademicYear">
                                @foreach ($academicYears as $year)
                                    <a href="
                                    @if ($request['c'] && $request['d'] )
                                        {{ url()->current() . '?a=' . $year->academic_year . '&c=' . $request['c'] . '&d=' . $request['d'] . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') }}
                                    @elseif ($request['c'])
                                        {{ url()->current() . '?a=' . $year->academic_year . '&c=' . $request['c'] . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') }}
                                    @elseif ($request['d'])
                                        {{ url()->current() . '?a=' . $year->academic_year . '&d=' . $request['d'] . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') }}
                                    @else
                                        {{ url()->current() . '?a=' . $year->academic_year . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') }}
                                    @endif
                                    " class="list-group-item {{ $request['a'] ? ($request['a'] == $year->academic_year ? 'active' : '') : ($year->last ? 'active' : 'false') }}">
                                        <span class="fa fa-circle text-warning m-r-10"></span>
                                        <span class="text-primary">{{ $year->academic_year ?? '' }}</span>
                                    </a>
                                @endforeach
                            </div>
                            <div>
                                <hr>
                            </div>
                        @endif
                        @if (count($departments) > 0)
                            <h5 class="card-title text-primary mb-0" data-toggle="collapse" data-target="#collapseDepartment" aria-expanded="false" aria-controls="collapseDepartment">Departments <i class="mdi mdi-chevron-down float-right mr-3"></i></h5>
                            <div class="collapse show mt-3" id="collapseDepartment">
                                <a href="
                                @if ($request['a'] && $request['c'])
                                    {{ url()->current() . '?a=' . $request['a'] . '&c=' . $request['c'] . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') }}
                                @elseif ($request['a'])
                                    {{ url()->current() . '?a=' . $request['a'] . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') }}
                                @elseif ($request['c'])
                                    {{ url()->current() . '?c=' . $request['c'] . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') }}
                                @else
                                    {{ url()->current() . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') }}
                                @endif
                                    " class="list-group-item {{ $request['d'] ? ($request['d'] == '' ? 'active' : '') : 'active' }}"><span
                                        class="fa fa-circle text-success m-r-10"></span>
                                    All Departments
                                </a>
                                @foreach ($departments as $department)
                                    <a href="
                                    @if ($request['a'] && $request['c'])
                                        {{ url()->current() . '?a=' . $request['a'] . '&c=' . $request['c'] . '&d=' . $department->name . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') }}
                                    @elseif ($request['a'])
                                        {{ url()->current() . '?a=' . $request['a'] . '&d=' . $department->name . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') }}
                                    @elseif ($request['c'])
                                        {{ url()->current() . '?c=' . $request['c'] . '&d=' . $department->name . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') }}
                                    @else
                                        {{ url()->current() . '?d=' . $department->name . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') }}
                                    @endif
                                    " class="list-group-item {{ $request['d'] ? ($request['d'] == $department->name ? 'active' : '') : '' }}"><span
                                            class="fa fa-circle text-info m-r-10"></span><span
                                            class="text-primary">{{ $department->name ?? '' }}</span>
                                        ({{ $department->ideas_count ?? 0 }})
                                    </a>
                                @endforeach
                            </div>
                            <div>
                                <hr>
                            </div>
                        @endif
                        @if (count($categories) > 0)
                            <h5 class="card-title text-primary mb-0" data-toggle="collapse" data-target="#collapseCategory" aria-expanded="false" aria-controls="collapseCategory">Categories <i class="mdi mdi-chevron-down float-right mr-3"></i></h5>
                            <div class="collapse show mt-3" id="collapseCategory">
                                <a href="
                                @if ($request['a'] && $request['d'])
                                    {{ url()->current() . '?a=' . $request['a'] . '&d=' . $request['d'] . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') }}
                                @elseif ($request['a'])
                                    {{ url()->current() . '?a=' . $request['a'] . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') }}
                                @elseif ($request['d'])
                                    {{ url()->current() . '?d=' . $request['d'] . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') }}
                                @else
                                    {{ url()->current() . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') }}
                                @endif
                                " class="list-group-item {{ $request['c'] ? ($request['c'] == '' ? 'active' : '') : 'active' }}"><span
                                        class="fa fa-circle text-success m-r-10"></span>
                                    All Categories
                                </a>
                                @foreach ($categories as $category)
                                    <a href="
                                    @if ($request['a'] && $request['d'])
                                        {{ url()->current() . '?a=' . $request['a'] . '&c=' . $category->name . '&d=' . $request['d'] . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') }}
                                    @elseif ($request['a'])
                                        {{ url()->current() . '?a=' . $request['a'] . '&c=' . $category->name . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') }}
                                    @elseif ($request['d'])
                                        {{ url()->current() . '?c=' . $category->name . '&d=' . $request['d'] . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') }}
                                    @else
                                        {{ url()->current() . '?c=' . $category->name . ($request['sortby'] ? '&sortby=' . $request['sortby'] : '') }}
                                    @endif
                                    " class="list-group-item {{ $request['c'] ? ($request['c'] == $category->name ? 'active' : '') : '' }}"><span
                                            class="fa fa-circle text-info m-r-10"></span><span
                                            class="text-primary">{{ $category->name ?? '' }}</span>
                                        ({{ $category->ideas_count ?? 0 }})
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="row">
                            <div class="col-md-12 align-self-center">
                                <h5 class="card-title m-b-0 text-muted">No Filter Available!</h5>
                            </div>
                        </div>
                    @endif
                </div>
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

            window.onresize = function(event) {
                $(".right-sidebar").slideDown(50);
                $(".right-sidebar").removeClass("shw-rside");
            };
        </script>
    </x-slot>
</x-app-layout>
