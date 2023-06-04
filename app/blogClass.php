<?php

class blogClass
{
    public $title;
    public $text;
    public $img;
    public $create_time;

    function __construct($title, $text, $img, $create_time)
    {
        $this->title = $title;
        $this->text = $text;
        $this->img = $img;
        $this->create_time = $create_time;
    }
}
