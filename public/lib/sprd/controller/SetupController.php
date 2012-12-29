<?php

class SetupController {

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

        require_once "lib/sprd/model/Tab.php";

        $platform = $_GET['platform'];
        $shopId = $_GET['shopId'];


        if (isset($_SESSION['signed_request']) && $platform && $shopId) {
            $tab = new Tab($_SESSION['signed_request']);
            $page = $tab->getPage();

            if ($tab->isPageAdmin() && $page) {
                $page->setShopId($shopId);
                $page->setPlatform($platform);

                return $page->save();
            }

        }

        return false;
    }


}
