<?php
/**
 * template name: 404
 */
get_header();
?>
<?php wp_reset_query();?>
<?php get_template_part('sections/main-menu-chuyen-khoa');?>
<section id="breckcrum" class="page_wrapper">
    <div class="container_site"> 
        <h1 class="title_child_page"><?php the_title(); ?></h1>
        <div class="content_breadcrumen_item">
			<span><i class="fas fa-home"></i></span>
			<span><a href="<?php echo get_home_url();?>">Home</a></span>
			<span class="breckcrum_space">/</span>
			<?php the_title(); ?>
		</div>
    </div>
</section>
<section id="DoiNguBacSi_archive_search" class="page_wrapper">
    <div class="container_site">
    	<header class="page-header">
    		<h1 style="text-align: center;" class="page_title_search">Xin lỗi! Trang bạn tìm kiếm không tồn tại</h1>
    	</header>
    	<div class="page_content_search">
			<p style="text-align: center;"><a href="<?php echo get_home_url();?>">Quay lại trang chủ</a></p>
    	</div>
    </div>
</section>

<?php
get_footer();
 ?>