<?php
session_status();
//セッションの破棄
unset($_SESSION["auth"]);
unset($_SESSION["login_id"]);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ログアウト | エフリエこうぼう 管理</title>
<link rel="stylesheet" href="css/admin.css">
</head>
<body>
<header>
  <div class="inner">
    <span><a href="index.php">エフリエこうぼう 管理</a></span>
  </div>
</header>
<div id="container">
  <main>
    <h1>ログアウト</h1>
    <p>ログアウトしました。</p>
    <p><a href="login.php">ログインページへ移動</a></p>
  </main>
  <footer>
    <p>copyright &copy; 2018 FRiekobo</p>
  </footer>
</div>
</body>
</html>