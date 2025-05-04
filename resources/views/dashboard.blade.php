@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #0e0e2c;
        color: #ffffff;
    }

    .sidebar {
        background-color: #111130;
        min-height: 100vh;
        padding-top: 20px;
        position: fixed;
        width: 220px;
    }

    .sidebar a {
        color: #ffffff;
        display: block;
        padding: 15px 20px;
        text-decoration: none;
        font-weight: 500;
    }

    .sidebar a:hover, .sidebar a.active {
        background-color: #1f1f4d;
        border-left: 4px solid #0ff;
    }

    .main-content {
        margin-left: 220px;
        padding: 30px;
    }

    .navbar {
        background-color: #161636;
        padding: 15px 30px;
        border-bottom: 1px solid #2c2c5a;
    }

    .navbar h4 {
        margin: 0;
        color: #0ff;
    }

    .card {
        background-color: #1a1a3b;
        border: none;
        color: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.4);
        transition: transform 0.2s ease-in-out;
    }

    .card:hover {
        transform: scale(1.02);
    }

    .card-icon {
        font-size: 2.2rem;
        background: #0ff;
        color: #000;
        padding: 12px;
        border-radius: 12px;
        margin-right: 15px;
    }

    canvas {
        background-color: #1a1a3b;
        border-radius: 12px;
        padding: 15px;
    }

    @media (max-width: 768px) {
        .sidebar {
            position: relative;
            width: 100%;
            height: auto;
        }

        .main-content {
            margin-left: 0;
        }
    }
</style>

<!-- Sidebar -->
<div class="sidebar">
    <h4 class="text-center text-white mb-4">FocusMap</h4>
    <a href="{{ route('dashboard') }}" class="active">📊 Dashboard</a>
    <a href="{{ route('students.index') }}">👨‍🎓 Students</a>
    <a href="{{ route('teachers.index') }}">👩‍🏫 Teachers</a>
    <a href="{{ route('courses.index') }}">📚 Courses</a>
    <a href="{{ route('settings') }}">⚙️ Settings</a>
</div>

<!-- Main Content -->
<div class="main-content">

    <!-- Top Navbar -->
    <div class="navbar d-flex justify-content-between align-items-center">
        <h4>Dashboard Overview</h4>
        <div>
            <span>Welcome, {{ Auth::user()->name }}</span>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="row mt-4">
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card p-3 d-flex flex-row align-items-center">
                <div class="card-icon">👨‍🎓</div>
                <div>
                    <h6 class="mb-1">Total Students</h6>
                    <h4>{{ $studentCount ?? '1,234' }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card p-3 d-flex flex-row align-items-center">
                <div class="card-icon">👩‍🏫</div>
                <div>
                    <h6 class="mb-1">Total Teachers</h6>
                    <h4>{{ $teacherCount ?? '125' }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card p-3 d-flex flex-row align-items-center">
                <div class="card-icon">📚</div>
                <div>
                    <h6 class="mb-1">Courses</h6>
                    <h4>{{ $courseCount ?? '89' }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card p-3 d-flex flex-row align-items-center">
                <div class="card-icon">⭐</div>
                <div>
                    <h6 class="mb-1">Avg. Rating</h6>
                    <h4>{{ $averageRating ?? '4.8' }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="card mt-3">
        <div class="card-body">
            <h5 class="mb-4">User Activity (Weekly)</h5>
            <canvas id="activityChart" height="120"></canvas>
        </div>
    </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('activityChart').getContext('2d');
    const activityChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Logins',
                data: [120, 190, 300, 250, 220, 340, 390],
                borderColor: '#0ff',
                backgroundColor: 'rgba(0,255,255,0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#0ff'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    ticks: { color: "#fff" },
                    grid: { color: "#333" }
                },
                x: {
                    ticks: { color: "#fff" },
                    grid: { color: "#333" }
                }
            },
            plugins: {
                legend: {
                    labels: { color: "#fff" }
                }
            }
        }
    });
</script>
@endsection
