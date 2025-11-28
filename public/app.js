// SISKAR BN666 App
console.log('SISKAR BN666 App Loaded.');

// Dark Mode Toggle
(function() {
    const currentTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', currentTheme);
    
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
    
    document.addEventListener('DOMContentLoaded', function() {
        if (!document.querySelector('.theme-toggle')) {
            const btn = document.createElement('button');
            btn.className = 'theme-toggle';
            btn.innerHTML = '<i class="fas fa-moon"></i>';
            document.body.appendChild(btn);
            updateIcon(currentTheme);
            btn.addEventListener('click', toggleTheme);
        }
    });
})();