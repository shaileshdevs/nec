<?php

class Login {
    private static $_instance = null;

    private $errors = array();

    public function __construct() {
        require_once 'class-sanitization.php';
        require_once dirname( MAIN_FILE_PATH ) . '/model/class-db-connect.php';

        $this->process_login_form();
        $this->render();
    }

    public static function get_instance() {
        if ( null == self::$_instance ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function process_login_form() {
        $form_type = empty( $_POST[ 'submit' ] ) ? '' : $_POST[ 'submit' ];
        if ( 'login' == $form_type ) {
            // Handle login form data
            $username = Sanitization::sanitize_text( $_POST[ 'username' ] );
            $password = $_POST[ 'password' ];

            if ( empty( $username ) ) {
                $this->errors[ 'username' ] = 'Username can not be empty';
            }

            if ( empty( $password ) ) {
                $this->errors[ 'password' ] = 'Password can not be empty';
            }

            if ( empty( $this->errors ) ) {
                $db_instance     = DB_Connect::get_instance();
                $db_conn            = $db_instance->get_connection();
                $user_table_name = $db_instance->get_user_table_name();

                $sql = "SELECT password FROM $user_table_name WHERE username=?";

                $stmt = $db_conn->prepare( $sql );
                $stmt->bind_param('s', $username);
                $stmt->execute();
                $stmt->bind_result( $hash );

                if ( $stmt->fetch() ) {
                    $is_valid = password_verify( $password, $hash );
                    
                    if ( $is_valid ) {
                        echo 'Login Successful!';
                    } else {
                        $this->errors[ 'password' ] = 'Password is incorrect';
                    }
                } else {
                    $this->errors[ 'username' ] = 'Username does not exist';
                }
            }
        }
    }

    public function render() {
        $errors = $this->errors;
        include_once dirname( MAIN_FILE_PATH ) . '/templates/login.php';
    }
}
