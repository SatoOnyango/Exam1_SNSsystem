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
        <h2>アカウント情報確認</h2>
        <div class="row">
          <div class="col-xs-4">
            <img src="">
          </div>
          <div class="col-xs-8">
            <div>
              <span>ユーザー名</span>
              <p class="lead">宮城太郎</p>
            </div>
            <div>
              <span>メールアドレス</span>
              <p class="lead">Miyagi@gmail.com</p>
            </div>
            <div>
              <span>パスワード</span>
              <p class="lead">●●●●●●●●</p>
            </div>
            <form method="POST" action="thanks.php">
              <a href="signup.php?action=rewrite" class="btn btn-default">&laquo;&nbsp;戻る</a> | 
              <input type="hidden" name="action" value="submit">
              <input type="submit" class="btn btn-primary" value="ユーザー登録">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>