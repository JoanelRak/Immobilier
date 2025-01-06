<?php
function convertIntoHtmlTable($data)
{
    // Initialize empty table HTML
    $html = '';

    // Check if data is not empty and is an array
    if (is_array($data) && !empty($data)) {
        // Start table HTML
        $html .= '<table class="data-table">';

        // Add table headers (if the first row has data and is an associative array)
        if (!empty($data[0]) && is_array($data[0])) {
            $html .= '<thead><tr>';
            foreach (array_keys($data[0]) as $header) {
                $html .= '<th class="table-header">' . htmlspecialchars($header) . '</th>';
            }
            $html .= '</tr></thead>';
        }

        // Add table body
        $html .= '<tbody>';
        foreach ($data as $row) {
            if (is_array($row)) {
                $html .= '<tr class="table-row">';
                foreach ($row as $cell) {
                    $html .= '<td class="table-cell">' . htmlspecialchars($cell) . '</td>';
                }
                $html .= '</tr>';
            }
        }
        $html .= '</tbody>';

        // Close table HTML
        $html .= '</table>';
    } else {
        // Handle case when data is empty or not an array
        $html = '<p>No data available to display in the table.</p>';
    }

    return $html;
}

?>