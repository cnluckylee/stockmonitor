<style type="text/css">
	.aui-btn-info p{
		color: #fff;
	}
</style>
<secton class="aui-grid">
    <div class="row aui-text-center">
    	<div class="aui-col-xs-4 aui-btn-info">
            <p>coin</p>
        </div>
        <div class="aui-col-xs-4 aui-btn-info">
            <p>count</p>
        </div>
        <div class="aui-col-xs-4 aui-btn-info">
            <p>totalprice</p>
        </div>

    <?php foreach($data as $k=>$v):?>
        <div class="aui-col-xs-4">
            <p><?=$v['name']?></p>
        </div>
        <div class="aui-col-xs-4">
            <p><?=$v['count']?></p>
        </div>
        <div class="aui-col-xs-4">
            <p><?=$v['money']?></p>
        </div>
	<?php endforeach;?>
    </div>
</secton>        


<!-- <div class="contrain">
<table class="table">
<tbody>
	<th>coin</th><th>count</th><th>totalprice</th></tbody>
  <?php foreach($data as $k=>$v):?>
  <tbody><th><?=$v['name']?></th><th><?=$v['count']?></th><td><?=$v['money']?></th></tbody>
<?php endforeach;?>
</table>
</div> -->
