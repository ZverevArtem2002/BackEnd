<style>
    .form1{
        max-width: 960px;
        text-align: center;
        margin: 0 auto;
    }
</style>
<body>
  <div class="form1">
  <form action="index.php" method="POST">
    <label> ФИО </label> <br>
    <input name="name" /> <br>
    <label> Почта </label> <br>
    <input name="email" type="email" /> <br>
    <label> Год рождения </label> <br>
    <select name="year">
      <option value="Выбрать">Выбрать</option>
    <?php
        for($i=1800;$i<=2022;$i++){
          printf("<option value=%d>%d год</option>",$i,$i);
        }
    ?>
    </select> <br>
    <label> Ваш пол </label> <br>
    <div>
      <input name="sex" type="radio" value="M" /> Мужчина
      <input name="sex" type="radio" value="W" /> Женщина
    </div>
    <label> Сколько у вас конечностей </label> <br>
    <div>
      <input name="limb" type="radio" value="1" /> 1 
      <input name="limb" type="radio" value="2" /> 2 
      <input name="limb" type="radio" value="3" /> 3 
      <input name="limb" type="radio" value="4" /> 4 
    </div>
    <label> Выберите суперспособности </label> <br>
    <select name="power[]" size="3" multiple>
      <option value="Телепортация">Телпортация</option>
      <option value="Бессмертие">Бессмертие</option>
      <option value="Телепатия">Телепатия</option>
    </select> <br>
    <label> Биография </label> <br>
    <textarea name="bio" rows="10" cols="15"></textarea> <br>
    <input name="check" type="checkbox"> Вы согласны с пользовательским соглашением <br>
    <input type="submit" value="Отправить"/>
  </form>
  </div>
</body>