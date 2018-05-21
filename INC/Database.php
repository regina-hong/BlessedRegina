<?php 

//Connect to db
function get_database_connection()
{
	$mysql_settings = array(
		"hostname" => "",
		"username" => "root",
		"password" => ""
	);

	// Create connection
	$mysqli = new mysqli($mysql_settings["hostname"], $mysql_settings["username"], $mysql_settings["password"]);
	// Check connection
	if ($mysqli->connect_errno) {
	    die("Connection failed: " . $mysqli->connect_error);
	}

	return $mysqli;
}

?>