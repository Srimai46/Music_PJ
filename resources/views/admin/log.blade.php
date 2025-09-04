@extends('layout.adminlayout')

@section('title', 'Log')

@section('content')
    <!-- Hero Section -->
    <section id="hero" class="py-5 text-center bg-light mb-5">
        <div class="container">
            <h1 class="display-4">Log</h1>
            <p class="lead">Book your rehearsal room now!</p>
            <a href="#" class="btn btn-primary btn-lg disabled">Book Now</a>
        </div>
    </section>

    <h1 class="mb-4">Welcome, Admin!</h1>
    <p>นี่คือหน้า Dashboard ของผู้ดูแลระบบ</p>

    <!-- Dashboard Cards -->
    <div class="row">
        <!-- Users Card -->
        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Users</h5>
                    <p class="card-text">จัดการผู้ใช้งานทั้งหมด</p>
                    <a href="#" class="btn btn-secondary disabled">Manage</a>
                </div>
            </div>
        </div>

        <!-- Rooms Card -->
        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Rooms</h5>
                    <p class="card-text">ดู/แก้ไขห้องซ้อม</p>
                    <a href="#" class="btn btn-secondary disabled">Manage</a>
                </div>
            </div>
        </div>

        <!-- Bookings Card -->
        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Bookings</h5>
                    <p class="card-text">ตรวจสอบการจองทั้งหมด</p>
                    <a href="#" class="btn btn-secondary disabled">View</a>
                </div>
            </div>
        </div>
    </div>
@endsection
