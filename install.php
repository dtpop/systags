<?php

/**
 * Systags Addon.
 *
 * @author wb[at]dtp-net[dot]de Wolfgang Bund
 */

$addon = rex_addon::get('systags');

rex_yform_manager_table::deleteCache();

$content = rex_file::get(rex_path::addon('systags', 'install/tablesets/yform_systags.json'));
if ($content) {
    rex_yform_manager_table_api::importTablesets($content);
}

rex_delete_cache();
rex_yform_manager_table::deleteCache();
