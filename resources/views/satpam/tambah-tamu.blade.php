@extends('layouts.satpam')

@section('content')
<div id="tambah-tamu-content" class="mobile-scroll-container">
    <div class="card">
        <div class="card-header">
            <h2>Form Tambah Tamu</h2>
        </div>
        <div class="card-body">
            <form id="tamu-form" enctype="multipart/form-data">
                @csrf
                <!-- Gambar --> 
                <div class="mb-4"> 
                    <label for="gambarInput" class="block text-sm font-medium text-gray-700 mb-1">Gambar <span class="text-red-500">*</span></label> 
                    <div class="flex gap-2 mb-2">
                        <button type="button" id="cameraBtn" class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors">
                            <i class="fas fa-camera"></i> Ambil Foto
                        </button>
                        <button type="button" id="galleryBtn" class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            <i class="fas fa-image"></i> Pilih dari Galeri
                        </button>
                    </div>
                    <input type="file" id="gambarInput" name="gambar" accept="image/*" required class="hidden"> 
                    <div id="imagePreview" class="mt-2 hidden">
                        <img id="previewImg" src="" alt="Preview" class="max-w-xs max-h-48 rounded-md border border-gray-300">
                        <button type="button" id="removeImage" class="ml-2 px-2 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
                    <video id="cameraVideo" class="hidden w-full max-w-md h-auto rounded-md border border-gray-300 mt-2"></video>
                    <canvas id="cameraCanvas" class="hidden"></canvas>
                    <div id="cameraControls" class="hidden mt-2 flex gap-2">
                        <button type="button" id="captureBtn" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            <i class="fas fa-camera"></i> Ambil Foto
                        </button>
                        <button type="button" id="cancelCameraBtn" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                            <i class="fas fa-times"></i> Batal
                        </button>
                    </div>
                </div> 
                
                <!-- Jenis Tamu --> 
                <div class="mb-4"> 
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Tamu <span class="text-red-500">*</span></label> 
                    <div class="flex flex-wrap gap-2"> 
                        <label class="flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-300 cursor-pointer hover:bg-blue-50"> 
                            <input type="radio" name="jenis_tamu" value="Tamu Warga" class="accent-blue-600" required> 
                            <i class="fas fa-user-friends text-blue-600"></i> Tamu Warga 
                        </label> 
                        <label class="flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-300 cursor-pointer hover:bg-blue-50"> 
                            <input type="radio" name="jenis_tamu" value="Ojek Online" class="accent-cyan-600"> 
                            <i class="fas fa-map-pin text-cyan-600"></i> Ojek Online 
                        </label> 
                        <label class="flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-300 cursor-pointer hover:bg-blue-50"> 
                            <input type="radio" name="jenis_tamu" value="Kurir" class="accent-yellow-600"> 
                            <i class="fas fa-truck text-yellow-600"></i> Kurir 
                        </label> 
                        <label class="flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-300 cursor-pointer hover:bg-blue-50"> 
                            <input type="radio" name="jenis_tamu" value="Lainnya" class="accent-gray-600"> 
                            <i class="fas fa-question text-gray-600"></i> Lainnya 
                        </label> 
                    </div> 
                </div> 
                
                <!-- Plat Nomor --> 
                <div class="mb-4"> 
                    <label for="platNomor" class="block text-sm font-medium text-gray-700 mb-1">Plat Nomor <span class="text-red-500">*</span></label> 
                    <input type="text" id="platNomor" name="plat_nomor" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"> 
                </div> 
                
                <!-- Tanggal --> 
                <div class="mb-4"> 
                    <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal <span class="text-red-500">*</span></label> 
                    <input type="date" id="tanggal" name="tanggal" value="{{ \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"> 
                </div> 
                
                <!-- Jam Masuk --> 
                <div class="mb-4"> 
                    <label for="jamMasuk" class="block text-sm font-medium text-gray-700 mb-1">Jam Masuk <span class="text-red-500">*</span></label> 
                    <div class="flex gap-2"> 
                        <input type="time" id="jamMasuk" name="jam_masuk" value="{{ \Carbon\Carbon::now('Asia/Jakarta')->format('H:i') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"> 
                        <button type="button" id="jamSekarangBtn" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 whitespace-nowrap">
                            <i class="fas fa-clock"></i> Sekarang
                        </button> 
                    </div> 
                </div> 
                
                <!-- Jam Keluar --> 
                <div class="mb-4"> 
                    <label for="jamKeluar" class="block text-sm font-medium text-gray-700 mb-1">Jam Keluar</label> 
                    <input type="time" id="jamKeluar" name="jam_keluar" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"> 
                </div> 
                
                <!-- Posisi --> 
                <div class="mb-4"> 
                    <label class="block text-sm font-medium text-gray-700 mb-2">Posisi <span class="text-red-500">*</span></label> 
                    <div class="flex gap-2"> 
                        <label class="flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-300 cursor-pointer hover:bg-blue-50"> 
                            <input type="radio" name="posisi" value="sedang didalam" class="accent-yellow-600" checked required> 
                            <i class="fas fa-clock text-yellow-600"></i> Di Dalam 
                        </label> 
                    </div> 
                </div> 
                
                <!-- Tujuan --> 
                <div class="mb-4"> 
                    <label for="tujuan" class="block text-sm font-medium text-gray-700 mb-1">Tujuan <span class="text-red-500">*</span></label> 
                    <input type="text" id="tujuan" name="tujuan" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"> 
                </div>
                
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">Tambah Tamu</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Camera functionality
let stream = null;
const video = document.getElementById('cameraVideo');
const canvas = document.getElementById('cameraCanvas');
const ctx = canvas.getContext('2d');
const cameraBtn = document.getElementById('cameraBtn');
const galleryBtn = document.getElementById('galleryBtn');
const captureBtn = document.getElementById('captureBtn');
const cancelCameraBtn = document.getElementById('cancelCameraBtn');
const gambarInput = document.getElementById('gambarInput');
const imagePreview = document.getElementById('imagePreview');
const previewImg = document.getElementById('previewImg');
const removeImageBtn = document.getElementById('removeImage');
const cameraControls = document.getElementById('cameraControls');

// Jam Sekarang functionality
const jamSekarangBtn = document.getElementById('jamSekarangBtn');
const jamMasukInput = document.getElementById('jamMasuk');

jamSekarangBtn.addEventListener('click', function() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const currentTime = `${hours}:${minutes}`;
    
    jamMasukInput.value = currentTime;
    
    // Visual feedback
    jamSekarangBtn.classList.add('bg-green-500');
    jamSekarangBtn.classList.remove('bg-blue-500');
    jamSekarangBtn.innerHTML = '<i class="fas fa-check"></i> Diperbarui';
    
    setTimeout(() => {
        jamSekarangBtn.classList.remove('bg-green-500');
        jamSekarangBtn.classList.add('bg-blue-500');
        jamSekarangBtn.innerHTML = '<i class="fas fa-clock"></i> Sekarang';
    }, 1500);
});

// Open camera
cameraBtn.addEventListener('click', async function() {
    try {
        // Request camera access with back camera preference for mobile
        const constraints = {
            video: {
                facingMode: { ideal: 'environment' }, // Back camera
                width: { ideal: 1280 },
                height: { ideal: 720 }
            }
        };
        
        stream = await navigator.mediaDevices.getUserMedia(constraints);
        video.srcObject = stream;
        video.classList.remove('hidden');
        cameraControls.classList.remove('hidden');
        
        // Hide buttons
        cameraBtn.style.display = 'none';
        galleryBtn.style.display = 'none';
        
        video.play();
    } catch (err) {
        console.error('Error accessing camera:', err);
        Swal.fire({
            icon: 'error',
            title: 'Kamera Tidak Tersedia',
            text: 'Tidak dapat mengakses kamera. Pastikan browser memiliki izin kamera.'
        });
    }
});

// Capture photo
captureBtn.addEventListener('click', function() {
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    ctx.drawImage(video, 0, 0);
    
    // Convert canvas to blob
    canvas.toBlob(function(blob) {
        const file = new File([blob], 'camera-photo.jpg', { type: 'image/jpeg' });
        
        // Create a new FileList-like object
        const dt = new DataTransfer();
        dt.items.add(file);
        gambarInput.files = dt.files;
        
        // Show preview
        const url = URL.createObjectURL(blob);
        previewImg.src = url;
        imagePreview.classList.remove('hidden');
        
        // Stop camera
        stopCamera();
        
        Swal.fire({
            icon: 'success',
            title: 'Foto Berhasil Diambil!',
            showConfirmButton: false,
            timer: 1500
        });
    }, 'image/jpeg', 0.8);
});

// Cancel camera
cancelCameraBtn.addEventListener('click', function() {
    stopCamera();
});

// Gallery button
galleryBtn.addEventListener('click', function() {
    gambarInput.click();
});

// Handle file input change
gambarInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const url = URL.createObjectURL(file);
        previewImg.src = url;
        imagePreview.classList.remove('hidden');
    }
});

// Remove image
removeImageBtn.addEventListener('click', function() {
    gambarInput.value = '';
    imagePreview.classList.add('hidden');
    previewImg.src = '';
    
    // Show buttons again
    cameraBtn.style.display = 'flex';
    galleryBtn.style.display = 'flex';
});

// Stop camera function
function stopCamera() {
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    }
    video.classList.add('hidden');
    cameraControls.classList.add('hidden');
    
    // Show buttons again
    cameraBtn.style.display = 'flex';
    galleryBtn.style.display = 'flex';
}

// Form submission
document.getElementById('tamu-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('{{ route("satpam.tambah-tamu") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location.href = '{{ route("satpam.daftar-tamu") }}';
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data.message || 'Terjadi kesalahan saat menambahkan tamu'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Terjadi kesalahan saat menambahkan tamu'
        });
    });
});
</script>

<style>
/* Mobile scrolling fix */
.mobile-scroll-container {
    height: auto;
    overflow: visible;
}

@media (max-width: 768px) {
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
    }
    
    /* Mobile scrolling fixes */
    .mobile-scroll-container {
        height: auto !important;
        max-height: none !important;
        overflow: visible !important;
        padding-bottom: 3rem !important;
    }
    
    .card {
        margin-bottom: 1rem !important;
        overflow: visible !important;
    }
    
    .card-body {
        overflow: visible !important;
        padding-bottom: 2rem !important;
    }
    
    /* Fix for camera video on mobile */
    #cameraVideo {
        max-width: 100%;
        height: auto;
    }
    
    /* Ensure form elements are properly sized on mobile */
    .flex.gap-2 {
        flex-wrap: wrap;
    }
    
    .flex.gap-2 button {
        flex: 1;
        min-width: 120px;
    }
    
    /* Fix for image preview on mobile */
    #imagePreview img {
        max-width: 100%;
        height: auto;
    }
    
    /* Form button spacing */
    button[type="submit"] {
        margin-bottom: 2rem !important;
    }
    
    /* Responsive form elements for 390px width */
    @media (max-width: 390px) {
        .flex.gap-2 button {
            min-width: 100px;
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
        }
        
        #jamSekarangBtn {
            font-size: 0.75rem;
            padding: 0.5rem;
        }
        
        .card-body {
            padding: 1rem !important;
        }
        
        .mb-4 {
            margin-bottom: 1rem !important;
        }
    }
}

/* Desktop scrolling */
@media (min-width: 769px) {
    .mobile-scroll-container {
        height: auto !important;
        overflow: visible !important;
    }
    
    #main-content .p-6 {
        height: auto !important;
        overflow: visible !important;
    }
}
</style>
@endsection