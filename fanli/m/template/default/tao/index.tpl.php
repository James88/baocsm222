<?php //多多
if (!defined('INDEX')) {
	exit ('Access Denied');
}
$webtitle=$dd_tpl_data['title'].'-淘宝';
?>
<?php include(TPLPATH.'/inc/header.tpl.php');?>
<div class="new-ct">
    <div class="new-category">
     	<ul class="new-category-lst">
    		        <li class="new-category-li">
    			<a href="javascript:void(0)" id="1315" class="new-category-a"><span class="icon"></span>服饰内衣</a>
    			<ul class="new-category2-lst" id="category1315" style="display: none; ">
    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'男装'))?>" class="new-category2-a"><span class="new-bar"></span>男装</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'女装'))?>" class="new-category2-a"><span class="new-bar"></span>女装</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'运动'))?>" class="new-category2-a"><span class="new-bar"></span>运动</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'内衣'))?>" class="new-category2-a"><span class="new-bar"></span>内衣</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'服饰配件'))?>" class="new-category2-a"><span class="new-bar"></span>服饰配件</a>
        				    						    							<a href="javascript:void(0)" class="new-category2-a"><span class="new-bar"></span></a>
    						    					                        			    			</li></ul>
        </li>
			        <li class="new-category-li">
    			<a href="javascript:void(0)" id="11729" class="new-category-a"><span class="icon"></span>鞋靴</a>
    			<ul class="new-category2-lst" id="category11729" style="display: none; ">
    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'流行男鞋'))?>" class="new-category2-a"><span class="new-bar"></span>流行男鞋</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'时尚女鞋'))?>" class="new-category2-a"><span class="new-bar"></span>时尚女鞋</a>
        				    						    							<a href="javascript:void(0)" class="new-category2-a"><span class="new-bar"></span></a>
    						    					                        			    			</li></ul>
        </li>
			        <li class="new-category-li">
    			<a href="javascript:void(0)" id="9987" class="new-category-a"><span class="icon"></span>手机</a>
    			<ul class="new-category2-lst" id="category9987" style="display: none; ">
    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'手机通讯'))?>" class="new-category2-a"><span class="new-bar"></span>手机通讯</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'手机配件'))?>" class="new-category2-a"><span class="new-bar"></span>手机配件</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'运营商'))?>" class="new-category2-a"><span class="new-bar"></span>运营商</a>
        				                        				</li>
    				    			    			</ul>
        </li>
			        <li class="new-category-li">
    			<a href="javascript:void(0)" id="652" class="new-category-a"><span class="icon"></span>数码</a>
    			<ul class="new-category2-lst" id="category652" style="display: none; ">
    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'摄影摄像'))?>" class="new-category2-a"><span class="new-bar"></span>摄影摄像</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'数码配件'))?>" class="new-category2-a"><span class="new-bar"></span>数码配件</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'时尚影音'))?>" class="new-category2-a"><span class="new-bar"></span>时尚影音</a>
        				                        				</li>
    				    			    			</ul>
        </li>
			        <li class="new-category-li">
    			<a href="javascript:void(0)" id="670" class="new-category-a"><span class="icon"></span>电脑、办公</a>
    			<ul class="new-category2-lst" id="category670" style="display: none; ">
    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'电脑整机'))?>" class="new-category2-a"><span class="new-bar"></span>电脑整机</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'电脑配件'))?>" class="new-category2-a"><span class="new-bar"></span>电脑配件</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'外设产品'))?>" class="new-category2-a"><span class="new-bar"></span>外设产品</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'网络产品'))?>" class="new-category2-a"><span class="new-bar"></span>网络产品</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'办公打印'))?>" class="new-category2-a"><span class="new-bar"></span>办公打印</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'办公文仪'))?>" class="new-category2-a"><span class="new-bar"></span>办公文仪</a>
        				                        				</li>
    				    			    			</ul>
        </li>
			        <li class="new-category-li">
    			<a href="javascript:void(0)" id="1316" class="new-category-a"><span class="icon"></span>个护化妆</a>
    			<ul class="new-category2-lst" id="category1316" style="display: none; ">
    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'面部护肤'))?>" class="new-category2-a"><span class="new-bar"></span>面部护肤</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'身体护肤'))?>" class="new-category2-a"><span class="new-bar"></span>身体护肤</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'口腔护理'))?>" class="new-category2-a"><span class="new-bar"></span>口腔护理</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'女性护理'))?>" class="new-category2-a"><span class="new-bar"></span>女性护理</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'香水彩妆'))?>" class="new-category2-a"><span class="new-bar"></span>香水彩妆</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'洗发护发'))?>" class="new-category2-a"><span class="new-bar"></span>洗发护发</a>
        				                        				</li>
    				    			    			</ul>
        </li>
			        <li class="new-category-li">
    			<a href="javascript:void(0)" id="1713" class="new-category-a"><span class="icon"></span>图书</a>
    			<ul class="new-category2-lst" id="category1713" style="display: none; ">
    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'小说'))?>" class="new-category2-a"><span class="new-bar"></span>小说</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'文学'))?>" class="new-category2-a"><span class="new-bar"></span>文学</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'青春文学'))?>" class="new-category2-a"><span class="new-bar"></span>青春文学</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'传记'))?>" class="new-category2-a"><span class="new-bar"></span>传记</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'艺术'))?>" class="new-category2-a"><span class="new-bar"></span>艺术</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'少儿'))?>" class="new-category2-a"><span class="new-bar"></span>少儿</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'经济'))?>" class="new-category2-a"><span class="new-bar"></span>经济</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'金融与投资'))?>" class="new-category2-a"><span class="new-bar"></span>金融与投资</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'管理'))?>" class="new-category2-a"><span class="new-bar"></span>管理</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'励志与成功'))?>" class="new-category2-a"><span class="new-bar"></span>励志与成功</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'健身与保健'))?>" class="new-category2-a"><span class="new-bar"></span>健身与保健</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'家教与育儿'))?>" class="new-category2-a"><span class="new-bar"></span>家教与育儿</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'旅游/地图'))?>" class="new-category2-a"><span class="new-bar"></span>旅游/地图</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'动漫'))?>" class="new-category2-a"><span class="new-bar"></span>动漫</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'历史'))?>" class="new-category2-a"><span class="new-bar"></span>历史</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'哲学/宗教'))?>" class="new-category2-a"><span class="new-bar"></span>哲学/宗教</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'国学/古籍图'))?>" class="new-category2-a"><span class="new-bar"></span>国学/古籍</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'政治/军事'))?>" class="new-category2-a"><span class="new-bar"></span>政治/军事</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'法律'))?>" class="new-category2-a"><span class="new-bar"></span>法律</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'心理学'))?>" class="new-category2-a"><span class="new-bar"></span>心理学</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'文化'))?>" class="new-category2-a"><span class="new-bar"></span>文化</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'社会科学'))?>" class="new-category2-a"><span class="new-bar"></span>社会科学</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'工业技术'))?>" class="new-category2-a"><span class="new-bar"></span>工业技术</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'建筑'))?>" class="new-category2-a"><span class="new-bar"></span>建筑</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'医学'))?>" class="new-category2-a"><span class="new-bar"></span>医学</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'科学与自然'))?>" class="new-category2-a"><span class="new-bar"></span>科学与自然</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'计算机与互联网'))?>" class="new-category2-a"><span class="new-bar"></span>计算机与互联网</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'体育/运动'))?>" class="new-category2-a"><span class="new-bar"></span>体育/运动</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'中小学教辅'))?>" class="new-category2-a"><span class="new-bar"></span>中小学教辅</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'考试'))?>" class="new-category2-a"><span class="new-bar"></span>考试</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'外语学习'))?>" class="new-category2-a"><span class="new-bar"></span>外语学习</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'字典词典/工具书'))?>" class="new-category2-a"><span class="new-bar"></span>字典词典/工具书</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'套装书'))?>" class="new-category2-a"><span class="new-bar"></span>套装书</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'杂志/期刊'))?>" class="new-category2-a"><span class="new-bar"></span>杂志/期刊</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'英文原版书'))?>" class="new-category2-a"><span class="new-bar"></span>英文原版书</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'港台图书'))?>" class="new-category2-a"><span class="new-bar"></span>港台图书</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'满200减100专区'))?>" class="new-category2-a"><span class="new-bar"></span>满200减100专区</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'烹饪/美食'))?>" class="new-category2-a"><span class="new-bar"></span>烹饪/美食</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'时尚/美妆'))?>" class="new-category2-a"><span class="new-bar"></span>时尚/美妆</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'家居'))?>" class="new-category2-a"><span class="new-bar"></span>家居</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'婚恋与两性'))?>" class="new-category2-a"><span class="new-bar"></span>婚恋与两性</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'娱乐/休闲'))?>" class="new-category2-a"><span class="new-bar"></span>娱乐/休闲</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'科普读物'))?>" class="new-category2-a"><span class="new-bar"></span>科普读物</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'电子与通信'))?>" class="new-category2-a"><span class="new-bar"></span>电子与通信</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'农业/林业'))?>" class="new-category2-a"><span class="new-bar"></span>农业/林业</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'大中专教材教辅'))?>" class="new-category2-a"><span class="new-bar"></span>大中专教材教辅</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'在线教育/学习卡'))?>" class="new-category2-a"><span class="new-bar"></span>在线教育/学习卡</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'文化用品'))?>" class="new-category2-a"><span class="new-bar"></span>文化用品</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'图书促销专区'))?>" class="new-category2-a"><span class="new-bar"></span>图书促销专区</a>
        				    						    							<a href="javascript:void(0)" class="new-category2-a"><span class="new-bar"></span></a>
    							<a href="javascript:void(0)" class="new-category2-a"></a>
    						    					                        			    			</li></ul>
        </li>
			        <li class="new-category-li">
    			<a href="javascript:void(0)" id="737" class="new-category-a"><span class="icon"></span>家用电器</a>
    			<ul class="new-category2-lst" id="category737" style="display: none; ">
    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'个护健康'))?>" class="new-category2-a"><span class="new-bar"></span>个护健康</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'生活电器'))?>" class="new-category2-a"><span class="new-bar"></span>生活电器</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'厨房电器'))?>" class="new-category2-a"><span class="new-bar"></span>厨房电器</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'大 家 电'))?>" class="new-category2-a"><span class="new-bar"></span>大 家 电</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'五金家装'))?>" class="new-category2-a"><span class="new-bar"></span>五金家装</a>
        				    						    							<a href="javascript:void(0)" class="new-category2-a"><span class="new-bar"></span></a>
    						    					                        			    			</li></ul>
        </li>
			        <li class="new-category-li">
    			<a href="javascript:void(0)" id="1319" class="new-category-a"><span class="icon"></span>母婴</a>
    			<ul class="new-category2-lst" id="category1319" style="display: none; ">
    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'奶粉'))?>" class="new-category2-a"><span class="new-bar"></span>奶粉</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'营养辅食'))?>" class="new-category2-a"><span class="new-bar"></span>营养辅食</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'尿裤湿巾'))?>" class="new-category2-a"><span class="new-bar"></span>尿裤湿巾</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'喂养用品'))?>" class="new-category2-a"><span class="new-bar"></span>喂养用品</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'洗护用品'))?>" class="new-category2-a"><span class="new-bar"></span>洗护用品</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'童车童床'))?>" class="new-category2-a"><span class="new-bar"></span>童车童床</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'童装童鞋'))?>" class="new-category2-a"><span class="new-bar"></span>童装童鞋</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'妈妈专区'))?>" class="new-category2-a"><span class="new-bar"></span>妈妈专区</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'服饰寝居'))?>" class="new-category2-a"><span class="new-bar"></span>服饰寝居</a>
        				                        				</li>
    				    			    			</ul>
        </li>
			        <li class="new-category-li">
    			<a href="javascript:void(0)" id="1320" class="new-category-a"><span class="icon"></span>食品饮料、保健食品</a>
    			<ul class="new-category2-lst" id="category1320" style="display: none; ">
    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'休闲食品'))?>" class="new-category2-a"><span class="new-bar"></span>休闲食品</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'饮料冲调'))?>" class="new-category2-a"><span class="new-bar"></span>饮料冲调</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'营养健康'))?>" class="new-category2-a"><span class="new-bar"></span>营养健康</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'健康礼品'))?>" class="new-category2-a"><span class="new-bar"></span>健康礼品</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'粮油调味'))?>" class="new-category2-a"><span class="new-bar"></span>粮油调味</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'亚健康调理'))?>" class="new-category2-a"><span class="new-bar"></span>亚健康调理</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'地方特产'))?>" class="new-category2-a"><span class="new-bar"></span>地方特产</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'进口食品'))?>" class="new-category2-a"><span class="new-bar"></span>进口食品</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'生鲜食品'))?>" class="new-category2-a"><span class="new-bar"></span>生鲜食品</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'中外名酒'))?>" class="new-category2-a"><span class="new-bar"></span>中外名酒</a>
        				    						    							<a href="javascript:void(0)" class="new-category2-a"><span class="new-bar"></span></a>
    							<a href="javascript:void(0)" class="new-category2-a"></a>
    						    					                        			    			</li></ul>
        </li>
			        <li class="new-category-li">
    			<a href="javascript:void(0)" id="1620" class="new-category-a"><span class="icon"></span>家居家装</a>
    			<ul class="new-category2-lst" id="category1620" style="display: none; ">
    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'家纺'))?>" class="new-category2-a"><span class="new-bar"></span>家纺</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'灯具'))?>" class="new-category2-a"><span class="new-bar"></span>灯具</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'生活日用'))?>" class="new-category2-a"><span class="new-bar"></span>生活日用</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'清洁用品'))?>" class="new-category2-a"><span class="new-bar"></span>清洁用品</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'家装软饰'))?>" class="new-category2-a"><span class="new-bar"></span>家装软饰</a>
        				    						    							<a href="javascript:void(0)" class="new-category2-a"><span class="new-bar"></span></a>
    						    					                        			    			</li></ul>
        </li>
			        <li class="new-category-li">
    			<a href="javascript:void(0)" id="6728" class="new-category-a"><span class="icon"></span>汽车用品</a>
    			<ul class="new-category2-lst" id="category6728" style="display: none; ">
    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'车载电器'))?>" class="new-category2-a"><span class="new-bar"></span>车载电器</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'维修保养'))?>" class="new-category2-a"><span class="new-bar"></span>维修保养</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'美容清洗'))?>" class="new-category2-a"><span class="new-bar"></span>美容清洗</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'汽车装饰'))?>" class="new-category2-a"><span class="new-bar"></span>汽车装饰</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'安全自驾'))?>" class="new-category2-a"><span class="new-bar"></span>安全自驾</a>
        				    						    							<a href="javascript:void(0)" class="new-category2-a"><span class="new-bar"></span></a>
    						    					                        			    			</li></ul>
        </li>
			        <li class="new-category-li">
    			<a href="javascript:void(0)" id="1672" class="new-category-a"><span class="icon"></span>礼品箱包</a>
    			<ul class="new-category2-lst" id="category1672" style="display: none; ">
    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'礼品'))?>" class="new-category2-a"><span class="new-bar"></span>礼品</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'精品男包'))?>" class="new-category2-a"><span class="new-bar"></span>精品男包</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'潮流女包'))?>" class="new-category2-a"><span class="new-bar"></span>潮流女包</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'功能箱包'))?>" class="new-category2-a"><span class="new-bar"></span>功能箱包</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'婚庆'))?>" class="new-category2-a"><span class="new-bar"></span>婚庆</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'奢侈品'))?>" class="new-category2-a"><span class="new-bar"></span>奢侈品</a>
        				                        				</li>
    				    			    			</ul>
        </li>
			        <li class="new-category-li">
    			<a href="javascript:void(0)" id="1318" class="new-category-a"><span class="icon"></span>运动健康</a>
    			<ul class="new-category2-lst" id="category1318" style="display: none; ">
    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'户外鞋服'))?>" class="new-category2-a"><span class="new-bar"></span>户外鞋服</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'户外装备'))?>" class="new-category2-a"><span class="new-bar"></span>户外装备</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'运动器械'))?>" class="new-category2-a"><span class="new-bar"></span>运动器械</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'纤体瑜伽'))?>" class="new-category2-a"><span class="new-bar"></span>纤体瑜伽</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'成人用品'))?>" class="new-category2-a"><span class="new-bar"></span>成人用品</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'保健器械'))?>" class="new-category2-a"><span class="new-bar"></span>保健器械</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'急救卫生'))?>" class="new-category2-a"><span class="new-bar"></span>急救卫生</a>
        				                        			    				                    	<a href="h<?=wap_l('tao','list',array('q'=>'体育娱乐'))?>" class="new-category2-a"><span class="new-bar"></span>体育娱乐</a>
        				    						    							<a href="javascript:void(0)" class="new-category2-a"><span class="new-bar"></span></a>
    						    					                        			    			</li></ul>
        </li>
			        <li class="new-category-li">
    			<a href="javascript:void(0)" id="6233" class="new-category-a"><span class="icon"></span>玩具乐器</a>
    			<ul class="new-category2-lst" id="category6233" style="display: none; ">
    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'适用年龄'))?>" class="new-category2-a"><span class="new-bar"></span>适用年龄</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'遥控/电动'))?>" class="new-category2-a"><span class="new-bar"></span>遥控/电动</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'毛绒布艺'))?>" class="new-category2-a"><span class="new-bar"></span>毛绒布艺</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'娃娃玩具'))?>" class="new-category2-a"><span class="new-bar"></span>娃娃玩具</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'模型玩具'))?>" class="new-category2-a"><span class="new-bar"></span>模型玩具</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'健身玩具'))?>" class="new-category2-a"><span class="new-bar"></span>健身玩具</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'动漫玩具'))?>" class="new-category2-a"><span class="new-bar"></span>动漫玩具</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'益智玩具'))?>" class="new-category2-a"><span class="new-bar"></span>益智玩具</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'积木拼插'))?>" class="new-category2-a"><span class="new-bar"></span>积木拼插</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'DIY玩具'))?>" class="new-category2-a"><span class="new-bar"></span>DIY玩具</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'创意减压'))?>" class="new-category2-a"><span class="new-bar"></span>创意减压</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'乐器相关'))?>" class="new-category2-a"><span class="new-bar"></span>乐器相关</a>
        				                        				</li>
    				    			    			</ul>
        </li>
			        <li class="new-category-li">
    			<a href="javascript:void(0)" id="5025" class="new-category-a"><span class="icon"></span>钟表</a>
    			<ul class="new-category2-lst" id="category5025" style="display: none; ">
    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'钟表'))?>" class="new-category2-a"><span class="new-bar"></span>钟表</a>
        				    						    							<a href="javascript:void(0)" class="new-category2-a"><span class="new-bar"></span></a>
    							<a href="javascript:void(0)" class="new-category2-a"></a>
    						    					                        			    			</li></ul>
        </li>
			        <li class="new-category-li">
    			<a href="javascript:void(0)" id="6196" class="new-category-a"><span class="icon"></span>厨具</a>
    			<ul class="new-category2-lst" id="category6196" style="display: none; ">
    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'烹饪锅具'))?>" class="new-category2-a"><span class="new-bar"></span>烹饪锅具</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'刀剪菜板'))?>" class="new-category2-a"><span class="new-bar"></span>刀剪菜板</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'厨房配件'))?>" class="new-category2-a"><span class="new-bar"></span>厨房配件</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'水具酒具'))?>" class="new-category2-a"><span class="new-bar"></span>水具酒具</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'餐具'))?>" class="new-category2-a"><span class="new-bar"></span>餐具</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'茶具/咖啡具'))?>" class="new-category2-a"><span class="new-bar"></span>茶具/咖啡具</a>
        				                        				</li>
    				    			    			</ul>
        </li>
			        <li class="new-category-li">
    			<a href="javascript:void(0)" id="6144" class="new-category-a"><span class="icon"></span>珠宝首饰</a>
    			<ul class="new-category2-lst" id="category6144" style="display: none; ">
    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'纯金K金饰品'))?>" class="new-category2-a"><span class="new-bar"></span>纯金K金饰品</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'金银投资'))?>" class="new-category2-a"><span class="new-bar"></span>金银投资</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'银饰'))?>" class="new-category2-a"><span class="new-bar"></span>银饰</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'钻石'))?>" class="new-category2-a"><span class="new-bar"></span>钻石</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'翡翠玉石'))?>" class="new-category2-a"><span class="new-bar"></span>翡翠玉石</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'水晶玛瑙'))?>" class="new-category2-a"><span class="new-bar"></span>水晶玛瑙</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'彩宝'))?>" class="new-category2-a"><span class="new-bar"></span>彩宝</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'时尚饰品'))?>" class="new-category2-a"><span class="new-bar"></span>时尚饰品</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'铂金'))?>" class="new-category2-a"><span class="new-bar"></span>铂金</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'天然木饰'))?>" class="new-category2-a"><span class="new-bar"></span>天然木饰</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'珍珠'))?>" class="new-category2-a"><span class="new-bar"></span>珍珠</a>
        				    						    							<a href="javascript:void(0)" class="new-category2-a"><span class="new-bar"></span></a>
    						    					                        			    			</li></ul>
        </li>
			        <li class="new-category-li">
    			<a href="javascript:void(0)" id="4051" class="new-category-a"><span class="icon"></span>音乐</a>
    			<ul class="new-category2-lst" id="category4051" style="display: none; ">
    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'颁奖典礼获奖专辑'))?>" class="new-category2-a"><span class="new-bar"></span>颁奖典礼获奖专辑</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'内地流行'))?>" class="new-category2-a"><span class="new-bar"></span>内地流行</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'华语流行'))?>" class="new-category2-a"><span class="new-bar"></span>华语流行</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'欧美流行'))?>" class="new-category2-a"><span class="new-bar"></span>欧美流行</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'日韩流行'))?>" class="new-category2-a"><span class="new-bar"></span>日韩流行</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'进口CD'))?>" class="new-category2-a"><span class="new-bar"></span>进口CD</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'古典'))?>" class="new-category2-a"><span class="new-bar"></span>古典</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'经典怀旧音乐'))?>" class="new-category2-a"><span class="new-bar"></span>经典怀旧音乐</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'摇滚'))?>" class="new-category2-a"><span class="new-bar"></span>摇滚</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'爵士/蓝调'))?>" class="new-category2-a"><span class="new-bar"></span>爵士/蓝调</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'民歌民谣'))?>" class="new-category2-a"><span class="new-bar"></span>民歌民谣</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'休闲、功能音乐'))?>" class="new-category2-a"><span class="new-bar"></span>休闲、功能音乐</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'影视音乐'))?>" class="new-category2-a"><span class="new-bar"></span>影视音乐</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'HIFI发烧碟'))?>" class="new-category2-a"><span class="new-bar"></span>HIFI发烧碟</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'有声读物'))?>" class="new-category2-a"><span class="new-bar"></span>有声读物</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'儿童音乐'))?>" class="new-category2-a"><span class="new-bar"></span>儿童音乐</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'音乐教育'))?>" class="new-category2-a"><span class="new-bar"></span>音乐教育</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'音乐DVD/VCD'))?>" class="new-category2-a"><span class="new-bar"></span>音乐DVD/VCD</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'民族音乐'))?>" class="new-category2-a"><span class="new-bar"></span>民族音乐</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'相声/戏曲/曲艺'))?>" class="new-category2-a"><span class="new-bar"></span>相声/戏曲/曲艺</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'中国民族乐器'))?>" class="new-category2-a"><span class="new-bar"></span>中国民族乐器 </a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'西洋乐器'))?>" class="new-category2-a"><span class="new-bar"></span>西洋乐器</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'宗教/庆典音乐'))?>" class="new-category2-a"><span class="new-bar"></span>宗教/庆典音乐</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'汽车音乐'))?>" class="new-category2-a"><span class="new-bar"></span>汽车音乐</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'瑜伽音乐'))?>" class="new-category2-a"><span class="new-bar"></span>瑜伽音乐</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'独立音乐'))?>" class="new-category2-a"><span class="new-bar"></span>独立音乐</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'网络歌曲'))?>" class="new-category2-a"><span class="new-bar"></span>网络歌曲</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'特色分类'))?>" class="new-category2-a"><span class="new-bar"></span>特色分类</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'音乐套装'))?>" class="new-category2-a"><span class="new-bar"></span>音乐套装</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'其他分类'))?>" class="new-category2-a"><span class="new-bar"></span>其他分类</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">


    				                    	<a href="<?=wap_l('tao','list',array('q'=>'中国摇滚'))?>" class="new-category2-a"><span class="new-bar"></span>中国摇滚</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'艺人周边'))?>" class="new-category2-a"><span class="new-bar"></span>艺人周边</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'文娱周边'))?>" class="new-category2-a"><span class="new-bar"></span>文娱周边</a>
        				                        				</li>
    				    			    			</ul>
        </li>
			        <li class="new-category-li">
    			<a href="javascript:void(0)" id="6994" class="new-category-a"><span class="icon"></span>宠物生活</a>
    			<ul class="new-category2-lst" id="category6994" style="display: none; ">
    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'宠物主粮'))?>" class="new-category2-a"><span class="new-bar"></span>宠物主粮</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'宠物零食'))?>" class="new-category2-a"><span class="new-bar"></span>宠物零食</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'医疗保健'))?>" class="new-category2-a"><span class="new-bar"></span>医疗保健</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'家居日用'))?>" class="new-category2-a"><span class="new-bar"></span>家居日用</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'宠物玩具'))?>" class="new-category2-a"><span class="new-bar"></span>宠物玩具</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'出行装备'))?>" class="new-category2-a"><span class="new-bar"></span>出行装备</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'洗护美容'))?>" class="new-category2-a"><span class="new-bar"></span>洗护美容</a>
        				    						    							<a href="javascript:void(0)" class="new-category2-a"><span class="new-bar"></span></a>
    							<a href="javascript:void(0)" class="new-category2-a"></a>
    						    					                        			    			</li></ul>
        </li>
			        <li class="new-category-li">
    			<a href="javascript:void(0)" id="4052" class="new-category-a"><span class="icon"></span>影视</a>
    			<ul class="new-category2-lst" id="category4052" style="display: none; ">
    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'电影'))?>" class="new-category2-a"><span class="new-bar"></span>电影</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'电视剧'))?>" class="new-category2-a"><span class="new-bar"></span>电视剧</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'专题栏目/纪录片'))?>" class="new-category2-a"><span class="new-bar"></span>专题栏目/纪录片</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'瑜伽/塑身'))?>" class="new-category2-a"><span class="new-bar"></span>瑜伽/塑身</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'生活/百科'))?>" class="new-category2-a"><span class="new-bar"></span>生活/百科</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'亲子幼教启蒙'))?>" class="new-category2-a"><span class="new-bar"></span>亲子幼教启蒙</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'卡通/动画'))?>" class="new-category2-a"><span class="new-bar"></span>卡通/动画</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'儿童影视'))?>" class="new-category2-a"><span class="new-bar"></span>儿童影视</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'戏剧/综艺'))?>" class="new-category2-a"><span class="new-bar"></span>戏剧/综艺</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'教育音像'))?>" class="new-category2-a"><span class="new-bar"></span>教育音像</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'经典电影'))?>" class="new-category2-a"><span class="new-bar"></span>经典电影</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'其他分类'))?>" class="new-category2-a"><span class="new-bar"></span>其他分类</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'影视周边'))?>" class="new-category2-a"><span class="new-bar"></span>影视周边</a>
        				    						    							<a href="javascript:void(0)" class="new-category2-a"><span class="new-bar"></span></a>
    							<a href="javascript:void(0)" class="new-category2-a"></a>
    						    					                        			    			</li></ul>
        </li>
			        <li class="new-category-li">
    			<a href="javascript:void(0)" id="4053" class="new-category-a"><span class="icon"></span>教育音像</a>
    			<ul class="new-category2-lst" id="category4053" style="display: none; ">
    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'英语学习'))?>" class="new-category2-a"><span class="new-bar"></span>英语学习</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'非英语语种/汉语学习'))?>" class="new-category2-a"><span class="new-bar"></span>非英语语种/汉语学习</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'幼儿/少儿英语'))?>" class="new-category2-a"><span class="new-bar"></span>幼儿/少儿英语</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'幼儿与学前启蒙'))?>" class="new-category2-a"><span class="new-bar"></span>幼儿与学前启蒙</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'教材/教辅'))?>" class="new-category2-a"><span class="new-bar"></span>教材/教辅</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'考试/考级'))?>" class="new-category2-a"><span class="new-bar"></span>考试/考级</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'影视周边'))?>" class="new-category2-a"><span class="new-bar"></span>经营管理培训</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'电脑培训/考试/考级'))?>" class="new-category2-a"><span class="new-bar"></span>电脑培训/考试/考级</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'职业教育'))?>" class="new-category2-a"><span class="new-bar"></span>职业教育</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'成人高考教育'))?>" class="new-category2-a"><span class="new-bar"></span>成人高考教育</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'文学'))?>" class="new-category2-a"><span class="new-bar"></span>文学</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'艺术'))?>" class="new-category2-a"><span class="new-bar"></span>艺术</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'体育'))?>" class="new-category2-a"><span class="new-bar"></span>体育</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'健身'))?>" class="new-category2-a"><span class="new-bar"></span>健身</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'专业舞蹈'))?>" class="new-category2-a"><span class="new-bar"></span>专业舞蹈</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'时尚靓妆'))?>" class="new-category2-a"><span class="new-bar"></span>时尚靓妆</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'生活百科'))?>" class="new-category2-a"><span class="new-bar"></span>生活百科</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'农业生产'))?>" class="new-category2-a"><span class="new-bar"></span>农业生产</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'教育名家'))?>" class="new-category2-a"><span class="new-bar"></span>教育名家</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'其他'))?>" class="new-category2-a"><span class="new-bar"></span>其他</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'游戏'))?>" class="new-category2-a"><span class="new-bar"></span>游戏</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'软件'))?>" class="new-category2-a"><span class="new-bar"></span>软件</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'周边产品'))?>" class="new-category2-a"><span class="new-bar"></span>周边产品</a>
        				    						    							<a href="javascript:void(0)" class="new-category2-a"><span class="new-bar"></span></a>
    						    					                        			    			</li></ul>
        </li>
			        <li class="new-category-li">
    			<a href="javascript:void(0)" id="9847" class="new-category-a"><span class="icon"></span>家具</a>
    			<ul class="new-category2-lst" id="category9847" style="display: none; ">
    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'卧室家具'))?>" class="new-category2-a"><span class="new-bar"></span>卧室家具</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'客厅家具'))?>" class="new-category2-a"><span class="new-bar"></span>客厅家具</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'餐厅家具'))?>" class="new-category2-a"><span class="new-bar"></span>餐厅家具</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'书房家具'))?>" class="new-category2-a"><span class="new-bar"></span>书房家具</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'储物家具'))?>" class="new-category2-a"><span class="new-bar"></span>储物家具</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'阳台/户外'))?>" class="new-category2-a"><span class="new-bar"></span>阳台/户外</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'商业办公'))?>" class="new-category2-a"><span class="new-bar"></span>商业办公</a>
        				    						    							<a href="javascript:void(0)" class="new-category2-a"><span class="new-bar"></span></a>
    							<a href="javascript:void(0)" class="new-category2-a"></a>
    						    					                        			    			</li></ul>
        </li>
			        <li class="new-category-li">
    			<a href="javascript:void(0)" id="9855" class="new-category-a"><span class="icon"></span>家装建材</a>
    			<ul class="new-category2-lst" id="category9855" style="display: none; ">
    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'灯饰照明'))?>" class="new-category2-a"><span class="new-bar"></span>灯饰照明</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'厨房卫浴'))?>" class="new-category2-a"><span class="new-bar"></span>厨房卫浴</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'五金工具'))?>" class="new-category2-a"><span class="new-bar"></span>五金工具</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'电工电料'))?>" class="new-category2-a"><span class="new-bar"></span>电工电料</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'墙地面材料'))?>" class="new-category2-a"><span class="new-bar"></span>墙地面材料</a>
        				                        			    				                    	<a href="<?=wap_l('tao','list',array('q'=>'装饰材料'))?>" class="new-category2-a"><span class="new-bar"></span>装饰材料</a>
        				                        				</li>
    				    			    				                    <li class="new-category2-li">
    				                    	<a href="<?=wap_l('tao','list',array('q'=>'装修服务'))?>" class="new-category2-a"><span class="new-bar"></span>装修服务</a>
        				    						    							<a href="javascript:void(0)" class="new-category2-a"><span class="new-bar"></span></a>
    							<a href="javascript:void(0)" class="new-category2-a"></a>
    						    					                        			    			</li></ul>
        </li>
						<!--<li class="new-category-li">
				<a href="javascript:void(0)" id="$category.cid" class="new-category-a"><span class="icon"></span>生活旅行</a>
				<ul class="new-category2-lst" id="category$category.cid" style="display: none; ">
                    <li class="new-category2-li"><a href="http://m.jd.com/chongzhi/index.action" class="new-category2-a"><span class="new-bar"></span>充值</a><a href="http://caipiao.m.jd.com/" class="new-category2-a"><span class="new-bar"></span>彩票</a><a href="http://m.jd.com/airline/index.action" class="new-category2-a"><span class="new-bar"></span>机票</a></li>
					<li class="new-category2-li"><a href="http://m.jd.com/hotel/index.html" class="new-category2-a"><span class="new-bar"></span>酒店</a><a href="http://menpiao.m.jd.com/" class="new-category2-a"><span class="new-bar"></span>景点</a><a href="http://movie.m.jd.com/" class="new-category2-a"><span class="new-bar"></span>电影票</a></li>
                </ul>
			</li>-->
			<li class="new-category-li">
				<a href="javascript:void(0)" id="$category.cid" class="new-category-a"><span class="icon"></span>数字娱乐</a>
				<ul class="new-category2-lst" id="category$category.cid" style="display: none; ">
                    <li class="new-category2-li"><a href="<?=wap_l('tao','list',array('q'=>'电子书'))?>" class="new-category2-a"><span class="new-bar"></span>电子书</a><a href="<?=wap_l('tao','list',array('q'=>'数字音乐'))?>" class="new-category2-a"><span class="new-bar"></span>数字音乐</a><a href="<?=wap_l('tao','list',array('q'=>'应用商店'))?>" class="new-category2-a"><span class="new-bar"></span>应用商店</a></li>
                </ul>
			</li>
        </ul>
    </div>
</div>
<script language="javascript">
	$(function(){
		$("li.new-category-li>a").click(function(){
    		var obj = $(this).parent().children().eq(1);
    		if(obj.css('display')=='none'){
    			$(".new-category2-lst").hide();
    			obj.fadeIn();
    			$("li.new-category-li>a").removeClass("new-category-a new-on").addClass("new-category-a");
    			$(this).addClass("new-category-a new-on");
    		}else{
    			obj.fadeOut();
    			$("li.new-category-li>a").removeClass("new-category-a new-on").addClass("new-category-a");
    			$(this).removeClass("new-category-a new-on").addClass("new-category-a");
    		}
    	})
	});
</script>

</div>
<?php include(TPLPATH.'/inc/footer.tpl.php');?>