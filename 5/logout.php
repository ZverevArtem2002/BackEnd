<?php
if(session_start() and !empty($_SESSION['login'])){
  session_destroy();
}
header('Location: index.php');
