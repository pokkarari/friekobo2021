<?php
require_once '../util.inc.php';
require_once '../db.inc.php';

//アップロード先の定義
const IMAGE_PATH ="../images/press/";

// キャンセルボタン
if(isset($_POST["cancel"])){
    header("Location: index.php");
    exit;
}
// 1件分のデータを取得
try {
    $pdo = db_init();
    $sql = "SELECT * FROM news
            WHERE id = ?";
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute([$_GET["id"]]);
    $news = $stmt -> fetch(PDO::FETCH_ASSOC);

    // 出力用に配列データを個別の変数に格納する
    $posted = $news["posted"];
    $title = $news["title"];
    $message = $news["message"];
    $image = $news["image"];
}
catch (PDOException $e) {
    echo $e -> getMessage();
}

// データの編集
if(isset($_POST["save"])){
    // ①バリデーション
    $posted = $_POST["posted"];
    $title = $_POST["title"];
    $message = $_POST["message"];

    $isValidated = true;

    if($posted === ""){
        // 日付がからの場合は、falseにはせずに、現在の日付を入れる
        $posted = date("Y-m-d");
    }
    elseif(!preg_match("/^\d{4}-\d{2}-\d{2}$/", $posted)){
        $isValidated = false;
        $errorPosted = "※日付は「0000-00-00」で入力してください";
    }

    if($title === ""){
        $isValidated = false;
        $errorTitle = "タイトルを入力してください";
    }

    if($message === ""){
        $isValidated = false;
        $errorMessage = "お知らせを入力してください";
    }

    //　②画像のアップロード
    $imgName = $_FILES["image"]["name"];
    $imgTmp  = $_FILES["image"]["tmp_name"];
    $imgError = $_FILES["image"]["error"];

    if($imgError == UPLODAE_ERR_OK) {
        //問題なし　→一時ファイル置き場から移動

        //画像ファイルかどうかのチェック
        //ファイルサイズが○○以下か？
        //ファイル名が重複したときの処理

        $destination =IMAGE_PATH . $imgName;
        $result = move_uploaded_file($imgTmp, $destination);
        if($result == false){
            $isValidated = false;
            $errorImage = "アップロードに失敗しました";
        }

    }
    elseif($imgError == UPLOAD_ERR_NO_FILE){
        // 画像未選択の場合
        $imgName = $image;
    }

    else{
        //アップロード失敗の場合
        $isValidated = false;
        $errorImage = "アップロードに失敗しました";
        echo "アップロード失敗";

    }
    // ③バリデーションOKの場合
    if($isValidated == true){
        //         echo "バリデーションOK";
        // 1.データの更新
        try {

            $sql = "UPDATE news
                        SET
                        posted = ?,
                        title = ?,
                        message = ?,
                        image = ?
                        WHERE id = ?";
            $stmt = $pdo -> prepare($sql);
            $stmt -> execute([$posted, $title, $message, $imgName,$_GET["id"]]);

        }
        catch (PDOException $e) {
            echo $e -> getMessage();
        }
        // 2　完了画面に遷移
        header("Location: news_edit_done.php");
        exit;
    }

}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>お知らせの編集 | エフリエこうぼう 管理</title>
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
    <h1>お知らせの編集</h1>
    <p>情報を入力し、「保存」ボタンを押してください。</p>
    <form action="" method="post" enctype="multipart/form-data">
    <table>
      <tr>
        <th class="fixed">日付(任意)</th>
        <td>
        <?php if(isset($errorPosted)): ?>
          <div class="error"><?php h($errorPosted); ?></div>
         <?php endif; ?>
          <input type="date" name="posted" value="<?php h($posted); ?>">
        </td>
      </tr>
      <tr>
        <th class="fixed">タイトル</th>
        <td>
         <?php if(isset($errorTitle)): ?>
          <div class="error"><?php h($errorTitle); ?></div>
         <?php endif; ?>
          <input type="text" name="title" size="80" value="<?php h($title); ?>">
        </td>
      </tr>
      <tr>
        <th class="fixed">お知らせの内容</th>
        <td>
          <?php if(isset($errorMessage)): ?>
          <div class="error"><?php h($errorMessage); ?></div>
         <?php endif; ?>
          <textarea name="message" cols="80" rows="5"><?php h($message); ?></textarea>
        </td>
      </tr>
      <tr>
     	<th class="fixed">画像（任意）</th>
      	<td>
      		<input type="file" name="image">
      		<?php if(isset($image)): ?>
      	<div><img src="../images/press/<?php h($image); ?>" width="64" height="64" alt=""></div>
      <?php endif; ?>
      </td>
      </tr>
    </table>
    <p>
      <input type="submit" name="save" value="保存">
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