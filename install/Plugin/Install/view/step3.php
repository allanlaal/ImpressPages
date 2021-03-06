<h1><?php _e('Database installation', 'Install'); ?></h1>

<div class="errorContainer"></div>
<form role="form" class="ipsForm">
    <div class="form-group">
        <label for="db_server"><?php _e('Database Host (eg. localhost or 127.0.0.1)', 'Install'); ?></label>
        <input type="text" class="form-control" id="db_server" name="server" value="<?php echo htmlspecialchars($db['hostname']); ?>">
    </div>
    <div class="form-group">
        <label for="db_user"><?php _e('User name', 'Install'); ?></label>
        <input type="text" class="form-control" id="db_user" autocomplete="off" name="db_user" value="<?php echo htmlspecialchars($db['username']); ?>">
    </div>
    <div class="form-group">
        <label for="db_pass"><?php _e('User password', 'Install'); ?></label>
        <input type="password" class="form-control" id="db_pass" autocomplete="off" name="db_pass" value="<?php echo htmlspecialchars($db['password']); ?>">
    </div>
    <div class="form-group">
        <label for="db_db"><?php _e('Database name', 'Install'); ?></label>
        <input type="text" class="form-control" id="db_db" name="db" value="<?php echo htmlspecialchars($db['database']); ?>">
    </div>
    <div class="form-group">
        <label for="db_prefix"><?php _e('Table prefix (use underscore to separate prefix).', 'Install'); ?></label>
        <input type="text" maxlength="7" class="form-control" id="db_prefix" name="prefix" value="<?php echo htmlspecialchars($db['tablePrefix']); ?>">
    </div>
    <input type="submit" style="position: absolute; left: -999999px; width: 1px; height: 1px; visibility: hidden;" tabindex="-1" />
</form>
<p class="text-right">
    <a class="btn btn-default" href="?step=2"><?php _e('Back', 'Install') ?></a>
    <a class="btn btn-primary ipsStep3" href="#"><?php _e('Next', 'Install') ?></a>
</p>
