<?php
session_start();

$errors = [];


//戻るボタンを押して、signup.phpに戻ってきたときの表示
//セッションの情報から前回入力情報を使って＄_POSTを擬似的に作成 !enmpty()のif文が実行されるようにする。
if(isset($_GET['action']) && $_GET['action'] == 'rewrite'){
        $_POST['input_name'] = $_SESSION['Exam1_SNSsystem']['name'];
        $_POST['input_email'] = $_SESSION['Exam1_SNSsystem']['email'];
        $_POST['input_password'] = $_SESSION['Exam1_SNSsystem']['password'];
//empty($errors)を通過防止ために、$errorsに値を入れておく
        $errors['rewrite'] = true;
}

//空で変数を定義しておく
$name = '';
$email = '';

if(!empty($_POST)){

    $name = $_POST['input_name'];
    $email = $_POST['input_email'];
    $password = $_POST['input_password'];

    if($name == ''){
        $errors['name'] = 'blank';
    }
    if($email == ''){
        $errors['email'] = 'blank';
    }

    $count = strlen($password);


    if($password == ''){
        $errors['password'] = 'blank';
    }elseif ($count < 4 || $count > 16) {
        $errors['password'] = 'length';
    }



    $file_name ='';
    if(!isset($_GET['action'])){
        //下の画像名を取得したときの状態をこのif文の中に入れる
        $file_name = $_FILES['input_img_name']['name'];
    }

    if(!empty($file_name)){

        //拡張子のチェック処理
        $file_type = substr($file_name, -3);
        $file_type = strtolower($file_type);

        if($file_type != 'png' && $file_type != 'jpg' && $file_type != 'gif'){
            $errors['img_name'] ='type';
        }
    }else{
        $errors['img_name'] = 'blank';
        }

    if(empty($errors)){
        date_default_timezone_set('Asia/Tokyo');

        $date_str = date('YmdHis');
        $submit_file_name = $date_str . $file_name;

        move_uploaded_file($_FILES['input_img_name']['tmp_name'],'../user_profile_img/' . $submit_file_name);



        $_SESSION['Exam1_SNSsystem']['name'] = $_POST['input_name'];
        $_SESSION['Exam1_SNSsystem']['email'] = $_POST['input_email'];
        $_SESSION['Exam1_SNSsystem']['password'] = $_POST['input_password'];

        $_SESSION['Exam1_SNSsystem']['img_name'] = $submit_file_name;


        header('Location: check.php');
        exit();
    }

}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Exam1_SNS</title>
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-xs-6 col-xs-offset-3 thumnail">
        <h2 class="text-center content_header">アカウント作成</h2>
        <form method="POST" action="signup.php" enctype="multipart/form-data">
          <div class="form-group">
            <label for="name">ユーザー名</label>
            <input type="text" name="input_name" value="<?php echo htmlspecialchars($name); ?>" class="form-control">
            <?php if(isset($errors['name']) && $errors['name'] =='blank'): ?>
              <p class="text-danger">ユーザー名を入力してください</p>
            <?php endif; ?>
          </div>
          <div>
            <label for="email">メールアドレス</label>
            <input type="email" name="input_email" value="<?php echo htmlspecialchars($email); ?>" class="form-control">
            <?php if(isset($errors['email']) && $errors['email'] == 'blank'): ?>
              <p class="text-danger">メールアドレスを入力してください</p>
            <?php endif; ?>
          </div>
          <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" name="input_password" class="form-control">
            <?php if(isset($errors['password']) && $errors['password'] == 'blank'): ?>
              <p class="text-danger">パスワードを入力してください</p>
            <?php endif; ?>
            <?php if(isset($errors['password']) && $errors['password'] == 'length'): ?>
              <p class="text-danger">パスワードは４〜１６文字で入力してください</p>
            <?php endif; ?>
            <?php if((isset($errors['password']) && $errors['password'] != 'blank') || (isset($errors['rewrite']) && $errors['rewrite'] == true)): ?>
              <p class="text-danger">パスワードを再入力してください</p>
            <?php endif; ?>
          </div>
          <div class="form-group">
            <label for="img_name">プロフィール画像</label>
            <input type="file" name="input_img_name" id="img_name" accept="image/*">
            <?php if(isset($errors['img_name']) && $errors['img_name'] == 'blank'): ?>
              <p class="text-danger">プロフィール画像を選択してください</p>
            <?php endif; ?>
            <?php if(isset($errors['img_name']) && $errors['img_name'] == 'type'): ?>
              <p class="text-danger">拡張子がpng,gif,jpgの画像を選択して下さい</p>
            <?php endif; ?>
          </div>
          <input type="submit" class="btn btn-default" value="確認">
          <span>
              <a href="../signin.php">サインインへ</a>
          </span>
        </form>
      </div>
    </div>
  </div>
  <script src="../assets/js/jquery-3.1.1.js"></script>
  <script src="../assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="../assets/js/bootstrap.js"></script>
</body>
</html>