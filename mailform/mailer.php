
<?php
//セッションを開始            ・・・①
session_start();
// パラメータ取得
$request_param = $_POST;
// お問い合わせ日時
$request_datetime = date("Y年m月d日 H時i分s秒");

//自動返信メール
$mailto = $request_param['email'];
$to = '自身のメールアドレス'; //ここを入力
$mailfrom = "From:自身のメールアドレス"; //ここを入力

//問い合わせ相手への送信メール
$subject1 = "お問い合わせ有難うございます。";
$content = "";
$content .= $request_param['name']. "様\r\n";
$content .= "お問い合わせ有難うございます。\r\n";
$content .= "お問い合わせ内容は下記通りでございます。\r\n";
$content .= "=================================\r\n";
$content .= "お名前        " . htmlspecialchars($request_param['name'])."\r\n";
$content .= "メールアドレス   " . htmlspecialchars($request_param['email'])."\r\n";
$content .= "題名   " . htmlspecialchars($request_param['subject'])."\r\n";
$content .= "内容   " . htmlspecialchars($request_param['message'])."\r\n";
$content .= "お問い合わせ日時   " . $request_datetime."\r\n";
$content .= "=================================\r\n";

//管理者確認用メール
$subject2 = "お問い合わせがありました。";
$content2 = "";
$content2 .= "お問い合わせがありました。\r\n";
$content2 .= "お問い合わせ内容は下記通りです。\r\n";
$content2 .= "=================================\r\n";
$content2 .= "お名前       " . htmlspecialchars($request_param['name'])."\r\n";
$content2 .= "メールアドレス   " . htmlspecialchars($request_param['email'])."\r\n";
$content2 .= "題名   " . htmlspecialchars($request_param['subject'])."\r\n";
$content2 .= "内容   " . htmlspecialchars($request_param['message'])."\r\n";
$content2 .= "お問い合わせ日時   " . $request_datetime."\r\n";
$content2 .= "================================="."\r\n";

mb_language("ja");
mb_internal_encoding("UTF-8");
//mail 送信
if (isset($_POST["csrf_token"])                            ・・・②
 && $_POST["csrf_token"] === $_SESSION['csrf_token']) {    ・・・②
  if( filter_var( $mailto, FILTER_VALIDATE_EMAIL ) ){
    if(mb_send_mail($to, $subject2, $content2, $mailfrom)){
      mb_send_mail($mailto,$subject1,$content,$mailfrom);
      ?>
      <script>
         window.location = '../mail-send-end.html';
      </script>
      <?php
    } else {
      header('Content-Type: text/html; charset=UTF-8');
      echo "メールの送信に失敗しました";
    };
  } else {
    header('Content-Type: text/html; charset=UTF-8');
    echo "メールアドレスの形式が正しくありません";
  };
} else {
  cho "メールアドレスの形式が正しくありません";
  };
} else {
  echo "メールの送信に失敗しました（トークンエラー）";
}
 ?>