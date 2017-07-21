<link rel="stylesheet" type="text/css" href="/css/cart.css?v=2017071403" />
<header id="header">
    <h1>购物车</h1>
</header>
<form id="cartform" action="/pay/submit" method="post" enctype="multipart/form-data">
    <section id="list" class="list">
        <?php foreach($goods as $k=>$v):?>
            <div class="shop-group-item">
                    <div class="shp-cart-item-core shop-cart-display  ">
                        <a class="cart-product-cell-1" href="javascript:void();">
                            <img class="cart-photo-thumb lazy" data-original="<?=Yii::$app->params['cdn_website'].$v['Images']?>" onerror="this.src='/images/noimage.jpg'" src="/images/noimage.jpg" ></a>
                        <div class="cart-product-cell-2">
                            <div class="cart-product-name">
                                <a href="javascript:void(0);">
                                    <span class="non-fresh-txt">
                                        <?=$v[ 'CName']?></span>
                                </a>
                            </div>
                            <div class="cart-product-prop eles-flex">
                            <span class="prop1 shp-cart-item-price ">¥<strong><?=$v[ 'Price']?></strong></span>
                                <span class="prop2">规格:<?=$v[ 'Unit']?></span>
                                 <!-- <span class="prop2">原价:<span class="line-through"><?=$v['OPrice']?></span> </span>  -->
                                    

                            </div>

                            <!-- <div class="icon-list"><span class="shp-cart-item-price ">¥<strong><?=$v[ 'Price']?></strong></span></div> -->
                            <!-- price move here begin-->
                            <div class="cart-product-cell-3">
                                <input type="hidden" id="goods<?=$v['COID']?>" data-price="<?=$v['Price']?>" data-count="<?=$v['Count']?>" data-coid="<?=$v['COID']?>" data-oprice= "<?=$v['OPrice']?>">
                                    <?php if($v['Remark']):?>
                                        <span class="cart-product-compare">比<?=$v['Remark']?>: </span><span class="shp-cart-item-price " style="font-size: 14px;">-¥<strong><?=$v['RemarkValue']?></strong></span>
                                    <?php endif;?>
                                <div class="quantity-wrapper customize-qua">
                                    <a class="quantity-decrease" href="javascript:void(0);" data-coid="<?=$v['COID']?>">
                                        <div class="reducebtn">-</div></a>
                                        <?php if($v['COID'] == $cid):?>
                                            <input type="tel" size="4" readonly="readonly" value="1" name="num[<?=$v['STID']?>][<?=$v['COID']?>]" id="num<?=$v['COID']?>" class="quantity" data-coid="<?=$v['COID']?>" onchange="updateTotalPrice()">
                                        <?php else:?>

                                    <input type="tel" size="4" readonly="readonly" value="0" name="num[<?=$v['STID']?>][<?=$v['COID']?>]" id="num<?=$v['COID']?>" class="quantity" data-coid="<?=$v['COID']?>" onchange="updateTotalPrice()">
                                <?php endif;?>
                                    <a class="quantity-increase" href="javascript:void(0);" data-coid="<?=$v['COID']?>">
                                        <div class="addbtn">+</div></a>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
      <?php endforeach;?>
    </section>
    <input name="_csrf" type="hidden" value="<?= Yii::$app->request->csrfToken ?>">
    <input name="token" type="hidden" id="hidtoken">
    <input name="payment_type" type="hidden" id="hidpaymenttype" value="1">
</form>
<footer id="footer">
    <ul>
        <li>
            <div class="footer-good-total-price">
                <div class="icon-badge" id="totalnum">0</div>件商品:¥
                <span id="totalprice">0</span></div>
            <div class="footer-good-total-save">为您节省：¥
                <span id="saveprice">0</span></div>
        </li>
        <li>
            <button id="payBtn" class="pay-btn">付 款</button></li>
    </ul>
</footer>
<script type="text/javascript">
    var cid = <?=$cid?>;
    var cartconfig=<?=$cartconfig?>;
</script>
<script type="text/javascript" src="/js/lazyload.min.js"></script>
<script type="text/javascript" src="/js/aui-toast.js"></script>
<script type="text/javascript" src="/js/base.min.js"></script>
<script type="text/javascript" src="/js/layer.js"></script>
<script type="text/javascript" src="/js/cart.min.js?v=2017071402"></script>



