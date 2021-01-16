<?php
session_start();

require_once '../util.inc.php';
require_once '../db.inc.php';

if($_SERVER["REQUEST_METHOD"] === "POST"){
	//①バリデーション
    $login_id = $_POST["id"];
    $login_pass = $_POST["pass"];

    $isValidated = ture;
    if($login_id === ""){
        $errorId = "ログインIDを入れてください";
        $isValidated = false;
    }
    if($login_pass === ""){
        $errorPass = "パスワードを入れてください";
        $isValidated = false;
    }

    if($isValidated == true){
        //②IDとパスワードが正しいかチェック
        try {
            $pdo = db_init();
            $sql = "SELECT * FROM admins
                    WHERE login_id = ?
                    AND login_pass = ? ";
            $stmt = $pdo -> prepare($sql);

            // ユーザーが入力したパスワードを暗号化
            $hashed = hash("sha256", $login_pass . $login_id);

            $stmt -> execute([$login_id, $hashed]);

            $data = $stmt -> fetch();

               if ($data != false) {
                   //「1.ログイン中」をセッション格納
                    $_SESSION["auth"] = true;
                    $_SESSION["login_id"] = $data["login_id"];
                   //2.index.phpに遷移させる
                   header("Location: index.php");
                   exit;
               }
               else {
                   $errorLogin = "IDまたはパスワードがちがいます";
               }
        }
        catch (PDOException $e){
            echo $e -> getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ログイン | エフリエこうぼう 管理</title>
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
    <h1>ログイン</h1>
    <?php if(isset($errorId)): ?>
    <p class="error"><?php h($errorId); ?></p>
    <?php endif; ?>
    <?php if(isset($errorPass)): ?>
    <p class="error"><?php h($errorPass); ?></p>
    <?php endif; ?>
    <?php if(isset($errorLogin)): ?>
    <p class="error"><?php h($errorLogin); ?></p>
    <?php endif; ?>
    <form action="" method="post">
    <table id="loginbox">
      <tr>
        <th>ログインID</th>
        <td><input type="text" name="id" value="<?php h($login_id); ?>"></td>
      </tr>
      <tr>
        <th>パスワード</th>
        <td><input type="password" name="pass"></td>
      </tr>
    </table>
    <p><input type="submit" value="ログイン"></p>
    </form>
  </main>
  <footer>
    <p>copyright &copy; 2020 FRiekobo</p>
  </footer>
</div>
</body>
</html>