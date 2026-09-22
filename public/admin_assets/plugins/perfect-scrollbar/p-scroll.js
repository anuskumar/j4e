(function ($) {
	"use strict";

	function initPerfectScrollbar(selector, options) {
		var element = document.querySelector(selector);
		if (!element) {
			return null;
		}

		try {
			return new PerfectScrollbar(element, options);
		} catch (error) {
			console.warn('PerfectScrollbar skipped for ' + selector, error);
			return null;
		}
	}

	var scrollOptions = {
		useBothWheelAxes: true,
		suppressScrollX: true,
	};

	initPerfectScrollbar('.chat-scroll', scrollOptions);
	window.adminNotificationScrollbar = initPerfectScrollbar('.Notification-scroll', scrollOptions);

	$(document).on('click', '.main-header-notification > a', function () {
		if (window.adminNotificationScrollbar && typeof window.adminNotificationScrollbar.update === 'function') {
			setTimeout(function () {
				window.adminNotificationScrollbar.update();
			}, 50);
		}
	});
})(jQuery);
