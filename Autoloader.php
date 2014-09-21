<?php

namespace ElvenSpellmaker;

class Autoloader
{
	public static function load( $class )
	{
		if( strpos( $class, 'ElvenSpellmaker\\' ) === 0 )
		{
			$filename = __DIR__ .'/'. str_replace( 
					['ElvenSpellmaker\\', '\\'],
					['src\\', '/'],
					$class
				) . '.php';

			if ( file_exists( $filename ) ) return require $filename;
		}
		
		return false;
	}
}

spl_autoload_register( 'ElvenSpellmaker\Autoloader::load' );