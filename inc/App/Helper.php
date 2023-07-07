<?php

namespace M8C;

class Helper
{

	function __construct()
	{

	}

	public static function m8c_printr($obj)
	{

		echo '<pre>';
		print_r($obj, true);
		echo '</pre>';

	}

}


