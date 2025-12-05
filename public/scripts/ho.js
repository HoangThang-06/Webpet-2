// Toggle mobile menu
function toggleMenu() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('active');
}

// Close menu when clicking outside on mobile
document.addEventListener('click', function(event) {
    const sidebar = document.getElementById('sidebar');
    const menuToggle = document.querySelector('.menu-toggle');
    
    if (window.innerWidth <= 768) {
        if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
            sidebar.classList.remove('active');
        }
    }
});

// Filter buttons
const filterButtons = document.querySelectorAll('.filter-btn');

filterButtons.forEach(button => {
    button.addEventListener('click', function() {
        filterButtons.forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');
    });
});

// Menu links (highlight active but allow navigation)
const menuLinks = document.querySelectorAll('.menu-link:not(.logout)');

menuLinks.forEach(link => {
    link.addEventListener('click', function() {
        menuLinks.forEach(l => l.classList.remove('active'));
        this.classList.add('active');
        // Không preventDefault nữa -> link chuyển trang bình thường
    });
});