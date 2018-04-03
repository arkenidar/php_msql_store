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
    prepend_item('store.json',['username'=>$username,'message'=>$message]);    
}

?>
<!doctype html>
<title>mini chat</title>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/ractive"></script>

<?php if(@$_SESSION['username']==''){ ?>

<form method="post">
<input type="text" placeholder="username" name="username">
<input type="password" placeholder="password" name="password">
<input type="submit" value="login">
</form>

<?php }else{ ?>

<form method="post" onsubmit="$.post('',$(this).serialize());$(this).trigger('reset');return false">
<input type="text" placeholder="message" name="message" autocomplete="off">
<input type="submit" value="send">
</form>

<div id="target"></div>
<script id="template" type="text/ractive">
{{#each items}} 
<li>{{this.username}}:{{this.message}}</li>
{{/each}}
</script>
<script>
ractive = new Ractive({
  target: '#target',
  template: '#template',
  data:{
      items: [],
  },
})

setInterval(function(){jQuery.getJSON('store.json',function(data){ractive.set('items',data)})},1000)
</script>

<?php } ?>