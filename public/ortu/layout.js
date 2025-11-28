// Load theme immediately
const savedTheme = localStorage.getItem('theme') || 'light';
document.documentElement.setAttribute('data-theme', savedTheme);

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

    // Dark Mode Toggle
    const currentTheme = localStorage.getItem('theme') || 'light';
    
    function toggleTheme() {
        const html = document.documentElement;
        const newTheme = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        html.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateIcon(newTheme);
    }
    
    function updateIcon(theme) {
        const icon = document.querySelector('.theme-toggle i');
        if (icon) icon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
    }
    
    if (!document.querySelector('.theme-toggle')) {
        const btn = document.createElement('button');
        btn.className = 'theme-toggle';
        btn.innerHTML = '<i class="fas fa-moon"></i>';
        document.body.appendChild(btn);
        updateIcon(currentTheme);
        btn.addEventListener('click', toggleTheme);
    }
});
