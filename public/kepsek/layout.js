document.addEventListener("DOMContentLoaded", function() {
    const sidebarToggler = document.getElementById("sidebarToggle");
    const sidebarOverlay = document.querySelector(".sidebar-overlay");

    if (sidebarToggler) {
        sidebarToggler.addEventListener("click", function() {
            document.body.classList.toggle("sidebar-toggled");
        });
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener("click", function() {
            document.body.classList.remove("sidebar-toggled");
        });
    }
});


// Dark Mode Toggle
document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('themeToggle');
    const htmlElement = document.documentElement;
    
    // Load saved theme
    const savedTheme = localStorage.getItem('theme') || 'light';
    htmlElement.setAttribute('data-theme', savedTheme);
    updateThemeIcon(savedTheme);
    
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            const currentTheme = htmlElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            htmlElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        });
    }
    
    function updateThemeIcon(theme) {
        if (themeToggle) {
            const icon = themeToggle.querySelector('i');
            if (icon) {
                if (theme === 'dark') {
                    icon.className = 'fa-solid fa-sun';
                } else {
                    icon.className = 'fa-solid fa-moon';
                }
            }
        }
    }
});
