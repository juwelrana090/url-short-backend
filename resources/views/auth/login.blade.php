@extends('layouts.auth')
@section('custom')
    <!-- Custom styles for this template -->
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-4 col-lg-6 col-md-8">
            <div class="card">
                <div class="card-body p-4">
                    <div class="">
                        <div class="text-center">
                            <a href="index.html" class="">
                                <img src="{{ asset('assets/images/logo-dark.png') }}" alt=""
                                    class="auth-logo logo-dark mx-auto" />
                                <img src="{{ asset('assets/images/logo-light.png') }}" alt=""
                                    class="auth-logo logo-light mx-auto" />
                            </a>
                        </div>
                        <!-- end row -->
                        <h4 class="font-size-18 text-muted mt-2 text-center">
                            Welcome Back !
                        </h4>
                        <p class="mb-5 text-center">{{ config('app.name', 'Madani Madrasha') }} Account Login Now </p>
                        <form class="form-horizontal" action="{{ route('userLogin') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <label class="form-label" for="username">Email</label>
                                        <input type="text" class="form-control" name="email"
                                            placeholder="Enter Email" />
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label" for="password">Password</label>
                                        <input type="password" class="form-control" name="password"
                                            placeholder="Enter password" />
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customControlInline" />
                                                <label class="form-label" class="form-check-label"
                                                    for="customControlInline">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="text-md-end mt-3 mt-md-0">
                                                <a href="#" class="text-muted"><i class="mdi mdi-lock"></i> Forgot
                                                    your
                                                    password?</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-grid mt-4">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">
                                            Log In
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
