<div class="ip">
    <div id="ipWidgetAudioPopup" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo __('Audio widget settings', 'ipAdmin') ?></h4>
                </div>

                <div class="modal-body">
                    <?php echo $formHtml; ?>

                    <div class="ipsFileList"></div>yyy
                    <audio preload="none" controls><source src="test.mp3" type="audio/mpeg">
                        Your browser does not support the audio element.</audio>xxx
                    <button type="button" class="btn btn-default ipsUploadAudioFile"><?php echo __('Upload', 'ipAdmin') ?></button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Cancel', 'ipAdmin') ?></button>
                    <button type="button" class="btn btn-primary ipsConfirm"><?php echo __('Confirm', 'ipAdmin') ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
