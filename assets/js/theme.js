(function () {
    // 1. Determine initial theme
    const savedTheme = localStorage.getItem('fiverst_theme') || 'dark';
    document.documentElement.setAttribute('data-theme', savedTheme);

    // 2. Wait for DOM content to bind toggle button
    window.addEventListener('DOMContentLoaded', () => {
        const themeToggleBtn = document.getElementById('theme-toggle');
        
        // Update button icon/text initially
        updateToggleIcon(themeToggleBtn, savedTheme);

        if (themeToggleBtn) {
            themeToggleBtn.addEventListener('click', () => {
                const currentTheme = document.documentElement.getAttribute('data-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

                // Apply transition class temporarily to animate colors
                document.body.classList.add('theme-transition');
                
                // Toggle theme attribute
                document.documentElement.setAttribute('data-theme', newTheme);
                localStorage.setItem('fiverst_theme', newTheme);
                
                // Update icon
                updateToggleIcon(themeToggleBtn, newTheme);

                // Remove transition class after animation completes
                setTimeout(() => {
                    document.body.classList.remove('theme-transition');
                }, 400);
            });
        }
    });

    function updateToggleIcon(btn, theme) {
        if (!btn) return;
        
        // Find icon inside button or change button content
        const icon = btn.querySelector('i');
        if (icon) {
            if (theme === 'dark') {
                icon.className = 'fa-solid fa-sun text-warning';
            } else {
                icon.className = 'fa-solid fa-moon text-primary';
            }
        }
    }
})();
