<x-app-layout>
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <div class="d-flex justify-content-start align-items-center">
                    <nav class="breadcrumb">
                        <span class="breadcrumb-item">Staff</span>
                        <span class="breadcrumb-item active">Dashboard</span>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Column -->
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="d-flex flex-row no-block">
                        <div class="p-10 bg-warning rounded-left">
                            <h3 class="text-white box m-b-0"><i class="fas fa-thumbs-up"></i></h3>
                        </div>
                        <div class="align-self-center m-l-20">
                            <h3 class="m-b-0 text-warning">{{ $counts[0]->count }}/{{ $counts[1]->count }}</h3>
                            <h5 class="text-muted m-b-0">Like/Unlike</h5>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="d-flex flex-row no-block">
                        <div class="p-10 bg-primary rounded-left">
                            <h3 class="text-white box m-b-0"><i class="icons-Light-Bulb"></i></h3>
                        </div>
                        <div class="align-self-center m-l-20">
                            <h3 class="m-b-0 text-primary">{{ $counts[2]->count }}</h3>
                            <h5 class="text-muted m-b-0">Idea</h5>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-header" style="background-color:rgba(100, 97, 97, 0.03)">
                        <div class="card-title">Recent Idea Posts
                            <div class="card-actions">
                                <a href="{{ route('staff.ideas') }}" class="btn waves-effect waves-light btn-sm btn-secondary" style="width:100px;">Show All</a>
                            </div>
                        </div>
                    </div>
                    @foreach($recentIdeas as $idea)
                    <div class="card-body" onclick="location.href='{{ route('idea.detail', $idea->id) }}'" style="cursor:pointer;padding-bottom:5px;">
                        <div class="d-flex m-b-0">
                            <a href=""><img src="{{ ($idea->name=='anonymous')?asset('assets/images/anonymous.png'):$idea->photo }}" alt="user" class="img-circle" width="40"></a>
                            <div class="p-l-10" style="width:100%">
                                <div style="padding-bottom: 20px;"><h5 class="m-b-0"><span style="float:left; font-weight: normal;">{{ $idea->name }}</span><span class="btn waves-effect waves-light btn-xs btn-info" style="float:right">{{ $idea->category }}</span></h5></div>
                                <div><small class="text-muted">{{ $idea->department }}</small></div>
                                <div class="card-text">{{ $idea->title }}</div>
                                <div style="text-align:right;"><small class="text-muted">{{ Carbon\Carbon::parse($idea->posted_at)->format('d M Y g:i A') }}</small></div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <hr class="m-t-0 m-b-0">
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-header" style="background-color:rgba(100, 97, 97, 0.03)">
                        <div class="card-title">Recent Comments
                        </div>
                    </div>
                    @foreach($recentComments as $comment)
                    <div class="card-body" onclick="location.href='{{ route('idea.detail', $comment->id) }}'" style="cursor:pointer;padding-bottom:5px;">
                        <div class="d-flex m-b-0">
                            <a><img src="{{ ($comment->name=='anonymous')?asset('assets/images/anonymous.png'):$comment->photo }}" alt="user" class="img-circle" width="40"/></a>
                            <div class="p-l-10" style="width:100%">
                                <div style="padding-bottom: 20px;"><h5 class="m-b-0"><span style="float:left; font-weight: normal;">{{ $comment->name }}</span><span class="btn waves-effect waves-light btn-xs btn-info" style="float:right">{{ $comment->category }}</span></h5></div>
                                <div><small class="text-muted">{{ $comment->department }}</small></div>
                                <div class="card-text">{{ Str::limit($comment->comment, 100) }}</div>
                                <div style="text-align:right;"><small class="text-muted">{{ Carbon\Carbon::parse($comment->created_at)->format('d M Y g:i A') }}</small></div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <hr class="m-t-0 m-b-0">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>


        <!-- ============================================================== -->
        <!-- End Page Content -->
        <!-- ============================================================== -->
    </div>
    <x-slot name="script">
        <script>

        </script>
    </x-slot>
</x-app-layout>
