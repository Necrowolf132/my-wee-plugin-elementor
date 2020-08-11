<?php

namespace My_elementor_extencion\Template\content;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

trait Post_Grid_Slider
{
    public static function __render_template($args, $settings)
    {   
        $query = new \WP_Query($args);
      
        ob_start();
        echo "<div class='swiper-container swiper-container-".$settings['wee_id_widget']."' data>
                <div class='swiper-wrapper'>";
        if($query->have_posts()) {
            while($query->have_posts()) {
                $query->the_post();
                echo '
                <div class="swiper-slide">
                <article class="eael-grid-post-slider eael-post-grid-column post-id-'. get_the_id() .'">
                    <div class="eael-grid-post-slider-holder">
                        <div class="eael-grid-post-slider-holder-inner">';
                            if (has_post_thumbnail() && $settings['wee_show_image'] == 'yes') {
                                echo '<div class="eael-entry-media">';
                                    if ('none' !== $settings['wee_post_grid_hover_animation']) {
                                        echo '<div class="eael-entry-overlay ' . $settings['wee_post_grid_hover_animation'] . '">';
                                            if( isset($settings['wee_post_grid_bg_hover_icon']['url']) ) {
                                                echo '<img src="'.esc_url($settings['wee_post_grid_bg_hover_icon']['url']).'" alt="'.esc_attr(get_post_meta($settings['wee_post_grid_bg_hover_icon']['id'], '_wp_attachment_image_alt', true)).'" />';
                                            }else {
                                                echo '<i class="' . $settings['wee_post_grid_bg_hover_icon'] . '" aria-hidden="true"></i>';
                                            }
                                            echo '<a href="' . get_the_permalink() . '"></a>';
                                        echo '</div>';
                                    }

                                    echo '<div class="eael-entry-thumbnail">
                                    <a href="' . get_the_permalink() . '">
                                        <img src="' . esc_url(wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size'])) . '" alt="' . esc_attr(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)) . '">
                                    </a>
                                    </div>';
                                echo '</div>';
                            }

                            if ($settings['wee_show_title'] || $settings['wee_show_meta'] || $settings['wee_show_excerpt']) {
                                echo '<div class="eael-entry-wrapper">
                                    <header class="eael-entry-header">';
                                        if ($settings['wee_show_title']) {
                                            echo '<h2 class="eael-entry-title"><a class="eael-grid-post-slider-link" href="' . get_the_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a></h2>';
                                        }

                                        if ($settings['wee_show_meta'] && $settings['meta_position'] == 'meta-entry-header') {
                                            echo '<div class="eael-entry-meta">
                                                <span class="eael-posted-by">' . get_the_author_meta( 'display_name' ) . '</span>
                                                <span class="wee-time eael-posted-on"><time datetime="' . get_the_date() . '">' . get_the_date() . '</time></span>';
                                                if ($settings['wee_show_categori_meta'] == "yes" ) {
                                                    $cats =  get_the_category();
                                                    $cat = $cats[0];
                                                    $wee_category = $cat->name;
                                                    echo '<span class="eael-category-on eael-posted-on">' . $wee_category . '</span>';
                                                }

                                           echo '</div>';
                                        }
                                    echo '</header>';

                                    if ($settings['wee_show_excerpt']) {
                                        echo '<div class="eael-entry-content">
                                            <div class="eael-grid-post-slider-excerpt">
                                                <p>' . wp_trim_words(strip_shortcodes(get_the_excerpt() ? get_the_excerpt() : get_the_content()), $settings['wee_excerpt_length'], $settings['expanison_indicator']) . '</p>';
                                                if ($settings['wee_show_read_more_button']) {
                                                    echo '<a href="' . get_the_permalink() . '" class="eael-post-elements-readmore-btn">' . esc_attr($settings['read_more_button_text']) . '</a>';
                                                }
                                            echo '</div>
                                        </div>';
                                    }
                                echo '</div>';

                                if ($settings['wee_show_meta'] && $settings['meta_position'] == 'meta-entry-footer') {
                                    echo '<div class="eael-entry-footer">
                                        <div class="eael-author-avatar">
                                            <a href="' . get_author_posts_url(get_the_author_meta('ID')) . '">' . get_avatar(get_the_author_meta('ID'), 96) . '</a>
                                        </div>
                                        <div class="eael-entry-meta">
                                            <div class="eael-posted-by">' . get_the_author_posts_link() . '</div>
                                            <div class="wee-time eael-posted-on"><time datetime="' . get_the_date() . '">' . get_the_date() . '</time></div>';
                                        if ($settings['wee_show_categori_meta'] == "yes" ) {
                                            $cats =  get_the_category();
                                            $cat = $cats[0];
                                            $wee_category = $cat->name;
                                            echo '<div class="eael-category-on eael-posted-on">' . $wee_category . '</div>';
                                        }
                                     echo  '</div>
                                    </div>';
                                }
                            }
                        echo '</div>
                    </div>
                </article>
                </div>';
            }
        echo "
            </div>
            <div class='swiper-pagination'></div>
        </div>
        ";
        } else {
            _e('<p class="no-posts-found">No posts found!</p>', 'essential-addons-elementor');
        }

        wp_reset_postdata();

        return ob_get_clean();
    }
}