<?php
$view = get_view();

$currentElementName = LocationConfig::getOptionTextForCurrent();
$moveBy = LocationConfig::getOptionTextForWho();
$moveDate = LocationConfig::getOptionTextForDate();
$historyElementName = LocationConfig::getOptionTextForHistory();
$historyColumns = LocationConfig::getOptionTextForHistoryColumns();
$publicElementName = LocationConfig::getOptionTextForPublic();
$publicValues = LocationConfig::getOptionTextForPublicValues();
$statusElementName = LocationConfig::getOptionTextForStatus();
$storageElementName = LocationConfig::getOptionTextForStorage();

?>

<div class="plugin-help learn-more">
    <a href="https://digitalarchive.us/plugins/avantlocation/" target="_blank"><?php echo __("Learn about the configuration options on this page"); ?></a>
</div>

<div class="field">
    <div class="two columns alpha">
        <label><?php echo CONFIG_LABEL_LOCATION_STORAGE; ?></label>
    </div>
    <div class="inputs five columns omega">
        <p class="explanation"><?php echo __("The element used to store an item's permanent location storage."); ?></p>
        <?php echo $view->formText(LocationConfig::OPTION_LOCATION_STORAGE, $storageElementName); ?>
    </div>
</div>

<div class="field">
    <div class="two columns alpha">
        <label><?php echo CONFIG_LABEL_LOCATION_CURRENT; ?></label>
    </div>
    <div class="inputs five columns omega">
        <p class="explanation"><?php echo __("The element used to store an item's current location."); ?></p>
        <?php echo $view->formText(LocationConfig::OPTION_LOCATION_CURRENT, $currentElementName); ?>
    </div>
</div>

<div class="field">
    <div class="two columns alpha">
        <label><?php echo CONFIG_LABEL_LOCATION_STATUS; ?></label>
    </div>
    <div class="inputs five columns omega">
        <p class="explanation"><?php echo __("The element used to store an item's location status."); ?></p>
        <?php echo $view->formText(LocationConfig::OPTION_LOCATION_STATUS, $statusElementName); ?>
    </div>
</div>

<div class="field">
    <div class="two columns alpha">
        <label><?php echo CONFIG_LABEL_LOCATION_HISTORY; ?></label>
    </div>
    <div class="inputs five columns omega">
        <p class="explanation"><?php echo __("The element used to store an item's location history."); ?></p>
        <?php echo $view->formText(LocationConfig::OPTION_LOCATION_HISTORY, $historyElementName); ?>
    </div>
</div>

<div class="field">
    <div class="two columns alpha">
        <label><?php echo CONFIG_LABEL_LOCATION_HISTORY_COLUMNS; ?></label>
    </div>
    <div class="inputs five columns omega">
        <p class="explanation"><?php echo __("The names of the columns in the location history."); ?></p>
        <?php echo $view->formText(LocationConfig::OPTION_LOCATION_HISTORY_COLUMNS, $historyColumns); ?>
    </div>
</div>

<div class="field">
    <div class="two columns alpha">
        <label><?php echo CONFIG_LABEL_LOCATION_PUBLIC; ?></label>
    </div>
    <div class="inputs five columns omega">
        <p class="explanation"><?php echo __("The element used to store an item's public location."); ?></p>
        <?php echo $view->formText(LocationConfig::OPTION_LOCATION_PUBLIC, $publicElementName); ?>
    </div>
</div>

<div class="field">
    <div class="two columns alpha">
        <label><?php echo CONFIG_LABEL_LOCATION_PUBLIC_VALUES; ?></label>
    </div>
    <div class="inputs five columns omega">
        <p class="explanation"><?php echo __("A comma-separated list of location values that can be public."); ?></p>
        <?php echo $view->formText(LocationConfig::OPTION_LOCATION_PUBLIC_VALUES, $publicValues); ?>
    </div>
</div>

<div class="field">
    <div class="two columns alpha">
        <label><?php echo CONFIG_LABEL_LOCATION_DATE; ?></label>
    </div>
    <div class="inputs five columns omega">
        <p class="explanation"><?php echo __("The date an item was moved."); ?></p>
        <?php echo $view->formText(LocationConfig::OPTION_LOCATION_DATE, $moveDate); ?>
    </div>
</div>

<div class="field">
    <div class="two columns alpha">
        <label><?php echo CONFIG_LABEL_LOCATION_WHO; ?></label>
    </div>
    <div class="inputs five columns omega">
        <p class="explanation"><?php echo __("The person who moved an item."); ?></p>
        <?php echo $view->formText(LocationConfig::OPTION_LOCATION_WHO, $moveBy); ?>
    </div>
</div>
