<?php if (!defined('THINK_PATH')) exit();?><div class="article_rd">
	<ul>
		<li>
			<span><a href="<?php echo U('Article/lists?category=news');?>">
				新闻中心
			</a></span>
		</li>
		<?php if(is_array($category)): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i; if(($current) == $cate['id']): ?><li class="active">
					<a href="<?php echo U('Article/lists?category='.$cate['name']);?>">
						<?php echo ($cate["title"]); ?>
					</a>
				</li>
			<?php else: ?>
				<li>
					<a href="<?php echo U('Article/lists?category='.$cate['name']);?>">
						<?php echo ($cate["title"]); ?>
					</a>
				</li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
	</ul>
</div>

<div class="ewm">
	<img src="/Public/static/images/weixin1.gif" width="189" height="189" alt="微风投官方微信" />
	关注【微风投】微信订阅号
</div>