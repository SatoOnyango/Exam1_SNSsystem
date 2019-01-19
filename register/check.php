<?php
session_start();
require('../dbconnect.php');

//正規のルートでここまでこなかったとき、signup.phpに強制的に遷移させる
if(!isset($_SESSION['Exam1_SNSsystem'])){
        header('Location: signup.php');
        exit();
}

$name = $_SESSION['Exam1_SNSsystem']['name'];
$email = $_SESSION['Exam1_SNSsystem']['email'];
$password =  $_SESSION['Exam1_SNSsystem']['password'];
$img_name = $_SESSION['Exam1_SNSsystem']['img_name'];

//登録ボタンが押されたとき（ポスト送信された時)
if(!empty($_POST)){
    $sql = 'INSERT INTO `users`(`name`,`email`,`password`,`img_name`,`created`) VALUES (?,?,?,?,NOW())';
    $data = [$name,$email,password_hash($password,PASSWORD_DEFAULT),$img_name];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    unset($_SESSION['Exam1_SNSsystem']);
    header('Location: thanks.php');
    exit();

}



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
          <div class="col-xs-4 thumbnail">
            <img src="../user_profile_img/<?php echo htmlspecialchars($img_name); ?>" width="500" class="img-responsive img-thumbnail">
          </div>
          <div class="col-xs-8">
            <div>
              <span>ユーザー名</span>
              <p class="lead"><?php echo htmlspecialchars($name); ?></p>
            </div>
            <div>
              <span>メールアドレス</span>
              <p class="lead"><?php echo htmlspecialchars($email); ?></p>
            </div>
            <div>
              <span>パスワード</span>
              <p class="lead">●●●●●●●●</p>
            </div>
            <form method="POST" action="check.php">
              <a href="signup.php?action=rewrite" class="btn btn-default">&laquo;&nbsp;戻る</a> | 
              <input type="hidden" name="action" value="submit">
              <input type="submit" class="btn btn-primary" value="ユーザー登録">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../assets/js/jquery-3.1.1.js"></script>
  <script src="../assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="../assets/js/bootstrap.js"></script>
</body>
</html>