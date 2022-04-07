<?php

class AvantLocationPlugin extends Omeka_Plugin_AbstractPlugin
{
    protected $_hooks = array(
        'admin_head',
        'after_save_item',
        'before_save_item',
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
        $version = OMEKA_VERSION . '.1';
        queue_css_file('avantlocation', 'all', false, 'css', $version);
    }

    public function hookAdminHead($args)
    {
        $this->head();
    }

    public function hookAfterSaveItem($args)
    {
        $item = $args['record'];

        $locationElementName = LocationConfig::getOptionTextForLocation();

        if (strlen($locationElementName) == 0)
            return;

        $locationElementId = ItemMetadata::getElementIdForElementName($locationElementName);

        $locationValue = "";
        $rule = 3;
        switch ($rule)
        {
            case LocationConfig::LOCATION_RULE_HIDE:
                $locationValue = "";
                break;

            case LocationConfig::LOCATION_RULE_STATUS:
            case LocationConfig::LOCATION_RULE_LOCATION:
                $statusElementName = LocationConfig::getOptionTextForStatus();
                $status = ItemMetadata::getElementTextForElementName($item, $statusElementName);
                $locationValue = $status;

                if ($rule == LocationConfig::LOCATION_RULE_LOCATION)
                {
                    $currentElementName = LocationConfig::getOptionTextForCurrent();
                    $current = ItemMetadata::getElementTextForElementName($item, $currentElementName);
                    $locationValue .= " : $current";
                }
                break;
        }


        ItemMetadata::updateElementText($item, $locationElementId, $locationValue);
    }

    public function hookBeforeSaveItem($args)
    {
        $item = $args['record'];

        $statusElementName = LocationConfig::getOptionTextForStatus();
        $oldStatus = ItemMetadata::getElementTextForElementName($item, $statusElementName);
        $currentElementName = LocationConfig::getOptionTextForCurrent();
        $oldCurrent = ItemMetadata::getElementTextForElementName($item, $currentElementName);

        $newStatus = AvantCommon::getPostTextForElementName($statusElementName);
        $newCurrent = AvantCommon::getPostTextForElementName($currentElementName);

        $statusChanged = $newStatus != $oldStatus;
        $currentChanged = $newCurrent != $oldCurrent;

        if (!$statusChanged && !$currentChanged)
            return;

        if ($statusChanged && $currentChanged)
            return;

        if ($statusChanged)
        {
            AvantElements::addError($item, $statusElementName, __('When you change the location status you must also change current location.'));
            return;
        }

        if ($currentChanged)
        {
            AvantElements::addError($item, $currentElementName, __('When you change the current location you must also change the location status.'));
            return;
        }
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
