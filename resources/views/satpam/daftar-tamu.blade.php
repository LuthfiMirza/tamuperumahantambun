@extends('layouts.satpam')

@section('content')
@if(session('success'))
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script>
      </script>
      @endif
      
      @if(session('error'))
      <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded" role="alert">
        <p>{{ session('error') }}</p>
      </div>
      @endif

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<div id="daftar-tamu-content" class="mobile-scroll-container">
    <div class="card">
        <div class="card-header">
            <h2>Daftar Tamu</h2>
        </div>
        <div class="card-body">
        <div class="export-controls-container flex flex-col md:flex-row justify-between items-start md:items-center mb-4 space-y-2 md:space-y-0">
        <div class="flex flex-wrap gap-2">
          <a href="{{ route('satpam.daftar-tamu') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 md:px-4 md:py-2 rounded-lg text-xs md:text-sm font-medium">Semua Data</a>
          <a href="{{ route('satpam.daftar-tamu', ['filter' => 'today']) }}" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 md:px-4 md:py-2 rounded-lg text-xs md:text-sm font-medium">Data Hari Ini</a>
        </div>
        <div class="flex flex-wrap gap-2">
          <div class="relative" x-data="{ open: false }" x-ref="pdfDropdown">
            <button @click="open = !open" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 md:px-4 md:py-2 rounded-lg text-xs md:text-sm font-medium flex items-center">
              <i class="fas fa-file-pdf mr-1 md:mr-2"></i> Export PDF <i class="fas fa-chevron-down ml-1"></i>
            </button>
            <div x-show="open" @click.away="open = false" x-cloak 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border"
                 style="z-index: 99999 !important; position: fixed !important; top: auto !important;">
              <a href="{{ route('satpam.export-tamu', ['type' => 'pdf', 'filter' => 'all']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <i class="fas fa-file-pdf mr-2 text-red-500"></i> Semua Data PDF
              </a>
              <a href="{{ route('satpam.export-tamu', ['type' => 'pdf', 'filter' => 'today']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <i class="fas fa-file-pdf mr-2 text-red-500"></i> Hari Ini PDF
              </a>
            </div>
          </div>
          
          <div class="relative" x-data="{ open: false }" x-ref="excelDropdown">
            <button @click="open = !open" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 md:px-4 md:py-2 rounded-lg text-xs md:text-sm font-medium flex items-center">
              <i class="fas fa-file-excel mr-1 md:mr-2"></i> Export Excel <i class="fas fa-chevron-down ml-1"></i>
            </button>
            <div x-show="open" @click.away="open = false" x-cloak 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border"
                 style="z-index: 99999 !important; position: fixed !important; top: auto !important;">
              <a href="{{ route('satpam.export-tamu', ['type' => 'excel', 'filter' => 'all']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <i class="fas fa-file-excel mr-2 text-green-600"></i> Semua Data Excel
              </a>
              <a href="{{ route('satpam.export-tamu', ['type' => 'excel', 'filter' => 'today']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <i class="fas fa-file-excel mr-2 text-green-600"></i> Hari Ini Excel
              </a>
            </div>
          </div>
        </div>
      </div>
      <style>
        [x-cloak] { display: none !important; }
        
        /* Dropdown styling */
        .relative {
          position: relative;
          z-index: 1000;
        }
        
        .relative div[x-show] {
          position: absolute;
          z-index: 9999 !important;
          box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
          border: 1px solid #e5e7eb;
          background: white !important;
          border-radius: 0.375rem;
        }
        
        .relative div[x-show] a:hover {
          background-color: #f3f4f6;
          transition: background-color 0.15s ease-in-out;
        }
        
        /* Ensure dropdown appears above everything */
        .card {
          position: relative;
          z-index: 1;
          overflow: visible !important;
        }
        
        .card-header {
          position: relative;
          z-index: 100;
          overflow: visible !important;
        }
        
        .card-body {
          position: relative;
          z-index: 1;
          overflow: visible !important;
        }
        
        .overflow-x-auto {
          position: relative;
          z-index: 1;
        }
        
        /* Mobile scrolling container */
        .mobile-scroll-container {
          height: auto;
          overflow: visible;
        }
        
        /* Ensure no parent containers clip the dropdown */
        #daftar-tamu-content {
          overflow: visible !important;
        }
        
        #daftar-tamu-content .card {
          overflow: visible !important;
        }
        
        #daftar-tamu-content .card-body {
          overflow: visible !important;
        }
        
        /* Force dropdown to appear above card */
        .export-controls-container {
          position: relative;
          z-index: 1001 !important;
        }
        
        .export-controls-container .relative {
          z-index: 1002 !important;
        }
        
        .export-controls-container .relative div[x-show] {
          z-index: 9999 !important;
          position: absolute !important;
        }
        
        /* Specific dropdown menu styling */
        .dropdown-menu {
          position: fixed !important;
          z-index: 999999 !important;
          background: white !important;
          box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
          border: 1px solid #e5e7eb !important;
          border-radius: 0.375rem !important;
          min-width: 12rem !important;
        }
        
        .dropdown-menu a {
          display: block !important;
          padding: 0.5rem 1rem !important;
          color: #374151 !important;
          text-decoration: none !important;
        }
        
        .dropdown-menu a:hover {
          background-color: #f3f4f6 !important;
        }
        
        @media (max-width: 768px) {
          .flex-wrap {
            flex-wrap: wrap;
          }
          .gap-2 {
            gap: 0.5rem;
          }
          .px-3 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
          }
         
          .text-xs {
            font-size: 0.75rem;
          }
          .mr-1 {
            margin-right: 0.25rem;
          }
          
          /* Mobile dropdown adjustments */
          .relative div[x-show] {
            position: fixed !important;
            right: 1rem !important;
            left: auto !important;
            width: auto !important;
            min-width: 200px;
            z-index: 9999 !important;
            top: auto !important;
            margin-top: 0.5rem;
          }
          
          /* Ensure buttons container has proper z-index */
          .flex.flex-wrap.gap-2 {
            position: relative;
            z-index: 10;
          }
          
          /* Mobile scrolling fixes */
          .mobile-scroll-container {
            height: auto !important;
            max-height: none !important;
            overflow: visible !important;
            padding-bottom: 4rem !important;
            margin-bottom: 2rem !important;
          }
          
          .card {
            margin-bottom: 1rem !important;
            overflow: visible !important;
          }
          
          .card-body {
            overflow: visible !important;
          }
          
          /* Fix table scrolling on mobile */
          .table-responsive {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
            margin: 0 -1rem !important;
            padding: 0 1rem !important;
          }
          
          .table-responsive table {
            width: 100% !important;
            white-space: nowrap !important;
          }
          
          /* Pagination mobile fix */
          .pagination-container {
            margin-top: 1rem !important;
            padding-bottom: 3rem !important;
            margin-bottom: 2rem !important;
            position: relative !important;
            z-index: 1 !important;
            background: #f3f4f6 !important;
            padding-top: 1rem !important;
          }
          
          /* Pagination navigation styling for mobile */
          .pagination-container nav {
            background: white !important;
            padding: 1rem !important;
            border-radius: 0.5rem !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
            margin: 0 !important;
          }
          
          /* Pagination links mobile responsive */
          .pagination-container .relative.inline-flex.items-center {
            padding: 0.5rem 0.75rem !important;
            margin: 0 0.1rem !important;
            font-size: 0.875rem !important;
          }
          
          /* Ensure main content area is scrollable */
          #main-content {
            height: 100vh !important;
            overflow-y: auto !important;
            -webkit-overflow-scrolling: touch !important;
          }
          
          /* Content padding adjustment */
          #main-content .p-6 {
            padding: 1rem !important;
            height: calc(100vh - 80px) !important;
            overflow-y: auto !important;
            -webkit-overflow-scrolling: touch !important;
            padding-bottom: 4rem !important;
          }
          
          /* Extra small screens (390px and below) */
          @media (max-width: 390px) {
            .mobile-scroll-container {
              padding-bottom: 5rem !important;
            }
            
            .pagination-container {
              padding-bottom: 4rem !important;
              margin-bottom: 3rem !important;
            }
            
            .pagination-container nav {
              padding: 0.75rem !important;
            }
            
            .pagination-container .relative.inline-flex.items-center {
              padding: 0.375rem 0.5rem !important;
              font-size: 0.75rem !important;
            }
            
            /* Ensure content doesn't get cut off */
            #main-content .p-6 {
              padding-bottom: 6rem !important;
            }
          }
        }
        
        /* Desktop - ensure normal behavior */
        @media (min-width: 769px) {
          .mobile-scroll-container {
            height: auto !important;
            overflow: visible !important;
          }
        }
      </style>
      
      <div class="overflow-x-auto bg-white rounded-xl shadow p-4">
        <div class="table-responsive">
          <table class="min-w-full text-sm">
            <thead>
              <tr class="bg-blue-900 text-white whitespace-nowrap">
                <th class="py-3 px-3 text-left w-11">No</th>
                <th class="py-3 px-5 text-left w-40">Jenis Tamu</th>
                <th class="py-3 px-1 text-left">Plat Nomor</th>
                <th class="py-3 px-7 text-left w-40">Tanggal</th>
                <th class="py-1 px-1 text-left">Jam Masuk</th>
                <th class="py-3 px-1 text-left">Jam Keluar</th>
                <th class="py-3 px-12 text-left w-40">Status</th>
                <th class="py-3 px-5 text-left w-40">Tujuan</th>
                <th class="py-3 px-5 text-left w-40 ">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @if($daftarTamu->count() > 0)
                @foreach($daftarTamu as $index => $tamu)
                <tr class="border-b whitespace-nowrap hover:bg-gray-50">
                  <td class="py-2 px-3">{{ ($daftarTamu->currentPage() - 1) * $daftarTamu->perPage() + $loop->iteration }}</td>
                  <td class="py-2 px-5">
                    @if(strtolower($tamu->jenis_tamu) == 'tamu warga')
                    <span class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                      <i class="fas fa-user-friends"></i> {{ $tamu->jenis_tamu }}
                    </span>
                    @elseif(strtolower($tamu->jenis_tamu) == 'ojek online')
                    <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                      <i class="fas fa-motorcycle"></i> {{ $tamu->jenis_tamu }}
                    </span>
                    @elseif(strtolower($tamu->jenis_tamu) == 'kurir')
                    <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                      <i class="fas fa-truck"></i> {{ $tamu->jenis_tamu }}
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold">
                      <i class="fas fa-user"></i> {{ $tamu->jenis_tamu }}
                    </span>
                    @endif
                  </td>
                  <td class="py-2 px-5">{{ $tamu->plat_nomor ?: '-' }}</td>
                  <td class="py-2 px-5">{{ \Carbon\Carbon::parse($tamu->tanggal)->format('Y-m-d') }}</td>
                  <td class="py-2 px-5">{{ $tamu->jam_masuk }}</td>
                  <td class="py-2 px-5">{{ $tamu->jam_keluar ?: '-' }}</td>
                  <td class="py-2 px-5">
                    @if(strtolower($tamu->posisi) == 'sedang didalam')
                    <span class="inline-flex items-center gap-1 bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                      <i class="fas fa-clock"></i> Di Dalam
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                      <i class="fas fa-sign-out-alt"></i> Sudah Keluar
                    </span>
                    @endif
                  </td>
                  <td class="py-2 px-5">{{ $tamu->tujuan }}</td>
                  <td class="py-2 px-5">
                    @if(strtolower($tamu->posisi) == 'sedang didalam')
                    <form action="{{ route('satpam.logout-tamu', $tamu->id) }}" method="POST" class="inline-block" id="logout-form-{{$tamu->id}}">
                      @csrf
                      <button type="button" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm font-medium inline-flex items-center gap-1" onclick="confirmLogoutTamu('{{$tamu->id}}')">
                        <i class="fas fa-sign-out-alt"></i> Logout
                      </button>
                    </form>
                    @endif
                  </td>
                </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="9" class="py-4 text-center text-gray-500">Tidak ada data tamu</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
      
      <style>
        @media (max-width: 768px) {
          .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin: 0 -1rem;
            padding: 0 1rem;
          } 
          
          .table-responsive table {
            width: 100%;
            white-space: nowrap;
          }
          
          .table-responsive th,
          .table-responsive td {
            min-width: 120px;
          }
          
          .table-responsive th:first-child,
          .table-responsive td:first-child {
            position: sticky;
            z-index: 1;
          }
          
          .flex-wrap {
            flex-wrap: wrap;
          }
          
          .gap-2 {
            gap: 0.5rem;
          }
          
          .px-3 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
          }
          
          .text-xs {
            font-size: 0.75rem;
          }
          
          .mr-1 {
            margin-right: 0.25rem;
          }
        }
      </style>
      
      <!-- Pagination -->
      <div class="mt-4">
        <div class="pagination-container">
          {{ $daftarTamu->links() }}
        </div>
      </div>
      
      <style>
        /* Modern Pagination Styling */
        .pagination-container nav {
          display: flex;
          justify-content: center;
          margin-top: 1.5rem;
        }
        
        .pagination-container .flex.justify-between.flex-1 {
          display: none; /* Hide the text information */
        }
        
        .pagination-container nav > div:last-child {
          display: flex;
          justify-content: center;
          align-items: center;
          width: 100%;
        }
        
        .pagination-container .relative.inline-flex.items-center {
          padding: 0.4rem 0.8rem;
          margin: 0 0.2rem;
          border-radius: 0.25rem;
          font-weight: 500;
          font-size: 0.875rem;
          transition: all 0.2s ease;
          border: none;
          background-color: #f7fafc;
          color: #4a5568;
          box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        
        .pagination-container .relative.inline-flex.items-center:hover {
          background-color: #edf2f7;
          color: #2d3748;
          transform: translateY(-1px);
          box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .pagination-container span[aria-current="page"] .relative.inline-flex.items-center {
          background-color: #4299e1;
          color: white;
          border-color: #4299e1;
          box-shadow: 0 1px 3px rgba(66, 153, 225, 0.5);
        }
        
        .pagination-container .relative.inline-flex.items-center svg {
          width: 0.875rem;
          height: 0.875rem;
        }
        
        /* Disable button styling */
        .pagination-container button[disabled] {
          opacity: 0.5;
          cursor: not-allowed;
        }
        
        /* Add spacing between pagination items */
        .pagination-container span {
          margin: 0 0.1rem;
        }
      </style>
        </div>
    </div>
</div>

<script>
function confirmLogoutTamu(id) {
  Swal.fire({
    title: 'Konfirmasi Logout',
    text: 'Apakah Anda yakin ingin logout tamu ini?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#22c55e',
    cancelButtonColor: '#ef4444',
    confirmButtonText: 'Ya',
    cancelButtonText: 'Tidak',
    background: '#fff',
    customClass: {
      popup: 'rounded-lg shadow-xl',
      title: 'text-xl font-semibold text-gray-800',
      content: 'text-gray-600 mt-2',
      confirmButton: 'px-6 py-2 rounded-md text-white font-medium hover:bg-green-600 transition-colors',
      cancelButton: 'px-6 py-2 rounded-md text-white font-medium hover:bg-red-600 transition-colors'
    },
    showClass: {
      popup: 'animate__animated animate__fadeIn'
    },
    hideClass: {
      popup: 'animate__animated animate__fadeOut'
    },
    backdrop: 'rgba(0,0,0,0.4)',
    allowOutsideClick: false,
    allowEscapeKey: false,
    allowEnterKey: true,
    focusConfirm: false,
    heightAuto: false,
    padding: '2em'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('logout-form-'+id).submit();
    }
  });
}
</script>
@endsection