const hamburger = document.getElementById('hamburger');
const mobileMenu = document.getElementById('mobileMenu');

// Toggle hamburger menu
hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('active');
    mobileMenu.classList.toggle('active');
});

// Close mobile menu when a link is clicked
const mobileLinks = mobileMenu.querySelectorAll('a');
mobileLinks.forEach(link => {
    link.addEventListener('click', () => {
        hamburger.classList.remove('active');
        mobileMenu.classList.remove('active');
    });
});

// Close mobile menu when clicking outside
document.addEventListener('click', (event) => {
    if (!event.target.closest('header')) {
        hamburger.classList.remove('active');
        mobileMenu.classList.remove('active');
    }
});