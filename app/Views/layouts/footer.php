</main>

<!-- Back to Top Button -->
<button type="button" class="btn btn-crimson btn-lg" id="btn-back-to-top">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- Footer Container -->
<footer class="footer py-5 mt-5" style="background-color: var(--footer-bg); border-top: 1px solid var(--border-color); transition: var(--theme-transition);">
    <div class="container text-center">
        <a href="/">
            <img src="/assets/photo/FS_wordmark.webp?v=2" alt="Five Star Logo" width="151" height="60" class="mb-3">
        </a>
        <div class="d-flex justify-content-center gap-3 mb-4">
            <a href="https://www.instagram.com/" class="text-secondary fs-4 hover-gold" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="https://www.facebook.com/" class="text-secondary fs-4 hover-gold" target="_blank" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
            <a href="https://www.twitter.com/" class="text-secondary fs-4 hover-gold" target="_blank" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
        </div>
        <p class="text-secondary mb-0 small">&copy; <?= date("Y") ?> Five Star Hainanese Kampung Chicken Rice. All Rights Reserved.</p>
    </div>
</footer>

<!-- Bootstrap 5 Bundle JS (Includes Popper) -->
<script src="/assets/js/bootstrap.bundle.min.js"></script>

<!-- Global Interactions Script -->
<script>
    // Back to Top Button Interaction
    const backToTopBtn = document.getElementById("btn-back-to-top");

    window.onscroll = function() {
        scrollFunction();
    };

    function scrollFunction() {
        if (
            document.body.scrollTop > 100 ||
            document.documentElement.scrollTop > 100
        ) {
            backToTopBtn.style.display = "flex";
        } else {
            backToTopBtn.style.display = "none";
        }
    }

    backToTopBtn.addEventListener("click", () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
</script>
</body>
</html>
