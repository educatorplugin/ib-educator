window.IBEducator || (window.IBEducator = {});

/**
 * requestAnimationFrame polyfill.
 */
(function() {
	'use strict';

	var lastTime = 0;
	var vendors = ['ms', 'moz', 'webkit', 'o'];
	for(var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
		window.requestAnimationFrame = window[vendors[x]+'RequestAnimationFrame'];
		window.cancelAnimationFrame = window[vendors[x]+'CancelAnimationFrame'] 
								   || window[vendors[x]+'CancelRequestAnimationFrame'];
	}
 
	if (!window.requestAnimationFrame)
		window.requestAnimationFrame = function(callback, element) {
			var currTime = new Date().getTime();
			var timeToCall = Math.max(0, 16 - (currTime - lastTime));
			var id = window.setTimeout(function() { callback(currTime + timeToCall); }, 
			  timeToCall);
			lastTime = currTime + timeToCall;
			return id;
		};
 
	if (!window.cancelAnimationFrame)
		window.cancelAnimationFrame = function(id) {
			clearTimeout(id);
		};
}());

(function($) {
	'use strict';

	/**
	 * Custom radio form control.
	 */
	function CustomRadio(radios) {
		this.radios = radios;
		this.init();
	}

	CustomRadio.prototype = {
		init: function() {
			var that = this;

			this.radios.each(function(i, radio) {
				var customRadio = $('<button class="custom-radio"></button>');
				if (radio.checked) {
					customRadio.addClass('checked');
				}
				customRadio.insertBefore(radio);
				customRadio.on('click', function(e) {
					e.preventDefault();
					that.onRadioClick(this);
				});
			});
		},

		onRadioClick: function(radio) {
			var jRadio = $(radio);

			this.radios.each(function(i, radio) {
				$(radio).prev('button').removeClass('checked');
			});

			if (!jRadio.hasClass('checked')) {
				jRadio.addClass('checked');
				jRadio.next('input[type="radio"]').attr('checked', 'checked');
			} else {
				jRadio.removeClass('checked');
				jRadio.next('input[type="radio"]').removeAttr('checked');
			}
		}
	};

	IBEducator.customRadio = function(radios) {
		return new CustomRadio(radios);
	};

	function ToggleLesson(el) {
		this.el = $(el);
		this.init();
	}

	ToggleLesson.prototype = {
		init: function() {
			this.excerpt = this.el.find('.excerpt');

			if (!this.excerpt.length) {
				return;
			}

			this.addHandle();
		},

		addHandle: function() {
			var that = this;

			this.handle = $('<span class="handle"></span>');
			this.handle.appendTo(this.el.find('h1,h4'));
			this.handle.on('click', function(e) {
				e.preventDefault();
				that.toggle();
			});
		},

		toggle: function() {
			if (this.el.hasClass('open')) {
				this.el.removeClass('open');
			} else {
				this.el.addClass('open');
			}
		}
	};

	IBEducator.toggleLesson = function(el) {
		return new ToggleLesson(el);
	};

	/**
	 * Transition end event name.
	 *
	 * @return {string}
	 */
	IBEducator.transitionEnd = function() {
		var names = {
			WebkitTransition: 'webkitTransitionEnd',
			MozTransition: 'transitionend',
			transition: 'transitionend'
		};

		return names[Modernizr.prefixed('transition')];
	};

	/**
	 * This function executes event callback after a given timeout.
	 */
	function delayEvent(func, threshold) {
		var timeout;
		threshold = threshold || 100;

		return function() {
			var obj = this, args = arguments;

			if (timeout) clearTimeout(timeout);

			timeout = setTimeout(function() {
				func.apply(obj, args);
				timeout = null;
			}, threshold);
		};
	}

	jQuery.fn['smartresize'] = function(fn) {
		return fn ? this.on('resize', delayEvent(fn)) : this.trigger('smartresize');
	};
})(jQuery);
