<?php

namespace core;

class TemplateEngine
{
    public static function render($view, $data = [])
    {
        extract($data);
        ob_start();
        include __DIR__ . "/../templates/views/$view.php";
        $content = ob_get_clean();
        include __DIR__ . "/../templates/layout.php";
    }

    public static function renderPartial($view, $data = [])
    {
        extract($data);
        include __DIR__ . "/../templates/views/$view.php";
    }
}

