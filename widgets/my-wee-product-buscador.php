<?php
namespace My_elementor_extencion\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class wee_Elementor_buscador_header extends Widget_Base {

	private static $reload = false;
 
	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		self::$reload = false;
		return 'wee_Elementor_buscador_header';
	}
	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Elementor Wee Buscador Header', 'wee_elementor-test-extension' );
	}
	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */

	
	public function get_icon() {
		return 'eicon-search';
	}
	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
        //return ['extencion-de-elementor-playful'];
        return ['extencion-de-elementor-playful'];
    }
    

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_style_depends(){

		return [ 'header-elementor-boostrap', 'buscador-elementor-my-estilos', 'select2' ];
	}
	public function get_script_depends() {
       // add_action( 'elementor/preview/enqueue_styles', function() {
       //     wp_enqueue_style('header-elementor-boostrap');
       // });
     /* add_action( 'elementor/frontend/after_enqueue_styles', function() {
        wp_enqueue_style( 'header-elementor-boostrap' );
        wp_enqueue_style( 'header-elementor-my-estilos');
     } );
     add_action( 'elementor/preview/enqueue_styles', function() {
        wp_enqueue_style( 'header-elementor-boostrap' );
        wp_enqueue_style( 'header-elementor-my-estilos');
     } );*/
        //
	   return [ 'bootstarp-js-extencion-elementor', 'vue-elementor', 'widget-buscador' ,'selectWoo'];
    }
    public function add_style_depends($handler) {
        $this->depended_styles[] = $handler;
    }
	
	public function is_reload_preview_required() {
		return true;
	}


    protected function _control_section_inputs_content(){
		if(function_exists('wc_get_attribute_taxonomies')){
			$array_attributes = wc_get_attribute_taxonomies();
		}
		$this->start_controls_section(
			'section_inputs',
			[
                'label' => __( 'Inputs de búsqueda', 'header-elementor-my-estilos' ),
                'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		if(!empty($array_attributes)){
			$valores_select_inputs=[];
			foreach($array_attributes as $locations_item => $name){ 
				$valores_select_inputs[$name->attribute_id] = $name->attribute_label;
			}
				$this->add_control(
					'select_atributes',
					[
						'label' => __( 'Elegir filtros', 'header-elementor-my-estilos' ),
						'type' => Controls_Manager::SELECT2,
						'description' => "Aqui debe escoger tantos filtros de busqueda como atributos creados existan y desee seleccionar",
						'multiple' => true,
						'options' => $valores_select_inputs,
						'default' => [ ],
					]
				);
		} else {
			$this->add_control(
				'select_atributes',
				[
					'label' => __( 'Elegir filtros', 'header-elementor-my-estilos' ),
					'type' => Controls_Manager::SELECT2,
					'description' => "No se puede seleccionar ningun Filtro de atributo, debido a que no existe ningun atributo creado",
                    'default' => [ ],
                    'options' => [
                        
                    ]
				]
			);
		}		
		$this->add_control(
			'buscar_por_categoria',
			[
				'label' => __( 'Buscar por categoria', 'header-elementor-my-estilos' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'SI', 'header-elementor-my-estilos' ),
				'label_off' => __( 'NO', 'header-elementor-my-estilos' ),
				'return_value' => 'true',
				'default' => 'false',
			]
		);
		$this->add_control(
			'numero_categoria',
			[
				'label' => __( 'Mostrar numero de las categorias', 'header-elementor-my-estilos' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'SI', 'header-elementor-my-estilos' ),
				'label_off' => __( 'NO', 'header-elementor-my-estilos' ),
				'return_value' => 'true',
				'default' => 'false',
			]
		);
        $this->end_controls_section();

	}
	
	protected function _control_section_menu_content(){
		$locations = get_nav_menu_locations();
		$this->start_controls_section(
			'section_menu',
			[
                'label' => __( 'Menu header', 'header-elementor-my-estilos' ),
                'tab' => Controls_Manager::TAB_CONTENT,
			]
        );
        if(!empty($locations)){
            $valores_select=[];
            foreach($locations as $locations_item => $name){
                $aux = wp_get_nav_menu_object( $name );    
                $valores_select[$name] = $aux->name;
            }
            $this->add_control(
                'select_menu',
                [
                    'label' => __( 'Elegir menu', 'header-elementor-my-estilos' ),
                    'type' => Controls_Manager::SELECT,
                    'description' => "Aqui debe seleccionar el menu segun la posicion en la que se allá creado y colocado en el administrador de menus de wordpress",
                    'default' => '',
                    'options' => $valores_select,
                ]
            );            
        } else { 
            $this->add_control(
                'select_menu',
                [
                    'label' => __( 'Elegir menu', 'header-elementor-my-estilos' ),
                    'type' => Controls_Manager::SELECT,
                    'description' => "No se puede seleccionar ningun menu, por que no se allá establesido ninguno en el administrador de menus",
                    'default' => '',
                    'options' => [
                        
                    ]
                ]
            );  
        }
        $this->end_controls_section();
	}

    protected function _control_section_buscador_style(){
		$this->start_controls_section(
			'section_style_inputs',
			[
				'label' => __( 'Style Busqueda Inputs', 'header-elementor-my-estilos' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );
		$this->add_responsive_control(
			'width_inputs',
			[
				'label' => __( 'Width de inputs', 'header-elementor-my-estilos' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .my-column' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'columna_fila',
			[
				'label' => __( 'Mostrar en Fila/Colunma', 'header-elementor-my-estilos' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Fila', 'header-elementor-my-estilos' ),
				'label_off' => __( 'Columna', 'header-elementor-my-estilos' ),
				'return_value' => 'Columna',
				'default' => 'Fila',
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_logo_typography',
				'selector' => '{{WRAPPER}} span.wee_header-title',
			]
		);
		$this->add_control(
			'text_transform',
			[
				'label' => __( 'Text menu Transform', 'elementor-hello-world' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'elementor-hello-world' ),
					'uppercase' => __( 'UPPERCASE', 'elementor-hello-world' ),
					'lowercase' => __( 'lowercase', 'elementor-hello-world' ),
					'capitalize' => __( 'Capitalize', 'elementor-hello-world' ),
				],
				'selectors' => [
					'{{WRAPPER}} span.wee_header-title' => 'text-transform: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
	}
	protected function _control_section_menu_header_style(){
        $this->start_controls_section(
			'section_style_menu',
			[
				'label' => __( 'Style Menu', 'elementor-hello-world' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'menu_color',
			[
				'label' => __( 'Color enlaces', 'elementor-hello-world' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .wee_navbar  ul>li>a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'menu_color_link_hover',
			[
				'label' => __( 'Color enlaces Hover', 'elementor-hello-world' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .wee_navbar  ul>li>a:hover' => 'color: {{VALUE}}',
				],
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_menu_typography',
				'selectors' => '{{WRAPPER}} .wee_navbar ul>li>a',
			]
		);
		$this->add_control(
			'text_transform_menu',
			[
				'label' => __( 'Text Transform', 'elementor-hello-world' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'elementor-hello-world' ),
					'uppercase' => __( 'UPPERCASE', 'elementor-hello-world' ),
					'lowercase' => __( 'lowercase', 'elementor-hello-world' ),
					'capitalize' => __( 'Capitalize', 'elementor-hello-world' ),
				],
				'selectors' => [
					'{{WRAPPER}} .wee_navbar  ul>li>a' => 'text-transform: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'hover_animation_link',
			[
				'label' => __( 'Hover Links', 'elementor-hello-world' ),
				'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
				'prefix_class' => 'wee-animation-hover',
			]
		);
		$this->add_responsive_control(
			'margin_links',
			[
				'label' => __( 'Espaciado entre enlaces', 'elementor-hello-world' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .nav-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'icon_menu',
			[
				'label' => __( 'Icono de menu movil', 'elementor-hello-world' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-bars',
					'library' => 'solid',
				],
			]
		);

		$this->end_controls_section();
    }
	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {

        $this->_control_section_inputs_content();

		$this->_control_section_menu_content();
        
		$this->_control_section_buscador_style();
		
		$this->_control_section_menu_header_style();
	}
	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
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
		var_dump($products[0]->get_attributes());
		
		?>

		<div id="buscador-wee-<?php echo $this->get_id();?>" data-id="<?php echo $this->get_id();?>" class="container-fluid buscador-class-general buscador-class-<?php echo $this->get_id();?>">
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
		$this->_add_script();
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
	protected function _content_template() {
		//$menus_selecionado = $this->get_settings_for_display('select_menu');
		return "";
        
    }

}
?>