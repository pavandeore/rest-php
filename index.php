<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");

$request_method = $_SERVER['REQUEST_METHOD'];
$response = array();

switch ($request_method) {
    case "GET":
        response(doGet());
        break;
}

function doGet(){
    if(@$_GET['id']){
        @$id = $_GET['id'];
        $where = "WHERE `id`=".$id;
    }else{
        $id = 0;
        $where = "";
    }
    $con = new mysqli("localhost","root","","test_db");
    $sql = "SELECT * FROM `users` ".$where;
    $query = $con->query($sql);
    while($data = mysqli_fetch_assoc($query)){
        $response[] = array("id"=>$data['id'],"name"=>$data['name']);
    }
    return $response;
}

function response($response){
    echo json_encode(array("status"=>"200","data"=>$response));
}

?>