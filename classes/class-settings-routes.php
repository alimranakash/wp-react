<?php

class WPReact_Settings_rest_route {
    public function __construct() {
        add_action( 'rest_api_init', [ $this, 'create_rest_routes' ] );
    }

    public function create_rest_routes() {
        register_rest_route( 'wpreact/v1', '/settings/', [
            'methods'   => 'GET',
            'callback'  =>  [ $this, 'get_settings' ],
            'permission_callback' => [ $this, 'get_settings_permission' ],
        ] );

        register_rest_route( 'wpreact/v1', '/settings/', [
            'methods'   => 'POST',
            'callback'  =>  [ $this, 'save_settings' ],
            'permission_callback' => [ $this, 'save_settings_permission' ],
        ] );
    }

    public function get_settings() {
        $firstname  = get_option( 'wpreact_settings_firstname' );
        $lastname   = get_option( 'wpreact_settings_lastname' );
        $email      = get_option( 'wpreact_settings_email' );

        $respons = [
            'firstname' => $firstname,
            'lastname'  => $lastname,
            'email'     => $email
        ];

        return rest_ensure_response( $respons );
    }

    public function get_settings_permission() {
        return true;
    }

    public function save_settings( $reqest ) {
        $firstname  = sanitize_text_field( $reqest[ 'firstname' ] );
        $lastname   = sanitize_text_field( $reqest[ 'lastname' ] );
        $email      = sanitize_text_field( $reqest[ 'email' ] );

        update_option( 'wpreact_settings_firstname', $firstname );
        update_option( 'wpreact_settings_lastname', $lastname );
        update_option( 'wpreact_settings_email', $email );

        return rest_ensure_response( 'Successfully Save' );
    }

    public function save_settings_permission() {
        // return true;
        return current_user_can( 'publish_posts' );
    }
}
new WPReact_Settings_rest_route();