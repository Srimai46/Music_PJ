@extends('layout.adminlayout')

@section('title', 'Activity Logs')

@section('content')
<div class="container py-5">

    <h3 class="mb-4 fw-bold text-black">Activity Logs</h3>

    <div class="card border-0 shadow-lg rounded-4 p-3"
         style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(12px);">
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center mb-0 text-white">
                <thead class="text-white-50">
                    <tr>
                        <th><i class="bi bi-hash"></i> Log ID</th>
                        <th><i class="bi bi-person-badge"></i> User</th>
                        <th><i class="bi bi-person-gear"></i> Role</th>
                        <th><i class="bi bi-gear"></i> Action</th>
                        <th><i class="bi bi-card-text"></i> Details</th>
                        <th><i class="bi bi-clock-history"></i> Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td>{{ $log->log_id }}</td>
                            <td>{{ $log->user->username ?? 'N/A' }}</td>
                            <td>
                                <span class="badge {{ $log->role === 'admin' ? 'bg-danger' : 'bg-primary' }}">
                                    {{ ucfirst($log->role) }}
                                </span>
                            </td>
                            <td>{{ $log->action_type }}</td>
                            <td class="text-truncate" style="max-width: 250px;" title="{{ $log->details }}">
                                {{ $log->details }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($log->created_at)->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-white-50 py-3">ไม่มีข้อมูล Log</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-3 d-flex justify-content-center">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
