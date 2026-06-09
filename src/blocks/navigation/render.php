<?php


    // display header navigation and mobile navigation on mobile view

    if( ! function_exists( 'divonex_fallback_nav' ) ) {
        // Custom fallback callback for navigation
        function divonex_fallback_nav() {
            echo '<ul class="divonex-menu">';
            echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
            echo '<li><a href="' . esc_url(home_url('/about')) . '">About</a></li>';
            echo '<li><a href="' . esc_url(home_url('/services')) . '">Services</a></li>';
            echo '<li><a href="' . esc_url(home_url('/contact')) . '">Contact</a></li>';
            echo '</ul>';
        }
    }

    if( ! function_exists( 'divonex_nav_block') ) {
        function divonex_nav_block( $attributes ) {
            
                $block_style = isset($attributes['blockStyle']) ? $attributes['blockStyle']['customCSS'] : [];
                $selected_menu = isset($attributes['selectedMenu']) ? $attributes['selectedMenu'] : '';
                // convert block style to CSS
                $block_style_css = '';
                foreach ( $block_style as $property => $value ) {
                    $block_style_css .= sprintf( '%s: %s;', esc_attr( $property ), esc_attr( $value ) );
                }

                $off_canvas = isset($attributes['offCanvasMenu']) ? $attributes['offCanvasMenu'] : 'mobile';
                $position = isset($attributes['offCanvasPosition']) ? $attributes['offCanvasPosition'] : 'right';
                $dropdown_border = isset($attributes['dropdownBorder']) ? $attributes['dropdownBorder'] : '';
                $dropdown_border_radius = isset($attributes['dropdownBorderRadius']) ? $attributes['dropdownBorderRadius'] : '';
                if (!empty($dropdown_border)) {
                    $block_style_css .= '--divonex-dropdown-border: ' . esc_attr($dropdown_border) . ';';
                }
                if (!empty($dropdown_border_radius)) {
                    $block_style_css .= '--divonex-dropdown-border-radius: ' . esc_attr($dropdown_border_radius) . ';';
                }
            ?>
                <div class="wp-block-divonex-navigation" <?php
                    if ( ! empty( $block_style_css ) ) {
                        echo 'style="' . esc_attr( $block_style_css ) . '"';
                    }
                ?>>
                <div class="desktop-navigation <?php echo esc_attr( $off_canvas ); ?>">
                    <?php
                        // display header navigation
                        wp_nav_menu( array(
                            'menu'          => $selected_menu,
                            'container'      => '',
                            'menu_class'    => 'divonex-menu divonex-desktop',
                            'fallback_cb'   => 'divonex_fallback_nav',
                        ) );
                    ?>
                </div>
                <div class="mobile-navigation <?php echo esc_attr( $off_canvas ); ?>">
                    <button class="mobile-bars">
                        <svg class="divonex-bars" width="20" height="14" viewBox="0 0 20 14" data-type="type-1" aria-hidden="true">
                            <rect y="0.00" width="20" height="1.7" rx="1"></rect>
                            <rect y="6.15" width="20" height="1.7" rx="1"></rect>
                            <rect y="12.3" width="20" height="1.7" rx="1"></rect>
                        </svg>
                    </button>
                    <div class="divonex-overlay"></div>
                    <div class="divonex-mobile <?php if($position === 'left') echo esc_attr($position); ?>">
                        <div class="close-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" color="#ffffff">
                                <path d="M18 6L6.00081 17.9992M17.9992 18L6 6.00085" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </div>
                        <?php
                            // display mobile navigation
                            wp_nav_menu( array(
                                'menu'          => $selected_menu,
                                'container'      => '',
                                'menu_class'    => 'divonex-menu divonex-mobile-menu',
                                'fallback_cb'   => 'divonex_fallback_nav',
                            ) );
                        ?>
                    </div>
                    
                </div>
            </div>
        <?php
        }
    }

    // call the navigation block
    divonex_nav_block( $attributes );

