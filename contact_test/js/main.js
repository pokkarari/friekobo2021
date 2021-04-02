/* jshint devel:true */
//console.log('\'Allore \'Allore!');

  $(function() {
            'use strict';
      // スクロールしたときに実行
      $(window).scroll(function () {

         // 目的のスクロール量を設定(px)
         var TargetPos = 250;
         // 現在のスクロール位置を取得
         var ScrollPos = $(window).scrollTop();
         // 現在位置が目的のスクロール量に達しているかどうかを判断
         if( ScrollPos >= TargetPos) {
            // 達していれば表示
            $('.pagetop').fadeIn();
         }
         else {
            // 達していなければ非表示
            $('.pagetop').fadeOut();
         }
      });
   });

$(function() {
    'use strict';
    $('img.thumb').mouseover(function(){
        // "_thumb"を削った画像ファイル名を取得
        var selectedSrc = $(this).attr('src').replace(/^(.+)_thumb(\.gif|\.jpg|\.png+)$/, '$1'+'$2');

        // 画像入れ替え
        $('img.mainImage').stop().fadeOut(50,
            function(){
                $('img.mainImage').attr('src', selectedSrc);
                $('img.mainImage').stop().fadeIn(200);
            }
        );
        // サムネイルの枠を変更
        $(this).css({'border':'1px solid #cccccc'});
    });

    // マウスアウトでサムネイル枠もとに戻す
    $('img.thumb').mouseout(function(){
        $(this).css({'border':''});
    });
});

$(function(){
	// プラスボタンで数量増
    $('.fa-plus').parent().click(function(){
        var newValue = parseInt($('input[name="quantity"]').val()) + 1;
        $('input[name="quantity"]').val(newValue);
        return false;
    });
    
    // マイナスボタンで数量減
    $('.fa-minus').parent().click(function(){
        var newValue = parseInt($('input[name="quantity"]').val()) - 1;
        if(newValue >= 1){
          $('input[name="quantity"]').val(newValue);
        }
        return false;
    });

});