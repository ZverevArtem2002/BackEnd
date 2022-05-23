<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();
  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
    $messages[] = 'Спасибо, результаты сохранены.';
    setcookie('name_value', '', 100000);
    setcookie('mail_value', '', 100000);
    setcookie('year_value', '', 100000);
    setcookie('sex_value', '', 100000);
    setcookie('limb_value', '', 100000);
    setcookie('bio_value', '', 100000);
    setcookie('immortal_value', '', 100000);
    setcookie('telepat_value', '', 100000);
    setcookie('teleport_value', '', 100000);
    setcookie('check_value', '', 100000);
  }
  //Ошибки
  
  $errors = array();
  $error=FALSE;
  $errors['name'] = !empty($_COOKIE['name_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['year'] = !empty($_COOKIE['year_error']);
  $errors['sex'] = !empty($_COOKIE['sex_error']);
  $errors['limb'] = !empty($_COOKIE['limb_error']);
  $errors['power'] = !empty($_COOKIE['power_error']);
  $errors['check'] = !empty($_COOKIE['check_error']);
  if ($errors['name']) {
    setcookie('name_error', '', 100000);
    $messages[] = '<div class="error">Заполните имя.</div>';
    $error=TRUE;
  }
  if ($errors['email']) {
    setcookie('email_error', '', 100000);
    $messages[] = '<div class="error">Заполните или исправьте почту.</div>';
    $error=TRUE;
  }
  if ($errors['year']) {
    setcookie('year_error', '', 100000);
    $messages[] = '<div class="error">Выберите год рождения.</div>';
    $error=TRUE;
  }
  if ($errors['sex']) {
    setcookie('sex_error', '', 100000);
    $messages[] = '<div class="error">Выберите пол.</div>';
    $error=TRUE;
  }
  if ($errors['limb']) {
    setcookie('limb_error', '', 100000);
    $messages[] = '<div class="error">Выберите сколько у вас конечностей.</div>';
    $error=TRUE;
  }
  if ($errors['power']) {
    setcookie('power_error', '', 100000);
    $messages[] = '<div class="error">Выберите хотя бы одну суперспособность.</div>';
    $error=TRUE;
  }
  if ($errors['check']) {
    setcookie('check_error', '', 100000);
    $messages[] = '<div class="error">Необходимо согласиться с политикой конфиденциальности.</div>';
    $error=TRUE;
  }
  $values = array();
  $values['immortal']=0;
  $values['teleport']=0;
  $values['telepat']=0;
  include('connect.php');
  try{
      $id=$_GET['edit_id'];
      $get=$db->prepare("select * from application where id=?");
      $get->execute(array($id));
      $user=$get->fetchALL();
      $values['name']=$user[0]['name'];
      $values['email']=$user[0]['email'];
      $values['year']=$user[0]['year'];
      $values['sex']=$user[0]['sex'];
      $values['limb']=$user[0]['limb'];
      $values['bio']=$user[0]['bio'];
      $get2=$db->prepare("select p_name from supers where uid=?");
      $get2->execute(array($id));
      $powers=$get2->fetchALL();
      for($i=0;$i<count($powers);$i++){
        if($powers[$i]['p_name']=='Бессмертие'){
          $values['immortal']=1;
        }
        if($powers[$i]['p_name']=='Телепортация'){
          $values['teleport']=1;
        }
        if($powers[$i]['p_name']=='Телепатия'){
          $values['telepat']=1;
        }
      }
  }
  catch(PDOException $e){
      print('Error: '.$e->getMessage());
      exit();
  }
  include('form.php');
}
else {
  if(!empty($_POST['edit'])){
    $regex_name='/[a-z,A-Z,а-я,А-Я,-]*$/';
    $regex_email='/[a-z]+\w*@[a-z]+\.[a-z]{2,4}$/';
    $id=$_POST['id'];
    $name=$_POST['name'];
    $email=$_POST['email'];
    $year=$_POST['year'];
    $sex=$_POST['sex'];
    $limb=$_POST['limb'];
    $pwrs=$_POST['power'];
    $bio=$_POST['bio'];
    if(empty($_SESSION['login'])){
      $check=$_POST['check'];
    }
    $errors = FALSE;
    if (empty($name) or !preg_match($regex_name,$name)) {
      setcookie('name_error', '1', time() + 24*60 * 60);
      setcookie('name_value', '', 100000);
      $errors = TRUE;
    }
    else {
      setcookie('name_value', $name, time() + 60 * 60);
      setcookie('name_error','',100000);
    }
    //проверка почты
    if (empty($email) or !preg_match($regex_email,$email)) {
      setcookie('email_error', '1', time() + 24*60 * 60);
      setcookie('email_value', '', 100000);
      $errors = TRUE;
    }
    else {
      setcookie('email_value', $email, time() + 60 * 60);
      setcookie('email_error','',100000);
    }
    //проверка года
    if ($year=='Выбрать' or ($year<1800 and $year>2022)) {
      setcookie('year_error', '1', time() + 24 * 60 * 60);
      setcookie('year_value', '', 100000);
      $errors = TRUE;
    }
    else {
      setcookie('year_value', intval($year), time() + 60 * 60);
      setcookie('year_error','',100000);
    }
    //проверка пола
    if (!isset($sex)  or ($sex!='M' and $sex!='W')) {
      setcookie('sex_error', '1', time() + 24 * 60 * 60);
      setcookie('sex_value', '', 100000);
      $errors = TRUE;
    }
    else {
      setcookie('sex_value', $sex, time() + 60 * 60);
      setcookie('sex_error','',100000);
    }
    //проверка конечностей
    if (!isset($limb)) {
      setcookie('limb_error', '1', time() + 24 * 60 * 60);
      setcookie('limb_value', '', 100000);
      $errors = TRUE;
    }
    else {
      setcookie('limb_value', $limb, time() + 60 * 60);
      setcookie('limb_error','',100000);
    }
    //проверка суперспособностей
    if (!isset($pwrs)) {
      setcookie('powers_error', '1', time() + 24 * 60 * 60);
      setcookie('immortal_value', '', 100000);
      setcookie('teleport_value', '', 100000);
      setcookie('telepat_value', '', 100000);
      $errors = TRUE;
    }
    else {
      $a=array(
        "immortal_value"=>0,
        "teleport_value"=>0,
        "telepat_value"=>0
      );
      foreach($pwrs as $pwr){
        if($pwr=='Бессмертие'){setcookie('immortal_value', 1, time() + 60 * 60); $a['immortal_value']=1;} 
        if($pwr=='Телепортация'){setcookie('teleport_value', 1, time() + 60 * 60);$a['teleport_value']=1;} 
        if($pwr=='Телепатия'){setcookie('telepat_value', 1, time() + 60 * 60);$a['telepat_value']=1;} 
      }
      foreach($a as $c=>$val){
        if($val==0){
          setcookie($c,'',100000);
        }
      }
    }
    
    //запись куки для биографии
    setcookie('bio_value',$bio,time()+ 60*60);
  
    if ($errors) {
      setcookie('save','',100000);
      header('Location: login.php');
    }
    else {
      setcookie('name_error', '', 100000);
      setcookie('email_error', '', 100000);
      setcookie('year_error', '', 100000);
      setcookie('sex_error', '', 100000);
      setcookie('limb_error', '', 100000);
      setcookie('power_error', '', 100000);
    }
    include('connect.php');
    if(!$errors){
        $upd=$db->prepare("update application set name=?,email=?,year=?,sex=?,limb=?,bio=? where id=?");
        $upd->execute(array($name,$email,$year,$sex,$limb,$bio,$id));
        $del=$db->prepare("delete from supers where uid=?");
        $del->execute(array($id));
        $upd=$db->prepare("insert into supers set p_name=?,uid=?");
        foreach($pwrs as $pwr){
          $upd->execute(array($pwr,$id));
        }
    }
    
    if(!$errors){
      setcookie('save', '1');
    }
    header('Location: edit.php?edit_id='.$id);
  }
  elseif(!empty($_POST['del'])) {
    $id=$_POST['id'];
    include('connect.php');
    try {
      $del=$db->prepare("delete from supers where uid=?");
      $del->execute(array($id));
      $stmt = $db->prepare("delete from application where id=?");
      $stmt -> execute(array($id));
    }
    catch(PDOException $e){
      print('Error : ' . $e->getMessage());
    exit();
    }
    setcookie('del','1');
    setcookie('del_user',$id);
    header('Location: admin.php');
  }
  else{
    header('Loction: admin.php');
  }
}
