<?php if ($this->getDoctype() == \Ip\Response\Layout::DOCTYPE_HTML5) { ?>
    <meta charset="<?php echo $charset; ?>" />
<?php } else { ?>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset; ?>" />
<?php } ?>
    <title><?php echo esc($title); ?></title>
    <link rel="shortcut icon" href="<?php echo esc($favicon, 'attr'); ?>" />
    <meta name="keywords" content="<?php echo esc($keywords, 'attr'); ?>" />
    <meta name="description" content="<?php echo esc($description, 'attr'); ?>" />
    <meta name="generator" content="ImpressPages" />
<?php foreach ($css as $key => $file) { ?>
    <link href="<?php echo $file['value']; ?>" rel="stylesheet" type="text/css" <?php
    if (is_array($file['attributes'])) {
        echo join(
            ' ',
            array_map(
                function ($sKey, $sValue) {
                    return esc($sKey) . '="' . esc($sValue) . '"';
                },
                array_keys($file['attributes']),
                array_values($file['attributes'])
            )
        );
    }
    ?>/>
<?php } ?>
