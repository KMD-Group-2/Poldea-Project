<x-app-layout>
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <div class="d-flex justify-content-start align-items-center">
                    <nav class="breadcrumb">
                        <span class="breadcrumb-item">Admin</span>
                        <span class="breadcrumb-item active">Dashboard</span>
                    </nav>
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
            <!-- Column -->
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="d-flex flex-row no-block">
                        <div class="p-10 bg-warning rounded-left">
                            <h3 class="text-white box m-b-0"><i class="fa fa-boxes"></i></h3>
                        </div>
                        <div class="align-self-center m-l-20">
                            <h3 class="m-b-0 text-warning">{{ $counts[0]->count }}</h3>
                            <h5 class="text-muted m-b-0">Department</h5>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="d-flex flex-row no-block">
                        <div class="p-10 bg-info rounded-left">
                            <h3 class="text-white box m-b-0"><i class="mdi mdi-account-card-details"></i></h3>
                        </div>
                        <div class="align-self-center m-l-20">
                            <h3 class="m-b-0 text-info">{{ $counts[1]->count }}</h3>
                            <h5 class="text-muted m-b-0">Staff</h5>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="d-flex flex-row no-block">
                        <div class="p-10 bg-success rounded-left">
                            <h3 class="text-white box m-b-0"><i class="icon-user"></i></h3>
                        </div>
                        <div class="align-self-center m-l-20">
                            <h3 class="m-b-0 text-success">{{ $counts[2]->count }}</h3>
                            <h5 class="text-muted m-b-0">User</h5>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="d-flex flex-row no-block">
                        <div class="p-10 bg-primary rounded-left">
                            <h3 class="text-white box m-b-0"><i class="icons-Light-Bulb"></i></h3>
                        </div>
                        <div class="align-self-center m-l-20">
                            <h3 class="m-b-0 text-primary">{{ $counts[3]->count }}</h3>
                            <h5 class="text-muted m-b-0">Idea</h5>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <figure class="highcharts-figure">
                    <div id="container1"></div>
                </figure>
            </div>

            <div class="col-lg-6 col-md-6">
                <figure class="highcharts-figure">
                    <div id="container2"></div>
                </figure>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-header" style="background-color:rgba(100, 97, 97, 0.03)">
                        <div class="card-title">Recent Ideas
                            <div class="card-actions">
                                <a href="{{ route('admin.idea_report') }}?date_range=&status=&post_type=all" class="btn waves-effect waves-light btn-sm btn-secondary" style="width:100px;">Show All</a>
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
                                <div class="card-text">{{ Str::limit($comment->comment, 100)   }}</div>
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
            // Data retrieved from https://netmarketshare.com/
            // Build the chart
            Highcharts.chart('container1', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'variablepie'
                },
                title: {
                    text: 'Published Ideas by Department',
                    align: 'left'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}</b> (<b>{point.percentage:.1f}%)</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: true
                    }
                },
                series: [{
                    minPointSize: 10,
                    innerSize: '20%',
                    zMin: 0,
                    name: 'Posted Idea',
                    data: [
                        @foreach($ideaCountByDeparment as $item)
                        {
                            name: '{{ $item->name }}',
                            y: {{ $item->count }},
                            z: {{ rand(240,90) }}
                        },
                        @endforeach
                    ]
                }]
            });

            Highcharts.chart('container2', {
                chart: {
                    type: 'column',
                },

                title: {
                    text: 'Ideas and Comments Comparison by Each Department',
                    align: 'left'
                },

                xAxis: {
                    categories: [
                        @foreach($ideaAndcommentCountByDepartment as $department)
                            '{{ $department->name }}',
                        @endforeach
                    ]
                },

                yAxis: [{ // Primary axis
                    className: 'highcharts-custom-color-0',
                    title: {
                        text: 'Idea'
                    },
                    allowDecimals: false
                }, { // Secondary axis
                    className: 'highcharts-custom-color-1',
                    opposite: true,
                    title: {
                        text: 'Comment'
                    },
                    allowDecimals: false
                }],

                plotOptions: {
                    column: {
                        borderRadius: 5
                    }
                },

                legend: {
                    align: 'center',
                    verticalAlign: 'top',
                    x: 0,
                    y: 0
                },

                series: [{
                    name: 'Idea',
                    data: [
                        @foreach($ideaAndcommentCountByDepartment as $idea)
                            {{ $idea->idea_count }},
                        @endforeach
                    ]
                }, {
                    name: 'Comment',
                    data: [
                        @foreach($ideaAndcommentCountByDepartment as $comment)
                            {{ $comment->comment_count }},
                        @endforeach
                    ],
                    yAxis: 1
                }]

                });

        </script>
    </x-slot>
</x-app-layout>
