<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (!empty($_SESSION['login'])) {
  header('Location: index.php');
  }else{
?>
<style>
  .form-sign-in{
    max-width: 960px;
    text-align: center;
    margin: 0 auto;
  }
</style>
<div class="form-sign-in">
<form action="login.php" method="post">
  <label> Логин <label> <br>
  <input name="login" /> 
  <label> Пароль <label> <br>
  <input name="pass" type="password"/>
  <input type="submit" value="Войти" />
</form>
</div>
<?php
  }
}
else {
  $l=$_POST['login'];
  $p=$_POST['pass'];
  $uid=0;
  $error=TRUE;
  require_once('connect.php');
  if(!empty($l) and !empty($p)){
    try{
      $chk=$db1->prepare("select * from users where login=?");
      $chk->execute(array($l));
      $username=$chk->fetchALL();
      if(password_verify($p,$username[0]['password'])){
        $uid=$username[0]['id'];
        $error=FALSE;
      }
    }
    catch(PDOException $e){
      print('Error : ' . $e->getMessage());
      exit();
    }
  }
  if($error==TRUE){
    print('Неправильные логин или пароль <br> Если вы хотите создать нового пользователя <a href="index.php">назад</a> или попытайтесь войти снова <a href="login.php">войти</a>');
    session_destroy();
    exit();
  }
  // Если все ок, то авторизуем пользователя.
  $_SESSION['login'] = $l;
  // Записываем ID пользователя.
  $_SESSION['uid'] = $uid;
  // Делаем перенаправление.
  header('Location: index.php');
}
