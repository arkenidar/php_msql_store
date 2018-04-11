<?php
session_start();
require 'json/lib_json_store.php';

require 'mysql/pdo.php';

if((string)@$_REQUEST['password']!=''){

    $username=(string)@$_REQUEST['username'];
    $password=(string)@$_REQUEST['password'];
    
    $users=read_json('json/passwords.json');
    foreach($users as $user){
        if($user->username==$username && $user->password==$password){
            $_SESSION['username']=$username;
            break;
        }
    }

}elseif((string)@$_SESSION['username']!='' && trim((string)@$_REQUEST['message'])!=''){
    $username=(string)@$_SESSION['username'];
    $message_content=trim((string)@$_REQUEST['message_content']);

    $statement=$pdo->prepare('INSERT INTO messages (username,message_content) VALUES (:username,:message_content)');
    $vars=[':username'=>$username,':message_content'=>$message_content];
    $statement->execute($vars);
  
}elseif((string)@$_REQUEST['username']=='query'){
    echo json_encode((string)@$_SESSION['username']);

}elseif((string)@$_REQUEST['messages']=='query'){
    $statement=$pdo->prepare("SELECT username,message_content FROM messages");
    $statement->execute();
    $rows=$statement->fetchAll();
    echo json_encode($rows);
}
?>