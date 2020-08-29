<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       -
 * @since      1.0.0
 *
 * @package    Linkoption
 * @subpackage Linkoption/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<form method="post" name="my_options" action="options.php">

    <?php

    $options = get_option($this->plugin_name);

    // var_dump($options); exit;

    settings_fields( $this->plugin_name );
    do_settings_sections( $this->plugin_name );
    
    ?>

	<h1><?php echo esc_html( get_admin_page_title() ); ?></h2>
    <h3><?php _e('Links options', $this->plugin_name); ?>:</h4>

    <fieldset>
        <legend class="screen-reader-text"><span><?php _e('Enable nofollow attribute for external links (rel="nofollow")', $this->plugin_name);?></span></legend>
        <label for="<?php echo $this->plugin_name;?>-rel_nofollow_attr">
            <input name="<?php echo $this->plugin_name;?>[rel_nofollow_attr]" type="checkbox" id="<?php echo $this->plugin_name;?>-rel_nofollow_attr" value="1" <?php if(isset($options['rel_nofollow_attr'])) { checked( $options['rel_nofollow_attr'], '1', TRUE ); } ?> />
            <span><?php _e('Enable nofollow attribute for external links (rel="nofollow")', $this->plugin_name);?></span>
        </label>
    </fieldset>

    <fieldset>
        <legend class="screen-reader-text"><span><?php _e('Open links in a new tab (target="_blank")', $this->plugin_name);?></span></legend>
        <label for="<?php echo $this->plugin_name;?>-target_blank_attr">
            <input name="<?php echo $this->plugin_name;?>[target_blank_attr]" type="checkbox" id="<?php echo $this->plugin_name;?>-target_blank_attr" value="1" <?php if(isset($options['target_blank_attr'])) { checked( $options['target_blank_attr'], '1', TRUE ); } ?> />
            <span><?php _e('Open links in a new tab (target="_blank")', $this->plugin_name);?></span>
        </label>
    </fieldset>

    <?php
    
    $post_types = $this->post_types_list();
    
    if(isset($post_types) && !empty($post_types)) { ?>

        <h3><?php _e('Post types - apply links options to selected post types', $this->plugin_name); ?>:</h4>

        <?php foreach( $post_types as $post_type ) { ?>

            <fieldset>
                <legend class="screen-reader-text"><span><?php _e($post_type, $this->plugin_name);?></span></legend>
                <label for="<?php echo $this->plugin_name;?>-<?=$post_type;?>">
                    <input name="<?php echo $this->plugin_name;?>[<?=$post_type;?>]" type="checkbox" id="<?php echo $this->plugin_name;?>-<?=$post_type;?>" value="1" <?php if(isset($options[$post_type])) { checked( $options[$post_type], '1', TRUE ); } ?> />
                    <span><?php _e($post_type, $this->plugin_name);?></span>
                </label>
            </fieldset>

        <?php } ?>
        
    <?php } ?>

    <?php submit_button(__('Save plugin settings', $this->plugin_name), 'primary','submit', TRUE); ?>

</form>