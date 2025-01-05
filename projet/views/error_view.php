<?php

class error_view {
    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function render()
    {
        return $this->message;
    }
}
?>
