<?php

namespace ElvenSpellmaker\Глаза;

interface ViewManagerInterface
{
	public static function addViewPath($path, $addToEnd = true);
	
	public static function getViewPaths();
	
	public static function findFullFilePath($fileName);
}