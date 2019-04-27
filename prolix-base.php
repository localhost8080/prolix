<?php

/**
 * prolix class file to organise functions
 *
 * @package  prolix
 */
/**
 * prolix class file to organise functions
 */
class prolixBase
{


    /**
     * constructor - add some actions to WordPress startup
     */
    public function __construct()
    {
        add_action(
            'after_setup_theme',
            array(
                $this,
                'prolix_register',
            )
        );
    }

    /**
     * Returns the current prolix version number
     *
     * @internal internal
     * @return string
     */
    public function prolix_version()
    {
        $version = '10.2.0';
        return $version;
    }

    /**
     * various register actions
     *
     * @internal internal
     */
    public function prolix_register()
    {
        // theme support
        load_theme_textdomain('prolix');
        add_theme_support('automatic-feed-links');
        add_theme_support('html5');
        add_theme_support(
            'post-formats',
            array(
                'image',
                'gallery',
                'video',
                'audio',
            )
        );
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support(
            'custom-header',
            array(
                'width' => 1800,
                'height' => 600,
                'default-image' => get_template_directory_uri() . '/images/default-slider.png',
                'uploads' => true,
            )
        );

        // actions
        add_action(
            'wp_enqueue_scripts',
            array(
                $this,
                'prolix_scripts_method',
            )
        );
        add_action(
            'wp_enqueue_scripts',
            array(
                $this,
                'prolix_stylesheet_method',
            )
        );
        add_action(
            'customize_register',
            array(
                $this,
                'prolix_customize_register',
            )
        );
        // add_action('wp_tag_cloud', array( $this, 'prolix_add_tag_class'));
        // filters
        add_filter(
            'the_content',
            array(
                $this,
                'prolix_featured_image_in_feed',
            )
        );
        // add_filter('post_class', array($this, 'prolix_remove_hentry_function'), 20);
        // add_filter('the_tags', 'prolix_add_class_the_tags', 10, 1);
        add_filter(
            'widget_tag_cloud_args',
            array(
                $this,
                'prolix_widget_tag_cloud_args',
            )
        );
        add_filter(
            'wp_tag_cloud',
            array(
                $this,
                'prolix_tag_cloud_filter',
            ),
            10,
            2
        );
        add_filter(
            'get_avatar',
            array(
                $this,
                'prolix_get_avatar',
            )
        );
        add_filter('widget_text', 'do_shortcode');
        // misc
        if (is_admin()) {
            add_editor_style('style.css');
        }
        $this->prolix_menu();
        set_post_thumbnail_size(605, 100);
        add_image_size('featured-post-thumbnail', 605, 100);
        if (! isset($content_width)) {
            $content_width = 900;
        }
        // sidebars
        add_action(
            'widgets_init',
            array(
                $this,
                'prolix_generate_sidebars',
            )
        );
    }

    /**
     * adds the featured image to the rss feed
     *
     * @internal internal
     * @param string $content
     * @return string
     */
    public function prolix_featured_image_in_feed($content)
    {
        global $post;
        if (is_feed()) {
            if (has_post_thumbnail($post->ID)) {
                $output = get_the_post_thumbnail(
                    $post->ID,
                    'medium',
                    array(
                        'style' => 'float:right; margin:0 0 10px 10px;',
                    )
                );
                $content = $output . $content;
            }
        }
        return $content;
    }

    /**
     * adds the prolix custom controls for wp customise api
     *
     * @api
     *
     * @param object $wp_customize
     */
    public function prolix_customize_register($wp_customize)
    {
        $wp_customize->add_section(
            'prolix_settings',
            array(
                'title' => esc_html__('prolix Settings', 'prolix'),
                'priority' => 30,
            )
        );
        $this->prolix_register_and_generate_custom_control('paralax_featured', 'paralax_featured', 'default', esc_html__('Excerpt or tags in featured posts', 'prolix'), $wp_customize, 'prolix_settings');
    }

    /**
     * registers and generates the custom controls for wp customise api
     *
     * @internal internal
     * @see prolix_customize_register();
     * @param string $setting_type
     * @param string $setting_name
     * @param string $default
     * @param string $label
     * @param object $wp_customize
     * @param string $section
     */
    public function prolix_register_and_generate_custom_control($setting_type, $setting_name, $default, $label, $wp_customize, $section)
    {
        $wp_customize->add_setting(
            $setting_name,
            array(
                'default' => $default,
                'transport' => 'refresh',
                'sanitize_callback' => 'esc_attr',
            )
        );
        if ($setting_type == 'paralax_featured') {
            $wp_customize->add_control(
                $setting_name,
                array(
                    'label' => esc_html__('Select Featured posts style:', 'prolix'),
                    'section' => $section,
                    'type' => 'select',
                    'choices' => array(
                        'empty' => 'empty',
                        'default' => 'tags',
                        'excerpt' => 'excerpt',
                    ),
                )
            );
        }
    }
   
    /**
     * enqueue the required javascript libraries.
     * - menu.js - custom built menu javascript for pop out menu
     * - bootstrap javascript library
     *
     * @internal internal
     */
    public function prolix_scripts_method()
    {
        wp_enqueue_script(
            'menu',
            get_template_directory_uri() . '/menu.js',
            array(
                'jquery',
            ),
            '',
            true
        );
    
       
        wp_enqueue_script(
            'bootstrap',
            get_template_directory_uri() . '/mdb/js/bootstrap.min.js',
            array(
                'jquery',
            ),
            '',
            true
        );
        wp_enqueue_script(
            'mdb',
            get_template_directory_uri() . '/mdb/js/mdb.min.js',
            array(
                'jquery',
            ),
            '',
            true
        );
     
    }

    /**
     * enqueue the stylesheets
     * - bootstrap css
     * - font awesome css
     * - style css [WordPress required with custom overrides for bootstrap]
     * - print css [custom overrides for printing]
     *
     * @internal internal
     */
    public function prolix_stylesheet_method()
    {
  
        wp_enqueue_style('bootstrap', get_template_directory_uri() . '/mdb/css/bootstrap.min.css');
        wp_enqueue_style('mdb', get_template_directory_uri() . '/mdb/css/mdb.min.css');
        wp_enqueue_style('mdb-style', get_template_directory_uri() . '/mdb/css/style.min.css');    
        wp_enqueue_style('style', get_stylesheet_uri());
        wp_enqueue_style('font-awesome', get_template_directory_uri() . '/font-awesome/css/font-awesome.min.css');
        wp_enqueue_style('print', get_template_directory_uri() . '/print.min.css');
    }

    /**
     * registers the WordPress menu location
     *
     * @internal internal
     */
    public function prolix_menu()
    {
        register_nav_menu('primary-menu', 'Primary Menu');
    }

    /**
     * generates the sidebars
     */
    public function prolix_generate_sidebars()
    {
        $sidebars = array(
            '1' => 'sidebar top',
            '2' => 'primary advert mobile',
            '3' => 'primary advert desktop',
            '4' => 'sidebar middle',
            '5' => 'sidebar bottom',
            '6' => 'footer top left',
            '7' => 'footer top right',
            '8' => 'social media',
            '9' => 'footer bottom left',
            '10' => 'footer bottom right',
            '11' => 'secondary advert mobile',
            '12' => 'secondary advert desktop'
        );
        foreach ($sidebars as $key => $name) {
            $args = array(
                'id' => 'sidebar-' . $key,
                'name' => $name . ' sidebar',
                'description' => $name . ' sidebar',
                'before_widget' => '',
                'after_widget' => '',
                'before_title' => '<p class="nav-header">',
                'after_title' => '</p>',
                'class' => '',
            );
            register_sidebar($args);
        }
    }

    /**
     * Returns matched post IDs for a pair of meta key and meta value from database
     *
     * @param [type] $meta_key
     * @param [type] $meta_value
     * @return array
     */
    public function prolix_get_post_id_by_meta_key_and_value($meta_key, $meta_value)
    {
        global $wpdb;
 
        $return = $wpdb->get_col($wpdb->prepare("SELECT post_id as ID FROM $wpdb->postmeta WHERE meta_key = %s AND meta_value = %s", $meta_key, $meta_value));
        return $return;
    }

    /**
     * removes css classes from the passed string
     *
     * @api
     *
     * @param array $classes
     * @return array
     */
    public function prolix_remove_hentry_function($classes)
    {
        // if (($key = array_search('hentry', $classes)) !== false) {
        // unset($classes[$key]);
        // }
        return $classes;
    }

    /**
     * adds a css class to the tag
     *
     * @api
     *
     * @param string $html
     * @return string
     */
    public function prolix_add_class_the_tags($html)
    {
        $html = str_replace('<a', '<a class="label"', $html);
        return $html;
    }

    /**
     * generates a tag cloud
     *
     * @param array $args
     * @return array
     * @internal internal
     */
    public function prolix_widget_tag_cloud_args($args)
    {
        $args['number'] = 20;
        // show less tags
        $args['largest'] = 20;
        $args['smallest'] = 8;
        $args['unit'] = 'pt';
        return $args;
    }

    /**
     * wrapper for the post title, if it has no title, supply one
     *
     * @api
     *
     * @param int $post_id
     * @return string
     * @example prolix_post_title(12);
     */
    public function prolix_post_title($post_id = 0)
    {
        if (! empty($post_id)) {
            $the_title = get_the_title($post_id);
        } else {
            $the_title = get_the_title();
        }
        if (empty($the_title)) {
            return esc_html__('Untitled Post', 'prolix');
        }
        return $the_title;
    }

    /**
     * wraps the tag cloud in a div
     *
     * @api
     *
     * @param string $tag_cloud
     * @return string
     */
    public function prolix_tag_cloud_filter($tag_cloud)
    {
        return '<div id="tag-cloud">' . $tag_cloud . '</div>';
    }

    /**
     * outputs the breadcrumb
     *
     * @api
     *
     * @return string
     */
    public function prolix_breadcrumbs()
    {
        global $post;
        $return = '';
        // $image_url = get_template_directory_uri() ;
        if (! is_home()) {
            $return .= '<li class="breadcrumb-item">';
            $return .= '<a href="';
            $return .= home_url();
            $return .= '">';
            $return .= '<span>';
            $return .= esc_html__('Home', 'prolix');
            $return .= '</span>';
            $return .= '</a>';
            $return .= '</li>';
        }
        if (is_category() || (is_single() && ! is_attachment())) {
            $category = get_the_category();
            $cat_id = $category[0]->cat_ID;
            $category_parents = get_category_parents($cat_id, false, ':::', false);
            $category_slug = explode(':::', $category_parents);
            foreach ($category_slug as $category => $slug) {
                $current_category = '';
                $current_category = get_category_by_slug($slug);
                if (! empty($slug) && ! empty($current_category)) {
                    $return .= '<li class="breadcrumb-item">';
                    $return .= '<a href="' . get_category_link($current_category->term_id) . '">';
                    $return .= '<span>' . $current_category->name . '</span>';
                    $return .= '</a>';
                    $return .= '</li>';
                }
            }
        }
        if (is_single()) {
            $return .= '<li class="breadcrumb-item d-none d-lg-block d-xl-block">' . $this->prolix_post_title() . '</li>';
        }
        if (is_page()) {
            $return .= '<li class="breadcrumb-item d-none d-lg-block d-xl-block">' . $this->prolix_post_title() . '</li>';
        }
        if (is_tag()) {
            $return .= '<li class="breadcrumb-item d-none d-lg-block d-xl-block">' . esc_html__('Tag: ', 'prolix') . single_tag_title('', false) . '</li>';
        }
        if (is_404()) {
            $return .= '<li class="breadcrumb-item d-none d-lg-block d-xl-block">' . esc_html__('404 - Page not Found', 'prolix') . '<li>';
        }
        if (is_search()) {
            $return .= '<li class="breadcrumb-item d-none d-lg-block d-xl-block">Search</li>';
        }
        if (is_year()) {
            $return .= '<li class="breadcrumb-item d-none d-lg-block d-xl-block">' . get_the_time('Y') . '</li>';
        }
        return $return;
    }

    /**
     * returns a random class from the list
     *
     * @api
     *
     * @param string $class
     * @return string <string>
     */
    public function prolix_get_random_solid_class($class = '')
    {
   
            // if it uses one of the bootswatch themes, use the bootstrap colours
            $input = array(
                'bg-primary',
                'bg-success',
                'bg-warning',
                'bg-info',
                'bg-danger',
                'bg-default',
            );
   
        $apps = array(
            'phone',
            'appstore',
            'calculator',
            'compass',
            'itunes',
            'mail',
            'music',
            'weather',
            'maps',
            'videos',
            'notes',
            'reminders',
            'calendar',
            'facebook',
            'google',
            'twitter',
            'linkedin',
            'finder',
            'safari',
            'firefox',
        );
        if (! empty($class) && in_array($class, $apps)) {
            $tile_colour = $class;
        } else {
            $rand_keys = array_rand($input);
            $tile_colour = $input[$rand_keys];
        }
        return $tile_colour;
    }

    /**
     * returns a random value from the list
     *
     * @api
     *
     * @return string
     */
    public function prolix_get_random_blue_class($class = '')
    {
               
        $input = array(
            'bg-primary',
            'bg-success',
            'bg-warning',
            'bg-info',
            'bg-danger',
            'bg-default',
        );
       
        $apps = array(
            'phone',
            'appstore',
            'calculator',
            'compass',
            'itunes',
            'mail',
            'music',
            'weather',
            'maps',
            'videos',
            'notes',
            'reminders',
            'calendar',
            'facebook',
            'google',
            'twitter',
            'linkedin',
            'finder',
            'safari',
            'firefox',
        );
        if (! empty($class) && in_array($class, $apps)) {
            $tile_colour = $class;
        } else {
            $rand_keys = array_rand($input);
            $tile_colour = $input[ $rand_keys ];
        }
        return $tile_colour;
    }

    /**
     * returns a random string from the list
     *
     * @api
     *
     * @param string $class
     * @return string Ambigous
     */
    public function prolix_get_random_colour_class($class = '')
    {
   
        $input = array(
            'bg-primary',
            'bg-success',
            'bg-warning',
            'bg-info',
            'bg-danger',
            'bg-default',
        );

        $apps = array(
            'phone',
            'appstore',
            'calculator',
            'compass',
            'itunes',
            'mail',
            'music',
            'weather',
            'maps',
            'videos',
            'notes',
            'reminders',
            'calendar',
            'facebook',
            'google',
            'twitter',
            'linkedin',
            'finder',
            'safari',
            'firefox',
        );
        if (! empty($class) && in_array($class, $apps)) {
            $tile_colour = $class;
        } else {
            $rand_keys = array_rand($input);
            $tile_colour = $input[ $rand_keys ];
        }
        return $tile_colour;
    }

    /**
     * outputs the category list as a hierarchy
     *
     * @api
     *
     * @param string $cat
     * @return string
     */
    public function prolix_category_list_as_hierarchy($cat = '0')
    {
        $tags = get_categories('hide_empty=true&orderby=name&order=ASC&parent=' . $cat);
        // Output a wrapper so that our arrays will be contained in 4 columns.
        $html = '';
        if ($tags) {
            // Output the markup for each tag found for each character.
            // in here I need to recurse down
            $old_tile_colour = $this->prolix_get_random_blue_class();
            foreach ((array) $tags as $tag) {
                // set the old colour so I can re-set it at the bottom
                $new_tile_colour = $this->prolix_get_random_solid_class($tag->slug);
                // fetch the new colour, if the returned string matches the slug, then set the tile_colour to it,
                // otherwise,
                // set it to the old one which is only set before this loop
                if ($new_tile_colour == $tag->slug) {
                    $tile_colour = $new_tile_colour;
                } else {
                    $tile_colour = $old_tile_colour;
                }
                if ($cat == '0') {
                    $html .= '<ul class="thumbnails row">';
                }
                $tag_link = get_category_link($tag->term_id);
                if (strlen($tag->name) > '30') {
                    $html .= '<li class="tag-item tile tile-double double-height col-sm-6 col-md-4 col-lg-3 ' . $tile_colour . '"onclick="javascript:window.location.href=';
                    $html .= "'" . $tag_link . "'";
                    $html .= '" >';
                } elseif (strlen($tag->name) > '10') {
                    $html .= '<li class="tag-item tile tile-double col-sm-6 col-md-4 col-lg-3 ' . $tile_colour . '"onclick="javascript:window.location.href=';
                    $html .= "'" . $tag_link . "'";
                    $html .= '" >';
                } elseif (strlen($tag->name) > '5') {
                    $html .= '<li class="tag-item tile tile-double col-sm-6 col-md-4 col-lg-3 ' . $tile_colour . '"onclick="javascript:window.location.href=';
                    $html .= "'" . $tag_link . "'";
                    $html .= '" >';
                } else {
                    $html .= '<li class="tag-item tile col-sm-6 col-md-4 col-lg-3 ' . $tile_colour . '"onclick="javascript:window.location.href=';
                    $html .= "'" . $tag_link . "'";
                    $html .= '" >';
                }
                if (strlen($tag->name) > '30') {
                    $html .= '<h2 class="nowrap"><a href="' . $tag_link . '" title="View the article tagged ' . $tag->name . '" >' . $tag->name . '</a></h2>';
                } elseif (strlen($tag->name) > '10') {
                    $html .= '<h3><a href="' . $tag_link . '" title="View the article tagged ' . $tag->name . '" >' . $tag->name . '</a></h3>';
                } else {
                    $html .= '<h2><a href="' . $tag_link . '" title="View the article tagged ' . $tag->name . '" >' . $tag->name . '</a></h2>';
                }
                $html .= '<span class="badge">' . $tag->count . '</span>';
                $html .= '</li>';
                $html .= $this->prolix_category_list_as_hierarchy($tag->term_id);
                if ($cat == '0') {
                    $html .= '</ul>';
                }
            }
        }
        return $html;
    }

    /**
     * generates the homepage featured posts box
     *
     * @api
     *
     * @return string
     */
    public function prolix_paralax_slider()
    {
        global $wpdb;
        $recent_posts = $this->prolix_get_featured_posts(10);
        $count = 1;
        $output = '<div class="container-fluid mb">';
        foreach ($recent_posts as $val) {
            $slider_image = wp_get_attachment_image_src(get_post_thumbnail_id($val->ID), 'large');
            if ($slider_image) {
                $theimg = $slider_image[0];
            } else {
                $theimg = get_header_image();
            }
            $colour = $this->prolix_get_random_blue_class();
            switch ($count) {
                case "1":
                case "6":
                    $output .= '<div class="paralax_image_holder float-left col-sm-8 col-md-8 col-lg-8 alpha omega doubleheight"> ';
                    $output .= '<img loading="lazy" src="' . $theimg . '" class="object-fit" alt="'.trim(stripslashes($this->prolix_post_title($val->ID))).'">';
                    $output .= '<div class="paralax_image_bg doubleheight ' . $colour . '"></div>';
                    break;
                case "2":
                case "3":
                case "4":
                case "7":
                case "8":
                case "10":
                    $output .= '<div class="paralax_image_holder float-left col-sm-4 col-md-4 col-lg-4 alpha omega"> ';
                    $output .= '<img loading="lazy" src="' . $theimg . '" class="object-fit" alt="'.trim(stripslashes($this->prolix_post_title($val->ID))).'">';
                    $output .= '<div class="paralax_image_bg ' . $colour . '"></div>';
                    break;
                case "5":
                case "9":
                    $output .= '<div class="paralax_image_holder float-left col-sm-8 col-md-8 col-lg-8 alpha omega"> ';
                    $output .= '<img loading="lazy" src="' . $theimg . '" class="object-fit" alt="'.trim(stripslashes($this->prolix_post_title($val->ID))).'">';
                    $output .= '<div class="paralax_image_bg ' . $colour . '"></div>';
                    break;
                default:
                    $output .= '<div class="paralax_image_holder float-left col-sm-4 col-md-4 col-lg-4 alpha omega"> ';
                    $output .= '<img loading="lazy" src="' . $theimg . '" class="object-fit" alt="'.trim(stripslashes($this->prolix_post_title($val->ID))).'">';
                    $output .= '<div class="paralax_image_bg ' . $colour . '"></div>';
                    break;
            }
            $output .= '<div class="paralax_image_text"><span class="h1"><a href="' . get_permalink($val->ID) . '">' . trim(stripslashes($this->prolix_post_title($val->ID))) . '</a></span>';
            $output .= '</div>';
            $output .= '</div>';
            $count++;
        }
        $output .= '</div>';
        return $output;
    }

/**
 * helper function to get top posts, ether top_ten, yoast cornerstone, or latest
 *
 * @param [type] $total_posts
 * @return void
 */
public function prolix_get_featured_posts($total_posts){
    if (function_exists('get_tptn_pop_posts')) {
        $args = array(
            'daily'        => false,
            'strict_limit' => true,
            'posts_only'   => false,
            'limit'        => $total_posts,
            'posts_only'   => true,
        );
        // todo - this needs to be an array of objects..
        $top_ten_post_array = get_tptn_pop_posts($args);
        $posts_to_get = array();
        foreach ($top_ten_post_array as $post => $val) {
            $posts_to_get[] = $val['ID'];
        }
        $args = array(
            'post__in' => $posts_to_get,
        );
        
    } elseif (defined('WPSEO_VERSION')) {
        $posts_to_get = $this->prolix_get_post_id_by_meta_key_and_value('_yoast_wpseo_is_cornerstone', '1');
        $args = array(
            'numberposts' => $total_posts,
            'offset' => 0,
            'category' => '',
            'orderby' => 'modified',
            'order' => 'DESC',
            'include' => '',
            'exclude' => '',
            'post_type' => 'post',
            'post_status' => 'publish',
            'post__in' => $posts_to_get,
        );
        
    } else {
        $args = array(
            'numberposts' => $total_posts,
            'offset' => 0,
            'category' => '',
            'orderby' => 'modified',
            'order' => 'DESC',
            'include' => '',
            'exclude' => '',
            'post_type' => 'post',
            'post_status' => 'publish',
        );
       
    }
    $recent_posts = get_posts($args);
    return $recent_posts;
}

    /**
     * generates the featured posts mini-boxes
     *
     * @api
     *
     * @return string
     */
    public function prolix_paralax_featured_sliders()
    {
        global $wpdb;
        $recent_posts = $this->prolix_get_featured_posts(4);
        $count = 1;
        $output = '<div class="featured-posts">';
        $colour = $this->prolix_get_random_blue_class();
        foreach ($recent_posts as $val) {
            $slider_image = wp_get_attachment_image_src(get_post_thumbnail_id($val->ID), 'thumbnail');
            if ($slider_image) {
                $theimg = $slider_image[0];
            } else {
                $theimg = get_header_image();
            }
            if ($count == '1' || $count == '2') {
                $output .= '<div class="paralax_image_holder float-left halfheight col-sm-6 col-md-3 col-lg-3 alpha omega">';
            } else {
                $output .= '<div class="paralax_image_holder float-left halfheight hidden-xs hidden-sm col-md-3 col-lg-3 alpha omega">';
            }
            $output .= '<img loading="lazy" src="' . $theimg . '" class="object-fit" alt="' . $this->prolix_post_title($val->ID) . '">';
            $output .= '<div class="paralax_image_bg halfheight ' . $colour . '"></div>';
            $output .= '<div class="paralax_image_text halfheight">';
            $output .= '<span class="h1"><a href="' . get_permalink($val->ID) . '">' . $this->prolix_post_title($val->ID) . '</a></span>';
            $output .= '</div></div>';
            $count++;
        }
        $output .= '</div>';
        return $output;
    }

    /**
     * gets the users avatar
     *
     * @api
     *
     * @param string $avatar
     * @return mixed
     */
    public function prolix_get_avatar($avatar)
    {
        $avatar = str_replace("class='avatar", "class='avatar img-fluid center-block", $avatar);
        return $avatar;
    }

    /**
     * renders the archive lists in the colour supplied
     *
     * @api
     *
     * @param string $colour
     * @todo make this return rather than echo
     * @see prolix_get_random_colour_class()
     * @see prolix_get_random_solid_class()
     * @see prolix_get_random_blue_class()
     */
    public function prolix_render_the_archive($colour)
    {
        // set it to blank so that it doesnt get the previous one..
        global $post;
        $thumbnail_id = get_the_ID();
        $slider_image = wp_get_attachment_image_src(get_post_thumbnail_id($thumbnail_id), 'thumbnail');
        if (! empty($slider_image)) {
            $the_image = $slider_image[0];
        // $width = $slider_image[1];
            // $height = $slider_image[2];
            // in here I need to check if its a mobile, and then give a different image:
        } else {
            $the_image = get_header_image();
        } ?>
<div class="paralax_image_holder float-left col-sm-6 col-md-4 col-lg-4" style="margin-bottom: 30px;">
    <img loading="lazy" src="<?php echo $the_image; ?>" class="object-fit" alt="<?php echo $this->prolix_post_title(); ?>">
	<div class="paralax_image_bg <?php echo $colour; ?>"></div>
	<div class="paralax_image_text">
		<span class="h1"> 
			<a href="<?php the_permalink(); ?>">
				<?php echo $this->prolix_post_title(); ?>
			</a>
		</span>
	</div>
</div>
<?php
    }

    /**
     * renders the tags or the excerpt for the supplied post id, depending on the setting in the wp_customize setting
     *
     * @api
     *
     * @param object $val
     * @param bool   $force_tags
     *            (set to true to force tag output)
     * @return string
     */
    public function prolix_render_tags($val, $force_tags = false)
    {
        $output = '';
        // check if they have selected tags or excerpt
        $mods = get_theme_mods();
        if (! empty($mods['paralax_featured']) && $mods['paralax_featured'] == 'excerpt' && empty($force_tags)) {
            // they have selected 'excerpt'
            // $excerpt = apply_filters( 'get_the_excerpt', $val->post_excerpt );
            $excerpt = wp_trim_words(apply_filters('the_excerpt', $val->post_excerpt));
            if (empty($excerpt)) {
                $excerpt = wp_trim_words($val->post_content);
            }
            $output .= $excerpt;
        } elseif (! empty($mods['paralax_featured']) && $mods['paralax_featured'] == 'empty' && empty($force_tags)) {
            // dont output anything, leave the tags thing empty, append nothing to the output to fool the wordpress
            // coding standards
            $output .= '';
        } else {
            $posttags = wp_get_post_tags($val->ID);
            if ($posttags) {
                foreach ($posttags as $tag) {
                    $output .= '<a class="label ';
                    $output .= $this->prolix_get_random_solid_class($tag->slug);
                    $output .= '" href="' . get_tag_link($tag->term_id) . '"><span class="fa fa-folder-o fa-fw"></span> ' . $tag->name . '</a>';
                }
            }
        }
        return $output;
    }
}
global $prolix;
$prolix = new prolixBase();
