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
