<link rel="stylesheet" type="text/css" href="/css/cart.css?v=<?=time()?>" />
<header id="header">
    <h1>订单详情</h1>
</header>

    <section id="list" class="list">
        <?php foreach($goods as $k=>$v):?>
            <div class="shop-group-item">
                    <div class="shp-cart-item-core shop-cart-display  ">
                        <a class="cart-product-cell-1" href="javascript:void();">
                            <img class="cart-photo-thumb" alt="" onerror="this.classList.add('err-img-hidden');" style="opacity: 1;" src="<?=$v['Images']?>"></a>
                        <div class="cart-product-cell-2">
                            <div class="cart-product-name">
                                <a href="javascript:void(0);">
                                    <span class="non-fresh-txt">
                                        <?=$v[ 'CName']?></span>
                                </a>
                            </div>
                            <div class="cart-product-prop eles-flex">
                                <span class="prop1">规格:
                                    <?=$v[ 'Unit']?></span>
                                <!-- <span class="prop2">尺码:120码建议身高110CM左右</span> --></div>
                            <div class="icon-list">
                                <!-- 通用标签优先级，满件起购，降价，白条--></div>
                            <!-- price move here begin-->
                            <div class="cart-product-cell-3">
                                <input type="hidden" id="goods<?=$v['COID']?>" data-price="<?=$v['Price']?>" data-count="<?=$v['Count']?>" data-coid="<?=$v['COID']?>">
                                <span class="shp-cart-item-price ">¥
                                    <strong><?=$v['Price']?></strong></span>
                                <span class="right-text">
                                   数量:<strong><?=$v['Count']?></strong>
                                </span>
                            </div>
                        </div>
                    </div>
            </div>
      <?php endforeach;?>
    </section>

<footer id="footer">
    <ul>
        <li>
            <div class="footer-good-total-price">
                <div class="icon-badge" id="totalnum"><?=$totalnum?></div>件商品:¥
                <span id="totalprice"><?=$totalprice?></span></div>
            <div class="footer-good-total-save">为您节省：¥
                <span id="saveprice">0</span></div>
        </li>
        <li>
            <button id="payBtn" class="pay-btn pay-btn-ok">支付完成</button></li>
    </ul>
</footer>

