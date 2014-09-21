<?php

namespace ElvenSpellmaker\Глаза;

use ElvenSpellmaker\Глаза\ViewInterface;
use Exception;

class View implements ViewInterface
{
	protected $fileName = '';
	
	protected $data = ['object' => [], 'string' => []];

	public function __construct($fileName, $data = [], $escape = true)
	{
		$fileName = ViewManager::findFullFilePath( $fileName .'.php' );
		
		$this->fileName = $fileName;
		
		foreach( $data as $datum_name => $datum_value )
			$this->set( $datum_name, $datum_value, $escape );
	}
	
	public function set($name, $data, $escape = true)
	{
		// Ensure the old values are cleaned up.
		unset( $this->data['string'][$name], $this->data['object'][$name] );
		
		if( $data instanceof static ) $this->data['object'][$name] = $data;
		else $this->data['string'][$name] = ( $escape ) ? htmlspecialchars( $data ) : $data;
		
		return $this;
	}
	
	public function render()
	{
		$variables = [];
	
		foreach( $this->data['object'] as $name => $view ) $variables[$name] = $view;
		foreach( $this->data['string'] as $name => $string ) $variables[$name] = (string)$string;
		
		extract($variables, EXTR_REFS);
		ob_start();
		
		try 
		{
			include $this->fileName;
		}
		catch (\Exception $e)
		{
			ob_get_clean();
			
			throw $e;
		}
		
		return ob_get_clean();
	}
	
	public function __toString()
	{
		return $this->render();
	}
}
