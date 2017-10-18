<?php



add_filter('edit_category_form_fields', 'edit_cat_description');
function edit_cat_description($category) { 
    $tag_extra_fields = get_option(description1);?>
    <table class="form-table">
    <tr class="form-field">
    <th scope="row" valign="top"><label for="description"><?php _ex('Description', 'Taxonomy Description'); ?></label></th>
    <td>
    <?php     $settings = array('wpautop' => true, 'media_buttons' => true, 'quicktags' => true, 'textarea_rows' => '15', 'textarea_name' => 'description' );
    wp_editor(html_entity_decode($category->description , ENT_QUOTES, 'UTF-8'), 'description1', $settings); ?>
    <br />
    <span class="description"><?php _e('The description is not prominent by default, however some themes may show it.'); ?></span>
    </td>
    </tr>
    </table>
<?php
}
 
add_filter( 'admin_print_styles', 'category_tinymce_css' );
function category_tinymce_css() { ?>    <style type="text/css">
    .quicktags-toolbar input{float:left !important; width:auto !important;}
    </style>
<?php 
}
 
add_filter('category_add_form_fields','add_cat_description');
function add_cat_description($tag) {
    $tag_extra_fields = get_option(description1);?>
    <table class="form-table">
    <tr class="form-field">
    <th scope="row" valign="top"><label for="description"><?php _ex('Description', 'Taxonomy Description'); ?></label></th></tr><tr class="form-field">
    <td>
    <?php     $settings = array('wpautop' => true, 'media_buttons' => true, 'quicktags' => true, 'textarea_rows' => '15', 'textarea_name' => 'description' );
    wp_editor(html_entity_decode($tag->description , ENT_QUOTES, 'UTF-8'), 'description1', $settings); ?>    <br />
    <span class="description"><?php _e('The description is not prominent by default, however some themes may show it.'); ?></span>
    </td>
    </tr>
    </table>
<?php 
} 
 
add_filter('admin_head', 'taxonomy_tinycme_hide_description');
function taxonomy_tinycme_hide_description() {
global $pagenow; 
//echo $pagenow;exit;
 
//only hide on detail not yet on the overview page.
    if( ($pagenow == 'edit-tags.php' || isset($_GET['action']) )) :    ?>    <script type="text/javascript">
    jQuery(function($) {
        $('#description, textarea#tag-description').closest('.form-field').hide();
    });
    </script><?php endif;
}



