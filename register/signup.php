<?php

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Exam1_SNS</title>
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../assets/font-awesome/css/font-awesome.css">
</head>
<body>
  <div class="container">
    <div class="row">
      <div>
        <h2>アカウント作成</h2>
        <form method="POST" action="check.php">
          <div>
            <label for="name">ユーザー名</label>
            <input type="text" name="input_name">
          </div>
          <div>
            <label for="email">メールアドレス</label>
            <input type="email" name="input_email">
          </div>
          <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" name="input_password">
          </div>
          <div>
            <label for="img_name">プロフィール画像</label>
            <input type="file" name="input_img_name" id="img_name" accept="image/*">
          </div>
          <input type="submit" class="btn btn-default" value="確認">
          <span>
              <a href="../signin.php">サインインへ</a>
          </span>
        </form>
      </div>
    </div>
  </div>
</body>
</html>