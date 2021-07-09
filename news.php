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
            LIMIT 0, 10";
    $stmt = $pdo -> query($sqi);
    $newsList = $stmt -> fetchAll(PDO::FETCH_ASSOC);

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

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scroll/16.1.0/smooth-scroll.min.js"></script><!--スクロールでページトップへ-->
    <script src="https://unpkg.com/scrollreveal"></script><!-- //−−スクロールでスライド-->
<script type="text/javascript">
$(function(){

});
</script>
</head>

<body>


        <header class="page-header ">
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
                    <li class="drawer-item"><a href="index.html">Home <span>ホーム</span></a></li>
                    <li class="drawer-item"><a href="news.php">News <span>おしらせ</span></a></li>
                    <li class="drawer-item"><a href="gallery.html">Gallery <span>ギャラリー</span></a></li>
                    <li class="drawer-item"><a href="howto.html">How To <span>ろう画ってなに？</span></a></li>
                    <li class="drawer-item"><a href="about.html">About <span>エフリエこうぼうについて</span></a></li>
                    <li class="drawer-item"><a href="contact.php">Contact <span>お問い合わせ</span></a></li>
                    <li class="drawer-item"><a href="">Blog <span>ブログ</span></a></li>
                  </ul><!-- /.drawer-list -->
                    <div class="hb-menu-bg">
                      <img src="images/home-suzume2.png" alt="">
                    </div><!-- /.hb-menu-bg -->
                  </nav><!-- /.drawer-content -->
                </div> <!-- /.drawer -->
            </div><!-- hb-menu -->
        </header>



<main>
    <div id="news" class="big-bg">
        <div class="page-top-img wrapper">
            <h1 class="page-top-title">
                <a href="index.html"><img src="images/kobo-logo.svg" alt=""></a></h1>
            <div class="howto-top-title">
              <h2><img src="images/news/news-title.png" alt="NEWS"></h2>
            </div>
        </div><!-- /.page-top-img -->
    </div><!-- /#news /.big-bg -->

<!-- ぶらし絵 -->
    <div class="top-brush">
        <img src="images/howto/howto-top-bursh.png" alt="">
    </div>

        <article class="wrapper">
<!-- ここからがおしらせリスト-->
          <section class="news-list">
                <?php foreach ($newsList as $news): ?>
            <div class="news-category-end">
<!-- カテゴリーと日付 -->
                <div class="news-contents">
                    <div class="news-cat-mark">
                            <p><?php h($news["category"]); ?></p>
<!--                             <?php if(isset($news["category"])): ?>
                            <a href="<?php h($news["category"]); ?>.html">
                            <p><?php h($news["category"]); ?></p></a>
                        <?php else: ?>
                            <p><?php h($news["category"]); ?></p>
                        <?php endif; ?> -->
                    </div><!--/.news-cat-mark -->
                    <div class="news-date">
                        <p><?php
                            $d = new DateTime($news["posted"]);
                            $fmt = $d -> format("Y年m月j日"); ?>
                            <?php h($fmt); ?>
                        </p>
                    </div><!-- /.news-date -->
                </div><!-- /.news-contents -->
<!-- タイトル -->
                <div class="news-title">
                    <h3><?php h($news["title"]); ?></h3>
                </div><!-- news-title -->
<!-- 画像-->
                <div class="news-list-img">
                    <?php if(isset($news["image"])): ?>
                        <img class="news-media-object" src="images/press/<?php h($news["image"]); ?>" alt="おしらせ写真">
                    <?php else: ?>
               	        <img class="news-media-object-none" src="images/news_coler.png" alt="">
                    <?php endif; ?>
                </div><!-- news-list-image -->
<!-- お知らせの中身 -->
                <div class="news-massage">
                    <p><?php h($news["message"]); ?></p>
                </div><!-- news-massage -->
<!-- 区切り -->
            </div>
                   <?php endforeach; ?>

                </section>

            </article><!-- #news -->


<!-- （ページの数字） -->

<!-- サイド -->
            <aside class="news-category-aside">
<!-- 年別一覧 -->
                <h3 class="news-yaer-title category-title">年別一覧</h3>
                <ul class="news-yaer-menu">
                    <li><a href="#"><p>2021年</p></a></li>
                </ul>
<!-- カテゴリー一覧 -->
                <h3 class="news-cat-title category-title">カテゴリー一覧</h3>
                <ul class="news-cat-menu">
                    <li class="news-cat-mark"><a href="#"><p >おしらせ</p></a></li>
                    <li class="news-cat-mark"><a href="#"><p>ひとこと</p></a></li>
                </ul>
            </aside>

        </div><!-- #news -->
    </main><!-- /ここまでがいるもの 現在のところ数は無限-->

    <div class="sns-area wrapper">
        <p class="home-topmark"><a href="#">▲トップへ</a></p>
        <img class="sns-fish" src="images/hikousen1.png" alt="">
        <div class="sns-bt">
            <p>FRIE KOBO OFFICIAL</p>
            <ul class="sns-bt-nav">
                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                <li><a href="#"><i class="fab fa-youtube"></i></a></li>
            </ul><!-- /.sns-bt-nav -->
        </div><!-- /.sns-bt -->
        <div class="sns-blog">
            <img src="images/home-blog-bar.png" alt="">
        </div>
    </div><!-- /.home-sns-area -->

    <div class="home-sns-bg">
        <a href="#"><img src="images/home-footer.jpg" alt=""></a>
    </div>

    <footer>
        <div class="wrapper">
            <p><small>&copy; 2020 FRieKobo</small></p>
        </div>
    </footer>

    <script src="js/script.js"></script>
</body>
</html>