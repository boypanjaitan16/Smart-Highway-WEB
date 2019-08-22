<?php
/**
 * Created by PhpStorm.
 * User: Boy Panjaitan
 * Date: 21/03/2018
 * Time: 21:00
 */
namespace helper;

class Configuration
{
    private $project_name;
    private $base_url;
    private $assets_dir;
    private $sessionAdmin;
    private $sessionUser;
	
	public function __construct(){
		//all default value
        $this->project_name     = "SMART HIGHWAY";
        $this->base_url         = "project/highway/";
        $this->assets_dir       = "../../../_assets/";
        $this->sessionAdmin     = "session-".preg_replace('/\W+/','-',$this->project_name)."-admin";
        $this->sessionUser      = "session-".preg_replace('/\W+/','-',$this->project_name)."-user";
	}

    /**
     * @return string
     */
    public function getSessionAdmin()
    {
        return $this->sessionAdmin;
    }

    /**
     * @return string
     */
    public function getSessionUser()
    {
        return $this->sessionUser;
    }

	//------------------fields----------------------------


    /**
     * @return string
     */
    public function getAssetsDir()
    {
        return $this->assets_dir;
    }

    /**
     * @param string $assets_dir
     */
    public function setAssetsDir($assets_dir)
    {
        $this->assets_dir = $assets_dir;
    }



    /**
     * @return string
     */
    public function getProjectName()
    {
        return $this->project_name;
    }

    /**
     * @param string $project_name
     */
    public function setProjectName($project_name)
    {
        $this->project_name = $project_name;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return (isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER["SERVER_NAME"]."/".$this->base_url;
    }

    /**
     * @param string $base_url
     */
    public function setBaseUrl($base_url)
    {
        $this->base_url = $base_url;
    }
}
