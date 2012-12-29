<?php

class DB {

    protected $connection;
    protected $db = null;

    function __construct()
    {
        $DB = $GLOBALS['DB'];

        $this->connection = mysql_connect($DB["host"], $DB["username"], $DB["password"]);
        if ($this->connection) {
            mysql_select_db($DB["database"]);
        }

    }

    public function select($query, $parameters) {
        foreach ($parameters as $key => $parameter) {
            $parameters[$key] = mysql_real_escape_string($parameter);
        }

        $query = vsprintf($query, $parameters);
        $resource = mysql_query($query, $this->connection);

        return $resource;
    }

    function __destruct() {
        if ($this->connection) {
            mysql_close($this->connection);
        }
    }

    /***
     * @return int
     */
    public function affected_rows()
    {
        return mysql_affected_rows($this->connection);
    }


}
