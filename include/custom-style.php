body {
	color: <?php echo $text_color; ?>;
	font-family: <?php echo $body_font; ?>;
	font-size: <?php echo $font_size . 'px'; ?>;
}

h1, h2, h3, h4, h5, h6, .site-title {
	color: <?php echo $headings_color; ?>;
	font-family: <?php echo $headings_font; ?>;
	font-weight: <?php echo $headings_font_weight; ?>;
}

#main-logo img {max-height: <?php echo intval( get_theme_mod( 'logo_height', 28 ) ); ?>px;}

.ib-edu-course-price .price,
.ib-edu-price-widget .price,
.ib-edu-form fieldset legend,
.ib-edu-question .label,
.educator-share-links .label,
.dm3-testimonial-name,
.drop-down > a,
.drop-down:hover > a,
.drop-down.open > a,
#payment-details td:first-child,
.payment-total,
.payment-total + dd,
.lesson-compact h1 > a,
ul.edr-syllabus-lessons h4 > a,
ul.products h3,
.woocommerce-breadcrumb a,
.product_list_widget li > a,
td.product-name > a {
	color: <?php echo $headings_color; ?>;
	font-weight: <?php echo $bold_font_weight; ?>;
}

strong,
label,
table th,
#main-nav > ul > li > a,
#auth-nav .auth-nav-login,
#user-nav .user-menu-name,
.ib-edu-courses .title,
.pagination .text,
.pagination .page-numbers,
.woocommerce-pagination a.page-numbers,
.woocommerce-pagination span.page-numbers,
.post-grid .price,
.post-fw .price,
.ib-edu-memberships .price,
.related-courses .price,
ul.products .price,
.comment-author .fn,
.the-tabs a,
.page-links,
.button,
.ib-edu-button,
input#submit,
.search-submit,
.post-password-form input[type="submit"],
.button-primary,
.dm3-btn,
.ib-edu-lessons .ib-edu-lesson:before,
.lessons-nav li:before,
.lessons-nav span,
.ib-edu-lesson-meta .quiz,
.product .onsale,
.tagcloud a,
.widget_rss .rsswidget,
#wp-calendar caption,
dt,
.post-navigation .post-title {
	font-weight: <?php echo $bold_font_weight; ?>;
}

.dm3-tabs-nav a,
.the-tabs a,
.dm3-collapse-trigger a {
	color: #333;
	font-weight: <?php echo $bold_font_weight; ?>;
}

#mobile-nav .auth-nav a,
#mobile-nav .user-menu-name {
	font-weight: <?php echo $bold_font_weight; ?>;
}

.ib-edu-lessons article h1 a,
.entry-title a,
blockquote,
body .dm3-tabs-testimonials blockquote,
.ib-edu-memberships h2 a {
	color: <?php echo $headings_color; ?>;
}

a,
.edu-js-pager-nav button {
	color: <?php echo $main_color; ?>;
}

a:hover,
.edu-js-pager-nav button:hover {
	color: <?php echo $hover_color; ?>;
}

.button,
.ib-edu-button,
input#submit,
.search-submit,
.post-password-form input[type="submit"],
.button-primary,
.dm3-btn {
	border-color: <?php echo $main_color; ?>;
	color: <?php echo $main_color; ?>;
}

.ib-edu-lessons .ib-edu-completed:before,
.lessons-nav .ib-edu-completed:before {
	border-color: <?php echo $main_color; ?>;
	color: <?php echo $main_color; ?>;
}

.button:hover,
.ib-edu-button:hover,
input#submit:hover,
.search-submit:hover,
.post-password-form input[type="submit"]:hover,
.button-primary:hover,
.dm3-btn:hover,
.css3-loader-inner div,
#main-nav > ul > .current-menu-item > a:after,
#main-nav > ul > .current-menu-parent > a:after,
#main-nav .sub-menu:before,
#user-nav ul:before,
.dm3-tabs-testimonials .dm3-tabs-nav .active a,
.flex-control-paging .flex-active:after,
.owl-page.active span,
.owl-dot.active span,
.product .onsale {
	background-color: <?php echo $main_color; ?>;
}

#main-nav > ul > li:hover > a,
#main-nav > ul > .current-menu-item > a,
#main-nav > ul > .current-menu-parent > a,
#main-nav .sub-menu a:hover,
#user-nav li a:hover,
#header-search button:hover,
#header-search.open button,
#auth-nav .auth-nav-login:hover,
.hentry .ib-edu-lessons article h1 a:hover,
.ib-edu-memberships h2 a:hover,
.entry-title a:hover,
.post-grid .price,
.post-fw .price,
ul.products .price,
.related-courses .price,
.ib-edu-memberships .price,
.no-touch .post-meta a:hover,
.post-meta .price,
.comment-metadata a:hover,
.dm3-box-icon-center .dm3-box-icon-icon span,
.dm3-box-icon-left .dm3-box-icon-icon,
.page-sidebar .cat-item a:hover,
.page-sidebar .widget_archive a:hover,
.page-sidebar .recentcomments a:hover,
.page-sidebar .widget_recent_entries a:hover,
.page-sidebar .menu-item a:hover,
.page-sidebar .page_item a:hover,
.custom-radio:before,
#user-nav:hover .user-menu-name,
.ib-edu-message:before,
.ib-edu-lesson-meta .quiz,
.lessons-nav a:hover,
#page-toolbar .cart-stats a:hover,
.ib-edu-courses .open-description:hover,
.product_list_widget li > a:hover,
td.product-name > a:hover {
	color: <?php echo $main_color; ?>;
}

.ib-edu-message:after {
	border-color: <?php echo $main_color; ?>;
}

.post-badge:before {
	border-color: <?php echo $main_color; ?> <?php echo $main_color; ?> transparent transparent;
}

#main-nav .sub-menu > li:last-child > a:hover,
#user-nav ul > li:last-child > a:hover {
	border-color: <?php echo $hover_bg; ?>;
}

.educator-share-links a:hover,
.share-links-menu .educator-share-links a:hover {
	background-color: <?php echo $hover_bg; ?>;
	color: <?php echo $text_color; ?>;
}

.no-touch .share-links-menu:hover > a,
.share-links-menu.open > a,
.dm3-tabs-nav a:hover,
.dm3-collapse-trigger a:hover,
.the-tabs a:hover,
.drop-down.open > a .icon,
.pagination .next:hover,
.pagination .prev:hover,
#main-nav .sub-menu a:hover,
#user-nav li a:hover,
.drop-down li a:hover {
	background-color: <?php echo $hover_bg; ?>;
	color: <?php echo $hover_text; ?>;
}

.dm3-tabs-nav .active a,
.dm3-collapse-open .dm3-collapse-trigger a,
.the-tabs .active a {
	background-color: #fff;
	color: <?php echo $hover_text; ?>;
}

.post-fw .post-meta,
.post-grid .post-meta,
.page-sidebar .widget,
.lecturers-grid,
#main-nav .sub-menu,
#user-nav .menu {
	box-shadow: 0 1px 2px 0 rgba(0,0,0,.07);
}
