<?php

class AvantLocation
{
    public static function filterHistory($item, $elementId, $text)
    {
        // Emit the HTML for the location history table.

        $titles = array_map('trim', explode('|', LocationConfig::getOptionTextForHistoryColumns()));
        $html = "<table class='location-history'>";
        $rows = array_map('trim', explode(PHP_EOL, $text));

        $html .= "<tr>";
        foreach ($titles as $title)
        {
            $html .= "<th>$title</th>";
        }
        $html .= "</tr>";

        foreach ($rows as $row)
        {
            $html .= "<tr>";
            $row = str_replace('<br />', '', $row);
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
