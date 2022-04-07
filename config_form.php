<?php
$view = get_view();

$currentElementName = LocationConfig::getOptionTextForCurrent();
$historyElementName = LocationConfig::getOptionTextForHistory();
$historyColumns = LocationConfig::getOptionTextForHistoryColumns();
$notesElementName = LocationConfig::getOptionTextForNotes();
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
        <label><?php echo CONFIG_LABEL_LOCATION_NOTES; ?></label>
    </div>
    <div class="inputs five columns omega">
        <p class="explanation"><?php echo __("The element used to store notes about an item's location."); ?></p>
        <?php echo $view->formText(LocationConfig::OPTION_LOCATION_NOTES, $notesElementName); ?>
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
