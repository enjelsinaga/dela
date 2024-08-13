document.addEventListener("DOMContentLoaded", function () {
    const navLinks = document.querySelectorAll('.custom-nav .nav-link');
    const sections = document.querySelectorAll('section');

    // Function to update visibility of sections
    function updateSectionVisibility(targetId) {
        sections.forEach(section => {
            if (section.id === targetId) {
                section.style.display = 'block'; // show the current section
            } else {
                section.style.display = 'none'; // hide other sections
            }
        });

        navLinks.forEach(link => {
            if (link.getAttribute('href') === '#' + targetId) {
                link.classList.add('active'); // add active class to the current link
            } else {
                link.classList.remove('active'); // remove active class from other links
            }
        });
    }

    // Initialize the page with the registration form active
    updateSectionVisibility('student-registration');

    // Add click event listener to nav links
    navLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1); // get the id without the hash
            updateSectionVisibility(targetId);
        });
    });
});