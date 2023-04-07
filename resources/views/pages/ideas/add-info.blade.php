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
                        <a class="breadcrumb-item" href="{{ route('staff.ideas') }}">Ideas</a>
                        <a class="breadcrumb-item" href="javascript:void(0)">Idea Submission Form</a>
                        <span class="breadcrumb-item active">Add Information</span>
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
                        <form action="{{ route('staff.idea.add-info.store') }}" method="POST"
                            class="validation-wizard wizard-circle">
                            @csrf
                            <input type="hidden" name="idea_id" value="{{ $idea ? $idea->id : null }}">
                            <!-- Step 1 -->
                            <h6>Add Information</h6>
                            <section>
                                <div class="card radius">
                                    <div class="card-body  mt-4 mb-4 mr-0 ml-0 mr-md-5 ml-md-5">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wcategory"> Category : <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <select class="custom-select form-control required" id="wcategory"
                                                        name="category_id"
                                                        data-value="{{ $idea ? $idea->category_id : null }}">
                                                        <option value="">Select Category</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}"
                                                                {{ $idea ? ($idea->category_id == $category->id ? 'selected' : '') : '' }}>
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wacademicYear">Academic Year : <span
                                                            class="text-danger">*</span></label>
                                                    <select class="custom-select form-control required"
                                                        id="wacademicYear" name="academic_year_id"
                                                        data-value="{{ $idea ? $idea->academic_year_id : null }}">
                                                        <option value="">Select Academic Year</option>
                                                        @foreach ($academicYears as $academicYear)
                                                            <option value="{{ $academicYear->id }}"
                                                                {{ $idea ? ($idea->academic_year_id == $academicYear->id ? 'selected' : '') : '' }}>
                                                                {{ $academicYear->academic_year }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="wtitle"> Title : <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control required" id="wtitle"
                                                        value="{{ $idea ? $idea->title : '' }}" name="title"
                                                        data-value="{{ $idea ? $idea->title : null }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="wemailAddress2"> Description : <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <textarea class="textarea_editor form-control " id="wdescription" name="description" rows="7"
                                                        placeholder="Enter text description..." data-value="{{ $idea ? $idea->description : null }}">{!! $idea ? $idea->description : '' !!}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </section>
                            <!-- Step 2 -->
                            <h6>Upload Files</h6>
                            <section></section>
                            <!-- Step 3 -->
                            <h6>Preview and Publish Post</h6>
                            <section></section>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->

    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->

    <x-slot name="script">
        <script>
            $(document).ready(function() {
                $('.textarea_editor').wysihtml5({
                    "stylesheets": ["{{ asset('assets/plugins/html5-editor/lib/css/wysiwyg-color.css') }}"],
                    "image": false,
                    "color": true
                });
            })

            var form = $(".validation-wizard").show();

            $(".validation-wizard").steps({
                headerTag: "h6",
                bodyTag: "section",
                transitionEffect: "fade",
                titleTemplate: '<span class="step">#index#</span> #title#',
                labels: {
                    next: "<i class='fas fa-angle-right'></i> Next",
                    previous: "<i class='fas fa-angle-left'></i> Previous",
                },
                onStepChanging: function(event, currentIndex, newIndex) {
                    // Add Information
                    if (currentIndex == 0) {
                        var data = new FormData($(form)[0]),
                            update = false;

                        $('.validation-wizard .actions li:nth-child(2) a').attr('href', 'javascript:void(0)').addClass('disabled');
                        $('.error-message').remove();

                        if ($('input[name=idea_id]').val() != '') {
                            let currentSection = form.find(".body:eq(" + currentIndex +
                                ") input[name=title],select,textarea");
                            $.each(currentSection, function(key, el) {
                                if ($(el).val() != $(el).data('value')) {
                                    update = true;
                                }
                            })
                        } else {
                            update = true;
                        }

                        if (update) {
                            $.ajax({
                                url: $(form).attr('action'),
                                method: $(form).attr('method'),
                                data: data,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function(res) {
                                    if (res) {
                                        CompletedHandler(res.id);
                                    }
                                },
                                error: function(res) {
                                    ErrorHandler(res, currentIndex);
                                }
                            })
                        }else{
                            CompletedHandler($('input[name=idea_id]').val());
                        }

                        return false;
                    } else {
                        return false;
                    }
                },
            });

            function CompletedHandler(id) {
                let url = "{{ route('staff.idea.upload-file', ['idea' => ':id']) }}";
                url = url.replace(':id', id);
                window.location.href = url;
            }

            function ErrorHandler(err, currentIndex) {
                let errors = '';
                $('.validation-wizard .actions li:nth-child(2) a').attr('href', '#next').removeClass('disabled');

                if (err.status == 422) {
                    $.each(err.responseJSON.errors, function(i, error) {
                        var el = $(document).find('[name="' + i + '"]');
                        if (i == 'description') {
                            $(document).find('.wysihtml5-sandbox').after($(
                                '<div class="text-danger error-message pt-1">' + error[0] +
                                '</div>'));
                        } else {
                            el.after($('<div class="text-danger error-message pt-1">' + error[0] +
                                '</div>'));
                        }
                    });
                } else {
                    $('.validation-wizard').find(".body:eq(" + currentIndex + ") .card .card-body")
                        .prepend(
                            `<div class="error-message alert alert-danger alert-rounded">Unable to Process! Check your internet connection!</div>`
                        )
                }
            }
        </script>
    </x-slot>

</x-app-layout>
