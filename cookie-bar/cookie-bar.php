<?php
/*
Plugin Name: Cookie Bar
Plugin URI: https://www.brontobytes.com/blog/cookie-bar-free-wordpress-plugin/
Description: Cookie Bar allows you to discreetly inform visitors that your website uses cookies.
Author: Brontobytes
Author URI: https://www.brontobytes.com/
Version: 2.3
License: GPLv2
*/

if ( ! defined( 'ABSPATH' ) )
	exit;

function cookie_bar_menu() {
	add_options_page('Cookie Bar Settings', 'Cookie Bar', 'administrator', 'cookie-bar-settings', 'cookie_bar_settings_page');
}
add_action('admin_menu', 'cookie_bar_menu');


add_filter( 'plugin_action_links', 'cookie_bar_settings_plugin_link', 10, 2 );

function cookie_bar_settings_plugin_link( $links, $file )
{
    if ( $file == plugin_basename(dirname(__FILE__) . '/cookie-bar.php') )
    {
        /*
         * Insert the link at the beginning
         */
     //   $in = '<a href="options-general.php?page=cookie-bar-settings">' . __('Settings','mtt') . '</a>';
     //   array_unshift($links, $in);

        /*
         * Insert at the end
         */
         $links[] = '<a href="options-general.php?page=cookie-bar-settings">'.__('Settings','mtt').'</a>';
    }
    return $links;
}

function cookie_bar_settings_page() {

    $cookie_bar_show_for_logged_out_users_only_option = get_option('cookie_bar_show_for_logged_out_users_only');
    $cookie_bar_show_on_top = get_option('cookie_bar_show_on_top');

    ?>
<script>
jQuery(document).ready(function($){
    $(".cookie_bar_btn_bg_colour").wpColorPicker();
    $(".cookie_bar_btn_font_colour").wpColorPicker();
    $(".cookie_bar_bar_bg_colour").wpColorPicker();
    $(".cookie_bar_bar_font_colour").wpColorPicker();
});
</script>
    <style type="text/css" >
        .wrap.cookie_bar_settings {
            max-width: 960px;
            padding: 26px 30px 30px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.04);
        }

        .wrap.cookie_bar_settings h1 {
            margin-bottom: 10px;
        }

        .cookie_bar_settings__intro {
            max-width: 760px;
            margin: 0 0 18px;
            color: #50575e;
            font-size: 14px;
            line-height: 1.6;
        }

        .cookie_bar_settings__panel {
            margin-top: 20px;
        }

        .wrap.cookie_bar_settings .form-table {
            margin-top: 0;
        }

        .wrap.cookie_bar_settings .form-table th {
            width: 220px;
            padding: 20px 20px 20px 0;
        }

        .wrap.cookie_bar_settings .form-table td {
            padding: 15px 10px;
        }

        .wrap.cookie_bar_settings fieldset label {
            display: block;
            margin: 0 0 10px;
            line-height: 1.4;
        }

        .wrap.cookie_bar_settings input[type="text"] {
            width: 100%;
            max-width: 520px;
        }

        .wrap.cookie_bar_settings input[size="4"] {
            width: 70px;
        }

        .wrap.cookie_bar_settings .description {
            max-width: 620px;
            margin-top: 8px;
            color: #646970;
        }

        .wrap.cookie_bar_settings code {
            display: block;
            max-width: 620px;
            margin-top: 10px;
            padding: 12px;
            overflow-x: auto;
            white-space: pre-wrap;
            background: #f6f7f7;
            border: 1px solid #dcdcde;
        }

        .wrap.cookie_bar_settings .cookie_bar_settings__divider th {
            padding: 10px 0;
        }

        .wrap.cookie_bar_settings .cookie_bar_settings__divider hr {
            max-width: none;
            margin: 0;
            border: 0;
            border-top: 1px solid #dcdcde;
        }

        .cookie_bar_settings__footer {
            margin-top: 20px;
            color: #50575e;
        }

        .cookie_bar_settings__brand {
            display: inline-block;
            margin-top: 4px;
        }

        .cookie_bar_settings__brand img {
            width: 100px;
            height: auto;
            vertical-align: middle;
        }

        @media screen and (max-width: 782px) {
            .wrap.cookie_bar_settings {
                padding: 18px;
                border-radius: 10px;
            }

            .cookie_bar_settings__panel {
                margin-top: 16px;
            }

            .wrap.cookie_bar_settings .form-table th,
            .wrap.cookie_bar_settings .form-table td {
                display: block;
                width: auto;
                padding: 12px 0;
            }

            .wrap.cookie_bar_settings .form-table th {
                padding-bottom: 0;
            }

            .wrap.cookie_bar_settings input[type="text"] {
                max-width: 100%;
            }
        }

    </style>
<div class="wrap cookie_bar_settings">
<h1><?php _e('Cookie Bar Settings', 'cookie-bar'); ?></h1>
<div class="cookie_bar_settings__intro">
<p><?php _e('Cookie Bar allows you to discreetly inform visitors that your website uses cookies.

This is to notify your visitors that you are using cookies and does not control which or if cookies are set. Your cookies are set in any case.', 'cookie-bar'); ?></p>
</div>
<div class="cookie_bar_settings__panel">
<form method="post" action="options.php">
    <?php settings_fields( 'cookie-bar-settings' ); ?>
    <?php do_settings_sections( 'cookie-bar-settings' ); ?>
    <table class="form-table">
        <tr valign="top">
            <th scope="row"><?php _e('Expiration', 'cookie-bar'); ?></th>
            <td>
                <?php $expiration_type = "custom";
                $option_type = get_option('cookie_bar_expiration_type');
                if (isset($option_type) && $option_type === "never") {
                    $expiration_type = "never";
                }

                $expiration_custom_date = "30";
                $option_custom_date = get_option('cookie_bar_days_to_expire');
                $option_custom_date = preg_replace('/\D/', '', isset($option_custom_date) ? $option_custom_date : '');

                if (isset($option_custom_date) && (!empty($option_custom_date)) ) {
                    $expiration_custom_date = $option_custom_date;
                }
                ?>
                <fieldset>
                <label><input type="radio" onclick="handleClick_type(this);" name="cookie_bar_expiration_type" <?php if ($expiration_type=="never") echo "checked";?> value="never"> <?php _e('Never expire (until cookies are cleared)', 'cookie-bar'); ?></label>
                <label><input type="radio" onclick="handleClick_type(this);" name="cookie_bar_expiration_type" <?php if ($expiration_type=="custom") echo "checked";?> value="custom"> <?php _e('Custom expiration', 'cookie-bar'); ?></label>
                <div class="cookie_bar_days_to_expire">
                    <input type="text" size="4" name="cookie_bar_days_to_expire" value="<?php echo esc_html( $expiration_custom_date ); ?>" /> <?php _e('days', 'cookie-bar'); ?>
                </div>
                </fieldset>


            </td>

        </tr>
        <tr class="cookie_bar_settings__divider">
            <th colspan="2" >
                <hr />
            </th>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e('Cookie Bar message', 'cookie-bar'); ?></th>
            <td><input type="text" size="100" name="cookie_bar_message" value="<?php echo esc_html( get_option('cookie_bar_message') ); ?>" /> <div class="description"><?php _e('HTML allowed. Example:', 'cookie-bar'); ?><code><?php echo esc_html('By continuing to browse this site, you agree to our <a href="https://aboutcookies.com/" target="_blank" rel="nofollow">use of cookies</a>.'); ?></code></div></td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e('Button text', 'cookie-bar'); ?></th>
            <td><input type="text" size="20" name="cookie_bar_button" value="<?php echo esc_attr( get_option('cookie_bar_button') ); ?>" /> <p class="description"><?php _e('E.g.: I understand', 'cookie-bar'); ?></p></td>
        </tr>
        <tr class="cookie_bar_settings__divider">
            <th colspan="2" >
                <hr />
            </th>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e('Button background colour', 'cookie-bar'); ?></th>
            <td><input type="text" name="cookie_bar_btn_bg_colour" value="<?php echo esc_attr( get_option('cookie_bar_btn_bg_colour') ); ?>" class="cookie_bar_btn_bg_colour" data-default-color="#45AE52" /></td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e('Button font colour', 'cookie-bar'); ?></th>
            <td><input type="text" name="cookie_bar_btn_font_colour" value="<?php echo esc_attr( get_option('cookie_bar_btn_font_colour') ); ?>" class="cookie_bar_btn_font_colour" data-default-color="#ffffff" /></td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e('Bar background colour', 'cookie-bar'); ?></th>
            <td><input type="text" name="cookie_bar_bar_bg_colour" value="<?php echo esc_attr( get_option('cookie_bar_bar_bg_colour') ); ?>" class="cookie_bar_bar_bg_colour" data-default-color="#2e363f" /></td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e('Bar font colour', 'cookie-bar'); ?></th>
            <td><input type="text" name="cookie_bar_bar_font_colour" value="<?php echo esc_attr( get_option('cookie_bar_bar_font_colour') ); ?>" class="cookie_bar_bar_font_colour" data-default-color="#ffffff" /></td>
        </tr>
        <tr class="cookie_bar_settings__divider">
            <th colspan="2" >
                <hr />
            </th>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e('Show for logged out users only', 'cookie-bar'); ?></th>
            <td><input type="checkbox"  name="cookie_bar_show_for_logged_out_users_only" <?php if ($cookie_bar_show_for_logged_out_users_only_option == "1") echo "checked";?> value="1" ></td>
        </tr>

        <tr valign="top">
            <th scope="row"><?php _e('Display at the top', 'cookie-bar'); ?></th>
            <td><input type="checkbox"  name="cookie_bar_show_on_top" <?php if ($cookie_bar_show_on_top == "1") echo "checked";?> value="1" ></td>
        </tr>

    </table>
    <script type="text/javascript" >

        function handleClick_type(type_) {

            if( type_.value == "custom")
            {

                var tracking_code_gtag = document.getElementsByClassName('cookie_bar_days_to_expire');

                for (var i = 0; i < tracking_code_gtag.length; i ++) {
                    tracking_code_gtag[i].style.display = 'block';
                }

            }
            else if( type_.value == "never")
            {
                var tracking_code_gtag = document.getElementsByClassName('cookie_bar_days_to_expire');

                for (var i = 0; i < tracking_code_gtag.length; i ++) {
                    tracking_code_gtag[i].style.display = 'none';
                }
            }
        }

        <?php if ($expiration_type == "never") { ?>
            handleClick_type({ value: "never" });
        <?php } else { ?>
            handleClick_type({ value: "custom" });
        <?php } ?>

    </script>

    <?php submit_button(); ?>
</form>
</div>
<div class="cookie_bar_settings__footer">
<p><?php _e('We are very happy to be able to provide this and other', 'cookie-bar'); ?> <a target="_blank" href="https://www.brontobytes.com/blog/c/wordpress-plugins/"><?php _e('free WordPress plugins', 'cookie-bar'); ?></a>.</p>
<p><?php _e('Plugin developed by', 'cookie-bar'); ?> <a href="https://www.brontobytes.com/" target="_blank" >Brontobytes</a></p>
    <a class="cookie_bar_settings__brand" href="https://www.brontobytes.com/" target="_blank"><img src="<?php echo plugins_url( 'images/brontobytes.svg', __FILE__ ) ?>" alt="Web hosting provider"></a>
</div>
</div>
<?php }

function cookie_bar_settings() {
	register_setting( 'cookie-bar-settings', 'cookie_bar_message' );
	register_setting( 'cookie-bar-settings', 'cookie_bar_button' );
    register_setting( 'cookie-bar-settings', 'cookie_bar_btn_bg_colour' );
    register_setting( 'cookie-bar-settings', 'cookie_bar_btn_font_colour' );
    register_setting( 'cookie-bar-settings', 'cookie_bar_bar_bg_colour' );
    register_setting( 'cookie-bar-settings', 'cookie_bar_bar_font_colour' );
    register_setting( 'cookie-bar-settings', 'cookie_bar_days_to_expire' );
    register_setting( 'cookie-bar-settings', 'cookie_bar_expiration_type' );
    register_setting( 'cookie-bar-settings', 'cookie_bar_show_for_logged_out_users_only' );
    register_setting( 'cookie-bar-settings', 'cookie_bar_show_on_top' );

}
add_action( 'admin_init', 'cookie_bar_settings' );

function cookie_bar_deactivation() {
    delete_option( 'cookie_bar_message' );
    delete_option( 'cookie_bar_button' );
    delete_option( 'cookie_bar_btn_bg_colour' );
    delete_option( 'cookie_bar_btn_font_colour' );
    delete_option( 'cookie_bar_bar_bg_colour' );
    delete_option( 'cookie_bar_bar_font_colour' );
    delete_option( 'cookie_bar_days_to_expire' );
    delete_option( 'cookie_bar_expiration_type' );
    delete_option( 'cookie_bar_show_for_logged_out_users_only' );
    delete_option( 'cookie_bar_show_on_top' );

}
register_deactivation_hook( __FILE__, 'cookie_bar_deactivation' );

function cookie_bar_dependencies() {
	wp_register_script( 'cookie-bar-js', plugins_url('js/cookie-bar.js', __FILE__), array('jquery'), time(), false );
	wp_enqueue_script( 'cookie-bar-js' );
	wp_register_style( 'cookie-bar-css', plugins_url('css/cookie-bar.css', __FILE__) );
	wp_enqueue_style( 'cookie-bar-css' );
}
add_action( 'wp_enqueue_scripts', 'cookie_bar_dependencies' );

class cookie_bar_languages {
    public static function loadTextDomain() {
        load_plugin_textdomain('cookie-bar', false, dirname(plugin_basename(__FILE__ )) . '/languages/');
    }
}


$allowed_html = array(
    'a'      => array(
        'href'       => array(),
        'title'      => array(),
        'target'     => array(),
        'class'      => array(),
        'id'         => array(),
        'rel'        => array(),
    ),
    'br'     => array(),
    'em'     => array(),
    'strong' => array(),
);


add_action('plugins_loaded', array('cookie_bar_languages', 'loadTextDomain'));

function cookie_bar_color_picker( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'cookie-bar-color-picker', plugins_url('js/cookie-bar.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}
add_action( 'admin_enqueue_scripts', 'cookie_bar_color_picker' );

function cookie_bar() {
    global $allowed_html;

    $cookie_bar_message_output = get_option( 'cookie_bar_message' );
    $cookie_bar_button_output = esc_attr( get_option('cookie_bar_button') );
    $cookie_bar_btn_font_colour = esc_attr( get_option('cookie_bar_btn_font_colour') );
    $cookie_bar_bar_bg_colour = esc_attr( get_option('cookie_bar_bar_bg_colour') );
    $cookie_bar_bar_font_colour = esc_attr( get_option('cookie_bar_bar_font_colour') );
    $cookie_bar_show_for_logged_out_users_only = esc_attr( get_option('cookie_bar_show_for_logged_out_users_only') );
    $cookie_bar_show_on_top = esc_attr( get_option('cookie_bar_show_on_top') );

    $expiration_type = "custom";
    $option_type = get_option('cookie_bar_expiration_type');
    if (isset($option_type) && $option_type === "never") {
        $expiration_type = "never";
    }

    $expiration_custom_date = "30";
    $option_custom_date = get_option('cookie_bar_days_to_expire');
    if (isset($option_custom_date) && (!empty($option_custom_date)) ) {
        $expiration_custom_date = $option_custom_date;
    }

    if ( empty( $cookie_bar_message_output ) ) $cookie_bar_message_output = 'By continuing to browse this site, you agree to our <a href="https://aboutcookies.com/" target="_blank" rel="nofollow">use of cookies</a>.';
    if ( empty( $cookie_bar_button_output ) ) $cookie_bar_button_output = "I Understand";
?>
        <style type="text/css" >
            <?php
            if (isset($cookie_bar_btn_font_colour) && (!empty($cookie_bar_btn_font_colour))) {
            ?>
                button#euCookieAcceptWP { color : <?php echo $cookie_bar_btn_font_colour ?>; }
            <?php
            }

            if (isset($cookie_bar_bar_bg_colour) && (!empty($cookie_bar_bar_bg_colour))) {
            ?>
                #eu-cookie-bar { background-color : <?php echo $cookie_bar_bar_bg_colour ?>; }
            <?php
            }


            if (isset($cookie_bar_bar_font_colour) && (!empty($cookie_bar_bar_font_colour))) {
            ?>
                #eu-cookie-bar , #eu-cookie-bar a { color : <?php echo $cookie_bar_bar_font_colour ?>; }
            <?php
            }


              if (isset($cookie_bar_show_on_top) && (!empty($cookie_bar_show_on_top))) {
            ?>
                #eu-cookie-bar
                {
                    position: fixed;
                    top: 0;
                    height: 30px;
                    z-index: 999999999999999;
                }
            <?php
            }



            ?>




        </style>
    <?php  if($cookie_bar_show_for_logged_out_users_only) {
                if(is_user_logged_in()) {
                    return;
                }
            } ?>
<!-- Cookie Bar -->
<div id="eu-cookie-bar"><?php echo wp_kses( $cookie_bar_message_output, $allowed_html ); ?> <button id="euCookieAcceptWP" <?php if (get_option('cookie_bar_btn_bg_colour') == true) { ?> style="background:<?php echo esc_html( get_option('cookie_bar_btn_bg_colour') ); ?>;" <?php } ?> onclick="euSetCookie('euCookiesAcc', true, <?php if($expiration_type === 'never' ) {echo '4000';} if($expiration_type === "custom" ) {echo $expiration_custom_date;} ?>); euAcceptCookiesWP();"><?php echo  wp_kses($cookie_bar_button_output, $allowed_html); ?></button></div>
<!-- End Cookie Bar -->
<?php
}
add_action( 'wp_footer', 'cookie_bar', 10 );
