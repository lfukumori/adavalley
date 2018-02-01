<?php

function create($class, $attributes = [], $quantity = null)
{
	if (is_null($quantity)) return factory($class)->create($attributes);
	
	return factory($class, $quantity)->create($attributes);
}

function make($class, $attributes = [], $quantity = null)
{
	if (is_null($quantity)) return factory($class)->make($attributes);

	return factory($class, $quantity)->make($attributes);
}