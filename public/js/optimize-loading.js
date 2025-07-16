// Script untuk mengoptimalkan loading halaman
document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk lazy loading gambar
    const lazyImages = document.querySelectorAll('img[data-src]');
    
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        lazyImages.forEach(function(img) {
            imageObserver.observe(img);
        });
    } else {
        // Fallback untuk browser yang tidak mendukung Intersection Observer
        lazyImages.forEach(function(img) {
            img.src = img.dataset.src;
            img.removeAttribute('data-src');
        });
    }
    
    // Optimasi rendering dengan requestAnimationFrame
    function optimizeRendering() {
        // Menunda operasi non-kritis sampai frame berikutnya
        window.requestAnimationFrame(function() {
            // Menerapkan kelas untuk animasi setelah halaman dimuat
            document.body.classList.add('loaded');
            
            // Inisialisasi komponen UI yang memerlukan JavaScript
            initializeUIComponents();
        });
    }
    
    function initializeUIComponents() {
        // Inisialisasi komponen UI yang memerlukan JavaScript
        const tables = document.querySelectorAll('table');
        tables.forEach(function(table) {
            table.classList.add('table-optimized');
        });
    }
    
    // Jalankan optimasi rendering
    optimizeRendering();
});