<?php
/**
 * Data Base Library
 * @Kenneth Brenes
 *  Organization: UCR
 *   https://github.com/kgatjens/bio_ftp.git
 */

/**
 * File to config the Data Base
 */
require_once 'config.php';

/**
 * Global connection variable
 *
 * @var mysqli
 */
$_connect = null;

/**
 * Return connection object
 *
 * @return mysqli
 */
function getConnection() {
    //echo DB_NAME;
     //return mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    return new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

}

/**
 * Insert data in the specific table and return the ID, not validates duplicates
 *
 * @return int
 */
function insertData($table, $data) {
    $con = getConnection();

    if (mysqli_connect_errno($con))
    {
        echo mysqli_connect_error();
    }
    
    $keys = array_keys($data);
    $columns = implode(',', $keys);
    
    $values = array();
    foreach ($data as $v) {
        $v = $con->escape_string($v);
        $values[] = "'{$v}'";
    }

    $values = implode(',', $values);

     $sql = "INSERT INTO `{$table}` ({$columns}) VALUES ({$values})";    

    //echo $sql."<br>";
    $sql = str_replace('\"','',$sql);
    $sql = str_replace('"','',$sql);
    $result = $con->query(str_replace('\n','',$sql));
    return $con->insert_id;
}

/*
    // Get the columns
    $cols = array_keys($data);
    $numCols = count($cols);
    $cols = implode(',', $cols);
    $vals = implode(',', array_fill(0, $numCols, '?'));
    $stringVals = implode('', array_fill(0, $numCols, 's'));

    $sql = "INSERT INTO {$table} ({$cols}) VALUES ({$vals})";
    $sth = $con->prepare($sql);

    $data = array($stringVals) + $data;
    call_user_func(array($sth, 'bind_param'), $data);

    $res = $sth->execute();

    var_dump($sql, $res, $data, $sth->insert_id);
    exit;
    return $sth->insert_id;
*/

