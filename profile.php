<?php
session_start();
require('dbconnect.php');

$sql = 'SELECT * FROM `users` WHERE `id` = ?';
$data = [$_SESSION['Exam1_SNSsystem']['id']];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

//ログインしているユーザーの情報
$signin_user = $stmt->fetch(PDO::FETCH_ASSOC);


// 選択されたユーザーの情報を取得し配列化
$user_sql = 'SELECT * FROM `users` WHERE `id` = ?';
$user_data = [$_GET['user_id']];
$user_stmt = $dbh->prepare($user_sql);

$user_stmt->execute($user_data);

$profile_user = $user_stmt->fetch(PDO::FETCH_ASSOC);


$sql = 'SELECT * FROM `followers` WHERE `user_id` = ? AND `follower_id` = ?';
$data = [$profile_user['id'],$signin_user['id']];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$is_followers = $stmt->fetch(PDO::FETCH_ASSOC);


$sql = 'SELECT * FROM `followers` AS `fo` LEFT JOIN `users` AS `u`
        ON `fo`.follower_id = `u`.`id`
        WHERE `fo`.`user_id` = ?';
$data = [$profile_user['id']];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

// フォロワー情報全てを入れる配列定義
$followers = [];
while(true){
    $followers_record = $stmt->fetch(PDO::FETCH_ASSOC);
    if($followers_record == false){
        break;
    }

$followers[] = $followers_record;
}

$sql = 'SELECT * FROM `followers` AS `fo` LEFT JOIN `users` AS `u`
        ON `fo`.`user_id` = `u`.`id`
        WHERE `fo`.`follower_id` = ?';
$data = [$profile_user['id']];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

// フォロワーしてるユーザー情報全てを入れる配列定義
$followings = [];
while(true){
    $followings_record = $stmt->fetch(PDO::FETCH_ASSOC);

    if($followings_record == false){
        break;
    }
    
$followings[] = $followings_record;
}


?>
<?php include('layouts/header.php'); ?>
<body style="margin-top: 60px; background: #E4E6EB;">
  <?php include("navbar.php"); ?>
  <div class="container">
    <div class="row">
      <div class="col-xs-3 text-center">
        <img src="user_profile_img/<?php echo $profile_user['img_name']; ?>" class="img-thumbnail">
        <h2><?php echo $profile_user['name']; ?></h2>
        <?php if($signin_user['id'] != $profile_user['id']): ?>

          <?php if($is_followers == false): ?>
            <!-- フォローしてない -->
            <a href="follow.php?following_id=<?php echo $profile_user['id']; ?>">
              <button class="btn btn-default btn-block">フォローする</button>
            </a>
          <?php else: ?>
            <!-- フォローしてる -->
            <a href="follow.php?following_id=<?php echo $profile_user['id']; ?>&unfollow=true">
              <button class="btn btn-danger btn-block">フォロー解除する</button>
            </a>
          <?php endif; ?>

        <?php endif; ?>
      </div><!--end col-xs-3 text-center -->
      <div class="col-xs-9">
        <ul class="nav nav-tabs">
          <li class="active">
            <a href="#tab1" data-toggle="tab">Followers</a>
          </li>
          <li>
            <a href="#tab2" data-toggle="tab">Following</a>
          </li>
        </ul>

        <div class="tab-content">

          <div id="tab1" class="tab-pane fade in active">
            <!-- followers このユーザーをフォローしてる人たち -->
            <?php foreach($followers as $follower): ?>
              <div class="thumbnail">
                <div class="row">
                  <div class="col-xs-2">
                    <img src="user_profile_img/<?php echo $follower['img_name']; ?>" width="80px">
                  </div>
                  <div class="col-xs-10">
                  名前 <a href="profile.php?user_id=<?php echo $follower['id']; ?>" style="color: #7F7F7F;"><?php echo $follower['name']; ?></a>
                      <br>
                    <?php echo $follower['created']; ?>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>

          <!-- following このユーザーがフォローしてる人たち -->
          <div id="tab2" class="tab-pane fade">
            <?php foreach($followings as $following): ?>
              <div class="thumbnail">
                <div class="row">
                  <div class="col-xs-2">
                    <img src="user_profile_img/<?php echo $following['img_name']; ?>" width="80px">
                  </div>
                  <div class="col-xs-10">
                  名前 <a href="profile.php?user_id=<?php echo $following['id']; ?>" style="color: #7F7F7F;"><?php echo $following['name']; ?></a>
                        <br>
                      <?php echo $following['created']; ?>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>

        </div>
      </div>
    </div>
  </div>
</body>
<?php include('layouts/footer.php'); ?>
</html>