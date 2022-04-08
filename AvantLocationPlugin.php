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

        $this->assignPublicLocationValue($item);

        $status = ItemMetadata::getElementTextForElementName($item, LocationConfig::getOptionTextForStatus());
        $currentLocation = ItemMetadata::getElementTextForElementName($item, LocationConfig::getOptionTextForCurrent());

        $this->createHistoryRow($item, $status, $currentLocation);
    }

    public function hookBeforeSaveItem($args)
    {
        $item = $args['record'];

        $status = ItemMetadata::getElementTextForElementName($item, LocationConfig::getOptionTextForStatus());
        $currentLocation = ItemMetadata::getElementTextForElementName($item, LocationConfig::getOptionTextForCurrent());

        $this->validateLocationValues($item, $status, $currentLocation);
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
    }

    public function hookPublicFooter($args)
    {
    }

    public function hookPublicHead($args)
    {
        $this->head();
    }

    protected function assignPublicLocationValue($item): void
    {
        // Get the element, if one exists, that's used to show the item's public location.
        $publicElementName = LocationConfig::getOptionTextForPublic();
        if (strlen($publicElementName) == 0)
            return;

        // Get the private location status.
        $statusElementName = LocationConfig::getOptionTextForStatus();
        $status = ItemMetadata::getElementTextForElementName($item, $statusElementName);

        // Determine if the private status can be used as the public location.
        $allowedValues = array_map('trim', explode(',', LocationConfig::getOptionTextForPublicValues()));
        $publicValue = in_array($status, $allowedValues) ? $status : "";

        // Set the value of the public location element.
        $publicElementId = ItemMetadata::getElementIdForElementName($publicElementName);
        ItemMetadata::updateElementText($item, $publicElementId, $publicValue);
    }

    protected function createHistoryRow($item, $status, $currentLocation): void
    {
        $date = LocationConfig::getOptionTextForDate();
        $who = LocationConfig::getOptionTextForWho();

        $row = "$date | $status | $currentLocation | $who";

        $historyElementName = LocationConfig::getOptionTextForHistory();
        $historyElementId = ItemMetadata::getElementIdForElementName($historyElementName);

        $history = AvantCommon::getPostTextForElementName($historyElementName);


        //$history = ItemMetadata::getElementTextForElementName($item, $historyElementName);
        $history = $row . "<br />" . PHP_EOL . $history;
        ItemMetadata::updateElementText($item, $historyElementId, $history);
    }

    protected function validateLocationValues($item, $status, $currentLocation): void
    {
        $statusElementName = LocationConfig::getOptionTextForStatus();
        $currentElementName = LocationConfig::getOptionTextForCurrent();

        // Get the form values for status and current location.
        $newStatus = AvantCommon::getPostTextForElementName($statusElementName);
        $newCurrent = AvantCommon::getPostTextForElementName($currentElementName);

        // Determine if both or neither of the status and current location values changed.
        $statusChanged = $newStatus != $status;
        $currentChanged = $newCurrent != $currentLocation;

        if (!$statusChanged && !$currentChanged)
            return;

        if ($statusChanged && $currentChanged)
            return;

        // Report an error when the status changed but the current value stayed the same and vice-versa.
        if ($statusChanged)
            AvantElements::addError($item, $statusElementName, __('When you change the location status you must also change current location.'));
        if ($currentChanged)
            AvantElements::addError($item, $currentElementName, __('When you change the current location you must also change the location status.'));
    }
}
