protected function render() {
        //wp_enqueue_style('header-elementor-boostrap');
        //wp_enqueue_style( 'header-elementor-my-estilos');
       //$this->add_style_depends([ 'header-elementor-boostrap','header-elementor-my-estilos' ]);
        $settings = $this->get_settings_for_display();

        //var_dump(wp_get_nav_menu_items($settings["select_menu"]));
        //echo $settings['title'];
        //$menu_id   = $locations["main_menu"] ;
		//$locationsitems_menu =  wp_get_nav_menu_items( $menu_id );
		$array_attributes = wc_get_attribute_taxonomies();
		$valores_select_pru=[];
		foreach($array_attributes as $locations_item => $name){ 
			$valores_select_pru[$name->attribute_label] = $name->attribute_id;
		}
		//var_dump($valores_select_pru);
	//	var_dump($settings['select_atributes']);
//		var_dump($settings['columna_fila']);
$arrays_filtros = [];
$products = wc_get_products(array(
	'limit' => -1,
	));
/*if(!empty($settings['select_atributes'])) {
	foreach($settings['select_atributes'] as $attributo_actual) {
		$attributes_all = wc_get_attribute($attributo_actual);
		$attributes_terms = get_terms(array(
			'taxonomy' => $attributes_name->slug
		));
		foreach($attributes_terms as $attributes_terms_actual){
			$array_final = [];
			foreach($settings['select_atributes'] as $attributo_actual2){
				$attributes_all2 = wc_get_attribute($attributo_actual2);
				foreach( $products as $producto_actual) {
					$prod_atri = $producto_actual->get_attributes();
					if($prod_atri[$attributes_all->slug]->options[0] == $attributes_terms_actual->id ){
						foreach($settings['select_atributes'] as $attributo_actual3){
							$attributes_all3 = wc_get_attribute($attributo_actual);
							if(!empty($array_final[$attributes_all3->slug]) ){
								$agregable = x; 
								foreach($array_final[$attributes_all3->slug] as $options){

								}
							}
						}
					}
				}
				//$arrays_filtros[$attributes_all->slug][$attributes_terms_actual->id] = 
			}		
		}
		$attributes_name = $attributes_all->name;
		$attributes_slug= $attributes_all->name;
		var_dump($attributes_all);
	}
}*/
		var_dump($products[0]->get_attributes());;
		
		?>

		<div id="buscador-wee-<?phpecho $this->get_id();?>" data-id="<?php echo $this->get_id();?>" class="container-fluid buscador-class-general buscador-class-<?php echo $this->get_id();?>">
			{{mensaje}}
				<div class="row d-flex justify-content-between align-items-center  <?php  echo $settings['columna_fila']=='Columna' ?  'flex-column' : 'flex-row';?>">
				<?php   $tolal_terms = [];
					if(!empty($settings['select_atributes'])) {
            			foreach($settings['select_atributes'] as $attributo_actual) {
							$attributes_name = wc_get_attribute($attributo_actual);
							$attributes_terms = get_terms(array(
								'taxonomy' => $attributes_name->slug
							));
							$attributes_name = $attributes_name->name;
						    //var_dump(wc_get_attribute($attributo_actual));
							//var_dump(get_terms($attributes_terms));	
				?>
					<input-atributo v-bind:input_mensaje="mensaje"></input-atributo>
					<div class="my-column">
						<label>Filtrar por <?php  echo $attributes_name; ?></label>
						<select name=" product_<?php  echo $attributes_name; ?>"  v-model="mensaje" id="select_<?php  echo $attributes_name; ?>" class="buscador_select2 dropdown_product_wooSelect select2-hidden-accessible"  tabindex="-1" aria-hidden="true">
							<option value="" selected="selected">Seleccione <?php  echo $attributes_name; ?></option>
						<?php  if(!empty($attributes_terms)) {
            				foreach($attributes_terms as $attributo_terms_aux) {
						?>
							<option class="level-0" value="<?php  echo $attributo_terms_aux->slug; ?>"><?php  echo $attributo_terms_aux->name; ?></option>
						<?php  }
						} ?>
						</select>
					</div>
					<?php  }
					} ?>
				</div>
		</div>
	<?php 
		//$this->_add_script();
	} 
//
//
//
//
//
//
	protected function _add_script(){
		if( \Elementor\Plugin::instance()->editor->is_edit_mode() )  { ?>
			<script type="text/javascript" >
				    jQuery(function($) {
						var selectables = jQuery('.dropdown_product_wooSelect');
							if ( jQuery().selectWoo && selectables) {
									for(var count = 0; selectables.length > count; count++){
										jQuery(selectables[count]).selectWoo( {
														placeholder: 'Select a category',
														minimumResultsForSearch: 5,
														width: '100%',
														allowClear: true,
														language: {
															noResults: function() {
																return 'No existe coincidencia';
															}
														}
													}); 
									}
									
								}       
					});
					var buscadores = jQuery('.buscador-class-general');
        			var BuscadoresApp = [];
					for(var count = 0; buscadores.length > count; count++){
						ID_actual = jQuery(buscadores[count]).attr('id');
						BuscadoresApp[count] = new Vue({
													el:"#"+ID_actual,
													data:{
															mensaje: 'hola mundo Vue '+ID_actual
													}                
													});
					}   
			</script>
		<?php 
		}
	}
	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */