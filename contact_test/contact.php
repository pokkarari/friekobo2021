<?php
session_start();
//セッションIDを更新して変更（セッションハイジャック対策）
session_regenerate_id( TRUE );

//エスケープ処理やデータチェックを行う関数のファイルの読み込み
  require 'libs/function.php';

  //ひみつ鍵を作るための関数を定義
  function getToken(){
    return hash("sha256",session_id());
}



// セッションに値がある場合、値を取り出す
if(isset($_SESSION["contact"])){
    $contact = $_SESSION["contact"];
    $name = $contact["name"];
    $kana = $contact["kana"];
    $email = $contact["email"];
    $tel = $contact["tel"];
    $message = $contact["message"];
}

if($_SERVER["REQUEST_METHOD"] === "POST"){

    //①バリデーション
    $name = $_POST["name"];
    $kana = $_POST["kana"];
    $email = $_POST["email"];
    $tel = $_POST["tel"];
    $message = $_POST["message"];

    $isValidated = true;

    if($name === ""){
        $isValidated = false;
        $errorName = "氏名を入力してください";
    }

    if($kana === ""){
        $isValidated = false;
        $errorKana = "フリガナを入力してください";
    }
    // 全角カタカナか半角空白以外はＮＧ
    elseif(!preg_match("/^[ァ-ヶー 　]+$/u", $kana)){
        $isValidated = false;
        $errorKana = "全角カナを入力してください";
    }
    //メールアドレスのバリデーション　空白の場合
    if($email === ""){
        $isValidated = false;
        $errorEmail = "メールアドレスを入力してください";
    }
    //メールアドレスのバリデーション 正しいメールアドレス
    elseif(!preg_match("/^[^@]+@[^@]+\.[^@]+$/", $email)){
        $isValidated = false;
        $errorEmail = "形式が正しくありません";
    }
    if($message === ""){
        $isValidated = false;
        $errorMessage = "内容を入力してください";
    }

    //②バリデーションOKの時
    if($isValidated == true){
// セッションに入力値を預けるため　$contactという名前にすべてのnameとかkanaとかを配列に入れる
        $contact["name"] = $name;
        $contact["kana"] = $kana;
        $contact["email"] = $email;
        $contact["tel"] = $tel;
        $contact["message"] = $message;
// セッションに入力値を預ける
        $_SESSION["contact"] = $contact;
//　確認画面へ
        header("Location: contact_conf.php");
        exit;
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
              <li class="active">Contact</li>
            </ol>
          </nav>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <h3>Contact Details</h3>
          <p>
            〒169-0073<br>東京都新宿区百人町2-4-8　グレースビル1階
          </p>
          <p><i class="fa fa-phone"></i> 03-1234-5678</p>
          <p><i class="fa fa-envelope-o"></i> info@crescent.com
          </p>
          <p><i class="fa fa-clock-o"></i>
            月-金曜日: 9:00 AM to 5:00 PM</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 hidden-sm hidden-xs contactleft">
            <div class="contact-img">
            <img src="images/contact.jpg">
            </div>
          </div>
          <div class="col-md-8">
            <h3 class="page-header">Send Message</h3>
                   <?php if(isset($errorName)):?>
            		<p><?php  h($errorName);?></p>
            		<?php endif; ?>
                   <?php if(isset($errorKana)):?>
            		<p><?php  h($errorKana);?></p>
            		<?php endif; ?>
                    <?php if(isset($errorEmail)):?>
            		<p><?php h($errorEmail);?></p>
            		<?php endif; ?>
                    <?php if(isset($errorMessage)):?>
            		<p><?php h($errorMessage);?></p>
            		<?php endif; ?>
            <form class="form-horizontal" action="" method="post">
              <div class="form-group">

                <label for="inputname" class="col-sm-3 control-label">お名前<span>(必須)</span></label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="inputname" name="name" value="<?php h($name); ?>" required>
                  <p class="help-block">(例)山田　太郎</p>
                </div>
              </div>

              <div class="form-group">
                <label for="inputkana" class="col-sm-3 control-label">フリガナ<span>(必須)</span></label>
                <div class="col-sm-9">

            	 <input type="text" class="form-control" id="inputkana" name="kana" value="<?php h($kana); ?>" required>
                  <p class="help-block">(例)ヤマダ　タロウ ※全角カタカナ</p>
                </div>
              </div>
              <div class="form-group">
                <label for="inputemail" class="col-sm-3 control-label">メールアドレス<span>(必須)</span></label>
                <div class="col-sm-9">

                  <input type="email" class="form-control" id="inputemail" name="email" value="<?php h($email); ?>" required>
                  <p class="help-block">(例)abc@zz.com ※半角英数字</p>
                </div>
              </div>
              <div class="form-group">
                <label for="inputtel" class="col-sm-3 control-label">電話番号</label>
                <div class="col-sm-9">
                  <input type="tel" class="form-control" id="inputtel" name="tel" value="<?php h($tel); ?>">
                  <p class="help-block">(例)03-1234-3214　※ハイフンあり　半角数字</p>
                </div>
              </div>
              <div class="form-group">
                <label for="inputmessage" class="col-sm-3 control-label">お問い合わせ内容<span>(必須)</span></label>
                <div class="col-sm-9">
                  <textarea rows="10" cols="100" class="form-control" id="message"  name="message" required maxlength="999" style="resize:none"><?php h($message); ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-10">

                  <p><input type="submit" value="確認して送信する"></input></p>
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
                <li><a href="about.html">ABOUT</a></li>
                <li><a href="news.php">NEWS</a></li>
                <li><a href="shop.html">ONLINE SHOP</a></li>
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
    </body>
    </html>