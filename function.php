<?php
	
	function countData($table)
	{
		include 'config.php';
		$sql_count = "SELECT COUNT(*) AS total FROM $table
			WHERE Status!='Archived'";
		$result = $con->query($sql_count);

		$data = mysqli_fetch_assoc($result);
		return $data['total'];
	}

	function getAppFolder()
	{
	    $protocol  = empty($_SERVER['HTTPS']) ? 'http' : 'https';
	    $port      = $_SERVER['SERVER_PORT'];
	    $disp_port = ($protocol == 'http' && $port == 80 || $protocol == 'https' && $port == 443) ? '' : ":$port";
	    $domain    = $_SERVER['SERVER_NAME'];

	    return "${protocol}://${domain}${disp_port}" . "/myshop/";
	}

?>