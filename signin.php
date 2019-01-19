<?php
require('dbconnect.php');

$errors = [];

if(!empty($_POST)){
    $email = $_POST['input_email'];
    $password = $_POST['input_password'];

    if($email==''){
        $errors['email'] = 'blank';
    }
    if($password==''){
        $errors['password'] = 'blank';
    }

    if(empty($errors)){
        //データベースとの照合処理
        $sql = 'SELECT * FROM `users` WHERE `email` = ?';
        $data = [$email];
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);
        $record = $stmt->fecth(PDO::FETCH_ASSOC);
        // メールアドレスでの本人確認
        if($record == false){
            $errors['signin'] = 'failed';
        }

    }else{
        $errors['signin'] = 'failed';
    }
}

?>
<body>
  <div class="container">
    <div class="row">
      <div>
        <h2>サインイン</h2>
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
</html>
