<?php

	// compact -  Create array containing variables and their values
	// compact(mixed $varname1 [, mixed $...])
	
	$city = 'San Francisco';
	$state = 'CA';
	$event = 'SIGGRAPH';
	
	$location_vars = array('city', 'state');
	
    $result = compact("event", $location_vars);
	
	print_r($result);
	

// -----

	$size = "large";
	
	$var_array = array(
		'color' => 'blue',
		'size' => 'medium',
		'shape' => 'sphere',
	);
	extract($var_array, EXTR_PREFIX_SAME, "wddx");
	echo "$color, $size, $shape, $wddx_size\n";
	// blue, large, sphere, medium