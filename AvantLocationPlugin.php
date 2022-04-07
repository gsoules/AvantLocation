<?php

class AvantLocationPlugin extends Omeka_Plugin_AbstractPlugin
{
    protected $_hooks = array(
        'admin_head',
        'config',
        'config_form',
        'initialize',
        'install',
        'public_footer',
        'public_head'
    );

    protected $_filters = array(
    );

    protected function head()
    {
    }

    public function hookAdminHead($args)
    {
        $this->head();
    }

    public function hookConfig()
    {
        LocationConfig::saveConfiguration();
    }

    public function hookConfigForm()
    {
        require dirname(__FILE__) . '/config_form.php';
    }

    public function hookInitialize()
    {
        add_translation_source(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'languages');
    }

    public function hookInstall()
    {
        LocationConfig::setDefaultOptionValues();
    }

    public function hookPublicFooter($args)
    {
    }

    public function hookPublicHead($args)
    {
        $this->head();
    }
}
