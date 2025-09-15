@extends('layout.userlayout')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<section id="hero" class="py-5 text-center bg-light border-bottom" 
         style="background: linear-gradient(135deg, rgba(255,255,255,0.7), rgba(240,240,255,0.6));
                backdrop-filter: blur(10px);">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3 text-dark">Welcome, {{ Auth::user()->firstname }}!</h1>
        <p class="lead text-muted mb-4">จองห้องซ้อมของคุณได้ง่าย ๆ</p>
        <a href="#rooms" class="btn btn-primary btn-lg px-4 shadow-sm">
            <i class="bi bi-music-note-beamed me-2"></i> Book Now
        </a>
    </div>
</section>

<!-- Promotions Section -->
<section id="promotions" class="py-5">
    <div class="container">
        <h2 class="mb-4 fw-semibold text-dark">
            <i class="bi bi-gift-fill me-2"></i>Promotions
        </h2>
        @if($promotions->isEmpty())
            <div class="alert alert-secondary text-center shadow-sm rounded-3">ไม่มีโปรโมชั่นในขณะนี้</div>
        @else
            <div class="row g-4">
                @foreach($promotions as $promo)
                    <div class="col-md-4">
                        <div class="card h-100 shadow-lg border-0"
                            style="background: rgba(255,255,255,0.65); 
                                   backdrop-filter: blur(12px); 
                                   border-radius: 16px; 
                                   transition: transform 0.3s, box-shadow 0.3s;">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-dark">{{ $promo->name }}</h5>
                                <p class="card-text text-muted">{{ $promo->description }}</p>

                                <p class="mb-2">
                                    <span class="badge bg-success shadow-sm fs-6">
                                        <i class="bi bi-percent me-1"></i>
                                        @if($promo->discount_type === 'percent')
                                            -{{ $promo->discount_value }}%
                                        @else
                                            -{{ number_format($promo->discount_value,2) }} ฿
                                        @endif
                                    </span>
                                </p>

                                <small class="text-muted d-block">
                                    <i class="bi bi-calendar-event me-1"></i>
                                    {{ $promo->start_date }} → {{ $promo->end_date }}
                                </small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<!-- Rooms Grid -->
<section id="rooms" class="py-5" 
        style="background: linear-gradient(135deg, rgba(240,248,255,0.7), rgba(255,255,255,0.6));
               backdrop-filter: blur(8px);">
    <div class="container">
        <h2 class="mb-4 fw-semibold text-dark text-center">
            <i class="bi bi-music-note-beamed me-2"></i>Our Rooms
        </h2>

        <!-- Search / Filter -->
        <form method="GET" action="{{ route('user.home') }}" 
            class="row mb-5 p-4 rounded-3 shadow-sm mx-auto align-items-end"
            style="background: rgba(255,255,255,0.6); backdrop-filter: blur(10px); max-width: 1200px;">

            <div class="col-md-4">
                <label class="form-label small fw-semibold text-dark mb-1">Search</label>
                <input type="text" name="search" class="form-control shadow-sm" 
                       placeholder="Search by room name..." value="{{ request('search') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label small fw-semibold text-dark mb-1">Capacity</label>
                <select name="capacity" class="form-select shadow-sm">
                    <option value="">All Capacities</option>
                    <option value="1-3" {{ request('capacity') === '1-3' ? 'selected' : '' }}>Small (1-3)</option>
                    <option value="4-6" {{ request('capacity') === '4-6' ? 'selected' : '' }}>Medium (4-6)</option>
                    <option value="7+" {{ request('capacity') === '7+' ? 'selected' : '' }}>Large (7+)</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label small fw-semibold text-dark mb-1">Price</label>
                <select name="price" class="form-select shadow-sm">
                    <option value="">Any Price</option>
                    <option value="low" {{ request('price') === 'low' ? 'selected' : '' }}>Below 200</option>
                    <option value="mid" {{ request('price') === 'mid' ? 'selected' : '' }}>200-500</option>
                    <option value="high" {{ request('price') === 'high' ? 'selected' : '' }}>500+</option>
                </select>
            </div>

            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary shadow-sm w-100 d-flex align-items-center justify-content-center" style="height: 2.75rem;">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                <a href="{{ route('user.home') }}" class="btn btn-outline-secondary shadow-sm w-100 d-flex align-items-center justify-content-center" style="height: 2.75rem;">
                    <i class="bi bi-arrow-clockwise me-1"></i> Reset
                </a>
            </div>
        </form>

        @if($rooms->isEmpty())
            <div class="alert alert-warning text-center shadow-sm rounded-3">ไม่พบห้องที่ตรงกับเงื่อนไข</div>
        @else
            <div class="row g-4">
                @foreach($rooms as $room)
                    <div class="col-md-4">
                        <a href="{{ route('user.roominfo', ['room' => $room->room_id]) }}" class="text-decoration-none">
                            <div class="card h-100 shadow-sm border-0 room-card"
                                style="background: rgba(255,255,255,0.65); backdrop-filter: blur(10px); border-radius: 16px; transition: transform 0.3s, box-shadow 0.3s;">
                                <img src="{{ $room->image_url ? asset('storage/' . $room->image_url) : 'https://shorturl.at/YT5O1' }}"
                                     class="card-img-top rounded-top" alt="{{ $room->name }}" style="object-fit: cover; height: 200px;">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fw-bold text-dark mb-2">{{ $room->name }}</h5>
                                    <p class="card-text mb-1">
                                        <i class="bi bi-cash-coin me-1 text-success"></i>
                                        <span class="fw-semibold">{{ number_format($room->price_per_hour,2) }}</span> / hour
                                    </p>
                                    <p class="card-text mb-1">
                                        <i class="bi bi-people-fill me-1 text-primary"></i>
                                        <span class="fw-semibold">{{ $room->capacity }}</span> people
                                    </p>
                                    <p class="card-text small text-muted">
                                        <i class="bi bi-music-note-list me-1"></i>
                                        @foreach($room->instruments as $inst)
                                            {{ $inst->name }} (x{{ $inst->pivot->quantity }}) |
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<style>
    .room-card {
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .room-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    .room-card img {
        transition: transform 0.3s;
    }
    .room-card:hover img {
        transform: scale(1.05);
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
</style>
@endsection
