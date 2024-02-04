<?php

class Base {
    private static $_instance = null;

    public function __construct() {
        require_once dirname( MAIN_FILE_PATH ) . '/model/class-db-connect.php';

        $this->connect_db();
    }
    
    public static function get_instance() {
        if ( null == self::$_instance ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function connect_db() {
        DB_Connect::get_instance();
    }

    public function render() {
        $this->get_head();
        $this->get_content();
        $this->get_footer();
    }

    public function get_head() {
        include_once dirname( MAIN_FILE_PATH ) . '/templates/head.html';
    }

    public function get_content() {
        $uri = $_SERVER[ 'REQUEST_URI' ];

        $domain_sub_part = trim( DOMAIN_SUB_PART, '/' );
        $domain_sub_part = '/' . $domain_sub_part . '/';
        $uri = ( $domain_sub_part == substr( $uri, 0, strlen( $domain_sub_part ) ) ? substr( $uri, strlen( $domain_sub_part ) ) : $uri );
        if ( file_exists( dirname( MAIN_FILE_PATH ) . '/controller/class-'.$uri ) ) {
            require_once 'class-'.$uri;
            $class_name = str_replace( '.php', '', $uri );
            $class_name::get_instance();
        } else {
            http_response_code(404);
            echo '404 Not Found';
        }
    }

    public function get_footer() {
        include_once dirname( MAIN_FILE_PATH ) . '/templates/footer.html';
    }
}