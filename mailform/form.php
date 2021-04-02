<?php
//セッションを開始       ・・・①
session_start();
//文字コード指定         ・・・②
header("Content-type: text/html; charset=utf-8");
//クリックジャッキング対策   ・・・③
header('X-FRAME-OPTIONS: SAMEORIGIN');

//疑似乱数のバイト文字列(16バイト)を生成     ・・・④
$token_byte = openssl_random_pseudo_bytes(16);
//バイナリのデータを16進表現に変換          ・・・⑤
$csrf_token = bin2hex($token_byte);
//セッション変数設定                       ・・・⑥
$_SESSION['csrf_token'] = $csrf_token;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <script type="text/javascript" charset="UTF-8"></script>
    <title>お問い合わせフォーム</title>
    <link rel="stylesheet" href="css/contact.css">
    <script src="//code.jquery.com/jquery-2.2.4.min.js"></script>
    <script>
    //共通パーツ読み込み
    $(function() {
        $("#header").load("common/header.html");
        $("#sidebar").load("common/sidebar-non.html");
        $("#footer").load("common/footer.html");
    });
    </script>
</head>
<body>
<!-- HEADER  -->
<div id="header"></div>
<!-- MAIN CONTENTS  -->
<div id="container">
<div id="content">
  <div id="inner-content" class="clearfix">
    <main id="main">
      <br/>
      <form method="POST" action="mailer.php">
        <input type="hidden" name="csrf_token" value="<?=$csrf_token?>"><!--      ・・・⑦ -->
        <div class="form">
          <p><font size="4"><b>お名前</b></font></p>
          <input type="text" name="name" />
          <p><font size="4"><b>メールアドレス</b></font></p>
          <input type="text" name="email" />
          <p><font size="4"><b>題名</b></font></p>
          <input type="text" name="subject" />
          <p><font size="4"><b>お問い合わせ内容</b></font></p>
          <textarea name="message"></textarea><br>
        </div>
        <br/>
        <div class="contact-submit">
          <input type="submit" value="送信">
        </div>
      </form>
    </main>
    <!-- SIDEBAR -->
    <div id="sidebar"></div>
  </div><!-- /#inner-content -->
</div><!-- /#content -->
<br/><br/>
<!-- FOOTER -->
<div id="footer"></div>
</body>
</html>