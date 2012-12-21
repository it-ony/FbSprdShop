<?php

require_once "lib/sprd/model/User.php";

class CanvasController {

    /***
     * @var Array
     */
    protected $config = null;

    function __construct($config)
    {
        $this->config = $config;
    }

    /***
     * @return User
     */
    public function handleRequest()
    {

        $signedRequest = $_REQUEST['signed_request'];
        if ($signedRequest) {
            require_once "lib/sprd/Facebook.php";
            $data = Facebook::parseSignedRequest($signedRequest, $this->config["secret"]);

            if ($data !== null) {
                return new User($data);
            }
        }

        return new User(array(
            "locale" => "en_UK",
            "country" => "uk"
        ));

    }

}
