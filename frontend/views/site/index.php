
 <style type="text/css">
.container-fluid{width: 80%;}
.swiper-button-next{right: 100px;}
.swiper-button-prev{left: 100px;}
.download{max-width: 680px;margin: 0 auto 60px;}
.cta-section .download .download-list{line-height: 150px;text-align: right;}
.cta-section .download{margin-bottom: 160px;}
.quote-container p{color: #fff;}
.download .quote-container p{color: #646464;}
</style>

    <style>
 .swiper-container{
	padding-top:40px; 
	padding-bottom: 40px;
 }
    .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;
        
        /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }
    #fullpage{
			padding-top:50px;
			padding-bottom:50px;    
    }
    </style>
  <!-- ******Promo Section****** -->
  
  <!--//promo-->
  <!-- ******Benefit-1 Section****** -->


        <div class="container text-center">
            <div class="content">
              <div class="content-inner">
               <div class="title black_logo">
                <h3> <img src="/images/top.png" width="980" height="162"></h3>
                </div>
              <div class="testimonial text-center ">
									<ul class="nav nav-tabs">
                                <li><a href="https://itunes.apple.com/us/app/spotter-instant-spotlight/id1058123052?&mt=8"><img alt="Download from App Store" src="../images/btn-app-store.png" class="img-responsive"></a></li>
                                <li><a href="/download/android"><img alt="Download from Google Play" src="../images/btn-google-play.png" class="img-responsive"></a></li>
                            </ul>
            </div>      
              </div>

            
            <!--//phone-holder-->
        </div>
        <!--//container-->
      </div>
      <!--//section-inner-->

 	    <div class="container swiper-container" >
        <div class="swiper-wrapper">
        <?php foreach($features as $i=>$v):?>
            <div class="swiper-slide"><img alt="" src="/images/softimg/<?=Yii::$app->language?>/1<?=$i?>.jpg" class="img-responsive" width="100%" height="auto" class="swiper-lazy"></div>
            <?php endforeach;?>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>
 </div>
<footer class="text-center">
        <div class="footer-above">
            <div class="container">
                <div class="row">
                    <div class="footer-col col-md-4">
                        <h3><a href="/static/Spotter_Privacy_Policy.pdf"><?=Yii::t('app','Privacy Policy')?></a></h3>
                       
                    </div>
                    <div class="footer-col col-md-4">
                        <h3><a href="/static/Spotter_Terms_of_Service .pdf"><?=Yii::t('app','Terms of Service')?></a></h3>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3><a href="/"><?=Yii::t('app','About US')?></a></h3>
                        </div>
                </div>
            </div>
        </div>
        <div class="footer-below">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                       &copy; <?php echo date('Y');?> <?=$_SERVER['HTTP_HOST']?> <a href="http://www.miibeian.gov.cn">沪ICP备16037896号</a
                    </div>
                </div>
            </div>
        </div>
    </footer>

  <!--//cta-section-->
  <script type="text/javascript" src="/js/swiper.min.js"></script>
  <script type="text/javascript">
      var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        slidesPerView: 3,
        paginationClickable: true,
        spaceBetween: 30,
        preloadImages: false,
        // Enable lazy loading
        lazyLoading: true,
       autoplay : 3000,
		 speed:500,
		 loop:true,
    });
  </script>
