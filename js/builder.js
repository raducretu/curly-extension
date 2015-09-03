jQuery(document).ready(function(){
	"use strict";
	
	// Bind Hide Builder
	jQuery('#curly_shortcode_builder').on('click', function () {
		curly_hide_builder();
	});
	
	// Bind Shortcode Buttons
	curly_bind_shortcode_buttons();
});

// Show Builder
function curly_show_builder() {
	jQuery('#curly_shortcode_builder').fadeIn();
	
}

// Hide Builder
function curly_hide_builder() {
	jQuery('#curly_shortcode_builder').fadeOut();
}

// Bind Shortcode Buttons
function curly_bind_shortcode_buttons() {
	
	// 1/2 Column
	jQuery('#curly-sc-col-12').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[column size="1/2" margin="" last="no"]...[/column]');
		curly_hide_builder();
	});
	
	// 1/3 Column
	jQuery('#curly-sc-col-13').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[column size="1/3" margin="" last="no"]...[/column]');
		curly_hide_builder();
	});
	
	// 1/4 Column
	jQuery('#curly-sc-col-14').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[column size="1/4" margin="" last="no"]...[/column]');
		curly_hide_builder();
	});
	
	// 2/3 Column
	jQuery('#curly-sc-col-23').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[column size="2/3" margin="" last="no"]...[/column]');
		curly_hide_builder();
	});
	
	// 2/4 Column
	jQuery('#curly-sc-col-24').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[column size="2/4" margin="" last="no"]...[/column]');
		curly_hide_builder();
	});
	
	// 3/4 Column
	jQuery('#curly-sc-col-34').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[column size="3/4" margin="" last="no"]...[/column]');
		curly_hide_builder();
	});
	
	// Full Width Box
	jQuery('#curly-sc-fullwidth').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[full-width-box size="" image="" background="" background_position="" background_repeat="" background_size="" background_attachment="" border="" border_color="" padding_top="" padding_bottom=""]...[/full-width-box]');
		curly_hide_builder();
	});
	
	// Featured Box
	jQuery('#curly-sc-featured-box').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[box style="default, 1, 2, 3, 4, 5" icon="" title="" background=""]...[/box]');
		curly_hide_builder();
	});
	
	// Call 2 Action
	jQuery('#curly-sc-action').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[call2action title="" link="" button="" style="default, 1, 2, 3, 4, 5"]...[/call2action]');
		curly_hide_builder();
	});
	
	// Divider
	jQuery('#curly-sc-divider').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[divider style="1, 2, 3, 4, 5" before="" after=""]');
		curly_hide_builder();
	});
	
	// Dropcap
	jQuery('#curly-sc-dropcap').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[dropcap]D[/dropcap]');
		curly_hide_builder();
	});
	
	// Abbreviation
	jQuery('#curly-sc-abbr').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[abbr title=""]...[/abbr]');
		curly_hide_builder();
	});
	
	// Featured Paragraph
	jQuery('#curly-sc-highlight').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[highlight align="left, right, center" style="default, different"]...[/highlight]');
		curly_hide_builder();
	});
	
	// Blockquote
	jQuery('#curly-sc-blockquote').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[blockquote cite="Person Name" image=""]...[/blockquote]');
		curly_hide_builder();
	});
	
	// Lists
	jQuery('#curly-sc-lists').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[list type="default, bullets, square, circle, checklist, crosslist"]<ul><li>Option One</li><li>Option Two</li></ul>[/list]');
		curly_hide_builder();
	});
	
	// Text Rotator
	jQuery('#curly-sc-text-rotator').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[simple-text-rotator animation="fade" separator="|" speed="2000"]Text 1 | Text 2 | Text 3[/simple-text-rotator]');
		curly_hide_builder();
	});
	
	// Text Marker
	jQuery('#curly-sc-text-marker').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[marker color="default, red, blue, orange, green, black"]...[/marker]');
		curly_hide_builder();
	});
	
	// Alert Box
	jQuery('#curly-sc-alert').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[alert color="yellow, red, blue, green"]...[/alert]');
		curly_hide_builder();
	});
	
	// Clear
	jQuery('#curly-sc-clear').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[clear]');
		curly_hide_builder();
	});
	
	// Icon
	jQuery('#curly-sc-icon').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[icon icon="" position="left, right" boxed="no" size="2x, 3x, 4x, 5x" color="" bg="" border=""]');
		curly_hide_builder();
	});
	
	// Button
	jQuery('#curly-sc-button').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[button link="#" color="default, red, green, blue, violet, navy, gray" size="mini, small, normal, large" title="Add a Button Title" target="_self" rel="nofollow"] Button Text [/button]');
		curly_hide_builder();
	});
	
	// Accordion
	jQuery('#curly-sc-accordion').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[accordion] <br> [toggle title="Some title" opened="yes"] Description [/toggle] <br> [toggle title="Some title" opened="no"] Description [/toggle] <br> [/accordion]');
		curly_hide_builder();
	});
	
	// Tabs
	jQuery('#curly-sc-tabs').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[tabs tab1="Title Tab 1" tab2="Title Tab 2"] <br> [tab id="1"] Content tab 1 [/tab] <br> [tab id="2"] Content tab 2 [/tab] <br> [/tabs]');
		curly_hide_builder();
	});
	
	// Progress
	jQuery('#curly-sc-progress').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[progress color="red, blue, green, orange" percent="50"]...[/progress]');
		curly_hide_builder();
	});
	
	// Toggle
	jQuery('#curly-sc-toggle').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[toggle-box title="Toggle Title"]...[/toggle-box]');
		curly_hide_builder();
	});
	
	// Testimonials
	jQuery('#curly-sc-testimonials').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[testimonials speed="5000" height="auto, equal"] <br> [testimonial name="" image=""] Testimonial Body [/testimonial] <br> [/testimonials]');
		curly_hide_builder();
	});
	
	// Team / Person
	jQuery('#curly-sc-team').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[person name="" position="" picture="" style="default, mini" facebook="" twitter="" linkedin="" email=""] Descriptive text [/person]');
		curly_hide_builder();
	});
	
	// Clients
	jQuery('#curly-sc-clients').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[clients] <br> [client name="" link="" image=""] <br> [client name="" link="" image=""] <br> [/clients]');
		curly_hide_builder();
	});
	
	// Slider
	jQuery('#curly-sc-slider').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[slider speed="5000" height="auto, equal"] <br> [slide] Slide 1 Content [/slide] <br> [slide] Slide 2 Content [/slide] <br> [/slider]');
		curly_hide_builder();
	});
	
	// Countdown
	jQuery('#curly-sc-countdown').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[countdown year="" month="" day="" hour="" minutes="" lang="" align="left, center, right"]');
		curly_hide_builder();
	});
	
	// Google Map
	jQuery('#curly-sc-map').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[map-maker latitude="" longitude="" type="roadmap" zoom="15" height="400"][/map-maker]');
		curly_hide_builder();
	});
	
	// Vimeo
	jQuery('#curly-sc-vimeo').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[vimeo id="(e.g. video id number 61589662)" width="700" height="390" fullwidth="yes"]');
		curly_hide_builder();
	});
	
	// YouTube
	jQuery('#curly-sc-youtube').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[youtube id="(e.g. video id number R4em3LKQCAQ)" width="700" height="390" fullwidth="yes"]');
		curly_hide_builder();
	});
	
	// Zoomify
	jQuery('#curly-sc-zoomify').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[picture-zoom image="image file"]');
		curly_hide_builder();
	});
	
	// Photo Frame
	jQuery('#curly-sc-photo-frame').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[photo-frame]...[/photo-frame]');
		curly_hide_builder();
	});
	
	// Lightbox
	jQuery('#curly-sc-lightbox').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[pretty-photo gallery="" title="" image="image file" visible="yes"]...[/pretty-photo]');
		curly_hide_builder();
	});
	
	// Weather
	jQuery('#curly-sc-weather').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[simple-weather location="London, Uk" latitude="" longitude="" days="2" night="no" units="metric" date="l"]');
		curly_hide_builder();
	});
	
	// QR Code
	jQuery('#curly-sc-qr').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[simple-qr size="" align="" type="" margin="" pointer_text="" pointer_color="" pointer_position=""]');
		curly_hide_builder();
	});
	
	// Pricing Table
	jQuery('#curly-sc-pricing').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[pricing-table]<br>[pricing-column size="1/2, 1/3, 1/4" last="no" highlight="no"]<br>[pricing-header currency="" price="" frequency=""] Title [/pricing-header]<br>[pricing-row] Description [/pricing-row]<br>[pricing-footer][button link="#" color="default, red, green, blue, violet, navy, gray" size="mini, small, large"] Button Text [/button][/pricing-footer]<br>[/pricing-column] <br>[/pricing-table]');
		curly_hide_builder();
	});
	
	// Event Agenda
	jQuery('#curly-sc-agenda').click(function (e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[agenda] <br> [event-day date=""] Day Name [/event-day] <br> [event time="" room=""] [/event] <br> [/agenda]');
		curly_hide_builder();
	});
}