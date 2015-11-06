window.IBEducator || (window.IBEducator = {});

(function() {
	'use strict';

	function Pager(el, options) {
		this.el = el;
		this.options = options;
		this.curPage = 0;

		this.init();
	}

	Pager.prototype.init = function() {
		this.items = this.el.querySelectorAll('.' + this.options.itemClass);
		this.items = Array.prototype.slice.call(this.items);
		this.perPage = parseInt(this.el.getAttribute('data-perpage'), 10);

		this.setupNav();
		this.go('next');
	};

	Pager.prototype.setupNav = function() {
		var nav, links, left, right, leftText, rightText, pages;
		var that = this;

		nav = document.createElement('div');
		nav.className = 'edu-js-pager-nav';

		links = document.createElement('div');
		links.className = 'links';
		nav.appendChild(links);

		left = document.createElement('button');
		left.className = 'pager-left';
		links.appendChild(left);

		right = document.createElement('button');
		right.className = 'pager-right';
		links.appendChild(right);

		leftText = this.el.getAttribute('data-left');

		if (leftText) {
			left.innerHTML = leftText;
		}

		rightText = this.el.getAttribute('data-right');

		if (rightText) {
			right.innerHTML = rightText;
		}

		left.addEventListener('click', function() {
			that.go('prev');
		}, false);

		right.addEventListener('click', function() {
			that.go('next');
		}, false);

		pages = document.createElement('div');
		pages.className = 'pages';
		nav.appendChild(pages);

		if (this.items.length <= this.perPage) {
			nav.className += ' disabled';
		}

		this.el.parentNode.insertBefore(nav, this.el.nextSibling);

		this.nav = nav;
	};

	Pager.prototype.getNumPages = function() {
		return Math.ceil(this.items.length / this.perPage);
	};

	Pager.prototype.setPage = function(page) {
		var numPages = this.getNumPages();

		this.nav.querySelector('.pages').innerHTML = page + '/' + numPages;
	};

	Pager.prototype.go = function(dir) {
		var nextPage = (dir == 'next') ? this.curPage + 1 : this.curPage - 1;
		var fromIndex = (nextPage - 1) * this.perPage;
		var i;
		var toIndex;
		var item;
		var numPages = this.getNumPages();

		if (nextPage > numPages) {
			nextPage = 1;
			fromIndex = 0;
		} else if (nextPage < 1) {
			nextPage = numPages;
			fromIndex = (nextPage - 1) * this.perPage;
		}

		this.items.map(function(item) {
			if (item.className.indexOf('visible') > -1) {
				item.className = item.className.replace(new RegExp('(^|\\s+)visible(\\s+|$)'), ' ');
			}
		});

		this.setPage(nextPage);

		toIndex = fromIndex + this.perPage;

		for (i = fromIndex; i < toIndex; i++) {
			if (i >= this.items.length) {
				break;
			}

			item = this.items[i];
			item.className += ' visible';
		}

		this.curPage = nextPage;
	};

	IBEducator.Pager = Pager;
})();
