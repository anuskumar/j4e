<?php $page = 'register'; ?>
@extends('layout.mainlayout')
@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">

                <div class="col-md-8 offset-md-2">


                    <!-- Register Content -->
                    <div class="account-content">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-md-7 col-lg-6 login-left">
                                @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="text-danger">{{$error}}</div>
                                @endforeach
                            @endif
                                <img src="assets/img/login-banner.png" class="img-fluid" alt="Pathivu Register">
                            </div>
                            <div class="col-md-12 col-lg-6 login-right">
                                <div class="login-header">
                                    <h3>Reseller Registration <a href="speaker-register">Register Here</a></h3>
                                </div>

                                <!-- Register Form -->
                                <form method="POST" action="{{ url('store_reseller') }}">
                                    @csrf
                                    <div class="form-group form-focus">
                                        <input type="text"
                                            class="form-control floating @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required autocomplete="name" autofocus>
                                        <label class="focus-label">{{ __('Name') }}</label>
                                        {{-- @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror --}}
                                    </div>
                                    <div class="form-group form-focus">
                                        <input type="email"
                                            class="form-control floating @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" required autocomplete="email">
                                        <label class="focus-label">{{ __('Email Address') }}</label>
                                        {{-- @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror --}}
                                    </div>
                                    <div class="form-group form-focus">
                                        <input type="password"
                                            class="form-control floating @error('password') is-invalid @enderror"
                                            name="password" required autocomplete="new-password">
                                        <label class="focus-label">{{ __('Password') }}</label>
                                        {{-- @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror --}}
                                    </div>
                                    <div class="form-group form-focus">
                                        <input type="password" class="form-control floating" name="password_confirmation"
                                            required autocomplete="new-password">
                                        <label class="focus-label">{{ __('Confirm Password') }}</label>
                                        {{-- @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror --}}
                                    </div>
                                    <div class="form-group form-focus">

                                        <select name="country" class="form-control" required>
                                            <option></option>
                                            @foreach ($countries as $val)
                                                <option value="{{ $val->id }}">{{ $val->country_name }}</option>
                                            @endforeach
                                        </select>
                                        <label class="focus-label">{{ __('country') }}</label>
                                        {{-- @error('country')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror --}}
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group form-focus">
                                                <select name="country_code" class="form-control" required>
                                                    <option value="">Code</option>
                                                    @foreach ($countries as $val)
                                                        @if (!$val->country_code == null)
                                                            <option value="{{ $val->country_code }}">
                                                                {{ $val->country_code . ' [' . $val->country_name . ' ]' }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                {{-- <label class="focus-label">{{ __('Code') }}</label> --}}
                                                {{-- @error('country_code')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror --}}
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div class="form-group form-focus">
                                                <input type="number"
                                                    class="form-control floating @error('phone') is-invalid @enderror"
                                                    name="phone" value="{{ old('phone') }}" required
                                                    autocomplete="phone" autofocus>
                                                <label class="focus-label">{{ __('Phone') }}</label>
                                                {{-- @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror --}}
                                            </div>
                                        </div>

                                    </div>






                                    <button class="btn btn-primary btn-block btn-lg login-btn"
                                        type="submit">{{ __('Register') }}</button>
                                    <div class="login-or">
                                        <span class="or-line"></span>
                                        <span class="span-or">or</span>
                                    </div>
                                    <div class="row form-row social-login">
                                        <div class="col-6">
                                            <a href="#" class="btn btn-facebook btn-block"><i
                                                    class="fab fa-facebook-f mr-1"></i> Login</a>
                                        </div>
                                        <div class="col-6">
                                            <a href="#" class="btn btn-google btn-block"><i
                                                    class="fab fa-google mr-1"></i> Login</a>
                                        </div>
                                    </div>
                                </form>
                                <!-- /Register Form -->

                            </div>
                        </div>
                    </div>
                    <!-- /Register Content -->

                </div>
            </div>

        </div>

    </div>
    <!-- /Page Content -->
    </div>
@endsection
