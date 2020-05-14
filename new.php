<!DOCTYPE html>
<!--- форма регистрации --->
<html>
<head>
    <meta charset="UTF-8">
    <title>Управление персоналом</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./styles.css">
</head>
<body>
<p><img src="./logo.png" alt="Embria" class="center"></p>
<br />
  <br />
    <form action="reg.php" method="post">
     <div class="form">
         <h2 align="center">Форма регистрации</h2>
         <div>
             <div>
                 <h4 align="center"><?php echo $message; ?> </h4>
                 <h4 align="center"><?php echo $error; ?></h4>
             </div>
      <label>Имя</label>
      <input type="text" name="name" placeholder="Иван" value="<?php echo $name; ?>" />
         </div>
         <div>
      <label>Фамилия</label>
      <input type="text" name="surname" placeholder="Иванов" value="<?php echo $surname; ?>" />
         </div>
         <div>
      <label>Почта</label>
      <input type="text" name="email" placeholder="i.ivanov@embria.com" value="<?php echo $email; ?>" />
         </div>
         <div>
             <label class="select-label">Выберите отдел:</label>
             <select class="cs-select" name="depart">
                 <option value="Business Development">Business Development</option>
                 <option value="EmbriaLabs">Рынки</option>
                 <option value="FinDept">Финансы</option>
                 <option value="Helpers">Помощники учредителей</option>
                 <option value="IT">IT-группа</option>
                 <option value="ManagementDept">PM</option>
                 <option value="Networking">Люди</option>
                 <option value="OfficeDept">Группа Офис</option>
             </select>
             </div>
         <br/>
         <div>
      <label>Должность</label>
      <input type="text" name="desc" placeholder="Бухгалтер" value="<?php echo $desc; ?>" />
         </div>
         <!---   <div>
	 <label>Номер телефона</label>
	 <input type="text" name="phone" placeholder="89123456789" value="<?php echo $phone; ?>" />
         </div>---->
    </form>
         <button input type="submit" name = "submit">Зарегистрировать</button>
        <br/>
         <p class="message">Передумали? <a href="mainpage.php">Вернуться</a></p>
     </div>

    </form>
    </div>
 </body>
</html>


