<?php

// enqueue parent styles

function ns_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

add_action( 'wp_enqueue_scripts', 'ns_enqueue_styles' );

if ( ! function_exists( 'mytheme_register_nav_menu' ) ) {

	function mytheme_register_nav_menu(){
		register_nav_menus( array(
	    	'primary_menu' => __( 'Primary Menu', 'text_domain' ),
	    	'footer_menu'  => __( 'Footer Menu', 'text_domain' ),
		) );
	}
	add_action( 'after_setup_theme', 'mytheme_register_nav_menu', 0 );
}


add_action('wp_enqueue_scripts', 'enqueue_swiper_assets');
add_action('wp_footer', 'render_swiper_slider');

// Enqueue Swiper CSS and JS
function enqueue_swiper_assets() {
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css');
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js', [], null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_swiper_assets');

function render_swiper_slider() {
    // Fetch posts from 'domain_listing' post type
    $domain_listings = new WP_Query([
        'post_type'      => 'domain_listing',
        'posts_per_page' => -1,
        'order'          => 'ASC',
		'tax_query'      => [
            [
                'taxonomy' => 'category', // Replace with your taxonomy if custom
                'field'    => 'slug', // Use 'slug' or 'term_id'
                'terms'    => 'for-sale', // Replace with your category slug
            ],
        ],
    ]);

    if ($domain_listings->have_posts()) {
        ob_start(); // Start output buffering
        ?>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <?php while ($domain_listings->have_posts()): $domain_listings->the_post(); ?>
                    <div class="swiper-slide">
                        <a href="<?php echo esc_url(get_permalink()); ?>">
                            <?php echo esc_html(get_the_title()); ?>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
            <!-- Add Pagination and Navigation -->
            <div class="swiper-pagination"></div>
            <!-- <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div> -->
        </div>
        <style>
            .swiper {
                width: 100%;
                padding: 20px 0;
            }
            .swiper-slide a {
                color: #333;
                text-decoration: none;
                font-weight: bold;
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const swiper = new Swiper('.mySwiper', {
                    slidesPerView: 4, // Number of slides visible per row
                    grid: {
                        rows: 3, // Number of rows
                        fill: 'row', // Fill rows first
                    },
                    spaceBetween: 30, // Space between slides
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                });
            });
        </script>
        <?php
        wp_reset_postdata();
        return ob_get_clean(); // Return the buffered output
    }
}

function sold_out_domain() {
    // Fetch posts from 'domain_listing' post type
    $domain_listings = new WP_Query([
        'post_type'      => 'domain_listing',
        'posts_per_page' => -1,
        'order'          => 'ASC',
		'tax_query'      => [
            [
                'taxonomy' => 'category', // Replace with your taxonomy if custom
                'field'    => 'slug', // Use 'slug' or 'term_id'
                'terms'    => 'sold-out', // Replace with your category slug
            ],
        ],
    ]);

    if ($domain_listings->have_posts()) {
        ob_start(); // Start output buffering
        ?>
        <div class="swiper mySwiper soldOut">
            <div class="swiper-wrapper">
                <?php while ($domain_listings->have_posts()): $domain_listings->the_post(); ?>
                    <div class="swiper-slide">
                        <a>
                            <?php echo esc_html(get_the_title()); ?>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
            <!-- Add Pagination and Navigation -->
            <div class="swiper-pagination"></div>
            <!-- <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div> -->
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const swiper = new Swiper('.soldOut', {
                    slidesPerView: 4, // Number of slides visible per row
                    grid: {
                        rows: 3, // Number of rows
                        fill: 'row', // Fill rows first
                    },
                    spaceBetween: 30, // Space between slides
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                });
            });
        </script>
        <?php
        wp_reset_postdata();
        return ob_get_clean(); // Return the buffered output
    }
}
function vc_logo_slider() {
    // Fetch posts from 'domain_listing' post type
    $postdata = new WP_Query([
        'post_type'      => 'vc_logo',
        'posts_per_page' => -1,
        'order'          => 'ASC',
    ]);

    if ($postdata->have_posts()) {
        ob_start(); // Start output buffering
        ?>
        <div class="swiper mySwiper vclogo whypage-slider">
            <div class="swiper-wrapper">
                <?php while ($postdata->have_posts()): $postdata->the_post(); ?>
                    <div class="swiper-slide">
                        <a>
                            <?php 
                                if (has_post_thumbnail()) {
                                    echo get_the_post_thumbnail(get_the_ID(), 'full', ['class' => 'swiper-image']);
                                }
                            ?>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
            <!-- Add Pagination and Navigation -->
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const swiper = new Swiper('.vclogo', {
                    slidesPerView: 3, // Number of slides visible per row
                    grid: {
                        rows: 2, // Number of rows
                        fill: 'row', // Fill rows first
                    },
                    spaceBetween: 30, // Space between slides
                    navigation: 
                    {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    autoplay: 
                    {
                        delay: 2000,
                    },
                });
            });
        </script>
        <?php
        wp_reset_postdata();
        return ob_get_clean(); // Return the buffered output
    }
}
function ml_logo_slider() {
    // Fetch posts from 'domain_listing' post type
    $postdata = new WP_Query([
        'post_type'      => 'ml_logo',
        'posts_per_page' => -1,
        'order'          => 'ASC',
    ]);

    if ($postdata->have_posts()) {
        ob_start(); // Start output buffering
        ?>
        <div class="swiper mySwiper mllogo whypage-slider">
            <div class="swiper-wrapper">
                <?php while ($postdata->have_posts()): $postdata->the_post(); ?>
                    <div class="swiper-slide">
                        <a>
                            <?php 
                                if (has_post_thumbnail()) {
                                    echo get_the_post_thumbnail(get_the_ID(), 'full', ['class' => 'swiper-image']);
                                }
                            ?>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
            <!-- Add Pagination and Navigation -->
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const swiper = new Swiper('.mllogo', {
                    slidesPerView: 3, // Number of slides visible per row
                    grid: {
                        rows: 2, // Number of rows
                        fill: 'row', // Fill rows first
                    },
                    spaceBetween: 30, // Space between slides
                    navigation: 
                    {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    autoplay: 
                    {
                        delay: 2000,
                    },
                });
            });
        </script>
        <?php
        wp_reset_postdata();
        return ob_get_clean(); // Return the buffered output
    }
}
function re_logo_slider() {
    // Fetch posts from 'domain_listing' post type
    $postdata = new WP_Query([
        'post_type'      => 're_logo',
        'posts_per_page' => -1,
        'order'          => 'ASC',
    ]);

    if ($postdata->have_posts()) {
        ob_start(); // Start output buffering
        ?>
        <div class="swiper mySwiper relogo whypage-slider">
            <div class="swiper-wrapper">
                <?php while ($postdata->have_posts()): $postdata->the_post(); ?>
                    <div class="swiper-slide">
                        <a>
                            <?php 
                                if (has_post_thumbnail()) {
                                    echo get_the_post_thumbnail(get_the_ID(), 'full', ['class' => 'swiper-image']);
                                }
                            ?>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
            <!-- Add Pagination and Navigation -->
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const swiper = new Swiper('.relogo', {
                    slidesPerView: 3, // Number of slides visible per row
                    grid: {
                        rows: 2, // Number of rows
                        fill: 'row', // Fill rows first
                    },
                    spaceBetween: 30, // Space between slides
                    navigation: 
                    {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    autoplay: 
                    {
                        delay: 2000,
                    },
                });
            });
        </script>
        <?php
        wp_reset_postdata();
        return ob_get_clean(); // Return the buffered output
    }
}
function fi_logo_slider() {
    // Fetch posts from 'domain_listing' post type
    $postdata = new WP_Query([
        'post_type'      => 'fi_logo',
        'posts_per_page' => -1,
        'order'          => 'ASC',
    ]);

    if ($postdata->have_posts()) {
        ob_start(); // Start output buffering
        ?>
        <div class="swiper mySwiper filogo whypage-slider">
            <div class="swiper-wrapper">
                <?php while ($postdata->have_posts()): $postdata->the_post(); ?>
                    <div class="swiper-slide">
                        <a>
                            <?php 
                                if (has_post_thumbnail()) {
                                    echo get_the_post_thumbnail(get_the_ID(), 'full', ['class' => 'swiper-image']);
                                }
                            ?>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
            <!-- Add Pagination and Navigation -->
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const swiper = new Swiper('.filogo', {
                    slidesPerView: 3, // Number of slides visible per row
                    grid: {
                        rows: 2, // Number of rows
                        fill: 'row', // Fill rows first
                    },
                    spaceBetween: 30, // Space between slides
                    navigation: 
                    {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    autoplay: 
                    {
                        delay: 2000,
                    },
                });
            });
        </script>
        <?php
        wp_reset_postdata();
        return ob_get_clean(); // Return the buffered output
    }
}
// Register the shortcode
function register_swiper_slider_shortcode() {
    add_shortcode('for_sale_domain', 'render_swiper_slider');
	add_shortcode('sold_out_domain', 'sold_out_domain');
    add_shortcode('vc_logo', 'vc_logo_slider');
    add_shortcode('re_logo', 're_logo_slider');
    add_shortcode('ml_logo', 'ml_logo_slider');
    add_shortcode('fi_logo', 'fi_logo_slider');
}
add_action('init', 'register_swiper_slider_shortcode');


