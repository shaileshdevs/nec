<?php

class Registration {
    private static $_instance = null;

    private $errors = array();

    public function __construct() {
        require_once 'class-sanitization.php';
        require_once dirname( MAIN_FILE_PATH ) . '/model/class-db-connect.php';

        $this->process_registration_form();
        $this->render();
    }

    public static function get_instance() {
        if ( null == self::$_instance ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function process_registration_form() {
        $form_type = empty( $_POST[ 'submit' ] ) ? '' : $_POST[ 'submit' ];
        if ( 'registration' == $form_type ) {

            // Handle registration form data
            $username = Sanitization::sanitize_text( $_POST[ 'username' ] );
            $email    = Sanitization::is_valid_email( $_POST[ 'email' ] );
            $password = $_POST[ 'password' ];

            if ( empty( $username ) ) {
                $this->errors[ 'username' ] = 'Username can not be empty';
                return;
            }
            
            if ( false === $email ) {
                $this->errors[ 'email' ] = 'Email is not valid';
                return;
            } else if ( empty( $email ) ) {
                $this->errors[ 'email' ] = 'Email can not be empty';
                return;
            }

            if ( empty( $password ) ) {
                $this->errors[ 'password' ] = 'Password can not be empty';
                return;
            } else {
                $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
            }

            if ( empty( $this->errors ) ) {
                $db_instance     = DB_Connect::get_instance();
                $db_conn         = $db_instance->get_connection();
                $user_table_name = $db_instance->get_user_table_name();

                if ( $this->username_exists( $username ) ) {
                    $this->errors[ 'username' ] = 'Username exists';
                    return;
                }

                if ( $this->email_exists( $email ) ) {
                    $this->errors[ 'email' ] = 'Email exists';
                    return;
                }

                // Handle file upload
                $profileImageName = $_FILES["profile_image"]["name"];
                $targetDir = empty($profileImageName) ? '' : 'uploads/';
                $targetPath = $targetDir . $profileImageName;

                move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetPath);

                // Insert user data into the database
                $sql = "INSERT INTO $user_table_name (username, email, password, profile_image) VALUES (?, ?, ?, ?)";

                $stmt = $db_conn->prepare( $sql );
                $stmt->bind_param( 'ssss', $username, $email, $password, $targetPath );
                $result = $stmt->execute();

                if ( $result ) {
                    echo 'Registration Successful';
                } else {
                    echo 'Error In Registration';
                }

            }
        }
    }

    public function username_exists( $username ) {
        $db_instance     = DB_Connect::get_instance();
        $db_conn         = $db_instance->get_connection();
        $user_table_name = $db_instance->get_user_table_name();

        // Get the id of based on username
        $sql = "SELECT id FROM $user_table_name WHERE username=?";

        $stmt = $db_conn->prepare( $sql );
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result( $id );

        if ( $stmt->fetch() ) {
            return true;
        } else {
            return false;
        }
    }

    public function email_exists( $email ) {
        $db_instance     = DB_Connect::get_instance();
        $db_conn         = $db_instance->get_connection();
        $user_table_name = $db_instance->get_user_table_name();

        // Insert the id based on email
        $sql = "SELECT id FROM $user_table_name WHERE email=?";

        $stmt = $db_conn->prepare( $sql );
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result( $id );

        if ( $stmt->fetch() ) {
            return true;
        } else {
            return false;
        }
    }

    public function render() {
        $errors = $this->errors;
        include_once dirname( MAIN_FILE_PATH ) . '/templates/registration.php';
    }
}
