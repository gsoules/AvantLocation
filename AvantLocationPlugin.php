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
        $this->createHistoryRow($item);
    }

    public function hookBeforeSaveItem($args)
    {
        $item = $args['record'];
        //$this->validateLocationValues($item);
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

    protected function createHistoryRow($item): void
    {
        // Get the information that will go into a new history row.
        $date = LocationConfig::getOptionTextForDate();
        if ($date == "")
        {
            $dateTime = new DateTime();
            $date = $dateTime->format('Y-m-d');
        }

        $who = LocationConfig::getOptionTextForWho();
        if ($who == "")
        {
            $who = current_user()->username;
        }

        $statusElementName = LocationConfig::getOptionTextForStatus();
        $currentElementName = LocationConfig::getOptionTextForCurrent();
        $status = ItemMetadata::getElementTextForElementName($item, $statusElementName);
        $currentLocation = ItemMetadata::getElementTextForElementName($item, $currentElementName);

        // Get the current history from the post instead of by calling getElementTextForElementName
        // because the latter call, during a save, causes the element text records to get locked
        // which prevents them from being updated as needs to be done here to update the history.
        $historyElementName = LocationConfig::getOptionTextForHistory();
        $oldHistory = AvantCommon::getPostTextForElementName($historyElementName);

        // Get the current history's first row.
        $existingRows = array_map('trim', explode(PHP_EOL, $oldHistory));
        $oldFirstRow = count($existingRows) > 0 ? $existingRows[0] : "";

        // When the old first row is blank, that means, don't update the history.
        $newFirstRow = "";
        if ($oldFirstRow != "")
        {
            // Create a new first row.
            $newFirstRow = "$date | $status | $currentLocation | $who";
        }

        // Compare the new and old first rows, ignoring case and white space.
        // If they match, don't create a new history row.
        if ($oldFirstRow)
        {
            if (strtolower(str_replace(' ', '', $newFirstRow)) == strtolower(str_replace(' ', '', $oldFirstRow)))
                $newFirstRow = "";
        }

        $newHistory = $newFirstRow;
        foreach ($existingRows as $row)
        {
            if ($row == "")
                continue;
            if ($newHistory != "")
                $newHistory .= PHP_EOL;
            $newHistory .= $row;
        }

        // Update the history.
        $historyElementId = ItemMetadata::getElementIdForElementName($historyElementName);
        ItemMetadata::updateElementText($item, $historyElementId, $newHistory);
    }

    protected function validateLocationValues($item): void
    {
        // This method ensures that both the location status and current location changed
        // or that neither changed. It reports an error if only one or the other changed.

        $statusElementName = LocationConfig::getOptionTextForStatus();
        $currentElementName = LocationConfig::getOptionTextForCurrent();
        $status = ItemMetadata::getElementTextForElementName($item, $statusElementName);
        $currentLocation = ItemMetadata::getElementTextForElementName($item, $currentElementName);

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
