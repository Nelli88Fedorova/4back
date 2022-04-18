<!DOCTYPE html>
<html>
<head>
<meta charset= "UTF-8">
<link rel="stylesheet" href="stiles.css">
<title>4Back</title>
<style>
.for
{
border: 2px solid rgb(26, 18, 144);
font-size: x-large;
text-align: center;
max-width:420px;
margin: 0 auto;
margin-top:50px;
}
input
{
 margin-top:10px;
 margin-bottom:10px;
 font-size: x-large;
 }
 option
 {
  font-size: x-large;
 }

</style>

</head>
<body>
<?php
if (!empty($messages)) {
  print('<div id="messages">');
  // Выводим все сообщения.
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}

// Далее выводим форму отмечая элементы с ошибками классом error
// и задавая начальные значения элементов ранее сохраненными.
?>
    <div class="for">
    <h4><form action="" method="POST">
      <label> Имя:<br />
      <input name="name" <?php if ($errors['name']) print 'class="error"' ?> value="<?php if ($errors['name']) print $values['name']; ?>" /></label><br />

 <label> e-mail:<br />
 <input name="email" <?php if ($errors['email']) print 'class="error"'; ?> value="<?php if ($errors['email']) print $values['email']; ?>" type="email" /> </label><br />
       
    <label>  Дата рождения:<br /><input name="date" <?php if ($errors['date']) print 'class="error"'; ?> value="<?php if ($errors['date']) print $values['date']; ?>" type="date" /></label><br />
             
             Пол:<br /> 
             <label><input type="radio" checked="checked" name="gender" value="m" /> М</label>
             <label><input type="radio" name="gender" value="w" /> Ж</label><br />
       
       Количество конечностей:<br />
             <label><input type="radio" checked="checked" name="hand" value="1" />1</label>
             <label><input type="radio" name="hand" value="2" /> 2</label>
             <label><input type="radio" name="hand" value="3" /> 3</label>
             <label><input type="radio" name="hand" value="4" /> 4</label>
             <label><input type="radio" name="hand" value="5" /> 5</label>
       
             <label>
               Сверхспособности:<br />
               <select name="syperpover[]" multiple>
                 <option selected="selected" value="immortality">бессмертие</option>
                 <option value="passing through walls" >прохождение сквозь стены</option>
                 <option value="levitation">левитация</option>
               </select>
             </label><br />
       
       <label>
               Биография:<br />
               <textarea name="biography" 
                         <?php if ($errors['biography']) print 'class="error"' ?>
                         value="<?php if ($errors['biography']) print $values['biography']; ?>" ></textarea>
             </label><br />
             
             <br />
             <label><input type="checkbox" checked="checked"
               name="check" />
               С контрактом ознакомлен(а) </label><br />
             
<input type="submit" value="Отправить" />
</form></h4>
</div>
</body>
</html>

