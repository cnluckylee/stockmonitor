
    <link rel="stylesheet" type="text/css" href="/css/cart.css?v=<?=time()?>" />
    <style type="text/css">
    
    header {
        width: 100%;
        height: 50px;
        background-color: #26bcee;
        position: fixed;
        z-index: 100;
    }
    
    header .back {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 80px;
        height: 50px;
        background: url(../image/back.png);
        background-position: 12px 16px;
        background-size: 11px 18px;
        background-repeat: no-repeat;
    }
    
    header h1 {
        width: 100%;
        height: 50px;
        text-align: center;
        color: #fff;
        font-size: 20px;
        line-height: 50px;
    }
    
    section {
        -webkit-box-flex: 1;
        -webkit-flex: 1;
        flex: 1;
        overflow: auto;
    }
    .list {
        display: block;
        position: relative;
        box-sizing: border-box;
        width: 100%;
        height: auto;
        top:50px;
        padding-bottom: 50px;
	    padding-left: 10px;
	    padding-right: 10px;
    }
    
    .ware {
        position: relative;
        width: 100%;
        margin-bottom: 8px;
        background-color: #fff;
    }
    
    .ware .content {
        position: relative;
        box-sizing: border-box;
        width: 100%;
        height: 100%px;
        padding-top: 8px;
        padding-bottom: 8px;
    }
    
    .ware .select {
        position: absolute;
        width: 16px;
        height: 16px;
        top: 56px;
        left: 8px;
        background-repeat: no-repeat;
        background-image: url(../image/select_on.png);
        background-size: 100% 100%;
        background-position: center center;
        z-index: 2;
    }
    
    .ware .select-off {
        background-image: url(../image/select_off.png);
    }
    
    .ware .thumbnail {
        position: absolute;
        top: 14px;
        left: 32px;
        height: 100px;
        width: 100px;
    }
    
    .ware .info {
        position: relative;
        box-sizing: border-box;
        padding-left: 90px;
        width: 100%;
        height: 75px;
        padding-right: 28px;
    }
    
    .ware .info .name,.ware .info .unit,.ware .info .price {
        color: #7b7b7b;
        margin-top: 0.2rem;
        font-size: 0.7rem;
    }
    .ware .info .unit,.ware .info .price{
		font-size: 0.5rem;
		color: #b2b2b2;
    }
    .ware .info .price{
		font-size: 0.8rem;
		color: #f2b961;
    }

    .ware .info .price-tag {
        margin-top: 10px;
        width: 100%;
        height: 12px;
        font-size: 12px;
        vertical-align: top;
    }
    
    .ware .info .price-tag .price {
        color: #e3007f;
    }
    
    .ware .info .price-tag .unit {
        font-size: 8px;
        color: #cbcbcb;
    }
    
    .ware .control {
        position: absolute;
        width: 110px;
        height: 23px;
        top: 35px;
        right: 8px;
    }
    
    .ware .control .minus {
        position: absolute;
        top: 0;
        left: 0;
        width: 23px;
        height: 23px;
        z-index: 2;
    }
    
    .ware .control .count {
        border: 1px solid #ccc;
	    width: 30px;
	    height: 23px;
	    margin: 0 auto;
	    text-align: center;
	    line-height: 23px;
	    font-size: 12px;
    }
    
    .ware .control .add {
        position: absolute;
        top: 0;
        right: 0;
        width: 23px;
        height: 23px;
        z-index: 2;
    }
    
    .empty {
        display: none;
        position: absolute;
        width: 100%;
        height: 100%;
        background-color: #fff;
        background-image: url(../image/shoppingcart_empty.png);
        background-repeat: no-repeat;
        background-size: 115px 190px;
        background-position: center 50px;
    }
    
    .active {
        opacity: 0.7;
    }
    footer {
        width: 100%;
        height: 50px;
        display: -webkit-box;
        display: -webkit-flex;
        display: flex;
        -webkit-box-orient: horizontal;
        -webkit-flex-flow: row;
        flex-flow: row;
        background-color: #26bcee;
        border-top: 1px solid #d1d1d1;
        position: fixed;
        bottom: 0px;
        z-index: 100;

    }

       .control {
        position: relative;
        width: 100px;
        height: 50px;
    }
    
   
    
    .control .info {
        box-sizing: border-box;
        width: 100%;
        height: 50px;
        padding-left: 32px;
        padding-top: 8px;
        padding-bottom: 8px;
    }
    
    .control .info .top {
        height: 20px;
        font-size: 14px;
        color: #444;
        text-align: left;
        line-height: 20px;
    }
    
    .control .info .bottom {
        height: 14px;
        font-size: 10px;
        color: #888;
        text-align: left;
        line-height: 14px;
    }
    
    .panel {
        -webkit-box-flex: 1;
        -webkit-flex: 1;
        flex: 1;
        height: 50px;
    }
    
    .panel .info {
        box-sizing: border-box;
        width: 100%;
        height: 50px;
        padding-top: 8px;
        padding-right: 8px;
    }
    
    .panel .info .top {
        position: relative;
        width: 100%;
        height: 20px;
        text-align: right;
        font-size: 16px;
        color: #444;
        line-height: 20px;
    }
    
    .panel .info .top .amount {
        font-weight: bold;
        color: #e3007f;
    }
    
    .panel .info .bottom {
        position: relative;
        height: 14px;
        font-size: 10px;
        color: #888;
        text-align: right;
        line-height: 14px;
    }
    
    .buy {
        width: 112px;
        height: 50px;
    }
    
    .buy .buy-button {
        width: 112px;
        height: 40px;
        margin-top: 5px;
    }
    
    .highlight {
        opacity: 0.7;
    }
    .thumbnail-div{
    	width: 80px;
	    height: 80px;
	    padding: 10px;
	    border: 1px #f2f2f2 solid;
	    float: left;
    }

    </style>
	<header id="header">
        <div class="back" tapmode="highlight" onclick="api.closeWin();"></div>
        <h1>购物车</h1>
    </header>
    <section id="list" class="list">
<?php for($i=0;$i<10;$i++):?>

    <div id="ware_{{=value.id}}" class="ware">
        <div class="content" tapmode onclick="fnOpenWareWin('{{=value.id}}');">
        <div class="thumbnail-div">
            <img src="/themes/aui/image/demo1.png" width="100%" height="100%">
        </div>    
            <div class="info">
                <div class="name">商品名称</div>
                <div class="unit">规格:个</div>
                <div class="price">￥10.23</div>
            </div>
        </div>
        <div class="control" id="control_{{=value.id}}">
            <img class="minus" src="../image/minus.png" tapmode onclick="fnMinus('{{=value.id}}');">
            <input type="text" class="count" name="" value="1">
            <img class="add" src="../image/add.png" tapmode onclick="fnAdd('{{=value.id}}');">
        </div>
    </div>
  
<?php endfor;?>
</section>
<footer id="footer">
        <div class="control">
            
            <div class="info">
                <div class="top">全选</div>
                <div class="bottom">已选<span id="count" class="count">0</span>件</div>
            </div>
        </div>
        <div class="panel">
            <div class="info">
                <div class="top">总金额:<span id="amount" class="amount">￥0</span></div>
                <div class="bottom">不含运费</div>
            </div>
        </div>
        <div class="buy" tapmode onclick="fnOpenOrderWin();">
            <img class="buy-button" src="../image/buy.png">
        </div>
    </footer>
<script type="text/javascript">
apiready = function() {
    initEventListener();
    getWareListFromDB();
};

var curShoppingCart;

function initEventListener() {
    // 监听购物车更新事件(自定义事件)，同步更新列表展示中选定商品的数量
    api.addEventListener({
        name: 'updateShoppingCart'
    }, function(ret, err) {
        if (ret) {
            if (ret.value) {
                // 获取相应商品元素的信息
                var count = $api.byId('count_' + ret.value.wareId);
                var ware = $api.byId('ware_' + ret.value.wareId);
                if (count && ware) {
                    // 更新商品数量及显示状态
                    count.innerHTML = ret.value.wareCount;
                    ware.style.display = (ret.value.wareCount > 0) ? 'block' : 'none';
                }
            }
        }
    });
}

function getWareListFromDB() {
    var ret = $db.select();
    // 购物车中有商品，则显示商品列表
    if (ret && ret.data.length > 0) {
        fnGetWareList(ret.data);
    } else {
        // 购物车中无商品，则提示用户去购物
        fnShowWareList(false);
    }
}

function fnGetWareList(wareList_) {
    api.showProgress({
        style: 'default',
        animationType: 'fade',
        title: '努力加载中...',
        text: '先喝杯茶...',
        modal: false
    });
    var wares = [];
    for (var i = 0; i < wareList_.length; i++) {
        if (wareList_[i].wareCount != 0) {
            wares.push(wareList_[i].wareId);
        }
    }
    var params = {
        fields: {},
        where: {
            id: {
                inq: wares
            }
        },
        skip: 0,
        limit: wares.length
    }
    params = $api.jsonToStr(params);
    api.ajax({
        url: 'http://d.apicloud.com/mcm/api/ware?filter=' + params,
        method: 'get',
        headers: {
            "X-APICloud-AppId": "A6921544633372",
            "X-APICloud-AppKey": "2672b5911d8551540c1ea598e01c87fee217a1e5.1482500122476"
        }
    }, function(ret, err) {
        if (ret) {
            for (var i = 0; i < ret.length; i++) {
                for (var j = 0; j < wareList_.length; j++) {
                    if (ret[i].id == wareList_[j].wareId) {
                        ret[i].wareCount = wareList_[j].wareCount;
                    }
                }
            }
            api.hideProgress();

            // 显示购物车中的商品列表
            fnUpdateWareListByShoppingCart(ret);

            // 保存为当前页面的购物车信息，便于在当前页面中添加或删除商品是操作
            curShoppingCart = ret;

            // 计算购物车中的商品总数及总金额
            fnGetShoppingCartAmount(ret);
        } else {
            //alert(JSON.stringify(err));
        }
    });
}

function fnUpdateWareListByShoppingCart(data_) {
    var list = $api.byId('list');

    // 编译模板函数
    var tempFn = doT.template($api.byId('template').innerHTML);

    // 使用模板函数生成HTML文本
    var resultHTML = tempFn(data_);
    list.innerHTML = resultHTML;
}

// 计算购物车中的商品总数及总金额
function fnGetShoppingCartAmount(data_) {
    var amountValue = 0;
    var countValue = 0;
    var offState = 0;
    for (var i = 0; i < data_.length; i++) {
        if (data_[i].wareState == 'off') {
            if (data_[i].wareCount > 0) {
                offState += 1;
            }
            continue;
        }
        countValue += parseInt(data_[i].wareCount);
        amountValue += parseFloat(data_[i].price) * parseInt(data_[i].wareCount);
    }
    amountValue = Math.round(amountValue * 10) / 10;

    if (countValue == 0 && offState == 0) {
        fnShowWareList(false);
    }
    // 在购物车Window中显示
    api.execScript({
        name: 'shoppingcart',
        script: 'fnSetWareCountAndAmount(' + countValue + ', ' + amountValue + ');'
    });
}

// 更新当前窗口中显示的购物车中的商品数量
function fnUpdateWareCount(wareId_, wareCount_) {
    for (var i = 0; i < curShoppingCart.length; i++) {
        if (curShoppingCart[i].id == wareId_) {
            curShoppingCart[i].wareCount = wareCount_;
        }
    }
    fnGetShoppingCartAmount(curShoppingCart);
}

// 更新当前窗口中显示的购物车中的商品选中状态
function fnUpdateWareState(wareId_, wareState_) {
    for (var i = 0; i < curShoppingCart.length; i++) {
        if (curShoppingCart[i].id == wareId_) {
            curShoppingCart[i].wareState = wareState_;
        }
    }
    fnGetShoppingCartAmount(curShoppingCart);
}

// 显示商品列表
function fnShowWareList(show_) {
    var empty = $api.byId('empty');
    var list = $api.byId('list');
    if (show_) {
        empty.style.display = 'none';
        list.style.display = 'block';
    } else {
        empty.style.display = 'block';
        list.style.display = 'none';
    }
}

// 打开商品详情Window，指定商品Id
function fnOpenWareWin(wareId_) {
    // 获取指定商品在购物车中的数量
    var count = $api.byId('count_' + wareId_);
    var wareCount = parseInt(count.innerHTML);
    api.openWin({
        name: 'ware',
        url: './ware.html',
        pageParam: {
            wareId: wareId_,
            wareCount: wareCount
        },
        animation: {
            type: "fade"
        }
    });
}

// 添加到购物车按钮的监听函数
function fnAdd(wareId_) {
    // 阻止事件继续向上冒泡
    event.stopPropagation();

    var count = $api.byId('count_' + wareId_);
    var control = $api.byId('control_' + wareId_);

    // 更新商品数量及显示状态
    var countNumber = parseInt(count.innerHTML);
    countNumber += 1;
    count.innerHTML = countNumber;
    control.style.display = (countNumber > 0) ? 'block' : 'none';

    // 更新当前页面的购物车信息
    fnUpdateWareCount(wareId_, countNumber);

    // 发送购物车更新自定义事件，传递商品Id和商品数量
    api.sendEvent({
        name: 'updateShoppingCart',
        extra: {
            wareId: wareId_,
            wareCount: countNumber
        }
    });
}

// 从购物车删除按钮的监听函数
function fnMinus(wareId_) {
    event.stopPropagation();
    var count = $api.byId('count_' + wareId_);
    var control = $api.byId('control_' + wareId_);
    var countNumber = parseInt(count.innerHTML);
    countNumber -= 1;
    count.innerHTML = countNumber;
    control.style.display = (countNumber > 0) ? 'block' : 'none';
    fnUpdateWareCount(wareId_, countNumber);
    api.sendEvent({
        name: 'updateShoppingCart',
        extra: {
            wareId: wareId_,
            wareCount: countNumber
        }
    });
}

// 设置商品是否选中
function fnSetSelect(wareId_) {
    // 阻止事件继续向上冒泡
    event.stopPropagation();

    var wareSelect = $api.byId('select_' + wareId_);
    if (!$api.hasCls(wareSelect, 'select-off')) {
        $api.addCls(wareSelect, 'select-off');
        fnUpdateWareState(wareId_, 'off');
    } else {
        $api.removeCls(wareSelect, 'select-off');
        fnUpdateWareState(wareId_, 'on');
    }
}

// 单购物车中没有商品的时候，点击关闭当前窗口
function fnCloseWin() {
    api.closeWin({
        animation: {
            type: 'fade' // 指定窗口关闭的动画为淡入淡出
        }
    });
}
</script>

</html>
