<?php 
namespace My_elementor_extencion;
use Elementor\Control_Media;
use Elementor\Group_Control_Image_Size;

final class wee_extra_functions extends Group_Control_Image_Size {
    
    const VERSION = '1.0.0';
    
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

    const MINIMUM_PHP_VERSION = '7.0';

    private static $_instance = null;

    public static function instance() {
        if(is_null( self::$_instance )){
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    public function __construct() {
        add_filter('upload_mimes', array($this,'wee_add_svg_mime_types'));
        add_filter('elementor/image_size/get_attachment_image_html', [$this, 'wee_get_attachment_image_html' ], 11, 4);

    }
    	/**
	 * Carga capacidad del plugin
	 *
	 * para soportar archivos de imagenes
	 *
	 * SVG en el  upload_mime filter hook
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function wee_add_svg_mime_types($mimes) {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
    }
    public function wee_get_attachment_image_html($html, $settings, $image_size_key, $image_key) {
        if ( ! $image_key ) {
			$image_key = $image_size_key;
		}

		$image = $settings[ $image_key ];

		// Old version of image settings.
		if ( ! isset( $settings[ $image_size_key . '_size' ] ) ) {
			$settings[ $image_size_key . '_size' ] = '';
		}

		$size = $settings[ $image_size_key . '_size' ];

		$image_class = ! empty( $settings['hover_animation'] ) ? 'elementor-animation-' . $settings['hover_animation'] : '';

		$html = '';

		// If is the new version - with image size.
		$image_sizes = get_intermediate_image_sizes();

		$image_sizes[] = 'full';

		if ( ! empty( $image['id'] ) && ! wp_attachment_is_image( $image['id'] ) ) {
			$image['id'] = '';
		}

		if ( ! empty( $image['id'] ) && in_array( $size, $image_sizes ) ) {
			$image_class .= " attachment-$size size-$size";
			$image_attr = [
                'class' => trim( $image_class ),
                'alt' => Control_Media::get_image_alt( $image ),
                'title' =>  $this->wee_local_get_image_title($image)
			];

			$html .= wp_get_attachment_image( $image['id'], $size, false, $image_attr );
		} else {
			$image_src = self::get_attachment_image_src( $image['id'], $image_size_key, $settings );

			if ( ! $image_src && isset( $image['url'] ) ) {
				$image_src = $image['url'];
			}

			if ( ! empty( $image_src ) ) {
                $image_class_html = ! empty( $image_class ) ? ' class="' . $image_class . '"' : '';
    
                $title_tal = $this->wee_local_get_image_title($image);

				$html .= sprintf( '<img src="%s" title="%s" alt="%s"%s />', esc_attr( $image_src ), $title_tal, Control_Media::get_image_alt( $image ), $image_class_html );
			}
        }
        return $html;
    }
   
    public function wee_local_get_image_title( $attachment ) {
		if ( empty( $attachment['id'] ) ) {
			return '';
		}

		$alt = get_the_title( $attachment['id'] );

		return  strip_tags( $alt );
	}

}
    wee_extra_functions::instance();
?>