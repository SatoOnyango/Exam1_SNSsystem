<?php
session_start();
require('dbconnect.php');

// ログインしているユーザーの情報
$sql = 'SELECT * FROM `users` WHERE `id` = ?';
$data = [$_SESSION['Exam1_SNSsystem']['id']];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

$signin_user = $stmt->fetch(PDO::FETCH_ASSOC);



// ユーザーの一覧取得
$sql = 'SELECT `name`,`img_name`,`created`,`id` FROM `users`';
$stmt = $dbh->prepare($sql);
$stmt->execute();

// 投稿情報全てを入れる配列定義
$users = [];
while(true){
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    //fetchは一つの行を取り出すこと
    if($record == false){
        break;
    }

    // `feeds`テーブにあるゆユーザーid数を取得
    $feed_sql = 'SELECT COUNT(*) AS `cnt` FROM `feeds` WHERE `user_id` = ? ';
    $feed_data = [$record['id']];
    $feed_stmt = $dbh->prepare($feed_sql);
    $feed_stmt->execute($feed_data);

    $feed = $feed_stmt->fetch(PDO::FETCH_ASSOC);
    //コメント(comment)の数が入っている
    $record['feed_cnt'] = $feed['cnt'];
    $users[] = $record;
}

?>

<?php include('layouts/header.php'); ?>
<body style="margin-top: 60px; background: #E4E6EB;">
  <?php include('navbar.php'); ?>
  <?php foreach($users as $user): ?>
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <div class="thumbnail">
            <div class="row">
              <div class="col-xs-2">
                <img src="user_profile_img/<?php echo $user['img_name']; ?>" width="80px">
              </div>
              <div class="col-xs-10">
                名前 <a href="profile.php?user_id=<?php echo $user['id']; ?>" style="color: #7f7f7f;"><?php echo $user['name']; ?></a><br>
                <?php echo $user['created']; ?>からメンバー
              </div>
            </div>
            <div class="row feed_sub">
              <div class="col-xs-12">
                <span class="comment_count">つぶやき数：<?php echo $user['feed_cnt']; ?></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</body>
<?php include('layouts/footer.php'); ?>
</html>