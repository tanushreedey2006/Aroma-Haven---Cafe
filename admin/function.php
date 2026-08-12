<?php
include_once "includes/db_connect.php";



if (!function_exists('allDetails')) {

    function allDetails($table_name){
        global $conn;
        /** @var mysqli $conn */

        $sql = "SELECT * FROM {$table_name} ORDER BY id DESC";
        $run = mysqli_query($conn, $sql);

        if(!$run){
            return false;
        }

        if(mysqli_num_rows($run) > 0){
            return mysqli_fetch_all($run, MYSQLI_ASSOC);
        }

        return false;
    }

}

if (!function_exists('delete_data')) {

    function delete_data($table_name, $id){
        global $conn;
        /** @var mysqli $conn */
        $sql = "DELETE FROM {$table_name} WHERE id = $id";
        return mysqli_query($conn, $sql);
    }

}
?>