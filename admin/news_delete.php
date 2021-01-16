<?php
require_once '../util.inc.php';
require_once '../db.inc.php';

// キャンセルボタン
if(isset($_POST["cancel"])){
    header("Location: index.php");
    exit;
}

// DBからデータを1件分取得
try {
    $pdo = db_init();
    $sql = "SELECT * FROM news
        WHERE id = ?";
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute([$_GET["id"]]);
    $news = $stmt -> fetch(PDO::FETCH_ASSOC);

}
catch (PDOException $e) {
    echo $e -> getMessage();
}

// 削除ボタン
if(isset($_POST["delete"])){
try {
       $sql = "DELETE FROM news
                WHERE id = ?";
       $stmt = $pdo -> prepare($sql);
        $stmt -> execute([$_GET["id"]]);

        //フォルダの中の画像の削除を入れるときはここに書く unlink()
        //画像の重複がないようにしておく

        header("Location: news_delete_done.php");
        exit;
 }
catch (PDOException $e) {
    echo $e -> getMessage();
 }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>お知らせの削除 | エフリエこうぼう 管理</title>
<link rel="stylesheet" href="css/admin.css">
</head>
<body>
<header>
  <div class="inner">
    <span><a href="index.php">エフリエこうぼう 管理</a></span>
    <div id="account">
      admin
      [ <a href="logout.php">ログアウト</a> ]
    </div>
  </div>
</header>
<div id="container">
  <main>
    <h1>お知らせの削除</h1>
    <p>以下のお知らせを削除します。</p>
    <p>よろしければ「削除」ボタンを押してください。</p>
    <form action="" method="post">
    <table>
      <tr>
        <th class="fixed">日付</th>
        <td>
          <?php h($news["posted"]); ?>
        </td>
      </tr>
      <tr>
        <th class="fixed">タイトル</th>
        <td>
        <?php h($news["title"]); ?>
        </td>
      </tr>
      <tr>
        <th class="fixed">お知らせ内容</th>
        <td>
        <?php h($news["message"]); ?>
        </td>
      </tr>
      <tr>
        <th class="fixed">画像</th>
         <?php if(isset($news["image"])): ?>
        <td><img src="../images/press/<?php h($news["image"]); ?>" width="64" height="64" alt=""></td>
        <?php else: ?>
          <td><img src="../images/press.png" width="64" height="64" alt=""></td>
          <?php endif; ?>
      </tr>

    </table>
    <p>
      <input type="submit" name="delete" value="削除">
      <input type="submit" name="cancel" value="キャンセル">
    </p>
    </form>
  </main>
  <footer>
    <p>copyright &copy; 2020 FRiekobo</p>
  </footer>
</div>
</body>
</html>