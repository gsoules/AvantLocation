<?php

define('CONFIG_LABEL_LOCATION', __('Location Element'));
define('CONFIG_LABEL_LOCATION_CURRENT', __('Current Location Element'));
define('CONFIG_LABEL_LOCATION_DATE', __('Location Move Date'));
define('CONFIG_LABEL_LOCATION_HISTORY', __('Location History Element'));
define('CONFIG_LABEL_LOCATION_HISTORY_COLUMNS', __('Location History Columns'));
define('CONFIG_LABEL_LOCATION_RULE', __('Location Rule'));
define('CONFIG_LABEL_LOCATION_STATUS', __('Location Status Element'));
define('CONFIG_LABEL_LOCATION_STORAGE', __('Storage Location Element'));
define('CONFIG_LABEL_LOCATION_WHO', __('Location Move By'));

class LocationConfig extends ConfigOptions
{
    const OPTION_LOCATION = 'avantlocation_location';
    const OPTION_LOCATION_CURRENT = 'avantlocation_current';
    const OPTION_LOCATION_DATE = 'avantlocation_date';
    const OPTION_LOCATION_HISTORY = 'avantlocation_history';
    const OPTION_LOCATION_HISTORY_COLUMNS = 'avantlocation_history_columns';
    const OPTION_LOCATION_RULE = 'avantlocation_rule';
    const OPTION_LOCATION_STATUS = 'avantlocation_status';
    const OPTION_LOCATION_STORAGE = 'avantlocation_storage';
    const OPTION_LOCATION_WHO = 'avantlocation_who';

    const LOCATION_RULE_HIDE = 1;
    const LOCATION_RULE_STATUS = 2;
    const LOCATION_RULE_LOCATION = 3;

    public static function getOptionTextForCurrent()
    {
        if (self::configurationErrorsDetected())
            $text = $_POST[self::OPTION_LOCATION_CURRENT];
        else
            $text = ItemMetadata::getElementNameFromId(get_option(self::OPTION_LOCATION_CURRENT));
        return $text;
    }

    public static function getOptionTextForDate()
    {
        if (self::configurationErrorsDetected())
            $text = $_POST[self::OPTION_LOCATION_DATE];
        else
            $text = ItemMetadata::getElementNameFromId(get_option(self::OPTION_LOCATION_DATE));
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

    public static function getOptionTextForLocation()
    {
        if (self::configurationErrorsDetected())
            $text = $_POST[self::OPTION_LOCATION];
        else
            $text = ItemMetadata::getElementNameFromId(get_option(self::OPTION_LOCATION));
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

    public static function getOptionTextForWho()
    {
        if (self::configurationErrorsDetected())
            $text = $_POST[self::OPTION_LOCATION_WHO];
        else
            $text = ItemMetadata::getElementNameFromId(get_option(self::OPTION_LOCATION_WHO));
        return $text;
    }

    public static function saveConfiguration()
    {
        self::saveOptionDataForCurrent();
        self::saveOptionDataForDate();
        self::saveOptionDataForHistory();
        self::saveOptionDataForHistoryColumns();
        self::saveOptionDataForLocation();
        self::saveOptionDataForStatus();
        self::saveOptionDataForStorage();
        self::saveOptionDataForWho();
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

    public static function saveOptionDataForDate()
    {
        $date = $_POST[self::OPTION_LOCATION_DATE];
        set_option(self::OPTION_LOCATION_DATE, $date);
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

    public static function saveOptionDataForLocation()
    {
        $elementName = $_POST[self::OPTION_LOCATION];
        $elementId = ItemMetadata::getElementIdForElementName($elementName);
        if ($elementId == 0)
            throw new Omeka_Validate_Exception(self::OPTION_LOCATION. ': ' . __('"%s" is not an element.', $elementName));
        set_option(self::OPTION_LOCATION, $elementId);
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

    public static function saveOptionDataForWho()
    {
        $who = $_POST[self::OPTION_LOCATION_WHO];
        set_option(self::OPTION_LOCATION_WHO, $who);
    }
}