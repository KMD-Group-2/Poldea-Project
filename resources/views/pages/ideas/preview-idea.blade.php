<x-app-layout>
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <div class="d-flex justify-content-start align-items-center">
                    <nav class="breadcrumb">
                        <a class="breadcrumb-item" href="{{ route('staff.dashboard') }}">Ideas</a>
                        <a class="breadcrumb-item" href="javascript:void(0)">Idea Submission Form</a>
                        <a class="breadcrumb-item" href="{{ route('staff.idea.add-info', $idea->id) }}">Add
                            Information</a>
                        <a class="breadcrumb-item" href="{{ route('staff.idea.upload-file', $idea->id) }}">Upload
                            Files</a>
                        <span class="breadcrumb-item active">Preview and Publish Post</span>
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

        <!-- Validation wizard -->
        <div class="row" id="validation">
            <div class="col-12">
                <div class="wizard-content">
                    <div>
                        <form action="{{ route('staff.idea.publish') }}" method="POST"
                            class="validation-wizard wizard-circle">
                            @csrf

                            <input type="hidden" name="idea_id" value="{{ $idea->id }}">
                            <!-- Step 1 -->
                            <h6>Add Information</h6>
                            <section></section>
                            <!-- Step 2 -->
                            <h6>Upload Files</h6>
                            <section></section>
                            <!-- Step 3 -->
                            <h6>Preview and Publish Post</h6>
                            <section>
                                @if (Carbon\Carbon::parse($idea->academic_year->closure_date)->diffInDays(Carbon\Carbon::now()) < 6)
                                    <div class="alert alert-danger">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span> </button>
                                        <i class="fa fa-exclamation-triangle"></i>
                                        <span class="ml-2">The closure date is only
                                            {{ Carbon\Carbon::parse($idea->academic_year->closure_date)->diffInDays(Carbon\Carbon::now()) }}
                                            days away. Please publish before closure date.</span>
                                    </div>
                                @endif

                                <div class="alert alert-danger error-message d-none">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span> </button>
                                    <i class="fa fa-exclamation-triangle"></i>
                                    <span class="message"></span>
                                </div>

                                <div class="card radius mb-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8 align-self-center d-flex no-block">
                                                <h5 class="card-title">{{ $idea->title ?? '' }} </h5>
                                                <span class="card-title label label-success ml-3">Preview</span>
                                            </div>
                                            <div class="col-md-4 align-self-center text-md-right">
                                                <span
                                                    class="card-title label label-info">{{ $idea->category->name ?? '' }}</span>
                                            </div>
                                        </div>
                                        <hr class="m-t-0">
                                        <div class="p-t-0">
                                            <div class="row m-b-10">
                                                <div class="col-md-8 d-flex no-block">
                                                    <div class="align-self-center">
                                                        <a href="javascript:void(0)"><img
                                                                src="{{ asset('assets/images/default-user.png') }}"
                                                                alt="user" width="40" class="img-circle" /></a>
                                                    </div>
                                                    <div class="p-l-10">
                                                        <h6 class="m-b-0">{{ Auth::user()->staff->name ?? '' }}
                                                        </h6>
                                                        <small
                                                            class="text-muted">{{ Auth::user()->staff->position->name ?? '' }}</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 align-self-center text-left text-md-right mt-2">
                                                    <small class="text-muted">Created:
                                                        {{ Carbon\Carbon::parse($idea->created_at)->format('d M Y') }}
                                                    </small>
                                                </div>
                                            </div>
                                            <div>{!! $idea->description ?? '' !!}</div>

                                            @if (count($idea->documents->whereIn('type', ['png', 'jpg', 'jpeg'])) > 0)
                                                <div class="row m-t-40">
                                                    <!-- Carousel -->
                                                    <div class="carousel-wrap">
                                                        <div class="owl-carousel owl-theme">
                                                            @php
                                                                $index = 0;
                                                            @endphp
                                                            @foreach ($idea->documents->whereIn('type', ['png', 'jpg', 'jpeg'])->sortByDesc('id') as $image)
                                                                <div class="item">
                                                                    <a href="{{ asset($image->file_path) }}"
                                                                        title="{{ $image->file_name }}"
                                                                        id="{{ $image->file_path }}"
                                                                        class="zoom-popup">
                                                                        <img src="{{ asset($image->file_path) }}"
                                                                            class="mx-auto d-block rounded"
                                                                            alt="{{ $image->file_path }}"
                                                                            width="200px" height="200px">
                                                                    </a>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if (count($idea->documents->whereIn('type', ['doc', 'docx', 'pdf'])) > 0)
                                                <div class="row mt-5 files-area">
                                                    @foreach ($idea->documents->whereIn('type', ['doc', 'docx', 'pdf']) as $file)
                                                        <div class="file-area col-md-6 col-lg-4 col-xl-4 mb-4"
                                                            data-entry-id="{{ $file->id }}">
                                                            <div class="file-tag border">
                                                                <div class="d-flex no-block py-2 px-3">
                                                                    <div
                                                                        class="file-image rounded-circle d-flex no-block align-items-center justify-content-center">
                                                                        @if ($file->type == 'pdf')
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                width="48" height="48"
                                                                                xml:space="preserve" version="1.1"
                                                                                viewBox="0 0 48 48">
                                                                                <image width="48" height="48"
                                                                                    xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAABvUlEQVR4nO3XTUsCQRgH8P0qWYe+QwZdgqBDL4dWqEuHDklBBYIGUUFQp7xEEHWMLlGdgkCJojCUUguDIvE1qEnoCwT+Y3xclrUtiGXGteaBB31mHPDn/ndBTVOlSmxB90BIj7SttSygOtklDwEBgI+HNKp+rxyEEAB7kYeAKIAsBEQCmASEcAATjJACYAIR0gBMEEIqgAlASAcwK8KVgN+0pgC6ugJQEXJSKkK6ipCz+psRmusDigWznx6ByD5g/FUMDlj3kzFgfdo8vzJu3S/We7ZXEiDQD1TegfIzcHEC3MZpvk8Do53A/DDNpRIQiwDlMs2bITq/OkFzPkvnjfZ3Swakrmj2tQPXl7S2PGYCEme0P9UDsApQyNFnDUD0oEkRagTwPt6ltfDMVwDvTJLWeMxcA8ik6P2ij+LA1/hsB0ic01pw0D5Ch9tNADS28SXsAHEbwOubeQPze0U6IJcF9sLA1gIQGjL37QB3N/UIeV16D+ie7wE897Vfuwj4OloIkM8Dp0f0yuedJetjNOp2QC3nFXoCbQTM/aYDdHmtKYCurgBUhJyUipCuIuSsVIR0FaF/HiFVqrQf6xPo5lRgsHhigAAAAABJRU5ErkJggg==" />
                                                                            </svg>
                                                                        @else
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                x="0px" y="0px" width="48"
                                                                                height="48" viewBox="0 0 48 48">
                                                                                <path fill="#2196f3"
                                                                                    d="M37,45H11c-1.657,0-3-1.343-3-3V6c0-1.657,1.343-3,3-3h19l10,10v29C40,43.657,38.657,45,37,45z">
                                                                                </path>
                                                                                <path fill="#bbdefb" d="M40 13L30 13 30 3z">
                                                                                </path>
                                                                                <path fill="#1565c0" d="M30 13L40 23 40 13z">
                                                                                </path>
                                                                                <path fill="#e3f2fd"
                                                                                    d="M15 23H33V25H15zM15 27H33V29H15zM15 31H33V33H15zM15 35H25V37H15z">
                                                                                </path>
                                                                            </svg>
                                                                        @endif
                                                                    </div>
                                                                    <div class="d-flex flex-column ml-3 no-block w-100"
                                                                        style="flex-grow: 1; min-width: 0;">
                                                                        <p class="mb-0 file-name">
                                                                            {{ $file->file_name }}.{{ $file->type }}</p>
                                                                        <span
                                                                            class="text-muted created-at">{{ Carbon\Carbon::parse($file->created_at)->format('d M Y, g:i A') }}</span>
                                                                    </div>
                                                                    <div
                                                                        class="delete-file-content px-3 d-flex no-block align-items-center justify-content-end">
                                                                        <a href="javascript:void(0)"
                                                                            style="cursor: not-allowed"
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            title="Preview Only"><img
                                                                                src="{{ asset('assets/images/ic-doc-download.svg') }}"
                                                                                width="30" alt="docs-download"
                                                                                class="img-fluid"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="card radius my-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 align-self-center">
                                                <h5 class="card-title">Academic Closure Date </h5>
                                            </div>
                                        </div>
                                        <hr class="m-t-0">
                                        <div class="content">
                                            <p class="mb-0">Idea Closure Date:
                                                <b>{{ $idea->academic_year->closure_date }}</b>
                                            </p>
                                            <p class="mb-0 text-danger">Note - Idea can be publish before academic year
                                                closure date.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="card radius my-4 term-condition">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 align-self-center">
                                                <h5 class="card-title">Terms and Conditions</h5>
                                            </div>
                                        </div>
                                        <hr class="m-t-0">
                                        <div class="content">
                                            {!! __('TermAndCondition.content') !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex no-block mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" name="term-condition" type="checkbox"
                                            value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            I agree Terms and
                                            Conditions
                                        </label>
                                    </div>
                                </div>
                            </section>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->

        <div class="d-none dropdown-area">
            <div class="dropdown show">
                <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Publish
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem" data-publish="author">Publish
                        as
                        Author</a>
                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem"
                        data-publish="anonymous">Publish
                        as Anonymous</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->

    <x-slot name="script">
        <script>
            var form = $(".validation-wizard").show();

            var publish;

            $(document).ready(function() {
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
            })

            $(".validation-wizard").steps({
                headerTag: "h6",
                bodyTag: "section",
                transitionEffect: "fade",
                titleTemplate: '<span class="step">#index#</span> #title#',
                labels: {
                    finish: "Publish <i class='fas fa-angle-up'></i> ",
                    previous: "<i class='fas fa-angle-left'></i> Previous",
                },
                startIndex: 2,
                onStepChanging: function(event, currentIndex, newIndex) {
                    if (newIndex == 0) {
                        let url = "{{ route('staff.idea.add-info', ['idea' => ':id']) }}";
                        url = url.replace(':id', "{{ $idea->id }}");
                        window.location.href = url;
                    } else if (newIndex == 1) {
                        let url = "{{ route('staff.idea.upload-file', ['idea' => ':id']) }}";
                        url = url.replace(':id', "{{ $idea->id }}");
                        window.location.href = url;
                    }

                    return false;
                },
                onFinishing: function(event, currentIndex) {
                    if (publish == 'author' || publish == 'anonymous') {
                        var formData = new FormData(form[0]);
                        formData.append('type', publish);

                        $.ajax({
                            url: $(form).attr('action'),
                            method: $(form).attr('method'),
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function(res) {
                                if (res.success) {
                                    Swal.fire({
                                        title: "Idea Successfully Published!",
                                        text: "",
                                        type: 'success',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK'
                                    }).then(function(result) {
                                        if (result) {
                                            window.location.href =
                                            "{{ route('staff.ideas') }}";
                                        }
                                    });
                                }
                            },
                            error: function(err) {
                                var el = $(document).find('.error-message');
                                if (err.status == 422) {
                                    $.each(err.responseJSON.errors, function(i, error) {
                                        el.find('.message').html(error[0]);
                                    });

                                    el.removeClass('d-none');
                                }
                            }
                        })

                        return false;
                    }
                    return false;
                },
                onFinished: function(event, currentIndex) {

                }
            })

            $('.validation-wizard .actions li:last-child').html($('.dropdown-area').html());

            $(document).on('click', '.dropdown .dropdown-menu a', function(e) {
                e.preventDefault();
                publish = $(this).data('publish');
                $(".wizard").steps("finish");
            })

            $('.validation-wizard .actions li:last-child a').attr('href', 'javascript:void(0)').addClass('disabled');

            $('input[name=term-condition]').on('click', function() {
                if ($(this).is(':checked')) {
                    $('.validation-wizard .actions li:last-child a').attr('href', '#finish').removeClass('disabled');
                } else {
                    $('.validation-wizard .actions li:last-child a').attr('href', 'javascript:void(0)').addClass(
                        'disabled');
                }
            })
        </script>
    </x-slot>

</x-app-layout>
