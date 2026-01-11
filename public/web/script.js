document.addEventListener('DOMContentLoaded', function() {
    // Basic filter button interaction
    const filterBtns = document.querySelectorAll('.filter-btn');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all
            filterBtns.forEach(b => b.classList.remove('active'));
            // Add active class to clicked
            this.classList.add('active');
        });
    });

    // Pagination interaction
    const pageLinks = document.querySelectorAll('.page-link');
    
    pageLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            pageLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Placeholder for search functionality
    const searchInput = document.querySelector('.search-input');
    searchInput.addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            console.log('Searching for:', this.value);
            // In a real app, this would trigger a search
        }
    });
    // View Toggle Logic
    const btnListView = document.getElementById('btnListView');
    const btnGridView = document.getElementById('btnGridView');
    const contentGrid = document.getElementById('contentGrid');

    if (btnListView && btnGridView && contentGrid) {
        btnListView.addEventListener('click', function() {
            // Activate List View
            contentGrid.classList.add('list-view');
            contentGrid.classList.remove('row-cols-2', 'row-cols-md-4', 'row-cols-lg-4');
            contentGrid.classList.add('row-cols-1');
            
            // Update buttons
            btnListView.classList.add('active');
            btnGridView.classList.remove('active');
        });

        btnGridView.addEventListener('click', function() {
            // Activate Grid View
            contentGrid.classList.remove('list-view');
            contentGrid.classList.remove('row-cols-1');
            contentGrid.classList.add('row-cols-2', 'row-cols-md-4', 'row-cols-lg-4');
            
            // Update buttons
            btnGridView.classList.add('active');
            btnListView.classList.remove('active');
        });
    }

    // Back to Top Button Logic
    const backToTopBtn = document.getElementById('backToTop');

    if (backToTopBtn) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTopBtn.classList.add('show');
            } else {
                backToTopBtn.classList.remove('show');
            }
        });

        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});
