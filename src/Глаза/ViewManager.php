<?php

namespace ElvenSpellmaker\Глаза;

use RuntimeException;

abstract class ViewManager implements ViewManagerInterface
{
	protected static $viewPaths = [];
	
	public static function addViewPath($path, $addToEnd = true)
	{
		if( $addToEnd ) static::$viewPaths[] = $path;
		else array_unshift( static::$viewPaths, $path );
	}
	
	public static function getViewPaths()
	{
		return static::$viewPaths;
	}
	
	public static function findFullFilePath($fileName)
	{
		if( ! is_file( $fileName ) )
			foreach( static::$viewPaths as $vp )
			{
				$fp = "$vp/$fileName";
				if( is_file( $fp ) ) return $fp; 
			}
		else return $fileName;
		
		throw new RuntimeException('Cannot find the view! Given: '. $fileName);
	}
}
