window.addEventListener('DOMContentLoaded', event => {
	// Navbar Shrink Function
	var navbarShrink = function() {
		const navbarCollapse = document.body.querySelector('#navbar');
		// if no navbar then return
		if (!navbarCollapse) {
			return;
		}
		
		// if we are at the top of page then remove the shrink tag, else remove the tag
		if (window.scrollY === 0) {
			navbarCollapse.classList.remove('navbar-shrink');
		} else {
			navbarCollapse.classList.add('navbar-shrink');
		}
	};

	// Shrink !!
	navbarShrink();

	// when page is scrolled shrink the navbar
	document.addEventListener('scroll', navbarShrink);
});