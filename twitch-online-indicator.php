<?php
/*
Plugin Name: Twitch Online Indicator
Plugin URI: https://bespokeweb.dev/plugins/twitch/
Description: Add a streaming indicator to let your visitors know when your Twitch channel is live.
Version: 1.0
Author: ShapeYourBits
Author URI: https://bespokeweb.dev/
Text Domain: twitch-online-indicator
Domain Path: /languages
License: GPL2
*/

function toi_theme_customizer( $wp_customize ) {
		// Customise panel
        $wp_customize->add_panel('toi_panel', array('title' => __('Twitch Online Indicator Plugin','twitch-online-indicator'),'priority' => 10,));

            // Main Settings
            $wp_customize->add_section('toi_main_section',array('title' => __( 'Main Settings (REQUIRED)','twitch-online-indicator' ),'panel' => 'toi_panel','priority' => 1));

                /* channel name */
                $wp_customize->add_setting('toi_channel_name',array('default' => '','sanitize_callback' => 'sanitize_toi_channel_name',));
                function sanitize_toi_channel_name($input) {return wp_kses_post(force_balance_tags($input));}
                $wp_customize->add_control('toi_channel_name',array('type' => 'text','label' => __('Channel name (REQUIRED)','twitch-online-indicator'),'description' => __('Enter your Twitch channel name in order to display stream status.','twitch-online-indicator'),'section' => 'toi_main_section',));

                /* client id */
                $wp_customize->add_setting('toi_client_id',array('default' => '','sanitize_callback' => 'sanitize_toi_client_id',));
                function sanitize_toi_client_id($input) {return wp_kses_post(force_balance_tags($input));}
                $wp_customize->add_control('toi_client_id',array('type' => 'text','label' => __('Client ID (REQUIRED)','twitch-online-indicator'),'description' => __('Enter your Client ID. Create a new one with category Website Integration, and Oauth URL of localhost at <a href="https://dev.twitch.tv/console/apps/create" target="blank">https://dev.twitch.tv/console/apps/create</a> ','twitch-online-indicator'),'section' => 'toi_main_section',));
                
                /* frequency to check */
                $wp_customize->add_setting('toi_minutes',array('default' => '','sanitize_callback' => 'sanitize_toi_minutes',));
                function sanitize_toi_minutes($input) {return wp_kses_post(force_balance_tags($input));}
                $wp_customize->add_control('toi_minutes',array('type' => 'text','label' => __('How Often to update','twitch-online-indicator'),'description' => __('How often to check to see if the channel is live in minutes. Defaults to 5.','twitch-online-indicator'),'section' => 'toi_main_section',));
                
                /* hide if feed offline */
                $wp_customize->add_setting('toi_offline_hide',array('sanitize_callback' => 'sanitize_toi_offline_hide',));
                function sanitize_toi_offline_hide( $input ) { if ( $input == 1 ) { return 1; } else { return ''; } }
                $wp_customize->add_control('toi_offline_hide',array('type' => 'checkbox','label' => __('Hide when offline','twitch-online-indicator'), 'description' => __('If checked, the stream status will be shown only when channel is actively streaming.','twitch-online-indicator'), 'section' => 'toi_main_section',));
                
                /* open in new window */
                $wp_customize->add_setting('toi_new_window',array('sanitize_callback' => 'sanitize_toi_new_window',));
                function sanitize_toi_new_window( $input ) { if ( $input == 1 ) { return 1; } else { return ''; } }
                $wp_customize->add_control('toi_new_window',array('type' => 'checkbox','label' => __('Open in new window','twitch-online-indicator'),'description' => __('If unchecked, Twitch will open in the same window.','twitch-online-indicator'), 'section' => 'toi_main_section',));
                
                /* live text */
                $wp_customize->add_setting('toi_live_text',array('default' => '','sanitize_callback' => 'sanitize_toi_live_text',));
                function sanitize_toi_live_text($input) {return wp_kses_post(force_balance_tags($input));}
                $wp_customize->add_control('toi_live_text',array('type' => 'text','label' => __('Status text if stream is live','twitch-online-indicator'),'description' => __('If empty, defaults to "LIVE on Twitch"','twitch-online-indicator'),'section' => 'toi_main_section',));
                
                /* offline text */
                $wp_customize->add_setting('toi_offline_text',array('default' => '','sanitize_callback' => 'sanitize_toi_offline_text',));
                function sanitize_toi_offline_text($input) {return wp_kses_post(force_balance_tags($input));}
                $wp_customize->add_control('toi_offline_text',array('type' => 'text','label' => __('Status text if stream is offline','twitch-online-indicator'),'description' => __('If empty, defaults to "OFFLINE on Twitch".','twitch-online-indicator'),'section' => 'toi_main_section',));
        
            // Positioning
            $wp_customize->add_section('toi_positioning_section',array('title' => __( 'Position','twitch-online-indicator' ),'panel' => 'toi_panel','priority' => 2));
            
                /* absolute position */
                $wp_customize->add_setting('toi_absolute_position',array('sanitize_callback' => 'sanitize_toi_absolute_position',));
                function sanitize_toi_absolute_position( $input ) { if ( $input == 1 ) { return 1; } else { return ''; } }
                $wp_customize->add_control('toi_absolute_position',array('type' => 'checkbox','label' => __('Absolute positioning','twitch-online-indicator'),'description' => __('If unchecked, fixed positioning is applied.','twitch-online-indicator'), 'section' => 'toi_positioning_section',));
                
                /* vertical placemenet */
                $wp_customize->add_setting('toi_placement',array(
                    'default' => 'top',
                ));
                $wp_customize->add_control('toi_placement',array(
                    'type' => 'select',
                    'label' => __('Vertical placement','twitch-online-indicator'),
                    'section' => 'toi_positioning_section',
                    'choices' => array(
                        'top' => __('Top','twitch-online-indicator'),
                        'bottom' => __('Bottom','twitch-online-indicator'),
                ),
                ));
                
                /* horizontal placemenet */
                $wp_customize->add_setting('toi_placement_horizontal',array(
                    'default' => 'left',
                ));
                $wp_customize->add_control('toi_placement_horizontal',array(
                    'type' => 'select',
                    'label' => __('Horizontal placement','twitch-online-indicator'),
                    'section' => 'toi_positioning_section',
                    'choices' => array(
                        'left' => __('Left','twitch-online-indicator'),
                        'right' => __('Right','twitch-online-indicator'),
                ),
                ));
                
                /* top/bottom distance */
                $wp_customize->add_setting('toi_vertical_distance',array('default' => '','sanitize_callback' => 'sanitize_toi_vertical_distance',));
                function sanitize_toi_vertical_distance($input) {return wp_kses_post(force_balance_tags($input));}
                $wp_customize->add_control('toi_vertical_distance',array('type' => 'text','label' => __('Top/bottom distance (in pixels)','twitch-online-indicator'),'description' => __('Example: 50 (if empty, defaults to 50).','twitch-online-indicator'),'section' => 'toi_positioning_section',));
                
                /* left distance */
                $wp_customize->add_setting('toi_horizontal_distance',array('default' => '','sanitize_callback' => 'sanitize_toi_horizontal_distance',));
                function sanitize_toi_horizontal_distance($input) {return wp_kses_post(force_balance_tags($input));}
                $wp_customize->add_control('toi_horizontal_distance',array('type' => 'text','label' => __('Left/right distance (in pixels)','twitch-online-indicator'),'description' => __('Example: 50 (if empty, defaults to 20).','twitch-online-indicator'),'section' => 'toi_positioning_section',));
            
            // Graphics
            $wp_customize->add_section('toi_graphics_section',array('title' => __( 'Graphics','twitch-online-indicator' ),'panel' => 'toi_panel','priority' => 3));
            
                /* background color */
                $wp_customize->add_setting('toi_background_color',array('sanitize_callback'=>'sanitize_hex_color'));
                $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'toi_background_color',array(
                    'label'=>__('Background','twitch-online-indicator'),'settings'=>'toi_background_color','section'=>'toi_graphics_section')
                ));
                
                /* text color */
                $wp_customize->add_setting('toi_status_text_color',array('sanitize_callback'=>'sanitize_hex_color'));
                $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'toi_status_text_color',array(
                    'label'=>__('Text color','twitch-online-indicator'),'settings'=>'toi_status_text_color','section'=>'toi_graphics_section')
                ));
                
                /* live text color */
                $wp_customize->add_setting('toi_status_text_color_live',array('sanitize_callback'=>'sanitize_hex_color'));
                $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'toi_status_text_color_live',array(
                    'label'=>__('Text color when live','twitch-online-indicator'),'settings'=>'toi_status_text_color_live','section'=>'toi_graphics_section')
                ));
                
                /* text hover color */
                $wp_customize->add_setting('toi_status_text_hover_color',array('sanitize_callback'=>'sanitize_hex_color'));
                $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'toi_status_text_hover_color',array(
                    'label'=>__('Text hover color','twitch-online-indicator'),'settings'=>'toi_status_text_hover_color','section'=>'toi_graphics_section')
                ));
                
                /* live text hover color */
                $wp_customize->add_setting('toi_status_text_hover_color_live',array('sanitize_callback'=>'sanitize_hex_color'));
                $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'toi_status_text_hover_color_live',array(
                    'label'=>__('Text hover color when live','twitch-online-indicator'),'settings'=>'toi_status_text_hover_color_live','section'=>'toi_graphics_section')
                ));
                
                /* rounded corners */
                $wp_customize->add_setting('toi_rounded_corners',array('default' => '','sanitize_callback' => 'sanitize_toi_rounded_corners',));
                function sanitize_toi_rounded_corners($input) {return wp_kses_post(force_balance_tags($input));}
                $wp_customize->add_control('toi_rounded_corners',array('type' => 'text','label' => __('Rounded corners (in pixels)','twitch-online-indicator'),'description' => __('Example: 5 (if empty, defaults to 0).','twitch-online-indicator'),'section' => 'toi_graphics_section',));
        
                /* disable status text underline */
                $wp_customize->add_setting('toi_no_underline',array('sanitize_callback' => 'sanitize_toi_no_underline',));
                function sanitize_toi_no_underline( $input ) { if ( $input == 1 ) { return 1; } else { return ''; } }
                $wp_customize->add_control('toi_no_underline',array('type' => 'checkbox','label' => __('Enable underline on hover','twitch-online-indicator'),'description' => __('When checked text will be underlined when hovered.','twitch-online-indicator'), 'section' => 'toi_graphics_section',));
        
            // Hide On Mobile
            $wp_customize->add_section('toi_misc_section',array('title' => __( 'Hide On Mobile','twitch-online-indicator' ),'panel' => 'toi_panel','priority' => 3));

                /* smaller than */
                $wp_customize->add_setting('toi_smaller_than',array('sanitize_callback' => 'sanitize_toi_smaller_than',));
                function sanitize_toi_smaller_than($input) {return wp_kses_post(force_balance_tags($input));}
                $wp_customize->add_control('toi_smaller_than',array(
                    'type' => 'text',
                    'label' => __('Hide at certain width/resolution','twitch-online-indicator'),
                    'description' => __('<strong>Example #1:</strong> If you want to show the stream status on desktop only, enter the values as 0 and 500. <br><br> <strong>Example #2:</strong> If you want to show the stream status on mobile only, enter the values as 500 and 5000. <br><br> Feel free to experiment with your own values to get the result that is right for you. If fields are empty, the stream status will be visible at all browser widths and resolutions. <br><br> Hide stream status if browser width or screen resolution (in pixels) is between...','twitch-online-indicator'),
                    'section' => 'toi_misc_section',
                ));
                
                /* larger than */
                $wp_customize->add_setting('toi_larger_than',array('sanitize_callback' => 'sanitize_toi_larger_than',));
                function sanitize_toi_larger_than($input) {return wp_kses_post(force_balance_tags($input));}
                $wp_customize->add_control('toi_larger_than',array(
                    'type' => 'text',
                    'description' => __('..and:','twitch-online-indicator'),
                    'section' => 'toi_misc_section',
                ));
	}
	add_action('customize_register', 'toi_theme_customizer');

	// Add stream status to theme	
	function toi_header() {
	?>
        <?php if( get_theme_mod('toi_channel_name') != '' && get_theme_mod('toi_client_id') != '') { ?>
            <div id="toi-container"><a class="toi-twitch" <?php if( get_theme_mod('toi_new_window') != '') { ?>target="_blank"<?php } ?> href="https://www.twitch.tv/<?php echo get_theme_mod('toi_channel_name'); ?>">
                <span class="toi-status-text-live">
                    <?php if( get_theme_mod('toi_live_text') != '') { ?>
                        <?php echo get_theme_mod('toi_live_text'); ?>
                    <?php } else { ?>
                        <?php esc_html_e( 'LIVE on Twitch', 'twitch-online-indicator' ); ?>
                    <?php } ?>
                </span>
                <span class="toi-status-text-offline">
                    <?php if( get_theme_mod('toi_offline_text') != '') { ?>
                        <?php echo get_theme_mod('toi_offline_text'); ?>
                    <?php } else { ?>
                        <?php esc_html_e( 'OFFLINE on Twitch', 'twitch-online-indicator' ); ?>
                    <?php } ?>
                </span>
            </a></div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" crossorigin="anonymous"></script>
            <script>
            function checkIfLive() {
                jQuery.ajax({
                    type: 'GET',
                    url: 'https://api.twitch.tv/helix/streams?user_login=<?php echo get_theme_mod('toi_channel_name'); ?>',
                    headers: {
                        'Client-ID': '<?php echo get_theme_mod('toi_client_id'); ?>'
                    },
                    success: function(twitch) {
                        if (twitch.data.length > 0 && twitch.data[0].type == 'live'){
                            jQuery('#toi-container').addClass('live');
                        }else{
                            jQuery('#toi-container a').removeClass('live');
                        }	
                    }
                });
            }
            jQuery(document).ready(function(){
                checkIfLive();
                setInterval(checkIfLive, <?php if( get_theme_mod('toi_minutes') != '') { echo get_theme_mod('toi_minutes'); } else { echo '5'; } ?>*60*1000);
            });
            </script>
        <?php }else{ ?>
            <!-- Please enter your Channel Name and Client ID-->
        <?php } ?>

	<?php
	}
	add_action('wp_footer','toi_header');
    
	// Add 'Settings' link to plugin page
    add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'add_toi_action_links' );
    function add_toi_action_links ( $links ) {
        $mylinks = array(
        '<a href="' . admin_url( 'customize.php?autofocus[panel]=toi_panel' ) . '">Settings</a>'
        );
    return array_merge( $links, $mylinks );
    }

	// twitch-online-indicator.css
	function toi_css() {
		wp_register_style( 'twitch-online-indicator-css', plugins_url( '/twitch-online-indicator.css', __FILE__ ) . '', array(), '1', 'all' );
		wp_enqueue_style( 'twitch-online-indicator-css' );
	}
	add_action( 'wp_enqueue_scripts', 'toi_css' );
    
	// Translation-ready
    function toi_load_plugin_textdomain() {
        load_plugin_textdomain( 'twitch-online-indicator', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
    }
    add_action( 'plugins_loaded', 'toi_load_plugin_textdomain' );

    // Admin notice if config missing
    function toi_configuration_missing() {
        ?>
        <div class="notice notice-warning is-dismissible">
            <p><?php _e( 'Twitch Online Indicator Plugin: You need to <a href="customize.php?autofocus[section]=toi_main_section">configure</a> both your twitch channel name and an API key!', 'toi-configure' ); ?></p>
        </div>
        <?php
    }
    
	// Insert customization options into the header
	function toi_customize() {
	?>
		<!-- Twitch Online Indicator Custom CSS -->
		<style>
		<?php if( get_theme_mod('toi_background_color') != '') { ?>/* background color */
		#toi-container {
			background-color:<?php echo get_theme_mod('toi_background_color') ?>;
			background-image: none;
			box-shadow: none;
		}
		<?php } ?>
			
		/* status text color */
		#toi-container a.toi-twitch span.toi-status-text-live { color:<?php if( get_theme_mod('toi_status_text_color_live') != '') { ?><?php echo get_theme_mod('toi_status_text_color_live'); ?><?php } else { ?>#32CD32<?php } ?>; }
		#toi-container a.toi-twitch span.toi-status-text-offline { color:<?php if( get_theme_mod('toi_status_text_color') != '') { ?><?php echo get_theme_mod('toi_status_text_color'); ?><?php } else { ?>#ffffff<?php } ?>; }
			
		/* status text hover */
		#toi-container:hover a, #toi-container:hover a.toi-twitch span.toi-status-text-live { color:<?php if( get_theme_mod('toi_status_text_hover_color_live') != '') { ?><?php echo get_theme_mod('toi_status_text_hover_color_live'); ?><?php } else { ?>#ffffff<?php } ?>; }
		#toi-container:hover a, #toi-container:hover a.toi-twitch span.toi-status-text-offline { color:<?php if( get_theme_mod('toi_status_text_hover_color') != '') { ?><?php echo get_theme_mod('toi_status_text_hover_color'); ?><?php } else { ?>#FF0000<?php } ?>; }

		<?php if( get_theme_mod('toi_rounded_corners') != '') { ?> /* rounded corners */
			
        /* left positioning */
		#toi-container {
			border-top-right-radius:<?php echo get_theme_mod('toi_rounded_corners'); ?>px;
			border-bottom-right-radius:<?php echo get_theme_mod('toi_rounded_corners'); ?>px;
			<?php if( get_theme_mod('toi_horizontal_distance') != '0') { ?>
			border-top-left-radius:<?php echo get_theme_mod('toi_rounded_corners'); ?>px;
			border-bottom-left-radius:<?php echo get_theme_mod('toi_rounded_corners'); ?>px;
			<?php } ?>
			padding: <?php echo get_theme_mod('toi_rounded_corners'); ?>px;
		}
		<?php if( get_theme_mod('toi_placement_horizontal') == 'right') { ?>/* right positioning */
		#toi-container {
			<?php if( get_theme_mod('toi_horizontal_distance') == '0') { ?>
			border-top-right-radius:0px;
			border-bottom-right-radius:0px;
			<?php } ?>
			border-top-left-radius:<?php echo get_theme_mod('toi_rounded_corners'); ?>px;
			border-bottom-left-radius:<?php echo get_theme_mod('toi_rounded_corners'); ?>px;
		}
		<?php } } ?>
		<?php if( get_theme_mod('toi_absolute_position') != '') { ?>#toi-container { position:absolute; }<?php } ?>
		#toi-container {
            top:<?php if( get_theme_mod('toi_vertical_distance') != '') { ?><?php echo get_theme_mod('toi_vertical_distance'); ?><?php } else { ?>50<?php } ?>px;
            left:<?php if( get_theme_mod('toi_horizontal_distance') != '') { ?><?php echo get_theme_mod('toi_horizontal_distance'); ?><?php } else { ?>20<?php } ?>px;
		}
		<?php if( get_theme_mod('toi_placement') == 'bottom') { ?>/* bottom placement */
		#toi-container {
			top:auto;
			bottom:<?php if( get_theme_mod('toi_vertical_distance') != '') { ?><?php echo get_theme_mod('toi_vertical_distance'); ?><?php } else { ?>50<?php } ?>px;
		}
		<?php } ?><?php if( get_theme_mod('toi_placement_horizontal') == 'right') { ?>/* right placement + distances */
		#toi-container {
			left:auto;
			right:<?php if( get_theme_mod('toi_horizontal_distance') != '') { ?><?php echo get_theme_mod('toi_horizontal_distance'); ?><?php } else { ?>20<?php } ?>px;
		}
		<?php } ?>
		<?php if( get_theme_mod('toi_no_underline') != '') { ?>/* no status text underline */
		#toi-container:hover a.toi-twitch { text-decoration: underline !important; }
		<?php } ?>
		<?php if( get_theme_mod('toi_offline_hide') != '') { ?>/* hide when offline */
		#toi-container { display:none; }
		#toi-container.live { display: block; }
		<?php } ?>
        
		/* hide between resolutions */
		@media ( min-width:<?php echo get_theme_mod('toi_smaller_than'); ?>px) and (max-width:<?php echo get_theme_mod('toi_larger_than'); ?>px) {
			#toi-container { display:none !important; }
		}
		</style>
		<!-- End Twitch Online Indicator Custom CSS -->
	<?php
	}
    add_action('wp_head','toi_customize');

    if( get_theme_mod('toi_channel_name') == '' || get_theme_mod('toi_client_id') == '') {
        add_action( 'admin_notices', 'toi_configuration_missing' );
    }
    
?>