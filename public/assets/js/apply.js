document.addEventListener("DOMContentLoaded", function() {
    const sections = document.querySelectorAll("section");
    const navLinks = document.querySelectorAll(".nav-link");
    const navSection = document.getElementById("navSection");
    const navbar = document.getElementById("principal-nav");

    function updateNavPosition() {
        if (navbar) {
            const navbarHeight = navbar.offsetHeight;
            const navSectionHeight = navSection.offsetHeight;
            navSection.style.top = `${navbarHeight}px`;
            sections.forEach(section => {
                section.style.scrollMarginTop = `${navbarHeight + navSectionHeight}px`; // Ajuste adicional
            });
        }
    }

    updateNavPosition();

    window.addEventListener("scroll", function() {
        let current = "";
        const navbarHeight = navbar.offsetHeight;
        const navSectionHeight = navSection.offsetHeight;

        sections.forEach(section => {
            const sectionTop = section.offsetTop - (navbarHeight + navSectionHeight);
            if (window.scrollY >= sectionTop) {
                current = section.getAttribute("id");
            }
        });

        navLinks.forEach(link => {
            link.classList.remove("active");
            if (link.getAttribute("href").substring(1) === current) {
                link.classList.add("active");
            }
        });
    });
});
