<?php
/**
 * User: tony
 * Date: 22.12.12
 * Time: 14:27
 */ 
class TabController {

    /***
     * @var Array
     */
    protected $config = null;

    function __construct($config)
    {
        $this->config = $config;
    }


    /***
     * @return Tab
     */
    public function handleRequest()
    {

        require_once "lib/sprd/Facebook.php";
        require_once "lib/sprd/model/Tab.php";

        $signedRequest = $_REQUEST['signed_request'];

        if ($signedRequest) {

            $data = Facebook::parseSignedRequest($signedRequest, $this->config["secret"]);
            $_SESSION['signed_request'] = $data;

            if ($data !== null) {
                return new Tab($data);
            }
        }

        return null;
    }


}
