<?php
/*
Plugin Name: Online Indicator for Twitch
Plugin URI: https://bespokeweb.dev/plugins/twitch/
Description: Add a streaming indicator to let your visitors know when your Twitch channel is live.
Version: 1.0
Author: ShapeYourBits
Author URI: https://bespokeweb.dev/
Text Domain: online-indicator-for-twitch
Domain Path: /languages
License: GPL2
*/

function oift_theme_customizer( $wp_customize ) {
		// Customise panel
        $wp_customize->add_panel('oift_panel', array('title' => __('Online Indicator for Twitch','online-indicator-for-twitch'),'priority' => 10,));

            // Main Settings
            $wp_customize->add_section('oift_main_section',array('title' => __( 'Main Settings (REQUIRED)','online-indicator-for-twitch' ),'panel' => 'oift_panel','priority' => 1));

                /* channel name */
                $wp_customize->add_setting('oift_channel_name',array('default' => '','sanitize_callback' => 'sanitize_oift_channel_name',));
                function sanitize_oift_channel_name($input) {return wp_kses_post(force_balance_tags($input));}
                $wp_customize->add_control('oift_channel_name',array('type' => 'text','label' => __('Channel name (REQUIRED)','online-indicator-for-twitch'),'description' => __('Enter your Twitch channel name in order to display stream status.','online-indicator-for-twitch'),'section' => 'oift_main_section',));
                
                /* hide if feed offline */
                $wp_customize->add_setting('oift_offline_hide',array('sanitize_callback' => 'sanitize_oift_offline_hide',));
                function sanitize_oift_offline_hide( $input ) { if ( $input == 1 ) { return 1; } else { return ''; } }
                $wp_customize->add_control('oift_offline_hide',array('type' => 'checkbox','label' => __('Hide when offline','online-indicator-for-twitch'), 'description' => __('If checked, the stream status will be shown only when channel is actively streaming.','online-indicator-for-twitch'), 'section' => 'oift_main_section',));
                
                /* open in new window */
                $wp_customize->add_setting('oift_new_window',array('sanitize_callback' => 'sanitize_oift_new_window',));
                function sanitize_oift_new_window( $input ) { if ( $input == 1 ) { return 1; } else { return ''; } }
                $wp_customize->add_control('oift_new_window',array('type' => 'checkbox','label' => __('Open in new window','online-indicator-for-twitch'),'description' => __('If unchecked, Twitch will open in the same window.','online-indicator-for-twitch'), 'section' => 'oift_main_section',));
                
                /* live text */
                $wp_customize->add_setting('oift_live_text',array('default' => '','sanitize_callback' => 'sanitize_oift_live_text',));
                function sanitize_oift_live_text($input) {return wp_kses_post(force_balance_tags($input));}
                $wp_customize->add_control('oift_live_text',array('type' => 'text','label' => __('Status text if stream is live','online-indicator-for-twitch'),'description' => __('If empty, defaults to "LIVE on Twitch"','online-indicator-for-twitch'),'section' => 'oift_main_section',));
                
                /* offline text */
                $wp_customize->add_setting('oift_offline_text',array('default' => '','sanitize_callback' => 'sanitize_oift_offline_text',));
                function sanitize_oift_offline_text($input) {return wp_kses_post(force_balance_tags($input));}
                $wp_customize->add_control('oift_offline_text',array('type' => 'text','label' => __('Status text if stream is offline','online-indicator-for-twitch'),'description' => __('If empty, defaults to "OFFLINE on Twitch".','online-indicator-for-twitch'),'section' => 'oift_main_section',));
        
            // Positioning
            $wp_customize->add_section('oift_positioning_section',array('title' => __( 'Position','online-indicator-for-twitch' ),'panel' => 'oift_panel','priority' => 2));
            
                /* absolute position */
                $wp_customize->add_setting('oift_absolute_position',array('sanitize_callback' => 'sanitize_oift_absolute_position',));
                function sanitize_oift_absolute_position( $input ) { if ( $input == 1 ) { return 1; } else { return ''; } }
                $wp_customize->add_control('oift_absolute_position',array('type' => 'checkbox','label' => __('Absolute positioning','online-indicator-for-twitch'),'description' => __('If unchecked, fixed positioning is applied.','online-indicator-for-twitch'), 'section' => 'oift_positioning_section',));
                
                /* vertical placemenet */
                $wp_customize->add_setting('oift_placement',array(
                    'default' => 'top',
                ));
                $wp_customize->add_control('oift_placement',array(
                    'type' => 'select',
                    'label' => __('Vertical placement','online-indicator-for-twitch'),
                    'section' => 'oift_positioning_section',
                    'choices' => array(
                        'top' => __('Top','online-indicator-for-twitch'),
                        'bottom' => __('Bottom','online-indicator-for-twitch'),
                ),
                ));
                
                /* horizontal placemenet */
                $wp_customize->add_setting('oift_placement_horizontal',array(
                    'default' => 'left',
                ));
                $wp_customize->add_control('oift_placement_horizontal',array(
                    'type' => 'select',
                    'label' => __('Horizontal placement','online-indicator-for-twitch'),
                    'section' => 'oift_positioning_section',
                    'choices' => array(
                        'left' => __('Left','online-indicator-for-twitch'),
                        'right' => __('Right','online-indicator-for-twitch'),
                ),
                ));
                
                /* top/bottom distance */
                $wp_customize->add_setting('oift_vertical_distance',array('default' => '','sanitize_callback' => 'sanitize_oift_vertical_distance',));
                function sanitize_oift_vertical_distance($input) {return wp_kses_post(force_balance_tags($input));}
                $wp_customize->add_control('oift_vertical_distance',array('type' => 'text','label' => __('Top/bottom distance (in pixels)','online-indicator-for-twitch'),'description' => __('Example: 50 (if empty, defaults to 50).','online-indicator-for-twitch'),'section' => 'oift_positioning_section',));
                
                /* left distance */
                $wp_customize->add_setting('oift_horizontal_distance',array('default' => '','sanitize_callback' => 'sanitize_oift_horizontal_distance',));
                function sanitize_oift_horizontal_distance($input) {return wp_kses_post(force_balance_tags($input));}
                $wp_customize->add_control('oift_horizontal_distance',array('type' => 'text','label' => __('Left/right distance (in pixels)','online-indicator-for-twitch'),'description' => __('Example: 50 (if empty, defaults to 20).','online-indicator-for-twitch'),'section' => 'oift_positioning_section',));
            
            // Graphics
            $wp_customize->add_section('oift_graphics_section',array('title' => __( 'Graphics','online-indicator-for-twitch' ),'panel' => 'oift_panel','priority' => 3));
            
                /* background color */
                $wp_customize->add_setting('oift_background_color',array('sanitize_callback'=>'sanitize_hex_color'));
                $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'oift_background_color',array(
                    'label'=>__('Background','online-indicator-for-twitch'),'settings'=>'oift_background_color','section'=>'oift_graphics_section')
                ));
                
                /* text color */
                $wp_customize->add_setting('oift_status_text_color',array('sanitize_callback'=>'sanitize_hex_color'));
                $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'oift_status_text_color',array(
                    'label'=>__('Text color','online-indicator-for-twitch'),'settings'=>'oift_status_text_color','section'=>'oift_graphics_section')
                ));
                
                /* live text color */
                $wp_customize->add_setting('oift_status_text_color_live',array('sanitize_callback'=>'sanitize_hex_color'));
                $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'oift_status_text_color_live',array(
                    'label'=>__('Text color when live','online-indicator-for-twitch'),'settings'=>'oift_status_text_color_live','section'=>'oift_graphics_section')
                ));
                
                /* text hover color */
                $wp_customize->add_setting('oift_status_text_hover_color',array('sanitize_callback'=>'sanitize_hex_color'));
                $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'oift_status_text_hover_color',array(
                    'label'=>__('Text hover color','online-indicator-for-twitch'),'settings'=>'oift_status_text_hover_color','section'=>'oift_graphics_section')
                ));
                
                /* live text hover color */
                $wp_customize->add_setting('oift_status_text_hover_color_live',array('sanitize_callback'=>'sanitize_hex_color'));
                $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'oift_status_text_hover_color_live',array(
                    'label'=>__('Text hover color when live','online-indicator-for-twitch'),'settings'=>'oift_status_text_hover_color_live','section'=>'oift_graphics_section')
                ));
                
                /* rounded corners */
                $wp_customize->add_setting('oift_rounded_corners',array('default' => '','sanitize_callback' => 'sanitize_oift_rounded_corners',));
                function sanitize_oift_rounded_corners($input) {return wp_kses_post(force_balance_tags($input));}
                $wp_customize->add_control('oift_rounded_corners',array('type' => 'text','label' => __('Rounded corners (in pixels)','online-indicator-for-twitch'),'description' => __('Example: 5 (if empty, defaults to 0).','online-indicator-for-twitch'),'section' => 'oift_graphics_section',));
        
                /* disable status text underline */
                $wp_customize->add_setting('oift_no_underline',array('sanitize_callback' => 'sanitize_oift_no_underline',));
                function sanitize_oift_no_underline( $input ) { if ( $input == 1 ) { return 1; } else { return ''; } }
                $wp_customize->add_control('oift_no_underline',array('type' => 'checkbox','label' => __('Enable underline on hover','online-indicator-for-twitch'),'description' => __('When checked text will be underlined when hovered.','online-indicator-for-twitch'), 'section' => 'oift_graphics_section',));
        
            // Hide On Mobile
            $wp_customize->add_section('oift_misc_section',array('title' => __( 'Hide On Mobile','online-indicator-for-twitch' ),'panel' => 'oift_panel','priority' => 3));

                /* smaller than */
                $wp_customize->add_setting('oift_smaller_than',array('sanitize_callback' => 'sanitize_oift_smaller_than',));
                function sanitize_oift_smaller_than($input) {return wp_kses_post(force_balance_tags($input));}
                $wp_customize->add_control('oift_smaller_than',array(
                    'type' => 'text',
                    'label' => __('Hide at certain width/resolution','online-indicator-for-twitch'),
                    'description' => __('<strong>Example #1:</strong> If you want to show the stream status on desktop only, enter the values as 0 and 500. <br><br> <strong>Example #2:</strong> If you want to show the stream status on mobile only, enter the values as 500 and 5000. <br><br> Feel free to experiment with your own values to get the result that is right for you. If fields are empty, the stream status will be visible at all browser widths and resolutions. <br><br> Hide stream status if browser width or screen resolution (in pixels) is between...','online-indicator-for-twitch'),
                    'section' => 'oift_misc_section',
                ));
                
                /* larger than */
                $wp_customize->add_setting('oift_larger_than',array('sanitize_callback' => 'sanitize_oift_larger_than',));
                function sanitize_oift_larger_than($input) {return wp_kses_post(force_balance_tags($input));}
                $wp_customize->add_control('oift_larger_than',array(
                    'type' => 'text',
                    'description' => __('..and:','online-indicator-for-twitch'),
                    'section' => 'oift_misc_section',
                ));
	}
	add_action('customize_register', 'oift_theme_customizer');

	// Add stream status to theme	
	function oift_footer() {
	?>
        <?php if( get_theme_mod('oift_channel_name') != '') { ?>
            <div id="oift-container"><a class="oift-twitch" <?php if( get_theme_mod('oift_new_window') != '') { ?>target="_blank"<?php } ?> href="https://www.twitch.tv/<?php echo get_theme_mod('oift_channel_name'); ?>">
                <span class="oift-status-text-live">
                    <?php if( get_theme_mod('oift_live_text') != '') { ?>
                        <?php echo get_theme_mod('oift_live_text'); ?>
                    <?php } else { ?>
                        <?php esc_html_e( 'LIVE on Twitch', 'online-indicator-for-twitch' ); ?>
                    <?php } ?>
                </span>
                <span class="oift-status-text-offline">
                    <?php if( get_theme_mod('oift_offline_text') != '') { ?>
                        <?php echo get_theme_mod('oift_offline_text'); ?>
                    <?php } else { ?>
                        <?php esc_html_e( 'OFFLINE on Twitch', 'online-indicator-for-twitch' ); ?>
                    <?php } ?>
                </span>
            </a></div><div id="oift-embed" style="display:none"></div>
        <?php
       }else{ ?>
            <!-- Please enter your Channel Name -->
        <?php } ?>

	<?php
	}
    add_action('wp_footer','oift_footer');

    function oift_front_end_scripts() {
        wp_register_script( 'oift-twitch', 'http://embed.twitch.tv/embed/v1.js', array(), '1.0', true ); // one day wordpress will support crossorigin="anonymous"
        wp_enqueue_script('oift-twitch');
        wp_add_inline_script( 'oift-twitch', "
        var oift_stream = new Twitch.Embed('oift-embed', {width: 340,height: 400,channel: '".get_theme_mod('oift_channel_name')."',layout: 'video'});
        var oift_intervalTimer;
        oift_stream.addEventListener(Twitch.Embed.VIDEO_READY, function() {
            oift_stream.setMuted(true);
        });
        oift_stream.addEventListener(Twitch.Player.ONLINE, function() {
            document.getElementById('oift-container').classList.add('live');
        });
        oift_stream.addEventListener(Twitch.Player.OFFLINE, function() {
            document.getElementById('oift-container').classList.remove('live');
        });");
    }
    if( get_theme_mod('oift_channel_name') != '') {
        add_action( 'wp_enqueue_scripts', 'oift_front_end_scripts' );
    }
    
	// Add 'Settings' link to plugin page
    add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'add_oift_action_links' );
    function add_oift_action_links ( $links ) {
        $mylinks = array(
        '<a href="' . admin_url( 'customize.php?autofocus[panel]=oift_panel' ) . '">Settings</a>'
        );
    return array_merge( $links, $mylinks );
    }

	// online-indicator-for-twitch.css
	function oift_css() {
		wp_register_style( 'online-indicator-for-twitch-css', plugins_url( '/online-indicator-for-twitch.css', __FILE__ ) . '', array(), '1', 'all' );
		wp_enqueue_style( 'online-indicator-for-twitch-css' );
	}
	add_action( 'wp_enqueue_scripts', 'oift_css' );
    
	// Translation-ready
    function oift_load_plugin_textdomain() {
        load_plugin_textdomain( 'online-indicator-for-twitch', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
    }
    add_action( 'plugins_loaded', 'oift_load_plugin_textdomain' );

    // Admin notice if config missing
    function oift_configuration_missing() {
        ?>
        <div class="notice notice-warning is-dismissible">
            <p><?php _e( 'Online Indicator for Twitch Plugin: You need to <a href="customize.php?autofocus[section]=oift_main_section">configure</a> your twitch channel name.', 'oift-configure' ); ?></p>
        </div>
        <?php
    }
    
	// Insert customization options into the header
	function oift_customize() {
	?>
        <!-- Online Indicator for Twitch Custom CSS -->
        <style>
		<?php if( get_theme_mod('oift_background_color') != '') { ?>/* background color */
		#oift-container {
			background-color:<?php echo get_theme_mod('oift_background_color') ?>;
			background-image: none;
			box-shadow: none;
		}
		<?php } ?>
			
		/* status text color */
		#oift-container a.oift-twitch span.oift-status-text-live { color:<?php if( get_theme_mod('oift_status_text_color_live') != '') { ?><?php echo get_theme_mod('oift_status_text_color_live'); ?><?php } else { ?>#32CD32<?php } ?>; }
		#oift-container a.oift-twitch span.oift-status-text-offline { color:<?php if( get_theme_mod('oift_status_text_color') != '') { ?><?php echo get_theme_mod('oift_status_text_color'); ?><?php } else { ?>#ffffff<?php } ?>; }
			
		/* status text hover */
		#oift-container:hover a, #oift-container:hover a.oift-twitch span.oift-status-text-live { color:<?php if( get_theme_mod('oift_status_text_hover_color_live') != '') { ?><?php echo get_theme_mod('oift_status_text_hover_color_live'); ?><?php } else { ?>#ffffff<?php } ?>; }
		#oift-container:hover a, #oift-container:hover a.oift-twitch span.oift-status-text-offline { color:<?php if( get_theme_mod('oift_status_text_hover_color') != '') { ?><?php echo get_theme_mod('oift_status_text_hover_color'); ?><?php } else { ?>#FF0000<?php } ?>; }

		<?php if( get_theme_mod('oift_rounded_corners') != '') { ?> /* rounded corners */
			
        /* left positioning */
		#oift-container {
			border-top-right-radius:<?php echo get_theme_mod('oift_rounded_corners'); ?>px;
			border-bottom-right-radius:<?php echo get_theme_mod('oift_rounded_corners'); ?>px;
			<?php if( get_theme_mod('oift_horizontal_distance') != '0') { ?>
			border-top-left-radius:<?php echo get_theme_mod('oift_rounded_corners'); ?>px;
			border-bottom-left-radius:<?php echo get_theme_mod('oift_rounded_corners'); ?>px;
			<?php } ?>
			padding: <?php echo get_theme_mod('oift_rounded_corners'); ?>px;
		}
		<?php if( get_theme_mod('oift_placement_horizontal') == 'right') { ?>/* right positioning */
		#oift-container {
			<?php if( get_theme_mod('oift_horizontal_distance') == '0') { ?>
			border-top-right-radius:0px;
			border-bottom-right-radius:0px;
			<?php } ?>
			border-top-left-radius:<?php echo get_theme_mod('oift_rounded_corners'); ?>px;
			border-bottom-left-radius:<?php echo get_theme_mod('oift_rounded_corners'); ?>px;
		}
		<?php } } ?>
		<?php if( get_theme_mod('oift_absolute_position') != '') { ?>#oift-container { position:absolute; }<?php } ?>
		#oift-container {
            top:<?php if( get_theme_mod('oift_vertical_distance') != '') { ?><?php echo get_theme_mod('oift_vertical_distance'); ?><?php } else { ?>50<?php } ?>px;
            left:<?php if( get_theme_mod('oift_horizontal_distance') != '') { ?><?php echo get_theme_mod('oift_horizontal_distance'); ?><?php } else { ?>20<?php } ?>px;
		}
		<?php if( get_theme_mod('oift_placement') == 'bottom') { ?>/* bottom placement */
		#oift-container {
			top:auto;
			bottom:<?php if( get_theme_mod('oift_vertical_distance') != '') { ?><?php echo get_theme_mod('oift_vertical_distance'); ?><?php } else { ?>50<?php } ?>px;
		}
		<?php } ?><?php if( get_theme_mod('oift_placement_horizontal') == 'right') { ?>/* right placement + distances */
		#oift-container {
			left:auto;
			right:<?php if( get_theme_mod('oift_horizontal_distance') != '') { ?><?php echo get_theme_mod('oift_horizontal_distance'); ?><?php } else { ?>20<?php } ?>px;
		}
		<?php } ?>
		<?php if( get_theme_mod('oift_no_underline') != '') { ?>/* no status text underline */
		#oift-container:hover a.oift-twitch { text-decoration: underline !important; }
		<?php } ?>
		<?php if( get_theme_mod('oift_offline_hide') != '') { ?>/* hide when offline */
		#oift-container { display:none; }
		#oift-container.live { display: block; }
		<?php } ?>
        
		/* hide between resolutions */
		@media ( min-width:<?php echo get_theme_mod('oift_smaller_than'); ?>px) and (max-width:<?php echo get_theme_mod('oift_larger_than'); ?>px) {
			#oift-container { display:none !important; }
		}
		</style>
		<!-- End Online Indicator for Twitch Custom CSS -->
	<?php
	}
    add_action('wp_head','oift_customize');

    if( get_theme_mod('oift_channel_name') == '') {
        add_action( 'admin_notices', 'oift_configuration_missing' );
    }
    
?>