document.addEventListener('DOMContentLoaded', function () {
	initializeTheme();
	setupThemeToggleListeners();
	watchSystemPreference();

	// Mobile menu toggle functionality
	const primaryMenuBtn = document.getElementById('primary-menu-btn');
	const navigationContainer = document.getElementById('navigation-container');
	const headerNav = document.getElementById('header-nav');
	const html = document.documentElement;

	// Calculate and set navigation top position based on header height
	const updateNavPosition = () => {
		if (window.innerWidth < 1024) {
			const headerHeight = headerNav.offsetHeight;
			navigationContainer.style.top = `${headerHeight}px`;
			// Update the height calculation too
			navigationContainer.style.height = `calc(100dvh - ${headerHeight}px)`;
		} else {
			navigationContainer.style.height = '100%';
			navigationContainer.style.top = ''; // Reset top position
		}
	}

	// Run on page load
	updateNavPosition();

	// Also run on window resize
	window.addEventListener('resize', updateNavPosition);

	const handlePrimaryMenuBtnClick = () => {
		// Toggle aria-expanded
		const isExpanded =
			primaryMenuBtn.getAttribute('aria-expanded') === 'true';
		primaryMenuBtn.setAttribute('aria-expanded', !isExpanded);

		// Toggle menu visibility
		if (isExpanded) {
			// Hide menu
			navigationContainer.classList.add('max-lg:translate-x-[-100%]');
			navigationContainer.classList.remove('max-lg:translate-x-[0]');

			// Remove open class from menu button
			primaryMenuBtn.classList.remove('open');
		} else {
			// Show menu
			navigationContainer.classList.remove('max-lg:translate-x-[-100%]');
			navigationContainer.classList.add('max-lg:translate-x-[0]');

			// Add open class to menu button
			primaryMenuBtn.classList.add('open');
		}

		// Add overflow to HTML element
		html.classList.toggle('overflow-hidden');

		// Ensure proper positioning when menu is toggled
		updateNavPosition();
	};

	primaryMenuBtn.addEventListener('click', handlePrimaryMenuBtnClick);
});

function initializeTheme() {
	const hasStoredTheme = 'theme' in localStorage;
	const storedTheme = localStorage.getItem('theme');
	const systemDarkMode = window.matchMedia(
		'(prefers-color-scheme: dark)'
	).matches;

	// Determine which theme to apply
	let activeTheme;

	if (hasStoredTheme) {
		activeTheme = storedTheme;
		document.documentElement.classList.toggle(
			'dark',
			storedTheme === 'dark'
		);
	} else {
		activeTheme = 'system';
		document.documentElement.classList.toggle('dark', systemDarkMode);
	}
	updateActiveRadioButton(activeTheme);
}

function setupThemeToggleListeners() {
	const radioGroup = document.getElementById(
		'headlessui-radiogroup-:Rcaulb:'
	);
	if (!radioGroup) return;

	const radioButtons = {
		system: document.getElementById('headlessui-radio-:Rdcaulb:'),
		light: document.getElementById('headlessui-radio-:Rlcaulb:'),
		dark: document.getElementById('headlessui-radio-:Rtcaulb:'),
	};

	// Add click event listeners to each button
	if (radioButtons.system) {
		radioButtons.system.addEventListener('click', function () {
			localStorage.removeItem('theme');
			const systemDarkMode = window.matchMedia(
				'(prefers-color-scheme: dark)'
			).matches;
			document.documentElement.classList.toggle('dark', systemDarkMode);
			updateActiveRadioButton('system');
		});
	}

	if (radioButtons.light) {
		radioButtons.light.addEventListener('click', function () {
			localStorage.setItem('theme', 'light');
			document.documentElement.classList.remove('dark');
			updateActiveRadioButton('light');
		});
	}

	if (radioButtons.dark) {
		radioButtons.dark.addEventListener('click', function () {
			localStorage.setItem('theme', 'dark');
			document.documentElement.classList.add('dark');
			updateActiveRadioButton('dark');
		});
	}
}

function updateActiveRadioButton(mode) {
	const radioButtons = {
		system: document.getElementById('headlessui-radio-:Rdcaulb:'),
		light: document.getElementById('headlessui-radio-:Rlcaulb:'),
		dark: document.getElementById('headlessui-radio-:Rtcaulb:'),
	};

	// Remove checked state from all buttons
	Object.values(radioButtons).forEach((button) => {
		if (button) {
			button.setAttribute('aria-checked', 'false');
			button.setAttribute('data-headlessui-state', '');
			button.removeAttribute('data-checked');
			button.tabIndex = -1;
		}
	});

	// Set checked state on the active button
	if (radioButtons[mode]) {
		radioButtons[mode].setAttribute('aria-checked', 'true');
		radioButtons[mode].setAttribute('data-headlessui-state', 'checked');
		radioButtons[mode].setAttribute('data-checked', '');
		radioButtons[mode].tabIndex = 0;
	}
}

/**
 * Watch for changes to the system color scheme preference
 */
function watchSystemPreference() {
	const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');

	// Add event listener for changes to system preference
	mediaQuery.addEventListener('change', function (e) {
		// Only update if user has chosen to use system preference (no theme in localStorage)
		if (!('theme' in localStorage)) {
			document.documentElement.classList.toggle('dark', e.matches);
		}
	});
}
