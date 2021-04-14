<?php

session_start();

// HPMailer のクラスをグローバル名前空間（global namespace）にインポート
// スクリプトの先頭で宣言する必要があります
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//PHPmailer設定
require "PHPMailer/src/Exception.php";
require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/SMTP.php";
//エラーメッセージ用日本語言語ファイルを読み込む場合
require "PHPMailer/language/phpmailer.lang-ja.php";

//データチェック
require "./libs/phpmailvars.php";

//エスケープ処理やデータチェックを行う関数のファイルの読み込み
  require 'libs/function.php';


//-------CSRF-------------------
function getToken(){
  return hash("sha256",session_id());
}

// if ($_SERVER['REQUEST_METHOD'] === "POST"){
//   //ひみつの鍵を持っているかのチェック
//   //1鍵をもっているか？
//   //2正しい鍵か？ 1と2の両方の条件を。
//   if (!isset($_POST["token"])) {
//     //POSTでtokenがないため鍵を持っていないので不正
//     exit("処理を正常に完了できません。不正の疑いあり");
//   }
//   elseif ($_POST["token"] !== getToken()) {
//     //POSTのgetTokenの正しい鍵ではないので不正
//     exit("不正の疑いあり");
//   }
// }
// else{
//   //直接このページを訪れた人は
//   //不正アクセスと見なし、contact.phpに戻す
//   header("Location: contact.php");
//   exit;
// }
// // --------------------------


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
    //言語、内部エンコーディングを指定
    mb_language("japanese");
    mb_internal_encoding("UTF-8");

    // インスタンスを生成（引数に true を指定して例外 Exception を有効に）
    $phpmail = new PHPMailer(true);

    //日本語用設定
    $phpmail->CharSet = "iso-2022-jp";
    $phpmail->Encoding = "7bit";

    //エラーメッセージ用言語ファイルを使用する場合に指定
    $phpmail->setLanguage("ja", "language/");


  //1 SMTPの設定 お決まりの書き方
  //サーバの設定
  $phpmail->SMTPDebug = SMTP::DEBUG_SERVER;  // デバグの出力を有効に（テスト環境での検証用）
  $phpmail->isSMTP();   // SMTP を使用
  $phpmail->Host = MAIL_HOST; // SMTP サーバーを指定（phpmailvars.phpで定義）
  $phpmail->SMTPAuth = true; // SMTP authentication を有効に
  $phpmail->Username = MAIL_USER; // SMTP ユーザ名（phpmailvars.phpで定義）
  $phpmail->Password = MAIL_PASSWORD; // SMTP パスワード（phpmailvars.phpで定義）
  $phpmail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  // 暗号化を有効に
  $phpmail->Port       = 465;  // TCP ポートを指定


  //2メールのタイトルや本文の設定
    $mail_text = <<< EOT
サイトより以下のお問い合わせがありました。

◆氏名 : {$contact["name"]}

◆フリガナ : {$contact["kana"]}
◆メール : {$contact["email"]}
◆電話番号 : {$contact["tel"]}
◆内容 :
{$contact["message"]}
EOT;

//------------受信者設定-----------
  //※名前などに日本語を使う場合は文字エンコーディングを変換
  //差出人アドレス, 差出人名
  $phpmail->setFrom("MAIL_USER", mb_encode_mimeheader("差出人名"));
  //受信者アドレス, 受信者名（受信者名はオプション）
  $phpmail->AddAddress(SEND_TO, mb_encode_mimeheader(SEND_TO_NAME)); //送信先アドレス・宛先名（phpmailvars.phpで定義）
  //追加の受信者（受信者名は省略可能なのでここでは省略）
  //$phpmail->addAddress('someone@gmail.com');
  //返信用アドレス（差出人以外に別途指定する場合）
  //$phpmail->addReplyTo('info@example.com', mb_encode_mimeheader("お問い合わせ"));
  //Cc 受信者の指定
  //$phpmail->addCC('foo@example.com');

  //----------コンテンツ設定--------------
  //$phpmail->isHTML(true);   // HTML形式を指定
  //メール表題（文字エンコーディングを変換）
  $phpmail->Subject = mb_encode_mimeheader("サイトからの問い合わせ");
  //HTML形式の本文（文字エンコーディングを変換）
  $phpmail->Body  = mb_convert_encoding($mail_text,"JIS","UTF-8");
  //テキスト形式の本文（文字エンコーディングを変換）
  //$phpmail->AltBody = mb_convert_encoding('テキストメッセージ',"JIS","UTF-8");


  //3メールを送信
  $result = $phpmail -> send(); //メール送信の結果の表記する関数

    if ($result == true) {
    //②A:メール送信が成功の場合
      // 1セッションの破棄
      unset($_SESSION["contact"]);//内容を破棄

    // 2完了画面に遷移
      header("Location: contact_done.php");
      exit;
    }
  else {
  //②B:メール送信が失敗の場合
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
    <meta name="robots" content="noindex,nofollow,noarchive" />
<!-- 検索エンジンに検索されないようにする -->
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
           	<form  action="" method="post"  >
             <table border=1>
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
            <input type="hidden" name="token" value="<?php echo getToken(); ?>">
            <p><input type="submit" name="send" value="送信する"></p>
            <p><input type="submit" name="back" value="修正する"></p>
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