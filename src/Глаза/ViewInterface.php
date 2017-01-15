<?php

namespace ElvenSpellmaker\Глаза;

interface ViewInterface
{
	public function __construct($fileName, $data = [], $escape = true);
	
	public function set($name, $data, $escape = true);
	
	public function render();
	
	public function __toString();
}
