<?php
session_start();
require_once 'lib_json_store.php';

if((string)@$_REQUEST['password']!=''){

    $username=(string)@$_REQUEST['username'];
    $password=(string)@$_REQUEST['password'];
    
    $users=read_json('passwords.json');
    foreach($users as $user){
        if($user->username==$username && $user->password==$password){
            $_SESSION['username']=$username;
            break;
        }
    }

}elseif((string)@$_SESSION['username']!='' && trim((string)@$_REQUEST['message'])!=''){
    $username=(string)@$_SESSION['username'];
    $message=trim((string)@$_REQUEST['message']);
    $item=['username'=>$username,'message'=>$message];
    prepend_item('store.json', $item);
  
}elseif((string)@$_REQUEST['username']=='query'){
    echo json_encode((string)@$_SESSION['username']);
}
?>