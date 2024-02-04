<?php

class DB_Connect {
    private static $_instance = null;

    private $conn = null;

    private $host = '';

    private $username = '';

    private $password = '';

    private $database = '';


    private function __construct() {
        $this->host     = DB_HOST;
        $this->username = DB_USERNAME;
        $this->password = DB_PASSWORD;
        $this->database = DB_NAME;

        $this->connect();
        $this->create_tables();
    }

    public static function get_instance() {
        if ( null == self::$_instance ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    private function connect() {
        $this->conn = new mysqli( $this->host, $this->username, $this->password, $this->database );

        if ( $this->conn->connect_error ) {
            die('Connection failed: ' . $this->conn->connect_error);
        }
    }

    public function get_connection() {
        if ( empty( $this->conn ) ) {
            $this->connect();
        }

        return $this->conn;
    }

    public function create_tables() {
        $user_table_name = $this->get_user_table_name();

        // SQL query to create a table
        $sql = "CREATE TABLE IF NOT EXISTS $user_table_name (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            profile_image VARCHAR(255)
        );";

        // Execute the query
        if ($this->conn->query($sql) === false) {
            echo 'Error creating table: ' . $this->conn->error;
            exit;
        }
    }

    public function get_user_table_name() {
        return 'users';
    }
}
