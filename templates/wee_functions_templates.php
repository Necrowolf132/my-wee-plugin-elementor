<?php

add_filter( 'theme_page_templates', 'wee_add_templates' );
function wee_add_templates( $templates ) {
 
	$templates['wee-template-full-sin-header.php'] = __( 'Extencion template elementor', 'my-elementor-extencion' );
 
	return $templates;
 
}

	
add_filter( 'page_template', 'wee_template_redirect' );
function wee_template_redirect( $template ) {
 
	$plugin_dir = dirname( __FILE__ );
 
	if ( is_page_template( 'wee-template-full-sin-header.php' ) ) {
 
		$template = $plugin_dir . '/modelos/wee-template-full-sin-header.php';
 
	}
 
	return $template;
 
}

?>