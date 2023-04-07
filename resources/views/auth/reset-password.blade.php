<x-guest-layout>
    <section id="wrapper">
        <div class="login-register">
            <div class="logo">
                <x-application-logo type="vertical_color" width="300px" height="300px" />
            </div>
            <div class="login-box card">
                <div class="card-body">

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4 alert alert-danger alert-rounded" :errors="$errors" />

                    <form class="form-horizontal form-material" action="{{ route('password.update') }}" method="POST">
                        @csrf

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="form-group ">
                            <div class="col-xs-12">
                                <h3>Reset Password</h3>
                                <p class="text-muted">{{ __('Change your account password? Password must be followed password rule.') }}</p>
                                <ul class="text-muted">
                                    <li>Require at least one uppercase and one lowercase letter...</li>
                                    <li>Minium length is 8</li>
                                </ul>
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" name="password" required=""
                                    placeholder="Password">
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" name="password_confirmation" required=""
                                    placeholder="Confirm Password">
                            </div>
                        </div>

                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light"
                                    type="submit">Reset Password</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
