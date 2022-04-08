<?php

class AvantLocationPlugin extends Omeka_Plugin_AbstractPlugin
{
    protected $locationHistoryChanged = false;

    protected $_hooks = array(
        'admin_head',
        'after_save_item',
        'before_save_item',
        'config',
        'config_form',
        'initialize',
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
        $this->detectLocationHistoryChange($item);
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
        if (!$this->locationHistoryChanged)
            return;

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

        // Get the location status.
        $statusElementName = LocationConfig::getOptionTextForStatus();
        $statusElementId = ItemMetadata::getElementIdForElementName($statusElementName);
        $status = ItemMetadata::getElementTextFromElementId($item, $statusElementId);

        // Get the temporary location.
        $temporaryElementName = LocationConfig::getOptionTextForTemporary();
        $temporaryElementId = ItemMetadata::getElementIdForElementName($temporaryElementName);
        $temporaryLocation = ItemMetadata::getElementTextFromElementId($item, $temporaryElementId);

        $historyLocation = $temporaryLocation;

        if ($temporaryLocation == __("<none>"))
        {
            // Get the storage location.
            $storageElementName = LocationConfig::getOptionTextForStorage();
            $storageElementId = ItemMetadata::getElementIdForElementName($storageElementName);
            $historyLocation = ItemMetadata::getElementTextFromElementId($item, $storageElementId);

            // Set the temporary location to blank.
            ItemMetadata::updateElementText($item, $temporaryElementId, "");
        }

        // Get the location history.
        $historyElementName = LocationConfig::getOptionTextForHistory();
        $historyElementId = ItemMetadata::getElementIdForElementName($historyElementName);
        $oldHistory = ItemMetadata::getElementTextFromElementId($item, $historyElementId);

        // Get the history's first row.
        $existingRows = array_map('trim', explode(PHP_EOL, $oldHistory));
        $oldFirstRow = count($existingRows) > 0 ? $existingRows[0] : "";

        // Create a new first history row.
        $newFirstRow = "$date | $status | $historyLocation | $who";

        // Compare the new and old first history rows, ignoring case and white space.
        // If they match, don't add a new row.
        if (strtolower(str_replace(' ', '', $newFirstRow)) == strtolower(str_replace(' ', '', $oldFirstRow)))
            $newFirstRow = "";

        // Create a new history starting with the new first row. Discard any blank rows.
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
        ItemMetadata::updateElementText($item, $historyElementId, $newHistory);
    }

    protected function detectLocationHistoryChange($item): void
    {
        // Get the old location status value.
        $statusElementName = LocationConfig::getOptionTextForStatus();
        $statusElementId = ItemMetadata::getElementIdForElementName($statusElementName);
        $status = ItemMetadata::getElementTextFromElementId($item, $statusElementId);

        // Get the old temporary location value.
        $temporaryElementName = LocationConfig::getOptionTextForTemporary();
        $temporaryElementId = ItemMetadata::getElementIdForElementName($temporaryElementName);
        $temporaryLocation = ItemMetadata::getElementTextFromElementId($item, $temporaryElementId);

        // Get the new location status and temporary location values
        $newStatus = AvantCommon::getPostTextForElementName($statusElementName);
        $newtemporary = AvantCommon::getPostTextForElementName($temporaryElementName);

        $this->locationHistoryChanged = $newStatus != $status || $newtemporary != $temporaryLocation;
    }
}
