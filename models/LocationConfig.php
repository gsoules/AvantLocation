<?php

define('CONFIG_LABEL_LOCATION_CURRENT', __('Current Location Element'));
define('CONFIG_LABEL_LOCATION_HISTORY', __('Location History Element'));
define('CONFIG_LABEL_LOCATION_HISTORY_COLUMNS', __('Location History Columns'));
define('CONFIG_LABEL_LOCATION_NOTES', __('Location Notes Element'));
define('CONFIG_LABEL_LOCATION_PUBLIC_STATUS', __('Location Public Status Element'));
define('CONFIG_LABEL_LOCATION_PUBLIC_STATUS_RULES', __('Location Public Status Rule'));
define('CONFIG_LABEL_LOCATION_STATUS', __('Location Status Element'));
define('CONFIG_LABEL_LOCATION_STORAGE', __('Storage Location Element'));

class LocationConfig extends ConfigOptions
{
    const OPTION_LOCATION_CURRENT = 'avantlocation_current';
    const OPTION_LOCATION_HISTORY = 'avantlocation_history';
    const OPTION_LOCATION_HISTORY_COLUMNS = 'avantlocation_history_columns';
    const OPTION_LOCATION_NOTES = 'avantlocation_notes';
    const OPTION_LOCATION_PUBLIC_STATUS = 'avantlocation_public_status';
    const OPTION_LOCATION_PUBLIC_STATUS_RULE = 'avantlocation_public_rule';
    const OPTION_LOCATION_STATUS = 'avantlocation_status';
    const OPTION_LOCATION_STORAGE = 'avantlocation_storage';


    public static function getOptionTextForCurrent()
    {
        if (self::configurationErrorsDetected())
            $text = $_POST[self::OPTION_LOCATION_CURRENT];
        else
            $text = ItemMetadata::getElementNameFromId(get_option(self::OPTION_LOCATION_CURRENT));
        return $text;
    }

    public static function getOptionTextForHistory()
    {
        if (self::configurationErrorsDetected())
            $text = $_POST[self::OPTION_LOCATION_HISTORY];
        else
            $text = ItemMetadata::getElementNameFromId(get_option(self::OPTION_LOCATION_HISTORY));
        return $text;
    }

    public static function getOptionTextForHistoryColumns()
    {
        $text = get_option(self::OPTION_LOCATION_HISTORY_COLUMNS);
        return $text;
    }

    public static function getOptionTextForNotes()
    {
        if (self::configurationErrorsDetected())
            $text = $_POST[self::OPTION_LOCATION_NOTES];
        else
            $text = ItemMetadata::getElementNameFromId(get_option(self::OPTION_LOCATION_NOTES));
        return $text;
    }

    public static function getOptionTextForStatus()
    {
        if (self::configurationErrorsDetected())
            $text = $_POST[self::OPTION_LOCATION_STATUS];
        else
            $text = ItemMetadata::getElementNameFromId(get_option(self::OPTION_LOCATION_STATUS));
        return $text;
    }

    public static function getOptionTextForStorage()
    {
        if (self::configurationErrorsDetected())
            $text = $_POST[self::OPTION_LOCATION_STORAGE];
        else
            $text = ItemMetadata::getElementNameFromId(get_option(self::OPTION_LOCATION_STORAGE));
        return $text;
    }

    public static function saveConfiguration()
    {
        self::saveOptionDataForCurrent();
        self::saveOptionDataForHistory();
        self::saveOptionDataForHistoryColumns();
        self::saveOptionDataForNotes();
        self::saveOptionDataForStatus();
        self::saveOptionDataForStorage();
    }

    public static function saveOptionDataForCurrent()
    {
        $elementName = $_POST[self::OPTION_LOCATION_CURRENT];
        $elementId = ItemMetadata::getElementIdForElementName($elementName);
        if ($elementId == 0)
        {
            throw new Omeka_Validate_Exception(self::OPTION_LOCATION_CURRENT . ': ' . __('"%s" is not an element.', $elementName));
        }
        set_option(self::OPTION_LOCATION_CURRENT, $elementId);
    }

    public static function saveOptionDataForHistory()
    {
        $elementName = $_POST[self::OPTION_LOCATION_HISTORY];
        $elementId = ItemMetadata::getElementIdForElementName($elementName);
        if ($elementId == 0)
            throw new Omeka_Validate_Exception(self::OPTION_LOCATION_HISTORY. ': ' . __('"%s" is not an element.', $elementName));
        set_option(self::OPTION_LOCATION_HISTORY, $elementId);
    }

    public static function saveOptionDataForHistoryColumns()
    {
        $text = $_POST[self::OPTION_LOCATION_HISTORY_COLUMNS];
        set_option(self::OPTION_LOCATION_HISTORY_COLUMNS, $text);
    }

    public static function saveOptionDataForNotes()
    {
        $elementName = $_POST[self::OPTION_LOCATION_NOTES];
        $elementId = ItemMetadata::getElementIdForElementName($elementName);
        if ($elementId == 0)
            throw new Omeka_Validate_Exception(self::OPTION_LOCATION_NOTES. ': ' . __('"%s" is not an element.', $elementName));
        set_option(self::OPTION_LOCATION_NOTES, $elementId);
    }

    public static function saveOptionDataForStatus()
    {
        $elementName = $_POST[self::OPTION_LOCATION_STATUS];
        $elementId = ItemMetadata::getElementIdForElementName($elementName);
        if ($elementId == 0)
            throw new Omeka_Validate_Exception(self::OPTION_LOCATION_STATUS. ': ' . __('"%s" is not an element.', $elementName));
        set_option(self::OPTION_LOCATION_STATUS, $elementId);
    }

    public static function saveOptionDataForStorage()
    {
        $elementName = $_POST[self::OPTION_LOCATION_STORAGE];
        $elementId = ItemMetadata::getElementIdForElementName($elementName);
        if ($elementId == 0)
            throw new Omeka_Validate_Exception(self::OPTION_LOCATION_STORAGE. ': ' . __('"%s" is not an element.', $elementName));
        set_option(self::OPTION_LOCATION_STORAGE, $elementId);
    }
}