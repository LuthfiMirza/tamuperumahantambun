<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Dashboard</title>
    @php
    use Illuminate\Support\Facades\Auth;
    @endphp
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/dashboard.css">
    <link rel="stylesheet" href="/css/tailwind-custom.css">
    <link rel="stylesheet" href="/css/optimize.css">
    <link rel="stylesheet" href="/css/table-fix.css">
    <link rel="stylesheet" href="/css/mobile-optimize.css">
    <link rel="stylesheet" href="/css/tambah-tamu.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body class="bg-gray-100">
    <div class="app-container">
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>
        
        <aside id="sidebar" class="sidebar bg-white shadow-lg">
            <div class="sidebar-header p-4 border-b flex items-center justify-between">
                <h3 class="text-xl font-semibold text-gray-800">Security Panel</h3>
            </div>
            <nav class="mt-4">
                <div class="menu-section px-4">
                    <div class="menu-item">
                        <a href="{{ route('satpam.dashboard') }}" class="flex items-center text-gray-600 hover:text-blue-500">
                            <i class="fas fa-home w-6"></i>
                            <span>Dashboard</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('satpam.tambah-tamu') }}" class="flex items-center text-gray-600 hover:text-blue-500">
                            <i class="fas fa-user-plus w-6"></i>
                            <span>Tambah Tamu</span>
                        </a>
                    </div>  
                    <div class="menu-item">
                        <a href="{{ route('satpam.daftar-tamu') }}" class="flex items-center text-gray-600 hover:text-blue-500">
                            <i class="fas fa-users w-6"></i>
                            <span>Daftar Tamu</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('satpam.jadwal-satpam') }}" class="flex items-center text-gray-600 hover:text-blue-500">
                            <i class="fas fa-calendar w-6"></i>
                            <span>Jadwal Satpam</span>
                        </a>
                    </div>
                </div>
            </nav>
        </aside>

        <main id="main-content" class="main-content bg-gray-100">
            <div class="topbar bg-white shadow-sm">
                <button id="sidebar-toggle" class="p-2 rounded-lg hover:bg-gray-100 focus:outline-none">
                    <i class="fas fa-bars text-gray-600"></i>
                </button>
                 <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <div class="avatar-circle">
                            <span class="initials">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <div class="ml-3">
                            <span class="text-gray-600 font-medium">{{ Auth::user()->name }}</span>
                            <div class="text-xs text-gray-500">Satpam Bertugas</div>
                        </div>
                    </div>
                    <div class="relative" x-data="{
                        open: false,
                        notifications: [],
                        scheduleNotifications: [],
                        init() {
                            this.checkNewGuests();
                            this.checkSchedule();
                            setInterval(() => {
                                this.checkNewGuests();
                                this.checkSchedule();
                            }, 30000);
                        },
                        async checkNewGuests() {
                            try {
                                const response = await fetch('/api/new-guests');
                                const data = await response.json();
                                if (data.success && data.data.length > 0) {
                                    this.notifications = data.data.map(guest => ({
                                        id: guest.id,
                                        type: 'guest',
                                        message: `Tamu baru: ${guest.jenis_tamu} - ${guest.tujuan}`,
                                        time: new Date(guest.created_at).toLocaleTimeString()
                                    }));
                                }
                            } catch (error) {
                                console.error('Error fetching notifications:', error);
                            }
                        },
                        async checkSchedule() {
                            const now = new Date();
                            const currentDay = now.toLocaleDateString('id-ID', { weekday: 'long' }).toLowerCase();
                            const currentHour = now.getHours();

                            try {
                                const response = await fetch('/api/jadwal-satpam');
                                const data = await response.json();
                                if (data.success && data.jadwal) {
                                    const jadwal = data.jadwal;
                                    if (jadwal[currentDay]) {
                                        const shift = jadwal[currentDay];
                                        if ((currentHour === 6 && shift === 'Pagi') || (currentHour === 18 && shift === 'Malam')) {
                                            this.scheduleNotifications = [{
                                                id: 'schedule-' + Date.now(),
                                                type: 'schedule',
                                                message: `Persiapan shift ${shift} akan dimulai dalam 1 jam`,
                                                time: now.toLocaleTimeString()
                                            }];
                                        }
                                    }
                                }
                            } catch (error) {
                                console.error('Error checking schedule:', error);
                            }
                        },
                        get allNotifications() {
                            return [...this.notifications, ...this.scheduleNotifications].sort((a, b) => {
                                return new Date(b.time) - new Date(a.time);
                            });
                        },
                        get notificationCount() {
                            return this.allNotifications.length;
                        }
                    }" @click.away="open = false">
                        <button @click="open = !open" class="notification-bell">
                            <i class="fas fa-bell text-gray-600"></i>
                            <span x-show="notificationCount > 0" class="notification-badge" x-text="notificationCount"></span>
                        </button>
                        <div x-show="open" x-cloak 
                             class="notification-dropdown"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <h3 class="text-lg font-semibold text-gray-800">Notifikasi</h3>
                            </div>
                            <div class="max-h-64 overflow-y-auto">
                                <template x-if="allNotifications.length === 0">
                                    <div class="px-4 py-3 text-sm text-gray-500">
                                        Tidak ada notifikasi baru
                                    </div>
                                </template>
                                <template x-for="notif in allNotifications" :key="notif.id">
                                    <div class="px-4 py-3 hover:bg-gray-50 border-b border-gray-100 last:border-0"
                                         :class="{'bg-blue-50': notif.type === 'schedule'}">
                                        <p class="text-sm text-gray-800" x-text="notif.message"></p>
                                        <p class="text-xs text-gray-500 mt-1" x-text="notif.time"></p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                    <button onclick="confirmLogout()" class="text-red-500 hover:text-red-600">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </div>
            </div>

            <div class="p-6">
                @yield('content')
            </div>
        </main>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        
        .app-container {
            display: flex;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            transition: all 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
            background: #fff;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar.collapsed {
            width: 90px;
            top: 0;
            left: 0;
        }

        .sidebar.collapsed .menu-item span,
        .sidebar.collapsed .sidebar-header h3 {
            display: none;
        }

        .sidebar.collapsed .menu-item i {
            margin: 0 auto;
            width: auto;
        }

        .main-content {
            flex: 1;
            margin-left: 250px;
            transition: all 0.3s ease;
            min-height: 100vh;
            background: #f3f4f6;
            overflow-y: auto;
            height: 100vh;
        }

        .main-content.expanded {
            margin-left: 70px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            position: sticky;
            top: 0;
            z-index: 10;
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .menu-section {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            padding: 1rem 0;
        }

        .menu-item {
            padding: 0.75rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            margin: 0 0.5rem;
        }

        .menu-item:hover {
            background-color: #f3f4f6;
        }

        .menu-item a {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: #4b5563;
            text-decoration: none;
        }

        .menu-item i {
            width: 1.5rem;
            text-align: center;
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 250px;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0 !important;
                height: 100vh;
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
            }

            .main-content.expanded {
                margin-left: 0 !important;
            }

            #sidebar-overlay {
                transition: opacity 0.3s ease;
            }

            .app-container {
                height: 100vh;
                overflow: hidden;
            }

            body {
                height: 100vh;
                overflow: hidden;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const overlay = document.getElementById('sidebar-overlay');

            function toggleSidebar() {
                if (window.innerWidth >= 768) {
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('expanded');
                } else {
                    sidebar.classList.toggle('active');
                    overlay.classList.toggle('hidden');
                }
            }

            sidebarToggle.addEventListener('click', toggleSidebar);

            overlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                overlay.classList.add('hidden');
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    overlay.classList.add('hidden');
                    sidebar.classList.remove('active');
                    if (sidebar.classList.contains('collapsed')) {
                        mainContent.classList.add('expanded');
                    }
                } else {
                    sidebar.classList.remove('collapsed');
                    mainContent.classList.remove('expanded');
                }
            });
        });

        function confirmLogout() {
            Swal.fire({
                title: 'Logout',
                text: 'Apakah Anda yakin ingin keluar?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
</body>
</html>

<style>
        /* Avatar Circle Style */
        .avatar-circle {
            width: 40px;
            height: 40px;
            background-color: #4299e1;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .initials {
            color: white;
            font-size: 18px;
            font-weight: 600;
        }

        /* Notification Bell Style */
        .notification-bell {
            position: relative;
            padding: 8px;
            border-radius: 50%;
            background-color: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .notification-bell:hover {
            background-color: #e5e7eb;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ef4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
    </style>

    <style>
        [x-cloak] { display: none !important; }

        .notification-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            width: 240px;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            margin-top: 0.5rem;
            z-index: 50;
        }

        @media (max-width: 768px) {
            .notification-dropdown {
                position: fixed;
                inset-inline: 0;
                top: 4rem;
                margin-inline: auto;
                width: 15rem;
                max-width: 100vw;
                right: 0;
                left: 0;
            }
        }

        @media (max-width: 390px) {
            .notification-dropdown {
                width: 90%;
                max-width: 240px;
            }
        }
        .notification-header {
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .notification-body {
            max-height: 290px;
            overflow-y: auto;
        }

        .empty-notifications {
            padding: 2rem;
            text-align: center;
            color: #6b7280;
        }

        .notification-item {
            display: flex;
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
            transition: background-color 0.2s;
        }

        .notification-item:hover {
            background-color: #f3f4f6;
        }

        .notification-icon {
            flex-shrink: 0;
            width: 2.5rem;
            height: 2.5rem;
            background-color: #e5e7eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }

        .notification-content {
            flex: 1;
        }

        .notification-text {
            color: #1f2937;
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }

        .notification-time {
            color: #6b7280;
            font-size: 0.75rem;
        }
    </style>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('notifications', () => ({
            notifications: [],
            async checkNewGuests() {
                try {
                    const response = await fetch('/api/new-guests');
                    const data = await response.json();
                    if (data.guests && data.guests.length > 0) {
                        data.guests.forEach(guest => {
                            this.notifications.unshift({
                                id: guest.id,
                                message: `Tamu baru: ${guest.name}`,
                                time: new Date(guest.created_at).toLocaleTimeString()
                            });
                        });
                    }
                } catch (error) {
                    console.error('Error checking new guests:', error);
                }
            },
            init() {
                this.checkNewGuests();
                setInterval(() => this.checkNewGuests(), 30000); // Check every 30 seconds
            }
        }));
    });
</script>