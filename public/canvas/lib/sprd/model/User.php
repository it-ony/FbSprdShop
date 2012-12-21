<?php
/**
 * User: tony
 * Date: 21.12.12
 * Time: 15:35
 */ 
class User {

    /***
     * @var Array
     */
    protected $data;

    function __construct($data)
    {
        $this->data = $data;
    }

    /***
     * @return string
     */
    public function getCountry() {
        return $this->data["country"];
    }

    /***
     * @return string
     */
    public function getLocale()
    {
        return $this->data["locale"];
    }

    /***
     * @return string
     */
    public function getLanguage() {
        return substr($this->getLocale(), 0, 2);
    }

    /***
     * @return string
     */
    public function getRegion()
    {
        $language = $this->getCountry();

        if (in_array($language, array("us"))) {
            return "na";
        }

        return "eu";
    }

}
