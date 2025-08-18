@extends('vendor.dashboard.layouts.master')
@section('content')
    <!--=============================
                                                                    DASHBOARD START
                                                                  ==============================-->
    <section id="wsus__dashboard">
        <div class="container-fluid">
            @include('vendor.dashboard.layouts.sidebar')
            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="far fa-user"></i> profile</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <h4>basic information</h4>
                                <div class="row">
                                    <form method="POST" action="{{ route('vendor.profile.update') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-md-12">
                                            <div class="col-md-2">
                                                <div class="wsus__dash_pro_img">
                                                    <img src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('frontend/images/ts-2.jpg') }}"
                                                        alt="img" class="img-fluid w-100">
                                                    <input name='image' type="file">
                                                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-5">
                                                <div class="wsus__dash_pro_single">
                                                    <i class="fas fa-user-tie"></i>
                                                    <input type="text" name="name" placeholder="Name"
                                                        value="{{ Auth::user()->name }}">
                                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="wsus__dash_pro_single">
                                                    <i class="fal fa-envelope-open"></i>
                                                    <input type="email" name="email" placeholder="Email"
                                                        value="{{ Auth::user()->email }}">
                                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <button class="common_btn mb-4 mt-2" type="submit">Update</button>
                                        </div>
                                    </form>


                                    <form method="POST" action="{{ route('vendor.password.update') }}" >
                                         @csrf
                                         @method('PUT')
                                    <div class="wsus__dash_pass_change mt-2">
                                        <div class="row">
                                            <div class="col-xl-4 col-md-6">
                                                <div class="wsus__dash_pro_single">
                                                    <i class="fas fa-unlock-alt"></i>
                                                    <input type="password" placeholder="Current Password" class="form-control" name='current_password'>
                                                    <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-6">
                                                <div class="wsus__dash_pro_single">
                                                    <i class="fas fa-lock-alt"></i>
                                                    <input type="password" placeholder="New Password" class="form-control" name='password'>
                                                    <x-input-error :messages="$errors->get('assword')" class="mt-2" />
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="wsus__dash_pro_single">
                                                    <i class="fas fa-lock-alt"></i>
                                                    <input type="password" class="form-control"
                                                        name='password_confirmation' placeholder="Confirm Password">
                                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <button class="common_btn" type="submit">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!--=============================
                                                                    DASHBOARD START
                                                                  ==============================-->
@endsection
