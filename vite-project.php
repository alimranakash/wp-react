<?php

/**
 * Plugin Name: Vite Project
 */

 class ViteProject {    
    function __construct() {
    // add_action('init',[$this,'initialize']);
        add_action('admin_enqueue_scripts', [$this, 'loadAssets']);
        add_action('wp_enqueue_scripts', [$this, 'loadAssets']);
        add_action('admin_menu', [$this, 'adminMenu']);
        add_action('wp_head', [$this, 'head']);
        add_filter('script_loader_tag', [$this, 'loadScriptAsModule'], 10, 3);

        require_once( dirname( __FILE__ ) . '/classes/class-settings-routes.php' );
    }

    function loadScriptAsModule($tag, $handle, $src) {
        // print_r($handle);
        if ('wp-vue-core' !== $handle) {
            return $tag;
        }
        print_r($handle);
        $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
        return $tag;
    }

    function adminMenu() {
        add_menu_page('WPReact', 'WPReact', 'manage_options', 'wpreact', [$this, 'loadAdminPage'], 'dashicons-tickets', 6);
    }

    function loadAdminPage() {
        include_once(plugin_dir_path(__FILE__) . "/wp-src/admin/admin.php");
    }

    function loadAssets() {
        $pluginUrl = plugin_dir_url(__FILE__);
        wp_enqueue_script('wp-vue-core', plugins_url( 'dist/index.js', __FILE__ ), [], time(), true);
        wp_localize_script('wp-vue-core', 'wpreact', [
            'url'       => $pluginUrl,
            'apiUrl'    => home_url( '/wp-json' ),
            'nonce'     => wp_create_nonce( 'wp_rest' )
        ]);
    }

    public function head() {
        echo '<div id="llllllllll">ttttttttttt</div>';
    }
 }
 new ViteProject(); ?>

 