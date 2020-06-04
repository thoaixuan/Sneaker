<footer class="footer__main">
<div class="ct__footer">  
  <div class="container">
    <div class="row-divide">
        <div class="col-divide-3">
          <div class="logo-footer"> 
            <a href="<?php echo get_home_url(); ?>"><img src="<?php echo get_theme_mod('footer_logo');/*echo get_template_directory_uri();*/ ?>" alt="<?php echo get_the_title(); ?>"></a>
          </div>
          <div class="text_footer">
            <h3>thông tin liên hệ</h3>
            <?php echo get_theme_mod('footer_text');?>
          </div>
        </div>
        <div class="col-divide-3">
          <div class="text_footer">
            <h3>Hỗ trợ khách hàng</h3>
            <?php echo wp_nav_menu( array('theme_location' => 'support',));?>
          </div>
        </div>
        <div class="col-divide-3">
          <div class="text_footer">
            <h3>chính sách</h3>
            <?php echo wp_nav_menu( array('theme_location' => 'policy-menu',));?>
          </div>
        </div>
        <div class="col-divide-3">
          <div class="text_footer">
            <h3>fanpage</h3>
            <?php echo get_theme_mod('footer_text_fanpage');?>
          </div>
        </div>
    </div> 
  </div>
</div>
</footer>

<!--Set color background-->
<?php wp_footer(); ?>
	</body>
</html>
