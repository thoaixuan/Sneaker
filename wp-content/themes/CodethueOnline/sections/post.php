<?php
/**
 * template name: Tin tức
 */
get_header();
?>
<?php wp_reset_query();
?>
<section class="cat_page_wrapper ct__latest_news">
    <div class="container">
        <div class="ct-title pos-rel" data-mask="TIN TỨC">
            <h1 class="d-none">TIN TỨC</h1>
            <h3 class="ct-tile-product"> - TIN TỨC</h3>
        </div>
        <div class="row pd-top-bot-20">
        <?php post_Pagination(); ?>
        </div>
    </div>
</section>
<?php get_footer();exit(); ?>