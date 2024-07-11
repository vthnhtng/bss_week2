<?php
namespace controllers\pages_controller;
use controllers\base_controller\BaseController;

class PagesController extends BaseController
{
    function __construct()
    {
        $this->folder = 'pages';
    }

    public function error()
    {
        $this->render("error");
    }
}
