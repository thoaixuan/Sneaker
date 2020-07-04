<?php
/**
 * template name: 404
 */
get_header();
?>
<?php wp_reset_query();?>

<section  class="page_wrapper">
    <div class="container_site">
    	<header class="page-header">
    		<h1 style="text-align: center;" class="page_title_search">Xin lỗi! Trang bạn tìm kiếm không tồn tại</h1>
    	</header>
    	<div class="page_content_search">
			<p style="text-align: center;"><a href="<?php echo get_home_url(); wp_safe_redirect(site_url());?>"></a>
			<a href="<?php echo get_home_url();?>">Quay lại trang chủ</a>
			</p>
    	</div>
    </div>
</section>

<?php get_footer();exit(); ?>