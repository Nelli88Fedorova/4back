<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') 
{
  if (isset($_COOKIE['save'])) 
  {
    setcookie('save', '', time()- 100000);
    $messages[] = 'Спасибо, результаты сохранены.';
  }
  $messages = array();
  $errors = array();
  
  if(isset($_COOKIE['name_error']))
  $errors['name']=$_COOKIE['name_error'];
  // Undefined index: name on line 16
  if (isset($errors['name'])) 
  { 
    if((int)$errors['name']==1) $messages[] = '<div class="error">Заполните поле'.' Имя'.'.</div>';
    else if((int)$errors['name']==2) $messages[] = '<div class="error"> Недопустимые символы в поле'.' Имя'.'! </div>';
    setcookie('name_error', '', time() - 3600);
  }
  // Undefined index: name on line 24
  $values = array();
  if(isset($errors['name']))
  if((int)$errors['name']==2)
   { $values['name']=$_COOKIE['name'];}
   else $values['name']='';

  // $parametrs=array('name', 'email','date','gender','hand','biography','syperpover');
  // foreach ($parametrs as $it)
  // {
  //   $errorname=$it .'_error';
  //   if(!empty($_COOKIE['$errorname']))
  //   $errors['$it']=empty($_COOKIE['$errorname']);
  // }
  //$formassage=array('name'=>" Имя", 'email'=>" Электронная почта",'date'=>" Дата рождения",'gender'=>" Пол",'hand'=>" Конечности",'biography'=>" Биография",'syperpover'=>" Суперспособность");
//   foreach ($errors as $key =>$er)
//  { 
//   $errorname=$key ."_error";
//   if ($er) 
//   { setcookie($errorname, '', time() - 3600);
//     if($er=='1') $messages[] = '<div class="error">Заполните поле'.(string)$formassage[$key].'.</div>';
//     else $messages[] = '<div class="error"> Недопустимые символы в поле'.(string)$formassage[$key].'! </div>';
//   }
//  }
  //foreach ($parametrs as $it)
  // {
  //   $errorname=$it ."_error";
  //   if(empty($_COOKIE[(string)$errorname]))
  //   $values[(string)$it]=empty($_COOKIE[(string)$it]);
  // }


  /* $values['name'] = empty($_COOKIE['name']) ? '' : $_COOKIE['name'];
  $values['email'] = empty($_COOKIE['email']) ? '' : $_COOKIE['email'];
  $values['date'] = empty($_COOKIE['date']) ? '' : $_COOKIE['date'];
  $values['gender'] = empty($_COOKIE['gender']) ? '' : $_COOKIE['gender'];
  $values['hand'] = empty($_COOKIE['hand']) ? '' : $_COOKIE['hand'];
  $values['biography'] = empty($_COOKIE['biography']) ? '' : $_COOKIE['biography'];
  $values['syperpover'] = empty($_COOKIE['syperpover']) ? '' : $_COOKIE['syperpover'];
  */

  foreach ($errors as $key =>$er)
  {
    print('<div> Errors: ');
    print('key: '.(string)$key . ' value: '.(string)$er);
    print('</div>');
  }
  foreach ($values as $key =>$er)
  {
    print('<div>Values: ');
    print('key: '.(string)$key . ' value: '.(string)$er);
    print('</div>');
  }
  foreach ($messages as $er)
  {
    print('<div>Messages: ');
    print((string)$er);
    print('</div>');
  }

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
  $errors = FALSE;
 
   if (empty($name))
 {
    setcookie('name_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else if (preg_match("/[^а-яА-ЯёЁa-zA-Z0-9\-_]+/",$name))//Yes <> |  No /\"'[]    "/[ \<|\>'\"[\]\\\/ ]/"
  {
    setcookie( 'name_error', '2', time() + 24 * 60 * 60);
    setcookie('name', $name, time() + 30 * 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('name', '', time() -3600);
    setcookie('name', $name, time() + 30 * 24 * 60 * 60);
  }

//    $formdata=array(
//     'name'=>$_POST['name'],
//     'email'=>$_POST['email'],
//     'date'=>$_POST['date'],
//     'gender'=>$_POST['gender'],
//     'hand'=>$_POST['hand'],
//     'biography'=>$_POST['biography'],
//     'check'=>$_POST['check'],
//     'syperpover'=>implode(',',$_POST['syperpover']),
//      );
//   // Проверяем ошибки.
//   $errors = FALSE;
//   foreach ($formdata as  $key =>$v)
//  {
//   $errorname=$key ."_error";
//  if (empty($v))
//  {
//     setcookie($errorname, '1', time() + 24 * 60 * 60);
//     $errors = TRUE;
//   }
//   else if (preg_match("/[^a-zA-Z0-9\-_]+/",$v))
//   {
//     setcookie( $errorname, '2', time() + 24 * 60 * 60);
//     $errors = TRUE;
//   }
//   else {
//     setcookie((string)$key, (string)$v, time() + 30 * 24 * 60 * 60);
//   }
//  }

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
