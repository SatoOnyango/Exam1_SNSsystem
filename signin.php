<?php
session_start();
require('dbconnect.php');

$errors = [];

// POST送信時のみ
if(!empty($_POST)){
    $email = $_POST['input_email'];
    $password = $_POST['input_password'];

    if($email == ''){
        $errors['email'] = 'blank';
    }

    $count = strlen($password);

    if($password == ''){
        $errors['password'] = 'blank';
    }
    if(empty($errors)){
        $sql = 'SELECT * FROM `users` WHERE `email`= ? ';
        $data = [$email];
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        //メールアドレスでの本人確認
        if($record == false){
            $errors['signin'] = 'failed';
        }
        //2.パスワードが一致するか確認
        if(password_verify($password, $record['password'])){
            $_SESSION['Exam1_SNSsystem']['id'] = $record['id'];
            // timeline.phpに遷移
            header('Location: timeline.php');
            exit();

        }else{
            //認証失敗
            $errors['signin'] = 'failed';
        }
    }
}



?>
<?php include('layouts/header.php'); ?>
<body>
  <div class="container">
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2 thumbnail">
        <h2 class="text-center content_header">サインイン</h2>
        <form method="POST" action="signin.php" enctype="multipart/form-data">
          <div class="form-group">
            <label for="email">メールアドレス</label>
            <input type="email" name="input_email" class="form-control" id="email" placeholder="example@gmail.com">
          </div>
          <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" name="input_password" class="form-control" id="password" placeholder="4 ~ 16文字のパスワード">
            <?php if(isset($errors['password'])&&$errors['password'] == 'blank'): ?>
              <p class = "text-danger">メールアドレスとパスワード入力してください</p>
            <?php endif; ?>
            <?php if(isset($errors['password'])&&$errors['password'] == 'failed'): ?>
              <p class = "text-danger">サインインに失敗しました</p>
            <?php endif; ?>
          </div>
          <input type="submit" class="btn btn-info" value="サインイン">
          <span>
            <a href="index.php">トップへ戻る</a>
          </span>
        </form>
      </div>
    </div>
  </div>
</body>
<?php include('layouts/header.php'); ?>
</html>
