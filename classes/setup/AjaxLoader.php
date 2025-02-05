<?php

namespace UMC\Setup\Classes;

use UMC\General\Classes\Basic;
use UMC\Controller\Classes\Controller;

if(!interface_exists('UMC\Setup\Classes\iAjaxLoader'))
{
    interface iAjaxLoader
    {
        public function setController(Controller $controller);
        public function registerAjaxCalls();
    }
}

if( !class_exists('\UMC\Setup\Classes\AjaxLoader'))
{
    /**
     * @name AjaxLoader
     * @description Generic loader for ajax call
     *
     * @author G.Maccario <g_maccario@hotmail.com>
     * @return
     */
    class AjaxLoader extends Basic implements iAjaxLoader
	{
		protected $controller;
		
		/**
		 * @name __construct
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return
		 */
	    public function __construct()
		{
			parent::__construct();
		}
		
		/**
		 * @name setController
		 *
		 * @param Controller $controller
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return
		 */
		public function setController(Controller $controller)
		{
		    $this->controller = $controller;
		}
		
		/**
		 * @name registerAjaxCalls
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return
		 */
		public function registerAjaxCalls()
		{		    
			/* 1. register AJAX API from the config */
		    $array_config = $this->controller->getCommon()->getConfig();

		    $sideFeatures = $array_config[ 'features' ];

		    array_map(function ($side) {		        
		        $this->registerAjaxSideCall($side['ajax']);
		    }, $sideFeatures);
			
			/* 2. register NEW ROUTES from the config */
			/* ... TODO ... */
		}
		
		/**
		 * @name registerAjaxSideCall
		 *
		 * @param array $methods
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return
		 */
		protected function registerAjaxSideCall(array $methods) : bool
		{
		    $controller = $this->controller;
		    
		    array_map(function ($method) use($controller){
		        $method = trim($method);
		        
		        if(method_exists($this->controller, $method ))
		        {
		            add_action( 'wp_ajax_' . $method, array( $controller, $method ));
		            add_action( 'wp_ajax_nopriv_' . $method, array( $controller, $method ));
		        }
		    }, $methods);
		    
		    return true;
		}
	}
}