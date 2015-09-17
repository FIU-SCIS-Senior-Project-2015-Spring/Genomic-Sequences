<?php

/*
*	This is the means of which the controller will pass variables to the UI. In other words,
*	as templates are created, controllers will set variables within the template that the 
*	template will use. This follows the MVC, or Model View Controller format.	
*/

class Template {
	protected $template;	// Path to the template will be stored here
	protected $vars = array();	// Any variables passed to the template are stored here, in other words, an array of arguments
	
	public function __construct($template) {	// Basic constructor. Accepts path to the template file (the view)
		$this->template = $template;
	}
	
	public function __get($key) {	// Magical get function that returns any arguments passed by the controller
		return $this->vars[$key];
	}
	
	public function __set($key, $value) { // Magical set function that the controller uses to pass variables
		$this->vars[$key] = $value;
	}
	
	public function __toString() {	// Treat template as string, therefore, allow echoing the template!
		extract($this->vars);
		chdir(dirname($this->template));
		ob_start();			
		include basename($this->template);
		return ob_get_clean();
	}
}