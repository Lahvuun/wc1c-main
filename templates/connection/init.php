<?php defined('ABSPATH') || exit; ?>

<?php
    $title = __('Connection', 'wc1c');
    $title = apply_filters(WC1C_ADMIN_PREFIX . 'settings_connect_title', $title);

    $text = sprintf
    (
            '<p>%s</p> %s',
            __('To receive support and official services, need to go through the authorization of external applications.', 'wc1c'),
            __('Authorization of an external app occurs by going to the official WC1C and returning to the current site.', 'wc1c')
    );

    $text = apply_filters(WC1C_ADMIN_PREFIX . 'settings_connect_text', $text);
?>

<div class="wc1c-configurations-alert mb-2 mt-2">
    <h3><?php echo $title; ?></h3>
    <p><?php echo $text; ?></p>
</div>