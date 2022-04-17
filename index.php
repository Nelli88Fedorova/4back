<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
   $messages = array();
  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
    $messages[] = 'Спасибо, результаты сохранены.';
  }

  $errors = array();
  $errors['name'] = !empty($_COOKIE['name_error']);$errors['email'] = !empty($_COOKIE['email_error']);
  $errors['date'] = !empty($_COOKIE['date_error']);$errors['gender'] = !empty($_COOKIE['gender_error']);
  $errors['hand'] = !empty($_COOKIE['hand_error']);$errors['biography'] = !empty($_COOKIE['biography_error']);
  $errors['syperpover'] = !empty($_COOKIE['syperpover_error']);

   foreach ($errors as $er)
 { 
  $errorname=key($er) ."_error";
   if ($er) 
   { setcookie($errorname, '', time() - 3600);
    if($er=='1') $messages[] = '<div class="error">Заполните поле.</div>';
    else $messages[] = '<div class="error"> Недопустимые символы! </div>';
  }


  $values = array();
  $values['name'] = empty($_COOKIE['name']) ? '' : $_COOKIE['name'];
  $values['email'] = empty($_COOKIE['email']) ? '' : $_COOKIE['email'];
  $values['date'] = empty($_COOKIE['date']) ? '' : $_COOKIE['date'];
  $values['gender'] = empty($_COOKIE['gender']) ? '' : $_COOKIE['gender'];
  $values['hand'] = empty($_COOKIE['hand']) ? '' : $_COOKIE['hand'];
  $values['biography'] = empty($_COOKIE['biography']) ? '' : $_COOKIE['biography'];
  $values['syperpover'] = empty($_COOKIE['syperpover']) ? '' : $_COOKIE['syperpover'];

 include('form.php');
}
$formdata=array(
    'name'=>$_POST['name'],
    'email'=>$_POST['email'],
    'date'=>$_POST['date'],
    'date'=>$_POST['gender'],
    'hand'=>$_POST['hand'],
    'biography'=>$_POST['biography'],
    'check'=>$_POST['check'],
    'syperpover'=>implode(',',$_POST['syperpover']),
);
   }
else {
  // Проверяем ошибки.
  $errors = FALSE;
foreach ($formdata as $v)
{
  $errorname=key($v) ."_error";
 if (empty($v))
 {
    setcookie($errorname, '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else if (preg_match("/[^a-zA-Z0-9\-_]+/",$v))
  {
    setcookie( $errorname, '2', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie(key($v), $v, time() + 30 * 24 * 60 * 60);
  }
 }

  if ($errors) {
    header('Location: index.php');
    exit();
  }
  else {
    setcookie('name_error', '',time() - 3600);
    setcookie('email_error', '',time() - 3600);
    setcookie('age_error', '',time() - 3600);
    setcookie('gender_error', '',time() - 3600);
    setcookie('numberOfLimb_error', '',time() - 3600);
    setcookie('biography_error', '',time() - 3600);
    setcookie('superpower_error', '',time() - 3600);
   }

  $name=$_POST['name'];
  $email=$_POST['email'];
  $date=$_POST['date'];
  $gender=$_POST['gender'];
  $hand=$_POST['hand'];
  $biography=$_POST['biography'];
  $check=$_POST['check'];
  $syperpover=implode(',',$_POST['syperpover']);
  
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
