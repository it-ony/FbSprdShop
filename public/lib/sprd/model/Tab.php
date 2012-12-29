<?php

require_once "lib/sprd/Facebook.php";
require_once "lib/sprd/model/User.php";
require_once "lib/sprd/model/Page.php";

class Tab {

    const UNCONFIGURED = "unconfigured";
    const SETUP = "setup";
    const LIVE = "live";

    protected $signed_request;
    protected $status = self::UNCONFIGURED;

    protected $user;
    protected $page;

    function __construct($signed_request)
    {
        $this->signed_request = $signed_request;
        $this->user = new User($signed_request["user"], $signed_request["user_id"]);

        $this->page = new Page($signed_request["page"]["id"]);
        $this->page->fetch();
    }

    /***
     * @return string
     */
    public function getStatus()
    {

        if ($this->page->valid()) {
            return self::LIVE;
        }

        if ($this->isPageAdmin()) {
            return self::SETUP;
        }

        return self::UNCONFIGURED;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getPage()
    {
        return $this->page;
    }


    public function isPageAdmin() {
        return $this->signed_request["page"]["admin"] == 1;
    }


}
