<x-app-layout>
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <div class="d-flex justify-content-start align-items-center">
                    <nav class="breadcrumb">
                        <span class="breadcrumb-item">{{ $user->roles()->first()->name }}</span>
                        <span class="breadcrumb-item active">My Profile</span>
                    </nav>
                </div>
            </div>
        </div>
    
        <div class="row">
            <!-- Column -->
            <div class="col-lg-4 col-xlg-3 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <center class="m-t-30"> <img src="{{ $user->staff->photo ?? asset('assets/images/default-user.png') }}" class="img-circle" width="150" />
                            <h4 class="card-title m-t-10">{{ $user->staff->name ?? '' }}</h4>  
                            <h6 class="card-subtitle">{{ $user->staff->position->name ?? '' }}</h6>                          
                        </center>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-8 col-xlg-9 col-md-7">
                <div class="card">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs profile-tab" role="tablist">                    
                        <li class="nav-item"> <a class="nav-link profile" data-toggle="tab" href="#profile" role="tab">Profile</a> </li>
                        <li class="nav-item"> <a class="nav-link password" data-toggle="tab" href="#password" role="tab">Change Password</a> </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">                       
                        <div class="tab-pane" id="profile" role="tabpanel">
                            <div class="card-body">
                                <div class="row my-2">
                                    <div class="col-md-3 col-4">
                                        <strong>Department</strong>
                                    </div>
                                    <div class="col-md-1 col-1">
                                        <span class="float-right">:</span>
                                    </div>
                                    <div class="col-md-8 col-7">
                                        <p class="mb-0">{{ $user->staff->department->name }}</p>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-md-3 col-4">
                                        <strong>Job Title</strong>
                                    </div>
                                    <div class="col-md-1 col-1">
                                        <span class="float-right">:</span>
                                    </div>
                                    <div class="col-md-8 col-7">
                                        <p class="mb-0">{{ $user->staff->position->name }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row my-2">
                                    <div class="col-md-3 col-4">
                                        <strong>User Name</strong>
                                    </div>
                                    <div class="col-md-1 col-1">
                                        <span class="float-right">:</span>
                                    </div>
                                    <div class="col-md-8 col-7">
                                        <p class="mb-0">{{ $user->username }}</p>
                                    </div>
                                </div>
                                @hasanyrole('Admin|QA Manager|QA Coordinator')
                                <div class="row my-2">
                                    <div class="col-md-3 col-4">
                                        <strong>Role</strong>
                                    </div>
                                    <div class="col-md-1 col-1">
                                        <span class="float-right">:</span>
                                    </div>
                                    <div class="col-md-8 col-7">
                                        <p class="mb-0">{{ $user->roles()->first()->name }}</p>
                                    </div>
                                </div>
                                @endhasanyrole
                                <div class="row my-2">
                                    <div class="col-md-3 col-4">
                                        <strong>Email</strong>
                                    </div>
                                    <div class="col-md-1 col-1">
                                        <span class="float-right">:</span>
                                    </div>
                                    <div class="col-md-8 col-7">
                                        <p class="mb-0">{{ $user->staff->email }}</p>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-md-3 col-4">
                                        <strong>Phone</strong>
                                    </div>
                                    <div class="col-md-1 col-1">
                                        <span class="float-right">:</span>
                                    </div>
                                    <div class="col-md-8 col-7">
                                        <p class="mb-0">{{ $user->staff->phone }}</p>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-md-3 col-4">
                                        <strong>Address</strong>
                                    </div>
                                    <div class="col-md-1 col-1">
                                        <span class="float-right">:</span>
                                    </div>
                                    <div class="col-md-8 col-7">
                                        <p class="mb-0">{{ $user->staff->address }}</p>
                                    </div>
                                </div>                                                        
                            </div>
                        </div>
                        <div class="tab-pane" id="password" role="tabpanel">
                            <div class="card-body">
                                <x-auth-session-status class="mb-4 alert alert-success alert-rounded" :status="session('status')" />

                                <form class="form-horizontal form-material" action="{{ route('account.change_password') }}" method="POST">
                                    @csrf                                    
                                    <div class="form-group">
                                        <label class="col-md-12">Current Password *</label>
                                        <div class="col-md-12">
                                            <input type="password" name="current_password" class="form-control form-control-line" placeholder="Enter Current Account Password">
                                            <span class="text-danger">{{ $errors->first('current_password') }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">New Password *</label>
                                        <div class="col-md-12">
                                            <input type="password" name="password" class="form-control form-control-line" placeholder="Enter New Password">
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Confirm New Password *</label>
                                        <div class="col-md-12">
                                            <input type="password" name="password_confirmation" class="form-control form-control-line" placeholder="Enter New Password Confirmation">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button class="btn btn-primary" type="submit">Change</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>
    </div>

    <x-slot name="script">
        <script>
            $('[data-toggle=tab]').on('click',function(){
                sessionStorage.setItem('tab',$(this).attr('href').replace('#',''));
            })

            let active = sessionStorage.getItem('tab');         

            if(active) {
                $(`.${active}`).addClass('active');
                $(`.tab-content #${active}`).addClass('active');
            }else{
                $('.profile').addClass('active');
                $(`.tab-content #profile`).addClass('active');
            }
        </script>
    </x-slot>
</x-app-layout>
