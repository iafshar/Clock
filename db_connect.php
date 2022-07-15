<?php

/**
 * A class file to connect to database
 */
class DB_CONNECT {

	private $con;

    // constructor
    function __construct() {
        // connecting to database
        $this->connect();
    }

    // destructor
    function __destruct() {
        // closing db connection
        $this->close();
    }

    /**
     * Function to connect with database
     */
    function connect() {
        // import database connection variables
        require_once __DIR__ . '/db_config.php';

        // Connecting to mysql database
        $this->con = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

		// Checking connection to the database
		if ($this->con->connect_error) {
			die("Failed to connect to MySQL: ".$this->con->connect_error);
		};

	}

	function get_con() {
        // returning connection cursor
        return $this->con;
    }

    /**
     * Function to close db connection
     */
    function close() {
        // closing db connection
        $this->con->close();
    }
}
?>
