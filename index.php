<?php  session_start();
require_once('templates/top.php'); ?>
<main class="main">
  <div class="container">
    <div class="row heading">
      <h1>Добро пожаловать в нашу гостевую книгу</h1>
    </div>
    <div class="row messages">
      <div class="messages__items">
        <?php
        if($result){
          while($row = mysql_fetch_array($result)){
        ?>
        <div class="panel panel-info">
          <div class="panel-heading">
            <div class="text-right">
              <?php echo $row['date'] ?></div>
            <div class="text-left"><strong><?php echo $row['name'] ?></strong> - <?php echo $row['email'] ?></div>
          </div>
          <div class="panel-body">
            <div class="media">
              <div class="media-left media-middle">
                <?php if($row['picture']){ ?>
                <img class="media-object" src="/<?php echo $row['picture'] ?>" alt="" width="150">
                <?php } ?></div>
              <div class="media-body">
                <p>
                  <?php echo $row['text'] ?>
                </p>
              </div>
            </div>
          </div>
        </div>
      <?php }
      }else{ ?>
        <div class="alert alert-info" role="alert">
          В гостевой книге пока нет ни одной записи. Можете стать первым!
        </div>
        <?php } ?></div>
      <div class="messages__pagination">
        <nav>
          <ul class="pagination">
            <?php
           if ($total > 1){
            echo $prevpage.$page5left.$page4left.$page3left.$page2left.$page1left.'
            <li class="active">
              <a>'.$page.'</a>
            </li>
            '.$page1right.$page2right.$page3right.$page4right.$page5right.$nextpage;
          }
            ?>
          </ul>
        </nav>
      </div>
    </div>
    <?php 
//Функция очистки данных, вводимых пользователем
function clearText($var){
  $var = stripcslashes($var);
  $var = htmlentities($var);
  $var = strip_tags($var);
  return $var;
}

if(!empty($_POST)){

  $user_email = clearText($_POST['email']);
  $user_name =  clearText($_POST['name']);
  $user_msg =  clearText($_POST['msg']);
  $capcha = $_POST['capcha'];
  if($_FILES['file']['size'] != 0){
    switch($_FILES['file']['type']){
      case 'image/jpeg': $ext = 'jpg'; break;
      case 'image/gif': $ext = 'gif'; break;
      case 'image/png': $ext = 'png'; break;
      default: $ext = ''; break;
    }
    if($ext){
      $file = 'upload/'.date("y_m_d_h_i_").$_FILES['file']['name'];
      move_uploaded_file($_FILES['file']['tmp_name'], $file);
    }else{
      $err = 'Неправильный формат изображения';
    }
  }else{
    $file = '';
  }
  if(empty($user_email)){
    $err = 'Введите пожалуйста email';
  }
  if (empty($user_name)) {
    $err = 'Введите пожалуйста имя';
  }
  if (empty($user_msg)) {
    $err = 'Введите пожалуйста ваше сообщение';
  }
  if (strtolower($capcha) != strtolower($_SESSION['capcha'])){
    $err = 'Не правильно введен код с картинки!';
  }
  if(empty($err)){
    $ins_query = "INSERT INTO messages (name, email, text, picture, date) VALUES ('$user_name', '$user_email', '$user_msg', '$file', NOW())";
    if(!mysql_query($ins_query)){
      exit($ins_query);
    }
    ?>
    <script>document.location.href="index.php";</script>
    <?php
  }else{
    ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $err; ?>
      </div>
    <?php
  }
}
?>
    <form class="form" method="post" action="index.php" enctype="multipart/form-data">
      <div class="form-group has-feedback">
        <label for="email">
          Email <abbr title="Обязательное поле">*</abbr>
        </label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required></div>
      <div class="form-group">
        <label for="name">
          Имя <abbr title="Обязательное поле">*</abbr>
        </label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Имя" required></div>
      <div class="form-group">
        <label for="msg">
          Ваше сообщение
          <abbr title="Обязательное поле">*</abbr>
        </label>
        <textarea class="form-control" id="msg" name="msg" rows="3" required></textarea>
      </div>
      <div class="form-group">
        <label for="file">Изображение</label>
        <input type="file" id="file" name="file">
        <p class="help-block">Прикрепите изображение</p>
      </div>
      <div class="form-group">
        <label for="capcha">Введите код с картинки:</label>
        <input type="text" id="capcha" name="capcha">
        <br>
        <img src="system/capcha.php" alt=""></div>
      <button type="submit" class="btn btn-success" name="submit">Отправить</button>
    </form>
  </div>
</main>
<?php require_once('templates/bottom.php'); ?>