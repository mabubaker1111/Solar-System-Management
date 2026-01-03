@extends('worker.layouts.app')
@section('title','Worker Dashboard')

@section('content')
<div class="container">
    <h3 class="mb-4">Welcome, {{ $user->name }}</h3>




    <body class="mmt-body">
        <div class="container">
            <div class="row g-4">
                <!-- LEFT PROFILE CARD -->
                <div class="col-md-4" style="height: 370px">
                    <div class="card d-flex border border-2 border-info align-items-center profile-card h-100 w-100 p-4 text-center">
                        <div class="mt-4">
                            @if($worker->photo)
                            <img src="{{ asset('storage/'.$worker->photo) }}" alt="Worker Photo"
                                class="img-fluid mx-auto rounded-circle mb-2" width="150">
                            @else
                            <img src="https://via.placeholder.com/150" alt="Worker Photo"
                                class="img-fluid rounded-circle mb-2">
                            @endif
                        </div>
                        <div>
                            <h4 class="fw-bold ">{{ $worker->user->name }}</h4>
                        </div>
                        {{-- <p class="text-secondary mb-1">Intern</p>
                        <p class="text-primary fw-semibold">MMT-Int-063</p> --}}
                        <div>
                            <span class="badge {{ $worker->status == 'approved' ? 'bg-success' : 'bg-warning' }}">{{
                                ucfirst($worker->status) }}</span>
                        </div>
                    </div>
                </div>


                <!-- RIGHT INFORMATION SECTION -->
                <div class="col-md-8 ">
                    <div class="card p-4 border border-2 border-info">
                        <h4 class="fw-bold mb-3">Personal Information</h4>


                        <div class="row g-3">


                            <div class="col-md-4 ">
                                <div class="p-3 shadow1 border info-box">
                                    <i class="fa fa-user"></i>
                                    <small class="text-secondary">Name</small>
                                    <p class="fw-bold mb-0">{{ $worker->user->name }}</p>
                                </div>
                            </div>


                            <div class="col-md-4 ">
                                <div class="p-3 shadow1 border info-box">
                                    <i class="fa fa-phone"></i>
                                    <small class="text-secondary">Phone No</small>
                                    <p class="fw-bold mb-0">{{ $worker->user->phone }}</p>
                                </div>
                            </div>


                            <div class="col-md-4 ">
                                <div class="p-3 shadow1 border info-box">
                                    <i class="fa fa-list"></i>
                                    <small class="text-secondary">Skill</small>
                                    <p class="fw-bold mb-0">{{ $worker->skill ?? 'N/A' }}</p>
                                </div>
                            </div>


                            <div class="col-md-6 ">
                                <div class="p-3 shadow1 border info-box">
                                    <i class="fa fa-envelope"></i>
                                    <small class="text-secondary">Email</small>
                                    <p class="fw-bold mb-0"> {{ $worker->user->email }}</p>
                                </div>
                            </div>


                            <div class="col-md-6 ">
                                <div class="p-3 shadow1 border info-box">
                                    <i class="fa fa-building"></i>
                                    <small class="text-secondary">Assigned Business</small>
                                    <p class="fw-bold mb-0">{{ $worker->business->business_name ?? 'Not assigned
                                        yet' }}</p>
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <div class="shadow1 p-3 border info-box">
                                    <i class="fa fa-address-card"></i>
                                    <small class="text-secondary">Experience</small>
                                    <p class="fw-bold mb-0">{{ $worker->experience ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <style>
                                .profile-card {
                                    transition: 0.3s ease;
                                }

                                .profile-card:hover {
                                    transform: translateY(-5px);
                                    box-shadow: 0 0 25px rgba(0, 0, 0, 0.15);
                                }

                                .avatar-img {
                                    width: 130px;
                                    height: 130px;
                                    border-radius: 50%;
                                    object-fit: cover;
                                }

                                .info-box {
                                    transition: 0.3s ease;
                                    border-radius: 12px;
                                }

                                .info-box:hover {
                                    background: #f5f8ff;
                                    transform: scale(1.02);
                                }
                                .shadow1 {
                                    box-shadow: 0;
                                }
                                .shadow1:hover{
                                    box-shadow: 0px 0px 15px -10px;
                                }
                            </style>
                            @endsection


                            {{-- <div class="card shadow-sm mb-4">
                                <div class="card-body" style="padding: 0">
                                    <div class="row bg-transparent">
                                        <div class="col-md-4 d-flex align-items-center  text-center"
                                            style="background-color: rgba(185, 221, 245, 0.824)">
                                            <div class="row">
                                                <div class="col-12">
                                                    @if($worker->photo)
                                                    <img src="{{ asset('storage/'.$worker->photo) }}" alt="Worker Photo"
                                                        class="img-fluid rounded-circle mb-2" width="150">
                                                    @else
                                                    <img src="https://via.placeholder.com/150" alt="Worker Photo"
                                                        class="img-fluid rounded-circle mb-2">
                                                    @endif
                                                </div>
                                                <li class="list-group-item fw-bold "> {{ $worker->user->name }}</li>
                                                <li class="list-group-item">
                                                    <span
                                                        class="badge {{ $worker->status == 'approved' ? 'bg-success' : 'bg-warning' }}">{{
                                                        ucfirst($worker->status) }}</span>
                                                </li>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="card bg-primary text-light">
                                                        <i class="fas fa-user"></i>
                                                        <li class="list-group-item"><strong>Name:</strong>
                                                            <br>
                                                            {{ $worker->user->name }}
                                                        </li>
                                                    </div>
                                                </div>
                                                <div class="col-6"></div>
                                            </div>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item"><strong>Name:</strong> {{
                                                    $worker->user->name }}</li>
                                                <li class="list-group-item"><strong>Email:</strong> {{
                                                    $worker->user->email }}</li>
                                                <li class="list-group-item"><strong>Phone:</strong> {{
                                                    $worker->user->phone }}</li>
                                                <li class="list-group-item"><strong>Skill:</strong> {{ $worker->skill ??
                                                    'N/A' }}</li>
                                                <li class="list-group-item"><strong>Experience:</strong> {{
                                                    $worker->experience ?? 'N/A' }}</li>
                                                <li class="list-group-item">
                                                    <strong>Status:</strong>
                                                    <span
                                                        class="badge {{ $worker->status == 'approved' ? 'bg-success' : 'bg-warning' }}">{{
                                                        ucfirst($worker->status) }}</span>
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>Assigned Business:</strong> {{
                                                    $worker->business->business_name ?? 'Not assigned
                                                    yet' }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}