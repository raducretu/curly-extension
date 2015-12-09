<?php
add_shortcode("pricing-table", "curly_pricingTable");
add_shortcode("curly_pricing_table", "curly_pricingTable"); 		

function curly_pricingTable( $atts, $content = null ) {
	extract(shortcode_atts(array(  
        "size" => '1', 
		"last" => 'no' 
    ), $atts)); 
	
	$css = 'wl-pricing-table light';
	 
    return '<div class="'.$css.'">'.apply_filters( 'the_content', $content).'</div>';  
} 

add_shortcode("pricing-header", "curly_pricing_table_header"); 
add_shortcode("curly_pricing_header", "curly_pricing_table_header"); 		

function curly_pricing_table_header( $atts, $content = null ) {
	extract(shortcode_atts(array(  
        "currency" => '$', 
		"price" => '55',
		"frequency" => 'monthly' 
    ), $atts)); 
	
	$html = '<div class="pricing-header">';
		$html .= ( $content ) ? '<h3>'.$content.'</h3>' : null;
		$html .= '<div class="pricing-row">';
		$html .= ( $price ) ? '<h4 style="text-align: center;"><span>'.$currency.$price.'</span></h4>' : null;
		$html .= ( $frequency ) ? '<em>'.$frequency.'</em>' : null;
		$html .= '</div>';
	$html .= '</div>';
	 
    return $html;  
} 

add_shortcode("pricing-column", "curly_pricing_table_column");
add_shortcode("curly_pricing_column", "curly_pricing_table_column");
 		

function curly_pricing_table_column( $atts, $content = null ) {
	extract(shortcode_atts(array( 
		"size" => '1/4', 
        "last" => 'no',
        "highlight" => 'no'
    ), $atts));
    
    $css = null;
	
	switch ( $size ){
		case '1/2'  : $css .= ' half'; break;
		case '1/3'  : $css .= ' one-three'; break;
		case '1/4'  : $css .= ' one-four'; break;
		default		: $css .= ' one-four';
	}
	
	$css .= ( filter_var( $highlight, FILTER_VALIDATE_BOOLEAN ) === true ) ? " highlight-column" : null;
	
	$css .= ( $last == "yes" ) ? " last" : null;
	
    return ( $content ) ? '<div class="content-column '.$css.'"><div class="pricing-table-content">'.apply_filters( 'the_content', $content).'</div></div>' : null;  
} 

add_shortcode("pricing-row", "curly_pricing_table_row"); 
add_shortcode("curly_pricing_row", "curly_pricing_table_row"); 		

function curly_pricing_table_row( $atts, $content = null ) {
    return ( $content ) ? '<span>'.$content.'</span>' : null;  
} 

add_shortcode("pricing-footer", "curly_pricing_table_footer"); 
add_shortcode("curly_pricing_footer", "curly_pricing_table_footer"); 		

function curly_pricing_table_footer( $atts, $content = null ) {
    return ( $content ) ? '<div class="pricing-footer">'.do_shortcode($content).'</div>' : null;  
} 

?>