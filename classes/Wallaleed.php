<?php

class Wallaleed {
    const CONFIG_FIELD = 'plugin_wallabag_url';

    public function uninstall() {
        $configuration = new Configuration();
        $configuration->delete(array('key' => self::CONFIG_FIELD));
        $_SESSION['configuration'] = null;
    }
}

?>
