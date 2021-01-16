<?php
session_start();

//ログイン中でない場合
// 強制的にlogin.phpに遷移させる
if ($_SESSION["auth"] !== true) {
    header("Location: login.php");
}
require_once '../util.inc.php';
require_once '../db.inc.php';

//表示用にlogin_idを取得
$login_id = $_SESSION["login_id"];


try{
    // DBへの接続〜文字コードの設定
    $pdo = db_init();

    // 新着情報の取得
    $sql = "SELECT * FROM news ORDER BY posted DESC";
    $stmt = $pdo -> query($sql);
    $newsList = $stmt -> fetchAll(PDO::FETCH_ASSOC);
//     var_dump($newsList);

}
catch (PDOException $e){
    echo $e -> getMessage();
}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>最新情報・お知らせ一覧 | エフリエこうぼう管理</title>
<link rel="stylesheet" href="css/admin.css">
</head>

<body id="admin_index">
<header>
  <div class="inner">
    <span><a href="index.php">エフリエこうぼう 管理</a></span>
    <div id="account">
      <?php h($login_id); ?>
      [ <a href="logout.php">ログアウト</a> ]
    </div>
  </div>
</header>
<div id="container">
  <main>
    <h1>お知らせ一覧</h1>
    <p><a href="news_add.php">お知らせの追加</a></p>
    <table>
      <tr>
        <th>日付</th>
        <th>タイトル／お知らせ内容</th>
        <th>画像(65×65)</th>
        <th>編集</th>
        <th>削除</th>
      </tr>
      <?php  foreach ($newsList as $news): ?>
      <tr>
        <td class="center"><?php h($news["posted"]); ?></td>
        <td>
          <span class="title"><?php h($news["title"]); ?></span>
          <?php h($news["message"]); ?>
        </td>
           <?php if(isset($news["image"])): ?>
        <td class="center"><img src="../images/press/<?php h($news["image"]); ?>" width="64" height="64" alt="">
         </td>
        <?php else: ?>
        <td class="center"><img src="../images/press.png" width="64" height="64" alt=""></td>
        <?php endif; ?>
        <td class="center"><a href="news_edit.php?id=<?php h($news["id"]); ?>">編集</a></td>
        <td class="center"><a href="news_delete.php?id=<?php h($news["id"]); ?>">削除</a></td>
      </tr>
      <?php endforeach;?>
    </table>
  </main>
</div>
  <footer>
    <p>copyright &copy; 2020 FRiekobo</p>
  </footer>
</div>
</body>
</html>
