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
    <div class="for">
    <h4><form action="" method="POST">
<?php if (isset($messages['save'])) print($messages['save']); ?>
<?php if (isset($messages['name'])) print($messages['name']); ?>
      <label> Имя:<br />
      <input name="name" <?php if (isset($errors['name']) && $errors['name']==2) print 'style="color:red"'; else print 'style="color:black"'; ?> value="<?php $values['name']; ?>" /></label><br />
 
<?php if (isset($messages['email'])) print($messages['email']); ?>
      <label> e-mail:<br />
   <input name="email" <?php if (isset($errors['email']) && $errors['email']==2) print 'style="color:red"'; else print 'style="color:black"';?> value="<?php $values['email']; ?>" type="email" /> </label><br />
       
<?php if (isset($messages['date'])) print($messages['date']); ?>
    <label>  Дата рождения:<br /><input name="date"  value="<?php $values['date']; ?>" type="date" /></label><br />
             
<?php if (isset($messages['gender'])) print($messages['gender']); ?>
             Пол:<br /> 
             <label><input type="radio" checked="checked" name="gender" value="m" /> М</label>
             <label><input type="radio" name="gender" value="w" /> Ж</label><br />
       
<?php if (isset($messages['hand'])) print($messages['hand']); ?>
       Количество конечностей:<br />
             <label><input type="radio" checked="checked" name="hand" value="1" />1</label>
             <label><input type="radio" name="hand" value="2" /> 2</label>
             <label><input type="radio" name="hand" value="3" /> 3</label>
             <label><input type="radio" name="hand" value="4" /> 4</label>
             <label><input type="radio" name="hand" value="5" /> 5</label>

<?php if (isset($messages['syperpover'])) print($messages['syperpover']); ?>             
             <label>
               Сверхспособности:<br />
               <select name="syperpover[]" multiple>
                 <option selected="selected" value="immortality">бессмертие</option>
                 <option value="passing through walls" >прохождение сквозь стены</option>
                 <option value="levitation">левитация</option>
               </select>
             </label><br />
       
       <label>
      
<?php if (isset($messages['biography'])) print($messages['biography']); ?>
               Биография:<br />
               <textarea name="biography" 
                         <?php if (isset($errors['biography']) && $errors['biography']==2) print 'style="color:red"'; else print 'style="color:black"'; ?>
                         value="<?php rint $values['biography']; ?>" ></textarea>
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

