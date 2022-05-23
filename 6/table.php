<style>
  .error {
    border: 2px solid red;
  }
</style>
<body>
  <div class="table">
    <table>
      <tr>
        <th>Имя</th>
        <th>Почта</th>
        <th>Год</th>
        <th>Пол</th>
        <th>Кол-во конечностей</th>
        <th>Сверхсилы</th>
        <th>Био</th>
      </tr>
      <?php
      foreach($users as $user){
      ?>
            <tr>
              <td><?= $user['name']?></td>
              <td><?= $user['email']?></td>
              <td><?= $user['year']?></td>
              <td><?= $user['sex']?></td>
              <td><?= $user['limb']?></td>
              <td><?php 
                $user_pwrs=array(
                    "immortal"=>FALSE,
                    "ghost"=>FALSE,
                    "levitation"=>FALSE
                );
                foreach($pwrs as $pwr){
                    if($pwr['id']==$user['id']){
                        if($pwr['power']=='бессмертие'){
                            $user_pwrs['immortal']=TRUE;
                        }
                        if($pwr['power']=='прохождение сквозь стены'){
                            $user_pwrs['ghost']=TRUE;
                        }
                        if($pwr['power']=='левитация'){
                            $user_pwrs['levitation']=TRUE;
                        }
                    }
                }
                if($user_pwrs['immortal']){echo 'Бессмертие<br>';}
                if($user_pwrs['ghost']){echo 'Прохождение сквозь стены<br>';}
                if($user_pwrs['levitation']){echo 'Левитация<br>';}?>
              </td>
              <td><?= $user['bio']?></td>
              <td>
                <form method="get" action="edit.php">
                  <input name=edit_id value="<?= $user['id']?>" hidden>
                  <input type="submit" value=Edit>
                </form>
              </td>
            </tr>
      <?php
       }
      ?>
    </table>
    <?php
    printf('Кол-во пользователей с сверхспособностью "Бессмертие": %d <br>',$powers_count[0]);
    printf('Кол-во пользователей с сверхспособностью "Прохождение сквозь стены": %d <br>',$powers_count[1]);
    printf('Кол-во пользователей с сверхспособностью "Левитация": %d <br>',$powers_count[2]);
    ?>
  </div>
</body>
