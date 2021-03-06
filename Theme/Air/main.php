<?php echo ipView('_header.php')->render(); ?>
    <div class="sidenav col_12 col_md_12 col_lg_3 left">
        <nav> <!-- add class="collapse" if you want subpages to be automatically hidden if inactive -->
            <?php
                // generate 2 - 7 levels submenu of top menu.
                // please note that it is possible to generate second level only if first level item is selected
                $pages = \Ip\Menu\Helper::getMenuItems('menu1', 2, 7);

                // submenu of currently active top menu item
                //$pages = \Ip\Menu\Helper::getChildItems();

                echo ipSlot('menu', 'menu2');
            ?>
        </nav>
    </div>
    <div class="main col_12 col_md_12 col_lg_8 right">
        <div class="breadcrumb">
            <?php echo ipSlot('breadcrumb'); ?>
        </div>
        <?php echo ipBlock('main')->render(); ?>
    </div>
    <div class="side col_12 col_md_12 col_lg_3 left">
        <aside>
            <?php echo ipBlock('side1')->asStatic()->render(); ?>
        </aside>
    </div>
    <div class="clear"></div>
<?php echo ipView('_footer.php')->render(); ?>
