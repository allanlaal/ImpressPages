<div class="ip">
    <div class="hidden" id="ipWidgetGalleryMenu">
        <div class="btn-toolbar" role="toolbar">
            <div class="btn-group">
                <button class="btn btn-default ipsEdit" role="button"><i class="fa fa-edit"></i></button>
                <button class="btn btn-default ipsLink" role="button"><i class="fa fa-link"></i></button>
                <button class="btn btn-default ipsSettings" role="button"><i class="fa fa-gears"></i></button>
                <button class="btn btn-default ipsDelete" role="button"><i class="fa fa-trash-o"></i></button>
            </div>
        </div>
    </div>
    <div class="hidden" id="ipWidgetGalleryControls">
        <div class="btn-toolbar" role="toolbar">
            <div class="btn-group">
                <button type="button" data-level="1" class="btn btn-default ipsAdd"><?php _e('Add image', 'ipAdmin'); ?></button>
            </div>
        </div>
    </div>
    <div id="ipWidgetGalleryEditPopup" class="modal"><?php /*Fade breaks image management*/?>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo __('Edit image', 'ipAdmin') ?></h4>
                </div>
                <div class="modal-body">
                    <div class="ipsEditScreen"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Cancel', 'ipAdmin') ?></button>
                    <button type="button" class="btn btn-primary ipsConfirm"><?php _e('Confirm', 'ipAdmin') ?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="ipWidgetGalleryLinkPopup" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo __('Link', 'ipAdmin') ?></h4>
                </div>
                <div class="modal-body">
                    <?php echo $linkForm ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Cancel', 'ipAdmin') ?></button>
                    <button type="button" class="btn btn-primary ipsConfirm"><?php _e('Confirm', 'ipAdmin') ?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="ipWidgetGallerySettingsPopup" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo __('Settings', 'ipAdmin') ?></h4>
                </div>
                <div class="modal-body">
                    <?php echo $settingsForm ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Cancel', 'ipAdmin') ?></button>
                    <button type="button" class="btn btn-primary ipsConfirm"><?php _e('Confirm', 'ipAdmin') ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
