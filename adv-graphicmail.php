<?php
/*
Plugin Name: ADV GraphicMail
Plugin URI: http://www.adv-media.it
Description: Show a subscribe form for your mailing list in GraphicMail.
Version: 1.0
Author: ADVMedia
Author URI: http://www.adv-media.it
License: GPLv2 or later
Text Domain: adv-graphicmail
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// setting costants
define('GM_VERSION', '1.0');
define('GM_HTTPS', true);

load_plugin_textdomain('adv-graphicmail', false, dirname( plugin_basename( __FILE__ ) ).'/languages');

// includes
include('includes/gm_api.php');
include('includes/gm_widget.php');
include('includes/gm_options.php');
include('includes/gm_ajax.php');

// widget
function gm_register_widget() {
    register_widget('GM_Widget');
}

// settings
function gm_register_settings() {
    register_setting('adv-graphicmail', 'gm_url');
    register_setting('adv-graphicmail', 'gm_user');
    register_setting('adv-graphicmail', 'gm_pass');
}

// menu
function gm_menu() {
    add_options_page('GraphicMail', 'GraphicMail', 'administrator', 'adv-graphicmail', 'gm_options');
}

// scripts
function gm_include_js() {

    // plugin js
    wp_register_script('gm_js', plugins_url('assets/js/scripts.min.js', __FILE__), array( 'jquery' ));
    wp_enqueue_script('gm_js');

    // sweet alert js
    wp_register_script('sweetalert_js', plugins_url('assets/sweetalert/sweet-alert.min.js', __FILE__));
    wp_enqueue_script('sweetalert_js');

}

// css
function gm_include_css() {

    // plugin css
    wp_register_style('gm_css', plugins_url('assets/css/default.css', __FILE__));
    wp_enqueue_style('gm_css');

    // sweet alert css
    wp_register_style('sweetalert_css', plugins_url('assets/sweetalert/sweet-alert.css', __FILE__));
    wp_enqueue_style('sweetalert_css');

}

// hooks
add_action('widgets_init',          'gm_register_widget');
add_action('admin_init',            'gm_register_settings');
add_action('admin_menu',            'gm_menu');
add_action('wp_enqueue_scripts',    'gm_include_js');
add_action('wp_enqueue_scripts',    'gm_include_css');
add_action('admin_enqueue_scripts', 'gm_include_css');

// ajax
add_action('wp_action_gm_ajax_subscribe',       'gm_ajax_subscribe');
add_action('wp_ajax_gm_ajax_subscribe',         'gm_ajax_subscribe');
add_action('wp_ajax_nopriv_gm_ajax_subscribe',  'gm_ajax_subscribe');