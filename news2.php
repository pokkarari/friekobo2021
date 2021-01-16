<?php
require_once 'util.inc.php';
require_once 'db.inc.php';

try{
    $pdo = db_init();
    // newsテーブルからデータの取得
    // CURDATE()は現在の日時を取得
    // ⇒現在の日付以前の新着情報のみ表示
    // ⇒あらかじめ先々の新着情報をいれておける
    $sqi = "SELECT *FROM news
            WHERE posted <= CURDATE()
            ORDER BY posted DESC
            LIMIT 0, 5";
    $stmt = $pdo -> query($sqi);
    $newsList = $stmt -> fetchAll(PDO::FETCH_ASSOC);
//     var_dump($newsList);

}
catch(PDOException $e){
    echo $e -> getMessage();
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ねことろう画のエフリエこうぼう</title>
    <meta name="description" content="ねこのろう画の絵とハンドメイド作品を制作しているエフリエこうぼうです。">
    <meta name="robots" content="noindex,nofollow,noarchive" />
<!-- 検索エンジンに検索されないようにする -->
    <link rel="icon" type="images/png" href="images/favicon.png">
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css"><!-- リセットcss-->
    <link rel="stylesheet" href="css/menu_style.css">
    <link rel="stylesheet" href="css/layout.css">
<!--     <link rel="stylesheet" href="css/layout_tb.css"> -->
    <link rel="stylesheet" href="css/layout_sp.css">
    <link rel="stylesheet" href="css/news.css">


    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet"><!-- フォントアイコン-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script><!--JQueryプラグイン-->
<script type="text/javascript">
$(function(){

});
</script>
</head>

<body id="news" class="page news_page">

        <header class="page-header wrapper">
    <!-- ここからハンバーガーメニュー -->
            <div class="hb-menu">
                <div class="logo">
                </div><!-- /. logo-->
                <!-- ハンバーガーメニューの部分 -->
                <div class="drawer">
                  <input type="checkbox" id="drawer-check" class="drawer-hidden">
                  <!-- ハンバーガーアイコン-->
                  <label for="drawer-check" class="drawer-open"><span><p class="hb-menu-moji">MENU</p></span></label>
                  <!-- メニュー -->
                  <nav class="drawer-content">
                    <div class="hb-menu-logo">
                      <a href="index.html"><img src="images/kobo-logo.svg" alt=""></a>
                    </div><!-- /.hb-menu-logo -->
                  <ul class="drawer-list">
                    <li class="drawer-item"><a href="">Home <span>ホーム</span></a></li>
                    <li class="drawer-item"><a href="news.php">News <span>おしらせ</span></a></li>
                    <li class="drawer-item"><a href="">Gallery <span>ギャラリー</span></a></li>
                    <li class="drawer-item"><a href="">How To <span>ろう画ってなに？</span></a></li>
                    <li class="drawer-item"><a href="">About <span>エフリエこうぼうについて</span></a></li>
                    <li class="drawer-item"><a href="">Contact <span>お問い合わせ</span></a></li>
                    <li class="drawer-item"><a href="">Blog <span>ブログ</span></a></li>
                  </ul><!-- /.drawer-list -->
                    <div class="hb-menu-bg">
                      <img src="images/home-suzume2.png" alt="">
                    </div><!-- /.hb-menu-bg -->
                  </nav><!-- /.drawer-content -->

                </div> <!-- /.drawer -->
            </div>

        </header>

    <div class="news-contents wrapper">
      <article>
            <header class="post-info">
                <p class="post-date">2020年3月30日 <span></span></p>
                <h2 class="post-title">ろう画作品を追加しました</h2>
                <p class="post-cat">カテゴリー : ギャラリー</p>
            </header>
            <img src="images/wall.jpg" alt="店内の様子">
      <p>絵画の技法であるろう画は自分でも予想を超えた作品になることが魅力の一つです。ろう画からオリジナルキャラクターは「ウォネとその他の皆さんその他のみなさん」は生まれました。そこからねこのオリジナルキャラクターを描き始めたことで作品の世界が広がり、ろう画やハンドメイド作品を持ってイベントに参加してきました。展示会にも参加。オンラインショップの展開作業中です。
        <br>オリジナルキャラクターは「ウォネとその他の皆さんその他のみなさん」。

      </p>
      <p>体に優しい自然食を提供する、WCB
      </p>
        </article>

        <aside>
            <h3 class="sub-title">カテゴリー</h3>
            <ul class="sub-menu">
                <li><a href="#">出展情報</a></li>
                <li><a href="#">作品ギャラリー</a></li>
                <li><a href="#">イベント</a></li>
                <li><a href="#">ろう画とは</a></li>

            </ul>
            <h3 class="sub-title">こうぼうとろう画 </h3>
            <p>
                自分でも予想を超えた作品になることが魅力の一つである、絵画の技法のろう画。ろう画からオリジナルキャラクター「ウォネとその他の皆さんその他のみなさん」は生まれました。
                <br>さまざまな表情のねこや動物たちの表情から、見た方が笑顔になってもらえたらと言う思いで描いています。
            </p>
        </aside>
    </div><!-- /.news-contents -->

<footer>
    <div class="wrapper">
        <p><small>&copy; 2020 FRiekobo</small></p>
    </div>
</footer>


</body>
</html>