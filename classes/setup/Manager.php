<?php

namespace UMC\Setup\Classes;

use UMC\General\Classes\Basic;
use UMC\Controller\Classes\iController;

if(!interface_exists('UMC\Setup\Classes\iManager'))
{
    interface iManager
    {
        public function setConfig();
    }
}

if(!class_exists('\UMC\Setup\Classes\Controller'))
{
    /**
     * @name Manager
     * @description Generic class for the Controller
     *
     * @author G.Maccario <g_maccario@hotmail.com>
     * @return
     */
    class Manager extends Basic implements iManager
    {
        protected $config;
        protected $controller;
        
        /**
         * @name __construct
         *
         * @author G.Maccario <g_maccario@hotmail.com>
         * @return
         */
        public function __construct(iController $controller)
        {
            parent::__construct();
            
            $this->controller = $controller;
        }
        
        /**
         * @name setConfig
         *
         * @author G.Maccario <g_maccario@hotmail.com>
         * @return void
         */
        public function setConfig()
        {
            $this->config = $this->controller->getCommon()->getConfig();
        }
        
        /**
         * @name enqueueAdditionalStaticFiles
         * 
         * @param array $additionals
         * @param string $enqueueType
         *
         * @author G.Maccario <g_maccario@hotmail.com>
         * @return void
         */
        protected function enqueueAdditionalStaticFiles(array $additionals, string $enqueueType)
        {
            array_map(function($additional) use($enqueueType){
                $basename = explode('/', $additional);
                
                if($enqueueType == 'js')
                {
                    wp_enqueue_script( 'ultimate_mortgage_calculator-frontend-js-' . $basename[count($basename) - 1], $additional, array( 'jquery' ), null, true );
                }
                else {
                    wp_enqueue_style( 'ultimate_mortgage_calculator-admin-frontend-css-' . $basename[count($basename) - 1], $additional);
                }
                
            }, $additionals);
        }
    }
}