<?php
$archive_page_title         = resido_get_options('archive_page_title');
$archive_page_subtitle      = resido_get_options('archive_page_subtitle');
?>
<!-- ============================ Page Title Start================================== -->
<div class="page-title">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12">
            <?php if($archive_page_title){ ?>
                <h2 class="ipt-title"><?php esc_html_e($archive_page_title, 'resido-listing') ?></h2>
            <?php }else{ ?>
                <h2 class="ipt-title"><?php echo esc_html(get_query_var('term')); ?></h2>
            <?php } ?>
                
                <span class="ipn-subtitle"><?php esc_html_e($archive_page_subtitle, 'resido-listing') ?></span>
            </div>
        </div>
    </div>
</div>
<!-- ============================ Page Title End ================================== -->