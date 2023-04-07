<x-guest-layout>
    <section id="wrapper">
        <div class="login-register">
            <div class="logo">
                <x-application-logo type="vertical_color" width="300px" height="300px" />
            </div>
            <div class="login-box card">
                <div class="card-body">
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4 alert alert-success alert-rounded" :status="session('status')" />

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4 alert alert-danger alert-rounded" :errors="$errors" />

                    <form class="form-horizontal form-material" action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <h3>Recover Password</h3>
                                <p class="text-muted">{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="username" required="" placeholder="Username"> </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="email" name="email" required="" placeholder="Email"> </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
                            </div>
                        </div>
                        <div class="form-group text-center mb-0">
                            <div class="col-xs-12">
                                <a href="{{ route('login') }}" class="text-info">back to sign in?</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
