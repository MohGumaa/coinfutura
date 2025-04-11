document.addEventListener('DOMContentLoaded', function () {
	initializeTheme();
	setupThemeToggleListeners();
	watchSystemPreference();
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
