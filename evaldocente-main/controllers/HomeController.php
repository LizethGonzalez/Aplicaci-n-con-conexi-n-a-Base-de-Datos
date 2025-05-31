<?php
namespace controllers;

use core\TemplateEngine;

class HomeController {
    public static function index() {
        TemplateEngine::render("home_index");
    }
}
