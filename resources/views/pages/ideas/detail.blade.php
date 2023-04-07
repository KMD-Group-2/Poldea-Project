<x-app-layout>
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-12 align-self-center">
                <nav class="breadcrumb">
                    <span class="breadcrumb-item">{{ Auth::user()->roles()->first()->name }}</span>
                    <span class="breadcrumb-item"><a href="{{ url()->previous() }}">Ideas</a></span>
                    <span class="breadcrumb-item active">Detail</span>
                </nav>
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
                <div class="">
                    <div class="p-t-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8 align-self-center">
                                    <h5 class="card-title m-b-0" style="font-weight:bold;">{{ $idea->title }}</h5>
                                </div>
                                <div class="col-md-4 align-self-center text-left text-md-right mt-2">
                                    @if (count($images) > 0 || count($files) > 0)
                                        <span class="label label-info m-r-10"><i
                                                class="fa fa-paperclip mr-2"></i>{{ count($images) }}
                                            photo{{ count($images) > 1 ? 's' : '' }}
                                            , {{ count($files) }} file{{ count($files) > 1 ? 's' : '' }} </span>
                                    @endif
                                    <span class="label label-info m-r-10">{{ $idea->category }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-t-0">
                            <div>
                                <hr class="m-t-0">
                            </div>
                            <div class="row m-b-10">
                                <div class="col-md-8 d-flex no-block">
                                    <div class="align-self-center">
                                        <a href="javascript:void(0)"><img src="{{ ($idea->anonymous==1)?asset('assets/images/anonymous.png'):$staff->photo }}" alt="user"
                                                width="40" class="img-circle" /></a>
                                    </div>
                                    <div class="p-l-10">
                                        <h6 class="m-b-0">{{ ($idea->anonymous==1)?"anonymous":$staff->name }}</h6>
                                        <small class="text-muted">{{ $department->name }}</small>
                                    </div>
                                </div>
                                <div class="col-md-4 align-self-center text-left text-md-right mt-2">
                                    <small class="text-muted">Published at: {{ Carbon\Carbon::parse($idea->posted_at)->format('d M Y g:i A') }}</small>
                                </div>
                            </div>
                            <area>{!! $idea->description !!} </p>

                            @if (count($images) > 0)
                                <div class="row m-t-40">
                                    <!-- Carousel -->
                                    <div class="carousel-wrap">
                                        <div class="owl-carousel owl-theme">
                                            @php
                                                $index = 0;
                                            @endphp
                                            @foreach ($images as $image)
                                                <div class="item">
                                                    <a href="{{ asset($image->file_path) }}"
                                                        title="{{ $image->file_name }}" id="{{ $image->file_path }}"
                                                        class="zoom-popup">
                                                        <img src="{{ asset($image->file_path) }}"
                                                            class="mx-auto d-block rounded"
                                                            width="200px"
                                                            height="200px">
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class=" m-t-40 m-l-40 m-r-40">
                            @if (count($files) > 0)
                                <div class="row m-l-10 m-r-10">
                                    @foreach ($files as $file)
                                        <div class="col-md-6 col-lg-6 col-xl-3 px-2">
                                            <div class="card card-body p-10 rounded-lg">
                                                <div class="row align-items-center">
                                                    <div class="col-sm-4 col-lg-3 text-center">
                                                        <a href="#"><img
                                                                src="{{ ($file->type=='pdf')?asset('assets/images/pdf.svg'):asset('assets/images/ic-doc-file.svg') }}"
                                                                width="41" alt="docs"
                                                                class="img-circle img-fluid"></a>
                                                    </div>
                                                    <div class="col-sm-6 col-lg-7">
                                                        <small
                                                            class="text-muted">{{ $file->file_name }}.{{ $file->type }}</small>
                                                        <br>
                                                        <small class="text-muted">{{ Carbon\Carbon::parse($file->created_at)->format('d M Y g:i A')  }}</small>
                                                    </div>
                                                    <div class="col-sm-2 col-lg-2 text-center">
                                                        <a href="{{ $file->file_path }}"><img
                                                                src="{{ asset('assets/images/ic-doc-download.svg') }}"
                                                                width="18" alt="docs-download"
                                                                class=" img-fluid"></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            </div>
                            <div>
                                <hr class="m-t-0 m-t-40">
                            </div>

                            <div class="row m-t-30 m-l-5">
                                <div class="col-md-8 align-self-center">
                                    <div class="like-comm">
                                            <a class="link m-r-10">
                                                <i class="fas fa-comment-alt text-primary mr-2"></i>
                                                <span id = "commentCount">
                                                    {{ $comment->comment_count }}
                                                    comment{{ $comment->comment_count > 1 ? 's' : '' }}
                                                </span>
                                            </a>
                                            @if($alreadyVote=="novote" || $alreadyVote=="unlike")
                                                <a onclick="sendLike(1)" class="link m-r-10" style="cursor:pointer" id="a_like">
                                            @else
                                                <a onclick="#" class="link m-r-10" id="a_like">
                                            @endif
                                                <i class="fas fa-thumbs-up text-info mr-2"></i>
                                                <span id = "likeCount">
                                                    {{ $like->like_count }}
                                                    like{{ $like->like_count > 1 ? 's' : '' }}
                                                </span>
                                            </a>
                                            @if($alreadyVote=="novote" || $alreadyVote=="like")
                                                <a onclick="sendLike(0)" class="link m-r-10" style="cursor:pointer" id="a_unlike">
                                            @else
                                                <a onclick="#" class="link m-r-10" id="a_unlike">
                                            @endif
                                                <i class="fas fa-thumbs-down text-danger mr-2"></i>
                                                <span id = "unlikeCount">
                                                    {{ $unlike->unlike_count }}
                                                    unlike{{ $unlike->unlike_count > 1 ? 's' : '' }}
                                                </span>
                                            </a>
                                            <a class="link m-r-10">
                                                <i  class="fas fa-eye text-cyan mr-2"></i>
                                                <span id = "viewCount">
                                                    {{ $view->view_count }}
                                                    view{{ $view->view_count > 1 ? 's' : '' }}
                                                </span>
                                            </a>
                                        </div>
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center mt-100 m-t-30">
                                <div class="col-lg-12">
                                    <div class="card">

                                            <div class="card-body text-start">
                                                <h5 class="card-title">Comments</h5>
                                            </div>
                                            <div class="comment-widgets" id="commentList">
                                            @if (count($comments) > 0)
                                                @foreach ($comments as $comment)
                                                    <div class="d-flex flex-row comment-row m-t-0 no-block">
                                                        <div class="p-2">
                                                            <img src="{{ ($comment->photo=='')?asset('assets/images/anonymous.png'):$comment->photo }}" alt="" width="50" class="rounded-circle">
                                                        </div>
                                                        <div class="comment-text w-100">
                                                            <div class="d-flex no-block justify-content-between align-items-center mb-2">
                                                                <h6 class="font-medium mb-0">{{ $comment->name }}</h6>
                                                                <span class="text-muted">{{ Carbon\Carbon::parse($comment->created_at)->format('d M Y g:i A')  }}</span>
                                                            </div>
                                                            <span class="m-b-15 d-block">{{ $comment->comment }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                            </div>
                                            @hasrole('Staff')
                                            <div class="comment-footer bg-comment-white">
                                                <div
                                                    class="d-flex flex-row bg-comment-box add-comment-section p-2 mx-3 my-2 no-block">
                                                    <input type="text" id="txtComment" style="border:none"
                                                        class="form-control bg-comment mr-3 pt-4 pb-4"
                                                        placeholder="Type your comment">
                                                    <div class="dropdown show px-md-4 py-2 dropup">
                                                        <a class="btn btn-primary dropdown-toggle" href="#"
                                                            role="button" id="dropdownMenuLink" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            Send
                                                        </a>

                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left"
                                                            aria-labelledby="dropdownMenuLink">
                                                            <a class="dropdown-item" onclick="sendComment(0)" style="cursor:pointer"
                                                                role="menuitem" data-publish="author">Send as Author</a>
                                                            <a class="dropdown-item" onclick="sendComment(1)" style="cursor:pointer"
                                                                role="menuitem" data-publish="anonymous">Send as Anonymous</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endrole
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>


        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->

    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function() {
                if("{{ $role }}"=="Staff"){
                    increaseViewCount();
                }
                var owl = $('.owl-carousel').owlCarousel({
                    loop: false,
                    margin: 10,
                    nav: true,
                    dots: false,
                    navText: ["<div class='nav-btn prev-slide'></div>",
                        "<div class='nav-btn next-slide'></div>"
                    ],
                    responsive: {
                        0: {
                            items: 1
                        },
                        600: {
                            items: 2
                        },
                        1000: {
                            items: 3
                        },
                        1300: {
                            items: 4
                        },
                        1400: {
                            items: 5
                        }
                    }
                })

                $('.owl-carousel').magnificPopup({
                    delegate: 'a',
                    type: 'image',
                    closeOnContentClick: false,
                    closeBtnInside: false,
                    mainClass: 'mfp-with-zoom mfp-img-mobile',
                    gallery: {
                        enabled: true
                    },
                    zoom: {
                        enabled: true,
                        duration: 300, // don't foget to change the duration also in CSS
                        opener: function(element) {
                            return element.find('img');
                        }
                    }
                });

            });

            function sendComment(anonymous){
                if("{{ $role }}"=="Staff"){
                    if($("#txtComment").val().trim()!=""){
                        var idea_id = {{ $idea->id }};
                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            data: { idea_id: idea_id, comment: $("#txtComment").val(), anonymous: anonymous},
                            url:"{{ route('staff.idea.add-comment') }}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            success:function(data){
                                if(data.status=="success"){
                                    $("#commentCount").text(data.comment_count + " comment" + ((parseInt(data.comment_count)>1)?"s":""));
                                    $("#commentList").empty();
                                    $.each(data.comments, function (i, o) {
                                        $("#commentList").append("<div class='d-flex flex-row comment-row m-t-0 no-block'><div class='p-2'><img src='" + ((o.photo=="")?"{{ asset('assets/images/anonymous.png') }}":o.photo) + "' alt='' width='50' class='rounded-circle'></div><div class='comment-text w-100'><div class='d-flex no-block justify-content-between align-items-center mb-2'><h6 class='font-medium mb-0'>" + o.name + "</h6><span class='text-muted'>" + moment(o.created_at).format("DD MMMM YYYY, hh:mm A")  +"</span></div><span class='m-b-15 d-block'>" + o.comment + "</span></div></div>");
                                    });
                                    $("#txtComment").val("");
                                }
                            }
                        });
                    }else{
                        alert("Comment shouldn't be empty!");
                    }
                }
            }

            function sendLike(likeunlike){
                if("{{ $role }}"=="Staff"){
                    var idea_id = {{ $idea->id }};
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        data: { idea_id: idea_id, likeunlike: likeunlike},
                        url:"{{ route('staff.idea.add-like') }}",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success:function(data){
                            if(data.status=="success"){
                                $("#likeCount").text(data.like_count + " like" + ((parseInt(data.like_count)>1)?"s":""));
                                $("#unlikeCount").text(data.unlike_count + " unlike" + ((parseInt(data.unlike_count)>1)?"s":""));
                                if(likeunlike==1){
                                    $("#a_like").attr("onclick","#");
                                    $("#a_unlike").attr("onclick","sendLike(0)");
                                    $("#a_like").css('cursor', '');
                                    $("#a_unlike").css('cursor', 'pointer');
                                }else{
                                    $("#a_unlike").attr("onclick","#");
                                    $("#a_like").attr("onclick","sendLike(1)");
                                    $("#a_unlike").css('cursor', '');
                                    $("#a_like").css('cursor', 'pointer');
                                }
                            }
                        }
                    });
                }
            }

            function increaseViewCount(){
                var idea_id = {{ $idea->id }};
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    data: { idea_id: idea_id},
                    url:"{{ route('staff.idea.increase-view-count') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success:function(data){
                        $("#viewCount").text(data.view_count + " view" + ((parseInt(data.view_count)>1)?"s":""));
                    }
                });
            }
        </script>
    </x-slot>

</x-app-layout>
