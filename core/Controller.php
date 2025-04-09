<?php
class Controller {
    protected function render($view, $data = []) {
        extract($data);
        require_once "view/$view.php";
    }
}
