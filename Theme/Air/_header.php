<?php echo ipDoctypeDeclaration(); ?>
<html<?php echo ipHtmlAttributes(); ?>>
<head>
    <?php ipAddCss('assets/theme.css'); ?>
    <?php echo ipHead(); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="wrapper clearfix">
    <header class="clearfix col_12">
        <?php echo ipSlot('logo'); ?>
        <div class="right">
            <span class="currentPage"><?php echo esc(ipContent()->getCurrentPage() ? ipContent()->getCurrentPage()->getTitle() : ''); ?></span>
            <a href="#" class="topmenuToggle">&nbsp;</a>
            <div class="topmenu">
                <?php echo ipSlot('menu', 'menu1'); ?>
                <?php if (count(ipContent()->getLanguages()) > 1) { ?>
                    <div class="languages">
                        <?php echo ipSlot('languages'); ?>
                    </div>
                <?php } ?>
            </div>

            <a href="#" class="searchToggle">&nbsp;</a>
            <?php echo ipSlot('search'); ?>
        </div>
    </header>
