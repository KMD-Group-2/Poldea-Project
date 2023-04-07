<x-guest-layout>
    <section id="wrapper">
        <div class="login-register">
            <div class="logo">
                <x-application-logo type="vertical_color" width="300px" height="300px" />
            </div>
            <div class="login-box card">
                <div class="card-body">
                    <form class="form-horizontal form-material" id="loginform" action="{{ route('login') }}" method="POST">
                        @csrf
                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4 alert alert-success alert-rounded" :status="session('status')" />

                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4 alert alert-danger alert-rounded" :errors="$errors" />

                        <h3 class="text-left m-b-20">Sign In</h3>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="username" required="" placeholder="Username"> </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" name="password" required="" placeholder="Password"> </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div class="ml-auto">
                                        <a href="{{ route('password.request') }}" class="text-info"><i class="fas fa-lock m-r-5"></i> Forgot password?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center mb-2">
                            <div class="col-xs-12">
                                <button class="btn btn-block btn-lg btn-info btn-rounded" type="submit">Sign In</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
