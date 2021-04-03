<?php
//実行検証済み


// HPMailer のクラスをグローバル名前空間（global namespace）にインポート
// スクリプトの先頭で宣言する必要があります
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';
//エラーメッセージ用日本語言語ファイルを読み込む場合
require 'language/phpmailer.lang-ja.php';

require 'phpmailvars.php';


//言語、内部エンコーディングを指定
mb_language("japanese");
mb_internal_encoding("UTF-8");

// インスタンスを生成（引数に true を指定して例外 Exception を有効に）
$phpmail = new PHPMailer(true);

//日本語用設定
$phpmail->CharSet = "iso-2022-jp";
$phpmail->Encoding = "7bit";

//エラーメッセージ用言語ファイルを使用する場合に指定
$phpmail->setLanguage('ja', 'vendor/phpmailer/phpmailer/language/');

try {
  //サーバの設定
  $phpmail->SMTPDebug = SMTP::DEBUG_SERVER;  // デバグの出力を有効に（テスト環境での検証用）
  $phpmail->isSMTP();   // SMTP を使用
  $phpmail->Host = MAIL_HOST; // SMTP サーバーを指定（phpmailvars.phpで定義）
  $phpmail->SMTPAuth = true; // SMTP authentication を有効に
  $phpmail->Username = MAIL_USER; // SMTP ユーザ名（phpmailvars.phpで定義）
  $phpmail->Password = MAIL_PASSWORD; // SMTP パスワード（phpmailvars.phpで定義）
  $phpmail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  // 暗号化を有効に
  $phpmail->Port       = 465;  // TCP ポートを指定

  //------------受信者設定-----------
  //※名前などに日本語を使う場合は文字エンコーディングを変換
  //差出人アドレス, 差出人名
  $phpmail->setFrom('MAIL_USER', mb_encode_mimeheader('差出人名'));
  //受信者アドレス, 受信者名（受信者名はオプション）
  //$phpmail->addAddress('someone@xxxx.com', mb_encode_mimeheader("受信者名"));
  //追加の受信者（受信者名は省略可能なのでここでは省略）
  //$phpmail->addAddress('someone@gmail.com');
  //返信用アドレス（差出人以外に別途指定する場合）
  //$phpmail->addReplyTo('info@example.com', mb_encode_mimeheader("お問い合わせ"));
  //Cc 受信者の指定
  //$phpmail->addCC('foo@example.com');

  //----------コンテンツ設定--------------
  //$phpmail->isHTML(true);   // HTML形式を指定
  //メール表題（文字エンコーディングを変換）
  $phpmail->Subject = mb_encode_mimeheader('日本語メールタイトル');
  //HTML形式の本文（文字エンコーディングを変換）
  $phpmail->Body  = mb_convert_encoding('メッセージ <b>BOLD</b>',"JIS","UTF-8");
  //テキスト形式の本文（文字エンコーディングを変換）
  //$phpmail->AltBody = mb_convert_encoding('テキストメッセージ',"JIS","UTF-8");

  $phpmail->send();  //送信
  echo 'Message has been sent';
} catch (Exception $e) {
  //エラー（例外：Exception）が発生した場合
  echo "Message could not be sent. Mailer Error: {$phpmail->ErrorInfo}";
}