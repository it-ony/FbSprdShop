<?php

require_once "lib/sprd/model/DB.php";

class Page {

    const EU = "EU";
    const NA = "NA";

    protected $id;
    protected $shopId = null;
    protected $platform = null;

    function __construct($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setPlatform($platform)
    {
        $this->platform = $platform;
    }

    public function getPlatform()
    {
        return $this->platform;
    }

    public function setShopId($shopId)
    {
        $this->shopId = $shopId;
    }

    public function getShopId()
    {
        return $this->shopId;
    }

    public function fetch()
    {
        $db = new DB();
        $resource = $db->select("SELECT * FROM page WHERE pageId = '%s'", array($this->id));

        if ($row = mysql_fetch_array($resource)) {
            $this->shopId = $row["shopId"];
            $this->platform = $row["platform"];

            return true;
        }

        return false;
    }

    public function valid()
    {
        return $this->shopId !== null;
    }

    public function save()
    {
        $db = new DB();
        $resource = $db->select("REPLACE INTO page (pageId, shopId, platform) VALUES ('%s', '%s', '%s')", array(
            $this->id,
            $this->shopId,
            $this->platform));

        return $resource && $db->affected_rows() === 1;
    }


}
