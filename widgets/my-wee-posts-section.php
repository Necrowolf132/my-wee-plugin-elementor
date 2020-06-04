<?php
namespace My_elementor_extencion\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class wee_Elementor_Section_posts extends Widget_Base {


 
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
		return 'wee_Elementor_Section_posts';
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
		return __( 'Elementor Wee Posts Section', 'wee_Elementor_Section_posts' );
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
		return 'eicon-gallery-grid';
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
        return [ 'bootstarp-js-extencion-elementor', 'widget-1' ];
    }
    public function add_style_depends($handler) {
        $this->depended_styles[] = $handler;
    }
    
    protected function _control_section_logo_content(){
        $this->start_controls_section(
			'section_logo',
			[
                'label' => __( 'Logo/Imagen', 'elementor-hello-world' ),
                'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'logo_link',
			[
				'label' => __( 'Link logo', 'plugin-domain' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'Colocar URL para el logo', 'plugin-domain' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
			]
		);
		$this->add_responsive_control(
			'width_logo',
			[
				'label' => __( 'Width de logo', 'plugin-domain' ),
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
					'{{WRAPPER}} .wee_logo' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'imagen_header',
			[
				'label' => __( 'Imagen/logo', 'elementor-hello-world' ),
                'type' => Controls_Manager::MEDIA ,
                'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_control(
			'title_x',
			[
				'label' => __( 'Title Logo', 'elementor-hello-world' ),
				'type' => Controls_Manager::TEXT,
				'default' =>''
			]
        );
        $this->end_controls_section();

	}
	
	protected function _control_section_menu_content(){
		$locations = get_nav_menu_locations();
		$this->start_controls_section(
			'section_menu',
			[
                'label' => __( 'Menu header', 'elementor-hello-world' ),
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
                    'label' => __( 'Elegir menu', 'elementor-hello-world' ),
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
                    'label' => __( 'Elegir menu', 'elementor-hello-world' ),
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

    protected function _control_section_title_header_style(){
        $this->start_controls_section(
			'section_style_title',
			[
				'label' => __( 'Style Title Header', 'elementor-hello-world' ),
				'tab' => Controls_Manager::TAB_STYLE,
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

        $this->_control_section_logo_content();

		$this->_control_section_menu_content();
        
		$this->_control_section_title_header_style();
		
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
		if(!empty($settings['logo_link']['is_external']) && !empty($settings['logo_link']['nofollow'])){
			$this->add_render_attribute(
				'wee-link',
				[
					'target' => '_blank',
					'rel' => 'nofollow'
				]
			);
		}elseif(empty($settings['logo_link']['is_external']) && !empty($settings['logo_link']['nofollow'])){
			$this->add_render_attribute(
				'wee-link',
				[
					'rel' => 'nofollow'
				]
			);
		}elseif(!empty($settings['logo_link']['is_external']) && empty($settings['logo_link']['nofollow'])){
			$this->add_render_attribute(
				'wee-link',
				[
					'target' => '_blank'
				]
			);
		}
        //var_dump(wp_get_nav_menu_items($settings["select_menu"]));
        //echo $settings['title'];
        //$menu_id   = $locations["main_menu"] ;
        //$locationsitems_menu =  wp_get_nav_menu_items( $menu_id );
		$href_atr=$this->get_render_attribute_string( 'wee-link');
		$productos = wc_get_products(array(
			'limit' => -1,
			'page'  => 1,
			'status' => 'publish',
		));
		$atributos_values_product = $productos[0]->get_attributes();
		$atributos_data = $productos[0]->get_data();
		//$atributos_product = $atributos_values_product[0]->get_options();
		//$atributos_values = $atributos_values_product[0]->get_position();
		echo "data";
		var_dump($atributos_data['attributes']);
		echo "atributos";
		var_dump($atributos_values_product[0]);
		
		//var_dump($atributos_product);
		echo "values";
		//var_dump($atributos_values);
		
		dynamic_sidebar('sidebar');
		?>
		<nav class='navbar navbar-expand-lg navbar-light'>
		<?php if(empty($settings['logo_link']['url'])){ 
			$url_image_aux=$settings['imagen_header']['url'];
		?>
			<img class='wee_logo d-inline-block align-top' width='712' height='442' src='<?php echo $url_image_aux; ?>' sizes='(max-width: 712px) 100vw, 712px'>
			<?php if(!empty($settings['title_x'])){ ?>
				<span class='wee_header-title'> <?php echo $settings['title_x']; ?> </span>
			<?php	} ?>
		<?php} else {
			$url_image_aux=$settings['imagen_header']['url'];
			$logo_link_aux=$settings['logo_link']['url'];
		?>
			<a class='navbar-brand' <?php echo $href_atr; ?>  href='<?php echo $logo_link_aux; ?>'>
				<img class='wee_logo d-inline-block align-top' width='712' height='442' src='<?php echo $url_image_aux; ?>' sizes='(max-width: 712px) 100vw, 712px'>
				<?php	if(!empty($settings['title_x'])){ ?>
						<span class='wee_header-title'><?php echo $settings[title_x]; ?></span>
				<?php	} ?>
       		</a>
		<?php	} ?>


		
		<button class='navbar-toggler'  type='button' data-toggle='collapse' data-target='#navbarNav-<?phpecho $this->get_id();?>' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
		<?php
			\Elementor\Icons_Manager::render_icon( $settings['icon_menu'], [ 'aria-hidden' => 'true' ] );
		/*$icon_menu_movil_aux = $settings['icon_menu']['value'];
		$out.="<i class='$icon_menu_movil_aux'></i>";*/
		?>
		</button>
        <div class='collapse navbar-collapse wee_navbar' id='navbarNav-<?php echo $this->get_id();?>'>
            <ul class='navbar-nav ml-auto wee-menu-font-transform wee-menu-font wee-menu-font-color'>                  
       <?php $menu_Object = wp_get_nav_menu_items( $settings['select_menu']);   
        if(!empty($menu_Object) && $menu_Object != false ) {
            foreach($menu_Object as $menu_actual){ ?>
                <li class='nav-item '>
                    <a class='nav-link text-center' data-padretogle='#navbarNav-<?php echo $this->get_id();?>' href='<?php echo  $menu_actual->url ?>'><?php echo $menu_actual->title ?></a>
                </li>
       <?php     }
        } ?> 
    	  </ul>
		</div>
        </nav>
	<?php } 
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
		return '';
        ?>
        
        <nav class='navbar navbar-expand-lg _belownavbar-light bg-light'>
        <a class='navbar-brand' href='#'>
            <img width='712' height='442' src='http://local-dev-selenil.loc/wp-content/uploads/2019/11/logo-Selenil.png' class='attachment-full size-full' alt=' srcset='http://local-dev-selenil.loc/wp-content/uploads/2019/11/logo-Selenil.png 712w, http://local-dev-selenil.loc/wp-content/uploads/2019/11/logo-Selenil-300x186.png 300w' sizes='(max-width: 712px) 100vw, 712px'>
            {{{ settings.title }}}
        </a>
        <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
        <span class='navbar-toggler-icon'></span>
        </button>
        <div class='collapse navbar-collapse' id='navbarNav'>
            <ul class='navbar-nav'>
            <?php
                $li = "";
                //var_dump($GLOBALS);
                //$menus_selecionado = $this->get_settings_for_display('select_menu');
                $menu_Object = wp_get_nav_menu_items('Menu principal');
                
                if(!empty($menu_Object) && $menu_Object != false ) {
                    foreach($menu_Object as $menu_actual){
                        $li .= "<li class='nav-item'>
                                     <a class='nav-link' href='$menu_actual->url'>$menu_actual->title</a>
                                </li>";
                    }
                }
                    echo $li;
              ?>
            </ul>
            </div>
            </nav>
		<?php
	}

}
?>