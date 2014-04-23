<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once(G5_LIB_PATH.'/thumbnail.lib.php'); 

widget_css();

if( $widget_config['forum1'] ) $_bo_table = $widget_config['forum1'];
else $_bo_table = $widget_config['default_forum_id'];

if( $widget_config['no'] ) $limit = $widget_config['no'];
else $limit = 4;

$list = g::posts( array(
			"bo_table" 	=>	$_bo_table,
			"limit"		=>	$limit,
			"select"	=>	"idx,domain,bo_table,wr_id,wr_parent,wr_is_comment,wr_comment,ca_name,wr_datetime,wr_hit,wr_good,wr_nogood,wr_name,mb_id,wr_subject,wr_content"
				)
		);	
		
if ($list) { ?>
<div class='latest-gallery-posts-1-with-image'>
	<?	
		$i = 1;
		foreach ($list as $post) {
			$thumb = x::post_thumbnail($_bo_table, $post['wr_id'], 213, 128);    					            
			if( empty($thumb['src']) ) {
				$_wr_content = db::result("SELECT wr_content FROM $g5[write_prefix]$_bo_table WHERE wr_id='$post[wr_id]'");
				$image_from_tag = g::thumbnail_from_image_tag( $_wr_content , $_bo_table, 213-2, 128-1 );
				if ( empty($image_from_tag) ) $img = "<img class='img_left' src='".x::url()."/widget/$widget_config[name]/img/no-image.png'/>";
				else $img = "<img class='img_left' src='$image_from_tag'/>";
				$count_image ++;
			} else {
				$img = '<img class="img_left" src="'.$thumb['src'].'">';
				$count_image ++;				
			}
	?>
		<div class="post-item <? if ($i%4 == 1) echo 'left-item'?>">
			<div class='post-image'>
				<a href="<?=$post['url']?>"><?=$img?></a>
			</div>
			
			<div class='post-content-container'>
				<div class='post-subject'><a href="<?=$post['url']?>"><?=cut_str($post['wr_subject'],15,'...')?></a></div>
				<div class='post-content'><a href="<?=$post['url']?>"><?=cut_str(strip_tags($post['wr_content']),50,'...')?></a></div>
			</div>
		</div>
	<?$i++;}?>
		<div style='clear: left'></div>
</div>
<? } else { ?>
<div class='latest-gallery-posts-1-with-image'>
		<?
			$no_subject = "회원님께서는 현재...";
			$no_content = "필고 갤러리 테마 No.1을 선택 하였습니다.";
		for ( $i = 1; $i <= 4; $i++ ) {
			$img = "<img src='$widget_config[url]/img/no_middle_$i.png'/>";
		?>		
		<div class="post-item <? if ($i == 1) echo 'left-item'?>">
			<div class='post-image'>
				<a href="javascript:void(0)"><?=$img?></a>
			</div>
			
			<div class='post-content-container'>
				<div class='post-subject'><a href="javascript:void(0)"><?=$no_subject?></a></div>
				<div class='post-content'><a href="javascript:void(0)"><?=$no_content?></a></div>
			</div>
		</div>
<? } ?>
		<div style='clear: left'></div>
</div>
<?}?>