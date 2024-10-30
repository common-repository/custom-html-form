<?php
/*
Plugin Name: Custom HTML Form
Description: Simple form validation for your custom HTML.
Author: Ceramedia
Version: 1.0
Author URI: http://ceramedia.net
License: GPL2
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
	exit;
}

class CM_CustomHtmlForm {

	private $_pluginPath;
	private $_pluginUrl;

	function __construct()
	{
		// Set up default vars
		$this->_pluginPath = plugin_dir_path( __FILE__ );
		$this->_pluginUrl = plugin_dir_url( __FILE__ );

		// Add your own hooks/filters
		add_action( 'init', array(&$this, 'init') );
	}
	function init()
	{
		// Require form file
		require_once $this->_pluginPath . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'Form.php';
	}


}
new CM_CustomHtmlForm();