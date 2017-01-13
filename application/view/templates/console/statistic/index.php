<?php
if (count($stat) == 0) {
    echo "No data.\n";
} else {
    $firstColName = 'Type';
    $col1StrlenMax = strlen($firstColName);
    $secondColName = 'Sum';
    $col2StrlenMax = strlen($secondColName);
    $thirdColName = 'Count';
    $col3StrlenMax = strlen($thirdColName);
    // Вычисление отступов
    foreach ($stat as $item) {
        $type = $item->p_type == \Application\DAO\Payments::TYPE_WITH_DOCUMENTS ? 'With documents' : 'Without documents';
        $strLen = strlen($type);
        if ($strLen > $col1StrlenMax) {
            $col1StrlenMax = $strLen;
        }

        $sum = $item->p_sum;
        $strLen = strlen($sum);
        if ($strLen > $col2StrlenMax) {
            $col2StrlenMax = $strLen;
        }

        $count = $item->p_cnt;
        $strLen = strlen($count);
        if ($strLen > $col3StrlenMax) {
            $col3StrlenMax = $strLen;
        }
    }

    $col1StrlenMax += 1;
    $col2StrlenMax += 1;
    $col3StrlenMax += 1;

    // Формирование и вывод таблицы
    $output = '';
    $border = '+-' . str_repeat('-', $col1StrlenMax)
        . '+-' . str_repeat('-', $col2StrlenMax)
        . '+-' . str_repeat('-', $col3StrlenMax) . "+\n";
    $output .= $border;
    $output .= '| ' . $firstColName;
    $diff = $col1StrlenMax - strlen($firstColName);
    $output .= str_repeat(' ', $diff);
    $output .= '| ' . $secondColName;
    $diff = $col2StrlenMax - strlen($secondColName);
    $output .= str_repeat(' ', $diff);
    $output .= '| ' . $thirdColName;
    $diff = $col3StrlenMax - strlen($thirdColName);
    $output .= str_repeat(' ', $diff) . "|\n";
    $output .= $border;
    foreach ($stat as $item) {
        $type = $item->p_type == \Application\DAO\Payments::TYPE_WITH_DOCUMENTS ? 'With documents' : 'Without documents';
        $output .= '| ' . $type;
        $diff = $col1StrlenMax - strlen($type);
        $output .= str_repeat(' ', $diff);
        $sum = $item->p_sum;
        $output .= '| ' . $sum;
        $diff = $col2StrlenMax - strlen($sum);
        $output .= str_repeat(' ', $diff);
        $count = $item->p_cnt;
        $output .= '| ' . $count;
        $diff = $col3StrlenMax - strlen($count);
        $output .= str_repeat(' ', $diff) . "|\n";
        $output .= $border;
    }

    echo $output;
}