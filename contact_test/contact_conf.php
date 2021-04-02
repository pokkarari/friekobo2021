<?php

session_start();

require_once 'util.inc.php';
require_once 'libs/qdmail.php';
require_once 'libs/qdsmtp.php';

// セッションから値を受け取る
if(isset($_SESSION["contact"])){
    $contact = $_SESSION["contact"];
}
else{
    // 入力値がない　⇒　入力画面へ
    header("Location: contact.php");
    exit;
}

//　戻るボタン
if(isset($_POST["back"])){
    header("Location: contact.php");
    exit;
}

//送信ボタン
if(isset($_POST["send"])){
    // ①メールを送信
    $myEmail = "info@friekobo.com";//メールを変数にする

    $qdmail = new Qdmail();

  //1 SMTPの設定 この8行はお決まりの書き方
    $param = ["host" => "smtp.lolipop.jp",
               "port" => 465,
               "from" => $myEmail,
              "protocol" => "SMTP_AUTH",
              "user" => $myEmail,
              "pass" => "frie8528"];//ここの行にサーバー情報を入れる
    $qdmail -> smtp(true);
    $qdmail -> smtpServer($param);


  //2メールのタイトルや本文の設定
    $text = <<< EOT
サイトより以下のお問い合わせがありました。

◆氏名 : {$contact["name"]}

◆フリガナ : {$contact["kana"]}
◆メール : {$contact["email"]}
◆電話番号 : {$contact["tel"]}
◆内容 :
{$contact["message"]}
EOT;

    $qdmail -> from($myEmail);
    $qdmail -> to($myEmail);
    $qdmail -> subject("サイトからの問い合わせ");
    $qdmail -> text($text);


  //3メールを送信
  $result = $qdmail -> send(); //メール送信の結果の表記する関数

    if ($result == true) {
    //②A:メール送信が成功の場合
      // 1セッションの破棄
      unset($_SESSION["contact"]);//内容を破棄
      unset($_SESSION["show_map"]);//地図を再表示するため

    // 2完了画面に遷移
      header("Location: contact_done.php");
      exit;
    }
  else {
  //②B:メール送信が失敗の場合
    //地図は映るように
    unset($_SESSION["show_map"]);
    header("Location: contact_error.php");
    exit;//エラー画面に遷移するだけ
  }

}

?>



<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="クレセントシューズは靴の素材と履き心地にこだわる方に満足をお届けする東京の靴屋です。後悔しない靴選びはぜひクレセントシューズにお任せください。">
  <meta name="keyword" content="Crescent,shoes,クレセントシューズ,東京,新宿区,メンズシューズ,レディースシューズ,キッズシューズ,ベビーシューズ">

  <title>Contact | Crescent Shoes</title>

  <link rel="shortcut icon" href="images/favicon.ico">
  <link rel="stylesheet" href="css/styles.css">
  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
      <!--[if lt IE 9]>
    <script src="http://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv-printshiv.min.js"></script>
    <script src="http://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <!--[if lt IE 8]>
    <![endif]-->
  </head>
  <body class="pageTop" id="pageTop">
    <header class="navbar navbar-default navbar-fixed-top" role="banner">
      <div class="container">
        <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <h1 class="navbar-header">
          <a href="index.php" class="navbar-brand"><img src="images/logo01.png" alt="LOGO"></a>
        </h1><!-- /.navbar-header -->
        <nav class="navbar-collapse collapse" id="navigation" role="navigation">
          <ul class="nav navbar-nav">
            <li><a href="index.php">ホーム<span>HOME</span></a></li>
            <li><a href="about.php">会社概要<span>ABOUT</span></a></li>
            <li><a href="news.php">ニュース<span>NEWS</span></a></li>
            <li><a href="shop.php">ショップ<span>ONLINE SHOP</span></a></li>
            <li><a href="contact.php">お問い合わせ<span>CONTACT</span></a></li>
          </ul>
          <form class="navbar-form" role="search">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="keyword">
              <span class="input-group-btn"><button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button></span>
            </div><!-- /.input-group -->
          </form>
        </nav>
      </div>
    </header>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <nav>
            <h1 class="page-header">Contact</h1>
            <ol class="breadcrumb">
              <li><a href="index.php">Home</a></li>
              <li><a href="contact.php">Contact</a></li>
              <li class="active">送信内容確認</li>
            </ol>
          </nav>
        </div>
      </div>
        <div class="row">
          <div class="col-md-4 hidden-sm hidden-xs">
            <div class="contact-img">
            <img src="images/contact.jpg">
            </div>
          </div>
          <div class="col-md-8">
            <h3 class="page-header">Message Confirmation</h3>
            <p>内容を修正される場合は「修正する」ボタンを、送信される場合は「送信する」ボタンを押してください。</p>
            <table class="table table-hover table-bordered">
              <tr>
                <th>お名前</th>
                <td><?php h($contact["name"]); ?></td>
              </tr>
              <tr>
                <th>フリガナ</th>
                <td><?php h($contact["kana"]); ?></td>
              </tr>
              <tr>
                <th>メールアドレス</th>
                <td><?php h($contact["email"]); ?></td>
              </tr>
              <tr>
                <th>電話番号</th>
                <td><?php h($contact["tel"]); ?></td>
              </tr>
              <tr>
                <th>お問い合わせ内容</th>
                <td><?php h($contact["message"]); ?></td>
              </tr>
            </table>
            <form action="" method="post" class="form-horizontal">
                <div class="form-group">
                <div class="col-sm-10">
                  <button type="submit" name="send" class="btn btn-success btn-lg">送信する</button>
                  <button type="submit" name="back" class="btn btn-success btn-lg">修正する</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="pagetop margin-top-md">
        <a href="#pageTop" class="center-block text-center" onclick="$('html,body').animate({scrollTop: 0}); return false;"><i class="fa fa-chevron-up center-block "></i>Page Top</a>
      </div>
      <footer class="margin-top-md" role="contentinfo">
        <div class="container">
          <div class="row">
            <div class="text-center">
              <ul class="list-inline">
                <li><a href="index.php">HOME</a></li>
                <li><a href="about.php">ABOUT</a></li>
                <li><a href="news.php">NEWS</a></li>
                <li><a href="shop.php">ONLINE SHOP</a></li>
                <li><a href="contact.php">CONTACT</a></li>
              </ul>
              <small>&copy; Crescent Shoes.All Rights Reserved.</small>
            </div><!-- /.text-center -->
          </div><!-- /.row -->
        </div><!-- /.container -->
      </footer>
      <script src="js/jquery-2.1.4.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/main.js"></script>
      <script>
      $(document).ready(function(){
        $('th').css({
            width: '20%',
            minWidth: '80px'
        });
        $('.contact-img').css({
            marginTop:'40px',
            overflow: 'hidden',
            height: $('.col-md-8').height() - 55
        });
      });
      </script>
    </body>
</html>