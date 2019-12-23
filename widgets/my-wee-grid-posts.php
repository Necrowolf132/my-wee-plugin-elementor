<?php

namespace My_elementor_extencion\Widgets;

require_once  WEE_DIR_PATH . '/Extra/Helper.php';
require_once  WEE_DIR_PATH . '/Templete/content/Post_Grid.php';

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Scheme_Typography;
use \Elementor\Widget_Base;
class wee_Post_Grid extends Widget_Base
{
    use \My_elementor_extencion\Extras\Helper;
    use \My_elementor_extencion\Template\content\Post_Grid;

    public function get_name()
    {
        return 'wee-post-grid';
    }

    public function get_title()
    {
        return __('Wee Post Grid', 'wee_elementor-test-extension');
    }

    public function get_icon()
    {
        return 'eicon-posts-grid';
    }

    public function get_categories()
    {
        return ['extencion-de-elementor-playful'];
    }
    public function get_style_depends(){

		return [ 'my-post-grid' ];
	}
	public function get_script_depends() {

        return [ 'my-js-post-grid'];
    }
    protected function _register_controls()
    {
        /**
         * Query And Layout Controls!
         * @source includes/elementor-helper.php
         */
        $this->wee_query_controls();
        $this->wee_layout_controls();

        /**
         * Grid Style Controls!
         */
        $this->start_controls_section(
            'wee_section_post_grid_style',
            [
                'label' => __('Post Grid Style', 'wee_elementor-test-extension'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'wee_post_grid_bg_color',
            [
                'label' => __('Post Background Color', 'wee_elementor-test-extension'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .eael-grid-post-holder' => 'background-color: {{VALUE}}',
                ],

            ]
        );

        $this->add_responsive_control(
            'wee_post_grid_spacing',
            [
                'label' => esc_html__('Spacing Between Items', 'wee_elementor-test-extension'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eael-grid-post' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'wee_post_grid_border',
                'label' => esc_html__('Border', 'wee_elementor-test-extension'),
                'selector' => '{{WRAPPER}} .eael-grid-post-holder',
            ]
        );

        $this->add_control(
            'wee_post_grid_border_radius',
            [
                'label' => esc_html__('Border Radius', 'wee_elementor-test-extension'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .eael-grid-post-holder' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wee_post_grid_box_shadow',
                'selector' => '{{WRAPPER}} .eael-grid-post-holder',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'wee_section_typography',
            [
                'label' => __('Color & Typography', 'wee_elementor-test-extension'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'wee_post_grid_title_style',
            [
                'label' => __('Title Style', 'wee_elementor-test-extension'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'wee_post_grid_title_color',
            [
                'label' => __('Title Color', 'wee_elementor-test-extension'),
                'type' => Controls_Manager::COLOR,
                'default' => '#303133',
                'selectors' => [
                    '{{WRAPPER}} .eael-entry-title a' => 'color: {{VALUE}};',
                ],

            ]
        );

        $this->add_control(
            'wee_post_grid_title_hover_color',
            [
                'label' => __('Title Hover Color', 'wee_elementor-test-extension'),
                'type' => Controls_Manager::COLOR,
                'default' => '#23527c',
                'selectors' => [
                    '{{WRAPPER}} .eael-entry-title:hover, {{WRAPPER}} .eael-entry-title a:hover' => 'color: {{VALUE}};',
                ],

            ]
        );
        $this->add_responsive_control(
            'wee_post_grid_title_alignment',
            [
                'label' => __('Title Alignment', 'wee_elementor-test-extension'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'wee_elementor-test-extension'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'wee_elementor-test-extension'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'wee_elementor-test-extension'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-entry-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'wee_post_grid_title_typography',
                'label' => __('Typography', 'wee_elementor-test-extension'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .eael-entry-title',
            ]
        );

        $this->add_control(
            'wee_post_grid_excerpt_style',
            [
                'label' => __('Excerpt Style', 'wee_elementor-test-extension'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'wee_post_grid_excerpt_color',
            [
                'label' => __('Excerpt Color', 'wee_elementor-test-extension'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .eael-grid-post-excerpt p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wee_post_grid_excerpt_alignment',
            [
                'label' => __('Excerpt Alignment', 'wee_elementor-test-extension'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'wee_elementor-test-extension'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'wee_elementor-test-extension'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'wee_elementor-test-extension'),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justified', 'wee_elementor-test-extension'),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-grid-post-excerpt p' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'wee_post_grid_excerpt_typography',
                'label' => __('Excerpt Typography', 'wee_elementor-test-extension'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .eael-grid-post-excerpt p',
            ]
        );

        $this->add_control(
			'content_height',
			[
				'label' => esc_html__( 'Content Height', 'wee_elementor-test-extension' ),
				'type' => Controls_Manager::SLIDER,
				'size_units'	=> ['px', '%', 'em'],
				'range' => [
					'px' => [ 'max' => 300 ],
					'%'	=> [ 'max'	=> 100 ]
				],
				'selectors' => [
					'{{WRAPPER}} .eael-grid-post-holder .eael-entry-wrapper' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            'wee_post_grid_meta_style',
            [
                'label' => __('Meta Style', 'wee_elementor-test-extension'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'wee_post_grid_meta_color',
            [
                'label' => __('Meta Color', 'wee_elementor-test-extension'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .eael-entry-meta, .eael-entry-meta a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wee_post_grid_meta_alignment',
            [
                'label' => __('Meta Alignment', 'wee_elementor-test-extension'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __('Left', 'wee_elementor-test-extension'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'wee_elementor-test-extension'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'flex-end' => [
                        'title' => __('Right', 'wee_elementor-test-extension'),
                        'icon' => 'fa fa-align-right',
                    ],
                    'stretch' => [
                        'title' => __('Justified', 'wee_elementor-test-extension'),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-entry-footer' => 'justify-content: {{VALUE}};',
                    '{{WRAPPER}} .eael-entry-meta' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'wee_post_grid_meta_typography',
                'label' => __('Meta Typography', 'wee_elementor-test-extension'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .eael-entry-meta > div, {{WRAPPER}} .eael-entry-meta > span',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'wee_section_hover_card_styles',
            [
                'label' => __('Hover Card Style', 'wee_elementor-test-extension'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'wee_post_grid_hover_animation',
            [
                'label' => esc_html__('Animation', 'wee_elementor-test-extension'),
                'type' => Controls_Manager::SELECT,
                'default' => 'fade-in',
                'options' => [
                    'none' => esc_html__('None', 'wee_elementor-test-extension'),
                    'fade-in' => esc_html__('FadeIn', 'wee_elementor-test-extension'),
                    'zoom-in' => esc_html__('ZoomIn', 'wee_elementor-test-extension'),
                    'slide-up' => esc_html__('SlideUp', 'wee_elementor-test-extension'),
                ],
            ]
        );

        $this->add_control(
            'wee_post_grid_bg_hover_icon_new',
            [
                'label' => __('Post Hover Icon', 'wee_elementor-test-extension'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'eael_post_grid_bg_hover_icon',
                'default' => [
                    'value' => 'fa fa-long-arrow-right',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'eael_post_grid_hover_animation!' => 'none',
                ],
            ]
        );

        $this->add_control(
            'wee_post_grid_hover_bg_color',
            [
                'label' => __('Background Color', 'wee_elementor-test-extension'),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0, .75)',
                'selectors' => [
                    '{{WRAPPER}} .eael-grid-post .eael-entry-overlay' => 'background-color: {{VALUE}}',
                ],

            ]
        );

        $this->add_control(
            'wee_post_grid_hover_icon_color',
            [
                'label' => __('Icon Color', 'wee_elementor-test-extension'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .eael-grid-post .eael-entry-overlay > i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'wee_post_grid_hover_icon_fontsize',
            [
                'label' => __('Icon font size', 'wee_elementor-test-extension'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => 18,
                ],
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-grid-post .eael-entry-overlay > i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eael-grid-post .eael-entry-overlay > img' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Read More Button Style Controls
         */
        $this->wee_read_more_button_style();

        /**
         * Load More Button Style Controls!
         */
        $this->wee_load_more_button_style();
    }
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $settings = $this->fix_old_query($settings);
        $args = $this->wee_get_query_args($settings);
        $settings = [
            'wee_show_image' => $settings['wee_show_image'],
            'image_size' => $settings['image_size'],
            'wee_show_title' => $settings['wee_show_title'],
            'wee_show_excerpt' => $settings['wee_show_excerpt'],
            'wee_show_meta' => $settings['wee_show_meta'],
            'meta_position' => $settings['meta_position'],
            'wee_excerpt_length' => intval($settings['wee_excerpt_length'], 10),
            'wee_post_grid_hover_animation' => $settings['wee_post_grid_hover_animation'],
            'wee_post_grid_bg_hover_icon' => (isset($settings['__fa4_migrated']['wee_post_grid_bg_hover_icon_new']) || empty($settings['wee_post_grid_bg_hover_icon'])) ? $settings['wee_post_grid_bg_hover_icon_new']['value'] : $settings['wee_post_grid_bg_hover_icon'],
            'wee_show_read_more_button' => $settings['wee_show_read_more_button'],
            'read_more_button_text' => $settings['read_more_button_text'],
            'read_more_button_text' => $settings['read_more_button_text'],
            
            'wee_post_grid_columns' => $settings['wee_post_grid_columns'],
            'show_load_more' => $settings['show_load_more'],
            'show_load_more_text' => $settings['show_load_more_text'],
            'expanison_indicator'   => $settings['excerpt_expanison_indicator']
        ];

        $this->add_render_attribute(
            'post_grid_wrapper',
            [
                'id' => 'wee-post-grid-' . esc_attr($this->get_id()),
                'class' => [
                    'wee-post-grid-container',
                    esc_attr($settings['wee_post_grid_columns']),
                ],
            ]
        );

        echo '<div ' . $this->get_render_attribute_string('post_grid_wrapper') . '>
            <div class="eael-post-grid eael-post-appender eael-post-appender-' . $this->get_id() . '">
                ' . self::__render_template($args, $settings) . '
            </div>
            <div class="clearfix"></div>
        </div>';
		
		if ('yes' == $settings['show_load_more']) {
			if ($args['posts_per_page'] != '-1') {
				echo '<div class="eael-load-more-button-wrap">
					<button class="eael-load-more-button" id="eael-load-more-btn-' . $this->get_id() . '" data-widget="' . $this->get_id() . '" data-class="' . get_class($this) . '" data-args="' . http_build_query($args) . '" data-settings="' . http_build_query($settings) . '" data-layout="masonry" data-page="1">
						<div class="eael-btn-loader button__loader"></div>
						<span>' . esc_html__($settings['show_load_more_text'], 'essential-addons-elementor') . '</span>
					</button>
				</div>';
			}
        }
        
        if (\Elementor\Plugin::instance()->editor->is_edit_mode()) {
            echo '<script type="text/javascript">
                jQuery(document).ready(function() {
                    jQuery(".eael-post-grid").each(function() {
                        var $scope = jQuery(".elementor-element-' . $this->get_id() . '");

                        // init isotope
                        var $gallery = jQuery(".eael-post-grid", $scope).isotope({
                            itemSelector: ".eael-grid-post",
                            masonry: {
                                columnWidth: ".eael-post-grid-column",
                                percentPosition: true
                            }
                        });
                    
                        // layout gal, while images are loading
                        $gallery.imagesLoaded().progress(function() {
                            $gallery.isotope("layout");
                        });
                    });
                });
            </script>';
        }
    }
}
?>