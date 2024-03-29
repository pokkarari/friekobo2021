// adobeのフォントファミリー追加スクリプト
  (function(d) {
    var config = {
      kitId: 'lvo0rlc',
      scriptTimeout: 3000,
      async: true
    },
    h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
  })(document);

//フォント読みこのちらつき防止用で、Web フォントのロードが完了しない場合の対策用
setTimeout(function() {
    if (document.getElementsByTagName("html")[0].classList.contains('wf-active') != true) {
        document.getElementsByTagName("html")[0].classList.add('loading-delay');
    }
}, 3000);

// スムーススクロールsmooth-scroll.min.js
        var scroll = new SmoothScroll('a[href^="#"]', {
        speedAsDuration:true,
        speed:1000,
        easing:'easeInOutQuint' // イージングも使えるよ！
        });

// AOSを実行させる フェードやスクロールで表示するスクリプト
    AOS.init({
      // once: ture
    });

// スクロールでスライドscrollreveal
$(function(){
    ScrollReveal().reveal('.animate');
    // ScrollReveal().reveal('.animateright', { distance: '50px', origin: 'right', viewFactor: '0.2' });
    ScrollReveal().reveal('.animateleft', { distance: '200px', origin: 'left', viewFactor: '0.2' });
    ScrollReveal().reveal('.animateslow', { duration: '500', reset: 'true'});
    ScrollReveal().reveal('.animatespeed1', { duration: '1800' } );
    ScrollReveal().reveal('.animatespeed2', { duration: '1800' ,delay: '500'} );
    ScrollReveal().reveal('.animatespeed3', { duration: '1800' ,delay: '1000'} );
    ScrollReveal().reveal('.animatetop', { distance: '100px', origin: 'top',duration: '2000'});
    ScrollReveal().reveal('.text6', {   duration: 1600,  scale: 0.1,  reset: 'true'});
});

//ハンバーガーメニューの時に背景をスクロールさせない




// 作品画像の拡大表示 プラグインColorBox
$(function() {
  $(".home-gallery-works").colorbox({
    maxWidth:"90%",
    maxHeight:"90%",
    opacity: 0.7
  });
});


// ギャラリーの表示 slick
// $('.slick01').slick({

// });
// ブレイクポイントによって画像数が変化
// $(function(){
//   $('.home-gallry-works01').slick({
//     dots: true,
//     infinite: false,
//     speed: 300,
//     slidesToShow: 5,
//     slidesToScroll: 4,
//     responsive: [
//       {
//         breakpoint: 480,
//         settings: {
//           slidesToShow: 3,
//           slidesToScroll: 3,
//           infinite: true,
//           dots: true
//         }
//       },
//       {
//         breakpoint: 768,
//         settings: {
//           slidesToShow: 3,
//           slidesToScroll: 3
//         }
//       },
//       {
//         breakpoint: 1024,
//         settings: {
//           slidesToShow: 3,
//           slidesToScroll: 3
//         }
//       }
//       // You can unslick at a given breakpoint now by adding:
//       // settings: "unslick"
//       // instead of a settings object
//     ]
//   });
// });