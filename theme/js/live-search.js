jQuery(document).ready(function ($) {
	let searchTimer;
	const searchToggleBtn = $('#search-toggle-btn');
	const searchContainer = $('#live-search-container');
	const searchInput = $('#live-search-input');
	const resultsContainer = $('#search-results');

	// Toggle search container on mobile button click
	searchToggleBtn.on('click', function (e) {
		e.preventDefault();
		e.stopPropagation();
		searchContainer.slideToggle(200);
		searchContainer.toggleClass('max-lg:hidden');

		if (!searchContainer.hasClass('max-lg:hidden')) {
			searchInput.focus();
		}
	});

	// Handle search input
	searchInput.on('input', function () {
		clearTimeout(searchTimer);
		const searchTerm = $(this).val();

		if (searchTerm.length < 3) {
			resultsContainer.html('').addClass('hidden');
			return;
		}

		resultsContainer
			.html('<div class="p-3 text-center">Searching...</div>')
			.removeClass('hidden');

		searchTimer = setTimeout(function () {
			$.ajax({
				url: liveSearch.ajaxurl,
				type: 'POST',
				data: {
					action: 'live_search',
					nonce: liveSearch.nonce,
					search_term: searchTerm,
				},
				success: function (response) {
					if (response.success && response.data.length > 0) {
						let output =
							'<div class="divide-y divide-gray-950/5 dark:divide-white/10">';
						response.data.forEach(function (item) {
							output += `
                <a href="${item.url}" class="flex items-center gap-x-2.5 p-3 transition-colors hover:bg-slate-50 dark:hover:bg-slate-800/50 group">
                  ${
						item.thumbnail
							? `<figure class="flex-shrink-0 w-14 h-12"><img src="${item.thumbnail}" alt="${item.title}" class="w-full h-full object-cover rounded wp-post-image"/></figure>`
							: ''
					}
								<div class="flex-1 min-w-0">
									<h4 class="font-medium article-title group-hover:text-blue-600 dark:group-hover:text-blue-400 line-clamp-2">${item.title}</h4>
								</div>
							</a>`;
						});
						output += '</div>';

						// Add View More button
						output += `
								<div class="p-3 flex justify-center">
										<a href="${liveSearch.searchurl}?s=${encodeURIComponent(searchTerm)}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md transition-colors dark:bg-blue-500 dark:hover:bg-blue-600">
											View More Results
											<svg class="ml-1.5 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
												<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
											</svg>
										</a>
								</div>`;

						resultsContainer.html(output);
					} else {
						resultsContainer.html(
							'<div class="p-3 text-center">No results found</div>'
						);
					}
				},
				error: function () {
					resultsContainer.html(
						'<div class="p-3 text-center">Error performing search</div>'
					);
				},
			});
		}, 500);
	});

	// Close when clicking outside
	$(document).on('click', function (event) {
		if (
			!$(event.target).closest('#live-search-container').length &&
			!$(event.target).closest('#search-toggle-btn').length
		) {
			if ($(window).width() < 1024) {
				// 1024px is the lg breakpoint
				searchContainer.slideUp(200);
				searchContainer.addClass('max-lg:hidden');
			}
			resultsContainer.addClass('hidden');
		}
	});

	// Prevent search container from closing when clicking inside
	searchContainer.on('click', function (e) {
		e.stopPropagation();
	});
});
