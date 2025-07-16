<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satpam Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3>Satpam Dashboard</h3>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="#" class="active">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#tambah-tamu" onclick="toggleTamuForm()">
                        <i class="fas fa-user-plus"></i>
                        <span>Tambah Tamu</span>
                    </a>
                </li>
                <li>
                    <a href="#daftar-tamu">
                        <i class="fas fa-users"></i>
                        <span>Daftar Tamu</span>
                    </a>
                </li>
                <li>
                    <a href="#jadwal-satpam">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Jadwal Satpam</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <nav class="navbar">
            <div class="toggle-sidebar" id="toggle-sidebar">
                <i class="fas fa-bars"></i>
            </div>
            <div class="user-info">
                <img src="https://via.placeholder.com/40" alt="User">
                <span>Satpam</span>
            </div>
        </nav>

        <div class="content">
            @include('tambah-tamu')
            @include('daftar-tamu')
            @include('jadwal-satpam')
            <!-- Dashboard Content -->
            <div id="dashboard-content">
                <div class="card">
                    <div class="card-header">
                        <h2>Dashboard Satpam</h2>
                    </div>
                    <div class="card-body">
                        <p>Selamat datang di dashboard Satpam. Silakan pilih menu di sidebar untuk mengakses fitur.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    function toggleTamuForm() {
        const content = document.getElementById('tambah-tamu-content');
        content.style.display = content.style.display === 'none' ? 'block' : 'none';
    }
</script>
</body>
</html>