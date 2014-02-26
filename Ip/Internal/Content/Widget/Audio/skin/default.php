<div class="ipsContainer">
    <?php if (ipIsManagementState() && empty($audioHtml)) { ?>
        <img style="max-width: 100%; cursor: pointer;" class="defaultImage" src="<?php echo ipFileUrl('Ip/Internal/Content/Widget/Audio/assets/audio.gif') ?>" /> <!-- //TODOX MOVE STYLE TO CSS -->
    <?php } else { ?>
        <?php echo isset($audioHtml) ? $audioHtml : ''; ?>
    <?php } ?>
    <div style="clear: both;"></div>

</div>


