<?php

/**
 * Created by PhpStorm.
 * User: Boy Panjaitan
 * Date: 24/10/2016
 * Time: 20:14
 */
namespace helper;

class Assets
{
    private $froala;
    private $bootstrap;
    private $sweetAlert;
    private $fontAwesome;
    private $jQuery;
    private $jQueryForm;
    private $limitless;
    private $assetsDir;

    public function __construct($assetsDir){
        $this->assetsDir    = $assetsDir;
        $this->froala       = $this->isLocal() ? $assetsDir."froala_editor_2.4.2/" : "https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.0/";
        $this->bootstrap    = $this->isLocal() ? $assetsDir."bootstrap-3.3.6-dist/" : "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/";
        $this->sweetAlert   = $this->isLocal() ? $assetsDir."sweetalert/" : "https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/";
        $this->fontAwesome  = $this->isLocal() ? $assetsDir."font-awesome-4.7.0/" : "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/";
        $this->jQuery       = $this->isLocal() ? $assetsDir."jquery.min.js" : "https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js";
        $this->jQueryForm   = $this->isLocal() ? $assetsDir."jquery.form.min.js" : "https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.1/jquery.form.min.js";
        $this->limitless    = $assetsDir."limitless-material/";

    }

    private function isLocal(){
        if(preg_match('/\d+\.\d+\.\d+\.\d+/',$_SERVER["SERVER_NAME"]) || $_SERVER["SERVER_NAME"] == 'localhost'){
            return true;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getFroala()
    {
        return $this->froala;
    }

    /**
     * @return string
     */
    public function getBootstrap()
    {
        return $this->bootstrap;
    }

    /**
     * @return string
     */
    public function getSweetAlert()
    {
        return $this->sweetAlert;
    }

    /**
     * @return string
     */
    public function getFontAwesome()
    {
        return $this->fontAwesome;
    }

    /**
     * @return string
     */
    public function getJQuery()
    {
        return $this->jQuery;
    }

    /**
     * @return string
     */
    public function getJQueryForm()
    {
        return $this->jQueryForm;
    }

    /**
     * @return string
     */
    public function getLimitless()
    {
        return $this->limitless;
    }

    /**
     * @param string $limitless
     */
    public function setLimitless($limitless)
    {
        $this->limitless = $this->assetsDir.$limitless."/";
    }
}