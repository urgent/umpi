<div class="sidebar-search-box " >
    <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
        <input type="search" id="<?php echo esc_attr(uniqid('search-form-')); ?>" class="search-field" placeholder="<?php esc_attr_e('Search ...', 'loveicon');?>" value="<?php echo get_search_query(); ?>" name="s" required="required"/>
            <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
    </form>
</div>