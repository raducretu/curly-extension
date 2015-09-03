<?php
add_shortcode("countdown", "countdown"); 		

function countdown( $atts, $content = null ) {

	extract(shortcode_atts(array(
				'year'		=> null,
				'month'		=> null,
				'day'		=> null,
				'hour'		=> 0,
				'minutes'	=> 00,
				'lang'		=> 'en',
				'align'		=> 'left'
	), $atts)); 
	
	wp_enqueue_script('curly-countdown', 'jquery');
	
	switch ($lang) {
		case 'ar' : wp_enqueue_script('countdown-ar', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-ar.js'); break;
		case 'bg' : wp_enqueue_script('countdown-bg', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-bg.js'); break;
		case 'bn' : wp_enqueue_script('countdown-bn', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-bn.js'); break;
		case 'bs' : wp_enqueue_script('countdown-bs', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-bs.js'); break;
		case 'ca' : wp_enqueue_script('countdown-ca', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-ca.js'); break;
		case 'cs' : wp_enqueue_script('countdown-cs', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-cs.js'); break;
		case 'cy' : wp_enqueue_script('countdown-cy', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-cy.js'); break;
		case 'da' : wp_enqueue_script('countdown-da', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-da.js'); break;
		case 'de' : wp_enqueue_script('countdown-de', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-de.js'); break;
		case 'el' : wp_enqueue_script('countdown-el', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-el.js'); break;
		case 'es' : wp_enqueue_script('countdown-es', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-es.js'); break;
		case 'et' : wp_enqueue_script('countdown-et', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-et.js'); break;
		case 'fa' : wp_enqueue_script('countdown-fa', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-fa.js'); break;
		case 'fi' : wp_enqueue_script('countdown-fi', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-fi.js'); break;
		case 'fr' : wp_enqueue_script('countdown-fr', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-fr.js'); break;
		case 'gl' : wp_enqueue_script('countdown-gl', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-gl.js'); break;
		case 'gu' : wp_enqueue_script('countdown-gu', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-gu.js'); break;
		case 'he' : wp_enqueue_script('countdown-he', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-he.js'); break;
		case 'hr' : wp_enqueue_script('countdown-hr', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-hr.js'); break;
		case 'hu' : wp_enqueue_script('countdown-hu', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-hu.js'); break;
		case 'hy' : wp_enqueue_script('countdown-hy', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-hy.js'); break;
		case 'id' : wp_enqueue_script('countdown-id', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-id.js'); break;
		case 'it' : wp_enqueue_script('countdown-it', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-it.js'); break;
		case 'ja' : wp_enqueue_script('countdown-ja', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-ja.js'); break;
		case 'kn' : wp_enqueue_script('countdown-kn', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-kn.js'); break;
		case 'ko' : wp_enqueue_script('countdown-ko', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-ko.js'); break;
		case 'lt' : wp_enqueue_script('countdown-lt', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-lt.js'); break;
		case 'lv' : wp_enqueue_script('countdown-lv', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-lv.js'); break;
		case 'ml' : wp_enqueue_script('countdown-ml', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-ml.js'); break;
		case 'ms' : wp_enqueue_script('countdown-ms', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-ms.js'); break;
		case 'my' : wp_enqueue_script('countdown-my', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-my.js'); break;
		case 'nb' : wp_enqueue_script('countdown-nb', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-nb.js'); break;
		case 'nl' : wp_enqueue_script('countdown-nl', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-nl.js'); break;
		case 'pl' : wp_enqueue_script('countdown-pl', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-pl.js'); break;
		case 'pt-BR' : wp_enqueue_script('countdown-pt-BR', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-pt-BR.js'); break;
		case 'ro' : wp_enqueue_script('countdown-ro', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-ro.js'); break;
		case 'ru' : wp_enqueue_script('countdown-ru', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-ru.js'); break;
		case 'sk' : wp_enqueue_script('countdown-sk', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-sk.js'); break;
		case 'sl' : wp_enqueue_script('countdown-sl', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-sl.js'); break;
		case 'sq' : wp_enqueue_script('countdown-sq', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-sq.js'); break;
		case 'sr-SR' : wp_enqueue_script('countdown-sr-SR', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-sr-SR.js'); break;
		case 'sr' : wp_enqueue_script('countdown-sr', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-sr.js'); break;
		case 'sv' : wp_enqueue_script('countdown-sv', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-sv.js'); break;
		case 'th' : wp_enqueue_script('countdown-th', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-th.js'); break;
		case 'tr' : wp_enqueue_script('countdown-tr', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-tr.js'); break;
		case 'uk' : wp_enqueue_script('countdown-uk', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-uk.js'); break;
		case 'uz' : wp_enqueue_script('countdown-uz', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-uz.js'); break;
		case 'vi' : wp_enqueue_script('countdown-vi', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-vi.js'); break;
		case 'zh-CN' : wp_enqueue_script('countdown-zh-CN', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-zh-CN.js'); break;
		case 'zh-TW' : wp_enqueue_script('countdown-zh-TW', get_template_directory_uri() . '/js/countdown-localisation/jquery.countdown-zh-TW.js'); break;
	}	
	
	
	
	$start = strtotime(current_time('mysql'));
	$end =   strtotime(''.$year.'-'.$month.'-'.$day.' '.$hour.':'.$minutes);
	
	function diff($x,$y,$interval){
		return (int)(($x-$y)/$interval);
	}
	
	$days=diff($end,$start,86400);
	$hours=diff($end,$start+$days*86400,3600);
	$minutes=diff($end,$start+$days*86400+$hours*3600,60);
	$seconds=$end-$start-$days*86400-$hours*3600-$minutes*60;
	
	if($days <= 0) $days="00"; elseif($days < 10) $days = '0'.$days;
	if($hours <= 0) $hours="00"; elseif($hours < 10) $hours = '0'.$hours;
	if($minutes <= 0) $minutes="00"; elseif($minutes < 10) $minutes = '0'.$minutes;
	if($seconds <= 0) $seconds="00"; elseif($seconds < 10) $seconds = '0'.$seconds;
	
	$time = $days.':'.$hours.':'.$minutes.':'.$seconds;
	
	if ( $year ) {
	
	$html = "<script type='text/javascript'>
				(function($) {
					var counter = {
						init: function (d)
						{
							jQuery('#counter').countdown({
								until: new Date(d),
								layout: counter.layout(),
							});
						},
						layout: function ()
						{
							return  '<div class=\"count-col text-center\"><span class=\"countdown_amount\">{dn}</span><span class=\"countdown_descr\">{dl}</span></div>' + 
									'<div class=\"count-col text-center\"><span class=\"countdown_amount\">{hnn}</span><span class=\"countdown_descr\">{hl}</span></div>' + 
									'<div class=\"count-col text-center\"><span class=\"countdown_amount\">{mnn}</span><span class=\"countdown_descr\">{ml}</span></div>' + 
									'<div class=\"count-col text-center\"><span class=\"countdown_amount\">{snn}</span><span class=\"countdown_descr\">{sl}</span></div>';
						}
					}

					// initialize the counter
					jQuery(document).ready(function() {
						counter.init('".$month."/".$day."/".$year." ".$hour.":".$minutes."');
					});
				})(jQuery);
			  </script>";
			  	  
	$html .= '<div class="curly-counter clearfix" style="text-align: '.$align.'"><div id="counter"></div></div>';
	
	} else {
		$html = null;
	}
	
    return $html;  
} 

?>