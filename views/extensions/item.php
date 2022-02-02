<?php defined('ABSPATH') || exit; ?>

<div class="mb-2 mt-2 rounded-1 border border-3 bg-white">
    <div class="card-header p-2 border-0">
        <h2 class="card-title mt-0 mb-0 float-start">
	        <?php echo $args['object']->getMeta('name', __('none')); ?>
        </h2>
        <div class="clearfix"></div>
    </div>
    <div class="card-body p-2">
        <div class="row g-0">
            <div class="col-24 col-md-15 col-lg-18">
                <p class="card-text mt-2 mb-2">
		            <?php echo $args['object']->getMeta('description', __('none')); ?>
                </p>
            </div>
            <div class="col-24 mt-2 mt-md-0 col-md-9 col-lg-6">
                <ul class="list-group m-0">
                    <li class="list-group-item m-0 list-group-item-light">
                        <?php _e('ID:', 'wc1c'); ?>
                        <span class="badge bg-info"><?php echo $args['id']; ?></span>
                    </li>
                    <li class="list-group-item m-0">
                            <?php _e('Version:', 'wc1c'); ?>
                            <span class="badge btn-sm bg-success">
                            <?php echo $args['object']->getMeta('version', __('none')); ?>
                         </span>
                    </li>
                    <li class="list-group-item m-0">
		                <?php _e('Versions WC1C:', 'wc1c'); ?>
                        от
                        <span class="badge btn-sm bg-success">
                            <?php echo $args['object']->getMeta('version_wc1c_min', __('none')); ?>
                         </span>
                        до
                        <span class="badge btn-sm bg-success">
                            <?php echo $args['object']->getMeta('version_wc1c_max', __('none')); ?>
                        </span>
                    </li>
                    <li class="list-group-item m-0">
		                <?php _e('Versions PHP:', 'wc1c'); ?>
                        от
                        <span class="badge btn-sm bg-success">
                            <?php echo $args['object']->getMeta('version_php_min', __('none')); ?>
                        </span>
                        до
                        <span class="badge btn-sm bg-success">
                            <?php echo $args['object']->getMeta('version_php_max', __('none')); ?>
                         </span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="card-footer p-2 border-0">
        <a class="text-decoration-none button button-secondary" href="#">
		    <?php _e('Deactivate'); ?>
        </a>
    </div>
</div>