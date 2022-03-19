<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");

$request_method = $_SERVER['REQUEST_METHOD'];
$response = array();

switch ($request_method) {
    case "GET":
        response(doGet());
        break;
    
    case "POST":
        response(doPost());
        break;
   
    case "DELETE":
        response(doDelete());
        break;
    
    case "PUT":
        response(doPut());
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
    $con = new mysqli("localhost","root","","codebits-rest");
    $sql = "SELECT * FROM `users` ".$where;
    $query = $con->query($sql);
    while($data = mysqli_fetch_assoc($query)){
        $response[] = array("id"=>$data['id'],"username"=>$data['username'],"email"=>$data['email']);
    }
    return $response;
}
function doPost(){
    if($_POST){

        $con = new mysqli("localhost","root","","codebits-rest");
        $sql = "INSERT INTO `users` (`username`,`email`,`password`) VALUES('".$_POST['username']."','".$_POST['email']."','".$_POST['password']."' )";
        $query = $con->query($sql);
        if($query){
            $response = array("message"=>"success");
        }else{
            $response = array("message"=>"failed");
        }
    }
    
    return $response;
}
function doDelete(){
    if($_GET['id']){

        $con = new mysqli("localhost","root","","codebits-rest");
        $sql = "DELETE FROM `users` WHERE `id` = '".$_GET['id']."'  ";
        $query = $con->query($sql);
        if($query){
            $response = array("message"=>"success");
        }else{
            $response = array("message"=>"failed");
        }
    }
    
    return $response;
}
function doPut(){
    parse_str(file_get_contents('php://input'), $_PUT);
    if($_PUT){

        $con = new mysqli("localhost","root","","codebits-rest");
        $sql = "UPDATE `users` SET 
        `username` = '".$_PUT['username']."',
        `email` = '".$_PUT['email']."',
        `password` = '".$_PUT['password']."' 
        WHERE `id` = '".$_GET['id']."' ";
        $query = $con->query($sql);
        if($query){
            $response = array("message"=>"success");
        }else{
            $response = array("message"=>"failed");
        }
    }
    
    return $response;
}

function response($response){
    echo json_encode(array("status"=>"200","data"=>$response));
}

?>
