document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const toggleSidebar = document.getElementById('toggle-sidebar');
    const pageContents = document.querySelectorAll('.page-content');
    const navLinks = document.querySelectorAll('.sidebar-menu a');
    const modal = document.getElementById('confirmation-modal');
    const modalClose = document.getElementById('modal-close');
    const cancelBtn = document.getElementById('cancel-btn');
    const confirmBtn = document.getElementById('confirm-btn');
    const tamuForm = document.getElementById('tamu-form');

    // Toggle Sidebar
    if (toggleSidebar) {
        toggleSidebar.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });
    }
    
    // Check screen size on load and set appropriate classes
    function checkScreenSize() {
        if (window.innerWidth <= 768) {
            sidebar.classList.add('collapsed');
            mainContent.classList.add('expanded');
        } else {
            sidebar.classList.remove('collapsed');
            mainContent.classList.remove('expanded');
        }
    }
    
    // Initial check
    checkScreenSize();

    // Navigation
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Don't prevent default to allow navigation to the URL
            // But still handle active class
            
            // Remove active class from all links
            navLinks.forEach(item => item.classList.remove('active'));
            
            // Add active class to clicked link
            this.classList.add('active');
            
            // Close sidebar on mobile
            if (window.innerWidth < 768) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            }
        });
    });
    
    // Set active menu item based on current URL
    function setActiveMenuItem() {
        const currentPath = window.location.pathname;
        navLinks.forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    }
    
    // Call on page load
    setActiveMenuItem();

    // Modal Handling
    function openModal() {
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal() {
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    // Example of how to trigger modal (attach to delete buttons)
    document.querySelectorAll('.btn-danger').forEach(btn => {
        btn.addEventListener('click', openModal);
    });

    if (modalClose) modalClose.addEventListener('click', closeModal);
    if (cancelBtn) cancelBtn.addEventListener('click', closeModal);
    if (confirmBtn) {
        confirmBtn.addEventListener('click', function() {
            closeModal();
            alert('Data tamu berhasil dihapus!');
            // Add your delete logic here
        });
    }

    // Form Submission
    if (tamuForm) {
        tamuForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Data tamu berhasil disimpan!');
            this.reset();
            
            // Switch to guest list after submission
            const daftarTamuLink = document.querySelector('#daftar-tamu-link');
            if (daftarTamuLink) daftarTamuLink.click();
        });
    }

    // Responsive adjustments
    window.addEventListener('resize', function() {
        checkScreenSize();
    });

    // Simple animation for page transitions
    function animatePage() {
        const activePage = document.querySelector('.page-content.active');
        if (activePage) {
            activePage.classList.add('fade-in');
        }
    }

    // Run animation when page loads
    animatePage();
});