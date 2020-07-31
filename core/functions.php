<?php
/**
 * Функция упрощает анализ переменной или иных переданных данных
 *
 * @param mixed $var переменная или данные, переданные в функцию для анализа
 * @param bool $file необходимо ли записать лог в файл
 * @author Nikita Murashov
 */
function analyze(
    $var,
    bool $file = false
) :void
{
    if ($file) {
        ob_start();
        echo date('d.m.Y H:i:s').PHP_EOL;
        var_dump($var);
        $result = ob_get_clean().PHP_EOL;
        file_put_contents(ROOT.'/log.txt', $result, FILE_APPEND);
    } else {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
}
