<?php
/** 
* Override or insert variables into the html template. 
*/ 
function corkedscrewer_preprocess_html(&$variables) {
	if (!theme_get_setting('responsive_respond','corkedscrewer')):
	drupal_add_css(path_to_theme() . '/css/basic-layout.css', array('group' => CSS_THEME, 'browsers' => array('IE' => '(lte IE 8)&(!IEMobile)', '!IE' => FALSE), 'preprocess' => FALSE));
	endif;

	drupal_add_css(path_to_theme() . '/css/ie.css', array('group' => CSS_THEME, 'browsers' => array('!IE' => FALSE), 'preprocess' => FALSE));
}


/**
 * Add javascript files for jquery slideshow.
 */
if (theme_get_setting('slideshow_js','corkedscrewer')):

	drupal_add_js(drupal_get_path('theme', 'corkedscrewer') . '/js/jquery.cycle.all.js');
	
	//Initialize slideshow using theme settings
	$effect=theme_get_setting('slideshow_effect','corkedscrewer');
	$effect_time=theme_get_setting('slideshow_effect_time','corkedscrewer')*1000;
	$slideshow_randomize=theme_get_setting('slideshow_randomize','corkedscrewer');
	$slideshow_wrap=theme_get_setting('slideshow_wrap','corkedscrewer');
	$slideshow_pause=theme_get_setting('slideshow_pause','corkedscrewer');
	
	drupal_add_js('jQuery(document).ready(function($) {
	
		$(window).load(function() {

			$("#slideshow").fadeIn("fast");
			$("#slideshow .slides img").show();
			$("slideshow .slides").fadeIn("slow");
			$("slideshow .slide-control").fadeIn("slow");
			$("#slide-nav").fadeIn("slow");
		
			$(".slides").cycle({ 
				fx:      	"'.$effect.'", 
				speed:    	"slow",
	    		timeout: 	'.$effect_time.',
	    		random: 	'.$slideshow_randomize.',
	    		nowrap: 	'.$slideshow_wrap.',
	    		pause: 	  	'.$slideshow_pause.',
	    		prev:    	"#prev", 
	            next:    	"#next",
	            pager:  "#slide-nav",
				pagerAnchorBuilder: function(idx, slide) {
					return "#slide-nav li:eq(" + (idx) + ") a";
				},
				slideResize: true,
				containerResize: false,
				height: "auto",
				fit: 1,
				before: function(){
					$(this).parent().find(".slider-item.current").removeClass("current");
				},
				after: onAfter
			});
			
		});
		function onAfter(curr, next, opts, fwd) {
			var $ht = $(this).height();
			$(this).parent().height($ht);
			$(this).addClass("current");
		}

		$(window).load(function() {
			var $ht = $(".slider-item.current").height();
			$(".slides").height($ht);
		});

		$(window).resize(function() {
			var $ht = $(".slider-item.current").height();
			$(".slides").height($ht);
		});

	});',
	array('type' => 'inline', 'scope' => 'footer', 'weight' => 5)
	);

endif;

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return
 *   A string containing the breadcrumb output.
 */
function corkedscrewer_breadcrumb($variables){
	$breadcrumb = $variables['breadcrumb'];
	$breadcrumb_separator=theme_get_setting('breadcrumb_separator','corkedscrewer');

	if (!empty($breadcrumb)) {
		$breadcrumb[] = drupal_get_title();
		return '<div id="breadcrumb">' . implode(' <span class="breadcrumb-separator">' . $breadcrumb_separator . '</span>', $breadcrumb) . '</div>';
	}

}

/**
 * Page alter.
 */
function corkedscrewer_page_alter($page) {

	if (theme_get_setting('responsive_meta','corkedscrewer')):
		$mobileoptimized = array(
			'#type' => 'html_tag',
			'#tag' => 'meta',
			'#attributes' => array(
			'name' =>  'MobileOptimized',
			'content' =>  'width'
			)
		);

		$handheldfriendly = array(
			'#type' => 'html_tag',
			'#tag' => 'meta',
			'#attributes' => array(
			'name' =>  'HandheldFriendly',
			'content' =>  'true'
			)
		);

		$viewport = array(
			'#type' => 'html_tag',
			'#tag' => 'meta',
			'#attributes' => array(
			'name' =>  'viewport',
			'content' =>  'width=device-width, initial-scale=1'
			)
		);

		drupal_add_html_head($mobileoptimized, 'MobileOptimized');
		drupal_add_html_head($handheldfriendly, 'HandheldFriendly');
		drupal_add_html_head($viewport, 'viewport');
	endif;
}

?>
