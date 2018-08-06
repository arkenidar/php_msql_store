<?php
session_start();
require 'json/lib_json_store.php';

require 'mysql/pdo.php';

if(isset($_REQUEST['password'])){

    $username=(string)@$_REQUEST['username'];
    $password=(string)@$_REQUEST['password'];

    $users=read_json('json/passwords.json');
    foreach($users as $user){
        if($user->username==$username && $user->password==$password){
            $_SESSION['username']=$username;
            echo 'logged';
            break;
        }
    }

}elseif(isset($_REQUEST["message_content"])){
    $username=(string)@$_SESSION["username"];
    $message_content=trim((string)@$_REQUEST["message_content"]);
    if($username=='' || $message_content=='') exit();

    $statement=$pdo->prepare("INSERT INTO messages (username,message_content) VALUES (:username,:message_content)");
    $vars=[":username"=>$username,":message_content"=>$message_content];
    $statement->execute($vars);

}elseif(isset($_REQUEST["query"])){
    $query_type=(string)@$_REQUEST["query"];
    switch($query_type){
    
        case "username":
        echo json_encode((string)@$_SESSION['username']);
        break;

        case "messages":
        $statement=$pdo->prepare("SELECT username,message_content FROM messages");
        $statement->execute();
        $rows=$statement->fetchAll();
        echo json_encode($rows);
        break;

    }
}
?>