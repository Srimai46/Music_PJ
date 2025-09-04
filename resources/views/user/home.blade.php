@extends('layout.userlayout')

@section('title', 'Home')

@section('content')
    <h1 class="mb-4">Welcome, {{ Auth::user()->firstname }}!</h1>
    <p>นี่คือหน้า Home ของผู้ใช้งาน</p>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Book a Room</h5>
                    <p class="card-text">จองห้องซ้อมของคุณได้ที่นี่</p>
                    <a href="#" class="btn btn-primary disabled">Book Now</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">My Bookings</h5>
                    <p class="card-text">ดูรายการจองของคุณ</p>
                    <a href="#" class="btn btn-primary disabled">View</a>
                </div>
            </div>
        </div>
    </div>
@endsection
