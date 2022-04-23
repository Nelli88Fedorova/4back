<?php
// при одной ошибке все остальные удачно заполненные поля очищаются
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') 
{
  $messages = array();
  if (isset($_COOKIE['save'])) 
  {
    setcookie('save', '', time()- 100000);
    $messages['save'] = '<div style="color:green"> Спасибо, результаты сохранены.</div>';
  }
  $errors = array();
  $values = array();
 
  $parametrs=array('name', 'email','date','gender','hand','biography','syperpover');
  foreach ($parametrs as $name)
  {
    if(isset($_COOKIE[$name]))
   { $values[$name]=$_COOKIE[$name];}
   else $values[$name]='';
  }
  foreach ($parametrs as $name)
  {
    $errorname=$name .'_error';
    if(isset($_COOKIE[$errorname]))
  $errors[$name]=$_COOKIE[$errorname];
  }
  $formassage=array('name'=>" Имя", 'email'=>" Электронная почта",'date'=>" Дата рождения",'gender'=>" Пол",'hand'=>" Конечности",'biography'=>" Биография",'syperpover'=>" Суперспособность");
  foreach ($errors as $name =>$val)
 { 
   if (isset($name))
   {  
     $errorname=$name ."_error";
     if((int)$errors[$name]==1) $messages[$name] = '<div style="color:red">Заполните поле'.(string)$formassage[$name].'.</div>';
    else if((int)$errors[$name]==2) $messages[$name] = '<div style="color:red"> Недопустимые символы в поле'.(string)$formassage[$name].'! </div>';
    setcookie($errorname, '', time() - 3600);
  }
 }
//$no=true; if(isset($_COOKIE['No'])){$no=false;}

 include('form.php');
}
else {
  $name=$_POST['name'];
  $email=$_POST['email'];
  $date=$_POST['date'];
  $gender=$_POST['gender'];
  $hand=$_POST['hand'];
  $biography=$_POST['biography'];
  $check=$_POST['check'];
  $syperpover=implode(',',$_POST['syperpover']);
  
  // $errors = FALSE;
  // if(isset($_POST['check']))
  // {
  //   $errors=true;
  //   setcookie('No','',time() + 30 * 24 * 60 * 60);
  // }

  $formpoints=array(
    'gender'=>$_POST['gender'],
    'hand'=>$_POST['hand'],
    'syperpover'=>$_POST['syperpover'],
  );  
  foreach ($formpoints as  $key =>$v)
  {
    setcookie($key, $v, time() + 30 * 24 * 60 * 60);
  }
  
   $formdata=array(
    'name'=>$_POST['name'],
    'email'=>$_POST['email'],
    'date'=>$_POST['date'],
    'biography'=>$_POST['biography'],
    'check'=>$_POST['check'],
     );
  // Проверяем ошибки.
  $errors = FALSE;
  foreach ($formdata as  $key =>$v)
 {
  $errorname=$key ."_error";
  if (empty($v))
  {
    setcookie($errorname, '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else if ($key=='email' && $krey!='check' && filter_var($v, FILTER_VALIDATE_EMAIL) == false)
  {
    setcookie( $errorname, '2', time() + 24 * 60 * 60);
    setcookie($key, $v, time() + 30 * 24 * 60 * 60);
    $errors = TRUE;
  }
  else if ($key !='email' && $krey!='check' && preg_match("/[^а-яА-ЯёЁa-zA-Z0-9\ \-_]+/",$v) ) 
  {
    setcookie( $errorname, '2', time() + 24 * 60 * 60);
    setcookie($key, $v, time() + 30 * 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
   // setcookie($errorname, '', time() - 3600);
   // setcookie($key, '', time() -3600);
   setcookie($key, $v, time() + 30 * 24 * 60 * 60);
  }
 }

  if ($errors) {
    header('Location: index.php');
    exit();
  }
  else {
    setcookie('name_error', '',time() - 3600);
    setcookie('email_error', '',time() - 3600);
    setcookie('date_error', '',time() - 3600);
    setcookie('gender_error', '',time() - 3600);
    setcookie('hand_error', '',time() - 3600);
    setcookie('biography_error', '',time() - 3600);
    setcookie('syperpover_error', '',time() - 3600);
    setcookie('No','',time() - 3600);
    
    
    
    $user='u47586'; $pass='3927785';
    $db=new PDO('mysql:host=localhost;dbname=u47586',$user,$pass, array(PDO::ATTR_PERSISTENT=>true));
    
    try{
      $stmt=$db->prepare("INSERT INTO MainData SET name = ?, email = ?, age=?, gender=?, numberOfLimb=?, biography=?");
      $stmt->execute(array($name, $email,$date, $gender,$hand, $biography));
      
      $super=$db->prepare("INSERT INTO Superpovers SET superpower=?");
      $super->execute(array($syperpover));
    }
    catch(PDOException $e)
    {
      print('Error:'.$e->GetMessage());
      exit();
    }
    
    setcookie('save', '1');
    header('Location: index.php');
  }
}
