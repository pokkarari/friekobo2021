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
    <div id="news" class="news_page big-bg">

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
            </div><!-- hb-menu -->
        </header>

        <div class="news-titile wrapper">
            <img src="images/kobo-logo.svg" alt="">
            <h2 class="page-title">News</h2>
        </div><!-- /.wrapper -->
    </div><!--/#news /.news_page big-bg-->


     <main>
        <div class="news-contents wrapper">
          <article class="news-list">    <!-- ここからがおしらせリスト-->
                <?php foreach ($newsList as $news): ?>
                <div class="post-info"><!-- 日にち・タイトル-->
                    <?php if(isset($news["category"])): ?>
                    <a href="<?php h($news["category"]); ?>.html">
                        <p class="post-date"><?php
                            $d = new DateTime($news["posted"]);
                            $fmt = $d -> format('Y年m月d日') ?>
                            <?php h($fmt); ?> <span></span></p>
                    	<h4 class="post-title">
                            	<?php h($news["title"]); ?></h4></a>
                        <?php else: ?>
                            <p class="post-date"><?php
                                $d = new DateTime($news["posted"]);
                                $fmt = $d -> format('Y年m月d日') ?>
                                <?php h($fmt); ?> <span></span></p>
                            <h4 class="post-title">
                                <?php h($news["title"]); ?></h4>
                        <?php endif; ?>
                </div><!-- /.post-info -->

                <div class="post-cat"><!-- カテゴリー-->
                    <?php if(isset($news["category"])): ?>
                        <p>カテゴリー :<a href="<?php h($news["category"]); ?>.html"><span><?php h($news["category"]); ?></span></a></p>
                    <?php else: ?>
                        <p>カテゴリー :<span><?php h($news["category"]); ?></span></p>
                    <?php endif; ?>
                    </div><!--/.post-cat-->

                <div class="post-massage"><!-- お知らせの中身 -->
                    <p><?php h($news["message"]); ?></p>
                </div>

                <div class="news-list-image"><!-- 画像-->
                    <?php if(isset($news["image"])): ?>
                        <img class="media-object" src="images/press/<?php h($news["image"]); ?>" alt="おしらせ写真">
                    <?php else: ?>
               	        <img class="media-object" src="images/news_coler.png" height="30" width="30" alt="">
                    <?php endif; ?>
                </div>
                   <?php endforeach; ?>
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
                    絵画の技法のろう画。このろう画は、自分でも予想を超えた作品になることが魅力の一つです。<br>さまざまな表情のねこや動物たちから、たくさんの人に笑顔になってもらえたらと言う思いで描いています。笑顔の絵は描いていても、なんだかニヤリとなってしまいます。
                    ろう画からオリジナルキャラクター「ウォネとその他の皆さんその他のみなさん」は生みだし、ハンドメイド作品も手がけています。
                </p>
            </aside>
        </div><!-- /.news-contents -->
    </main><!-- /ここまでがいるもの 現在のところ数は無限-->



    <div class="sns-area wrapper">
        <p class="home-topmark"><a href="#">▲トップへ</a></p>
        <img class="sns-fish" src="images/hikousen1.png" alt="">
        <div class="sns-bt">
            <p>FRIE KOBO OFFICIAL</p>
            <lu class="sns-bt-nav">
                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                <li><a href="#"><i class="fab fa-youtube"></i></a></li>
            </lu><!-- /.sns-bt-nav -->
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