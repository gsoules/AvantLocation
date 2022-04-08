<?php

class AvantLocation
{
    public static function filterHistory($item, $elementId, $text)
    {
        // This method emit the HTML for the location history table.

        $html = "<table class='location-history'>";

        // Get the history rows.
        $rows = array_map('trim', explode(PHP_EOL, $text));

        // Get the column names to use for the titles in the table's header row and emit the row.
        $titles = array_map('trim', explode('|', LocationConfig::getOptionTextForHistoryColumns()));
        $html .= "<tr>";
        foreach ($titles as $title)
            $html .= "<th>$title</th>";
        $html .= "</tr>";

        // Emit the data rows.
        foreach ($rows as $row)
        {
            $html .= "<tr>";
            $row = str_replace('<br />', '', $row);
            if ($row == "")
                continue;

            // Get the row's columns.
            $columns = array_map('trim', explode('|', $row));
            foreach ($columns as $column)
            {
                $html .= "<td>";
                $html .= $column;
                $html .= "</td>";
            }
            $html .= "</tr>";
        }

        $html .= "</table>";
        return $html;
    }
}
