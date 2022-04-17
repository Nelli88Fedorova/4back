<?php
/**пока оставить так. кажется такая проверка идет ниже
 * Реализовать проверку заполнения обязательных полей формы в предыдущей
 * с использованием Cookies, а также заполнение формы по умолчанию ранее
 * введенными значениями.
 */
if (isset($_COOKIE["error_name"]))


// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Массив для временного хранения сообщений пользователю.
  $messages = array();

  // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
  // Выдаем сообщение об успешном сохранении.
  if (!empty($_COOKIE['save'])) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('save', '', 100000);
    // Если есть параметр save, то выводим сообщение пользователю.
    $messages[] = 'Спасибо, результаты сохранены.';
  }

  // Складываем признак ошибок в массив.
  $errors = array();
  $errors['name'] = !empty($_COOKIE['name_error']);$errors['email'] = !empty($_COOKIE['email_error']);
  $errors['date'] = !empty($_COOKIE['date_error']);$errors['gender'] = !empty($_COOKIE['gender_error']);
  $errors['hand'] = !empty($_COOKIE['hand_error']);$errors['biography'] = !empty($_COOKIE['biography_error']);
  $errors['syperpover'] = !empty($_COOKIE['syperpover_error']);

  // Выдаем сообщения об ошибках.
  foreach ($errors as $er)
 { //if ($errors['name']) {
  $errorname=key($er) ."_error";
   if ($er) 
   {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie($errorname, '', time() - 3600);
    // Выводим сообщение.
    if($er=='1') $messages[] = '<div class="error">Заполните поле.</div>';
    else $messages[] = '<div class="error">Недопустимые символы: /\ : * ? ><'' "" |.</div>';
  }
}

  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $values['name'] = empty($_COOKIE['name']) ? '' : $_COOKIE['name'];
  $values['email'] = empty($_COOKIE['email']) ? '' : $_COOKIE['email'];
  $values['date'] = empty($_COOKIE['date']) ? '' : $_COOKIE['date'];
  $values['gender'] = empty($_COOKIE['gender']) ? '' : $_COOKIE['gender'];
  $values['hand'] = empty($_COOKIE['hand']) ? '' : $_COOKIE['hand'];
  $values['biography'] = empty($_COOKIE['biography']) ? '' : $_COOKIE['biography'];
  $values['syperpover'] = empty($_COOKIE['syperpover']) ? '' : $_COOKIE['syperpover'];


  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
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
else {
  // Проверяем ошибки.
  $errors = FALSE;
foreach ($formdata as $v)
{
  $errorname=key($v) ."_error";
 if (empty($v))
 {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie($errorname, '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else if (preg_match("/[^a-zA-Z0-9\-_]+/",$v))
  {
    setcookie( $errorname, '2', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie(key($v), $v, time() + 30 * 24 * 60 * 60);
  }
 }

// При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
  if ($errors) {
    header('Location: index.php');
    exit();
  }
  else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('name_error', '',time() - 3600);
    setcookie('email_error', '',time() - 3600);
    setcookie('age_error', '',time() - 3600);
    setcookie('gender_error', '',time() - 3600);
    setcookie('numberOfLimb_error', '',time() - 3600);
    setcookie('biography_error', '',time() - 3600);
    setcookie('superpower_error', '',time() - 3600);
    // TODO: тут необходимо удалить остальные Cookies.
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

  // Сохраняем куку с признаком успешного сохранения.
  setcookie('save', '1');

  // Делаем перенаправление.
  header('Location: index.php');
}
