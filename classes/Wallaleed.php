<?php

class Wallaleed {
    const CONFIG_FIELD = 'plugin_wallabag_url';
    const ACTION_VALUE = 'wallaleed_update';
    const DEFAULT_VALUE = 'http://wallabag.mondomaine.com';

    public function install() {
        $configuration = new Configuration();
        $configuration->put(self::CONFIG_FIELD, self::DEFAULT_VALUE);
        $_SESSION['configuration'] = null;
    }

    public function uninstall() {
        $configuration = new Configuration();
        $configuration->delete(array('key' => self::CONFIG_FIELD));
        $_SESSION['configuration'] = null;
    }
}

?>
