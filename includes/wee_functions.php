<?php
namespace My_elementor_extencion;

final class wee_Elementor_my_Extencion {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var wee_Elementor_my_Extencion The single instance of the class.
	 */
    private static $_instance = null;

	/**
	 * Instance
	 *
	 * Indicador para saber si debe o no inicializar el admin.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return string or int  An instance of the class.
	 */
    public static $estado = "ok";
    
    public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {

		add_action( 'init', [ $this, 'i18n' ] );
        add_action( 'plugins_loaded', [ $this, 'init' ] );
		add_action( 'admin_menu', [$this, 'wee_Add_My_Admin_Link'] );

	}
	
	
	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function i18n() {

		load_plugin_textdomain( 'wee_elementor-test-extension' );

	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated
		if (  !did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'wee_admin_notice_no_existe_elementor' ] );
            self::$estado = 1;
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'wee_admin_notice_Elementor_version_antigua' ] );
            return;
            self::$estado = 2;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', [ $this, 'wee_admin_notice_version_php_antigua' ] );
            self::$estado = 3;
			return;
		}

		// Add Plugin actions
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'wee_init_widgets' ] );
        add_action( 'elementor/controls/controls_registered', [ $this, 'wee_init_controls' ] );
        add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'wee_widget_styles' ] );
        add_action( 'elementor/frontend/after_register_scripts', [ $this, 'wee_widget_scripts' ] );
		add_action( 'elementor/elements/categories_registered', [ $this, 'wee_add_my_widget_categories']);


    }
    public function wee_widget_styles() {

		wp_register_style( 'header-elementor-boostrap',  plugins_url( 'my-wee-plugin-elementor/css/bootstrap_css/bootstrap.min.css', WEE_DIR_PATH));
		wp_register_style( 'header-elementor-my-estilos', plugins_url( 'my-wee-plugin-elementor/css/my_elementor_estilos.css', WEE_DIR_PATH ) );
		wp_register_style( 'buscador-elementor-my-estilos', plugins_url( 'my-wee-plugin-elementor/css/buscador_elementor_estilos.css', WEE_DIR_PATH ) );
		wp_register_style( 'my-post-grid', plugins_url( 'my-wee-plugin-elementor/css/post-grid/index.css', WEE_DIR_PATH ) );
    }
    public function wee_widget_scripts() {

		wp_register_script( 'bootstarp-js-extencion-elementor', plugins_url( 'my-wee-plugin-elementor/js/bootstrap_js/bootstrap.bundle.min.js', WEE_DIR_PATH ), [ 'jquery' ] );
		wp_register_script( 'my-js-post-grid', plugins_url( 'my-wee-plugin-elementor/js/post-grid/index.min.js', WEE_DIR_PATH ), [ 'jquery' ] );
		wp_register_script( 'vue-elementor', plugins_url( 'my-wee-plugin-elementor/js/vue/vue.js', WEE_DIR_PATH ), [ 'bootstarp-js-extencion-elementor', 'jquery' ] );
		wp_register_script( 'widget-buscador', plugins_url( 'my-wee-plugin-elementor/js/widget-buscador.js', WEE_DIR_PATH ),['vue-elementor','bootstarp-js-extencion-elementor'] );
		wp_register_script( 'widget-1', plugins_url( 'my-wee-plugin-elementor/js/widget-1.js', WEE_DIR_PATH ),['vue-elementor','bootstarp-js-extencion-elementor'] );

	}
    public function wee_add_my_widget_categories( $elements_manager ) {

        $elements_manager->add_category(
            'extencion-de-elementor-playful',
            [
                'title' => __( 'Extencion de Elementor Playful', 'wee_elementor-test-extension' ),
                'icon' => 'fas fa-rocket',
            ]
        );
    
	}
	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */

	public function wee_admin_notice_no_existe_elementor() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementor-test-extension' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'elementor-test-extension' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-test-extension' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

    }
    
	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function wee_admin_notice_Elementor_version_antigua() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-test-extension' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'elementor-test-extension' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-test-extension' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function wee_admin_notice_version_php_antigua() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-test-extension' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'elementor-test-extension' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'elementor-test-extension' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

    }
    
    // agregar un nuevo top  menu link para el ACP
    public function wee_Add_My_Admin_Link(){
        add_menu_page(
            'Extencion para elementor by necrowolf', // Title of the page
            'Elementor Extencion', // Text to show on the menu link
            'manage_options', // Capability requirement to see the link
            plugin_dir_path(__FILE__) . '/admin/wee-acp-page.php' // The 'slug' - file to display when clicking the link
        );
    }

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function wee_init_widgets() {

		// Include Widget files
        //require_once(  '../widgets/test-widget.php' );
	   require_once  WEE_DIR_PATH . '/widgets/test-header-widget.php';
	   //require_once  WEE_DIR_PATH . '/widgets/my-wee-posts-section.php';
	   require_once  WEE_DIR_PATH . '/widgets/my-wee-grid-posts.php';


		// Register widget
		//\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\wee_Elementor_Section_posts() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\wee_Elementor_Test_header() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\wee_Post_Grid() );

		if(function_exists('wc_get_attribute_taxonomies')){
			require_once  WEE_DIR_PATH . '/widgets/my-wee-product-buscador.php';
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\wee_Elementor_buscador_header() );
		}
	}

	/**
	 * Init Controls
	 *
	 * Include controls files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function wee_init_controls() {

		// Include Control files
       // require_once( '../controls/test-control.php' );
       require_once  WEE_DIR_PATH  . '/controls/test-control.php';

		// Register control
		//\Elementor\Plugin::$instance->controls_manager->register_control( 'control-herader-1', Test_Control1() );

	}

}

wee_Elementor_my_Extencion::instance();

if(wee_Elementor_my_Extencion::$estado=="ok"){
    require_once  WEE_DIR_PATH  . '/templates/wee_functions_templates.php';
}

/*add_filter( 'wp_nav_menu_objects',  'My_elementor_extencion\wee_wp_nav_menu_objects');
function wee_wp_nav_menu_objects( $sorted_menu_items )
{	$my_wee_devolucion = [];
    foreach ( $sorted_menu_items as $menu_item ) {
        if ( $menu_item->current ) {
            $GLOBALS['wee_menu_title'] = $menu_item->title;
            break;
		}
		array_push($my_wee_devolucion,$menu_item);
	}
	//var_dump($my_wee_devolucion);
	//return $my_wee_devolucion;
	return $sorted_menu_items;
}
//add_action( "elementor/widget/wee_Elementor_Test_header/skins_init", 'My_elementor_extencion\wee_widget_styles_enqueue');
//add_action( "elementor/widget/render_content", 'My_elementor_extencion\wee_widget_styles_enqueue', 10, 2);
//add_action( "elementor/widget/wee_Elementor_Section_posts/skins_init", 'My_elementor_extencion\wee_widget_styles_enqueue');
function wee_widget_styles_enqueue($content, $widget) {
	if('wee_Elementor_Test_header'===$widget->get_name()){
		$widget->get_style_depends();
	}
	return $content;
}*/
?>