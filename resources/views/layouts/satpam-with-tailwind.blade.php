<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Dashboard</title>
    <!-- Tambahkan CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preload" href="/css/dashboard.css" as="style">
    <link rel="preload" href="/css/tailwind-custom.css" as="style">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/dashboard.css">
    <link rel="stylesheet" href="/css/tailwind-custom.css">
    <link rel="stylesheet" href="/css/optimize.css">
    <link rel="stylesheet" href="/css/table-fix.css">
    <link rel="stylesheet" href="/css/mobile-optimize.css">
    @yield('styles')
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <img src="https://via.placeholder.com/40" alt="Logo">
                <h3>Security Dashboard</h3>
            </div>
            
            <div class="sidebar-menu">
                <div class="menu-title">Main Menu</div>
                
                <div class="menu-item">
                    <a href="/satpam/dashboard" class="active" id="dashboard-link">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
                
                <div class="menu-item">
                    <a href="/satpam/tambah-tamu" id="tambah-tamu-link">
                        <i class="fas fa-user-plus"></i>
                        <span>Tambah Tamu</span>
                        <span class="menu-badge">New</span>
                    </a>
                </div>
                
                <div class="menu-item">
                    <a href="/satpam/daftar-tamu" id="daftar-tamu-link">
                        <i class="fas fa-users"></i>
                        <span>Daftar Tamu</span>
                        <span class="menu-badge">5</span>
                    </a>
                </div>
                
                <div class="menu-item">
                    <a href="/satpam/laporan" id="laporan-link">
                        <i class="fas fa-chart-bar"></i>
                        <span>Laporan</span>
                    </a>
                </div>
            </div>
            
            <div class="sidebar-footer">
                <a href="/logout" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <!-- Topbar -->
            <header class="topbar">
                <button id="sidebar-toggle" class="sidebar-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="topbar-right">
                    <div class="dropdown">
                        <button class="dropdown-toggle">
                            <img src="https://via.placeholder.com/32" alt="User" class="user-avatar">
                            <span>Admin</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a href="/profile">
                                <i class="fas fa-user"></i>
                                <span>Profile</span>
                            </a>
                            <a href="/settings">
                                <i class="fas fa-cog"></i>
                                <span>Settings</span>
                            </a>
                            <a href="/logout">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Content -->
            <div class="content-wrapper">
                @yield('content')
            </div>
        </main>
    </div>
    
    <script src="/js/dashboard.js"></script>
    @yield('scripts')
</body>
</html>