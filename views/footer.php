    <footer>

        <p class="copyright">© 2025 - Tous droits réservés | Noa • Armelle • Vladimir</p>

    </footer>
</body>
    <script>
        const menuHamburger = document.querySelector("#menu-hamburger");
        const navLinks = document.querySelector(".nav-link");

        menuHamburger.addEventListener("click", () => {
            navLinks.classList.toggle("mobile-menu");
        });
    </script>
</html>