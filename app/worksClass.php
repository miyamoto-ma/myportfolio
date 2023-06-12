<?php

namespace MySite;

class worksClass
{
    public $title;
    public $text;
    public $skill;
    public $link1;
    public $link_text1;
    public $link2;
    public $link_text2;
    public $img;

    function __construct($title, $text, $skill, $link1, $link_text1, $link2, $link_text2, $img)
    {
        $this->title = $title;
        $this->text = $text;
        $this->skill = $skill;
        $this->link1 = $link1;
        $this->link_text1 = $link_text1;
        $this->link2 = $link2;
        $this->link_text2 = $link_text2;
        $this->img = $img;
    }
}
