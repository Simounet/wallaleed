<?php
/*
@name wallaleed
@author Simounet <http://www.simounet.net>
@link https://github.com/Leed-market/wallaleed
@licence GPLv3
@version 1.0.0
@description This plugin wallaleed add an article sharing option from Leed to <a target="_blank" href="https://wallabag.org/">wallabag (v2)</a>.
*/

function wallaleedPluginAddTo(&$event){
    $configurationManager = new Configuration();
    $configurationManager->getAll();
    $wallabagUrl = $configurationManager->get('plugin_wallabag_url');
    if( empty($wallabagUrl) ) {
        return false;
    }

    echo '<a title="'._t('P_WALLALEED_SHARE_WITH_WALLABAG').'" target="_blank" href="'.$wallabagUrl.'bookmarklet?url='.$event->getLink().'">'._t('P_WALLALEED_WALLABAG_EXCLAMATION').'</a>';
}

function wallaleedPluginSettingsLink(&$myUser){
    echo '<li><a class="toggle" href="#wallabag-plugin">'._t('P_WALLALEED_WALLABAG').'</a></li>';
}

function wallaleedPluginSettingsBlock(&$myUser){
    $configurationManager = new Configuration();
    $configurationManager->getAll();
    echo '
    <section class="wallabag-plugin">
        <form action="action.php?action=wallaleed_update" method="POST">
        <h2>'._t('P_WALLALEED_PLUGIN_TITLE').'</h2>
        <p class="wallabagBlock">
        <label for="plugin_wallabag_url">'._t('P_WALLALEED_WALLABAG_LINK').'</label>
        <input type="text" placeholder="http://wallabag.mondomaine.com" value="'.$configurationManager->get('plugin_wallabag_url').'" id="plugin_wallabag_url" name="plugin_wallabag_url" />
        <input type="submit" class="button" value="'._t('P_WALLALEED_SAVE').'"><br/>
        </p>
        '._t('P_WALLALEED_NB_INFO').'
        </form>
    </section>
    ';
}

function wallaleedPluginUpdateUrl($_){
    $myUser = (isset($_SESSION['currentUser'])?unserialize($_SESSION['currentUser']):false);
    if($myUser===false) exit(_t('P_WALLALEED_CONNECTION_ERROR'));

    if($_['action']=='wallaleed_update'){
        $configurationManager = new Configuration();
        $wallabagUrl = $_['plugin_wallabag_url'];
        $wallabagUrl .= (substr($wallabagUrl, -1) === '/' ? '' : '/');
        $configurationManager->put('plugin_wallabag_url', $wallabagUrl);
        $_SESSION['configuration'] = null;
        header('location: settings.php');
    }
}

Plugin::addHook('event_post_top_options', 'wallaleedPluginAddTo');
Plugin::addHook('setting_post_link', 'wallaleedPluginSettingsLink');
Plugin::addHook('setting_post_section', 'wallaleedPluginSettingsBlock');
Plugin::addHook("action_post_case", "wallaleedPluginUpdateUrl");

?>
