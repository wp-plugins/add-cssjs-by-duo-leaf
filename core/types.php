<?php

class dl_acj_Resource {

    public $id = 0;
    public $name = '';
    public $content = '';
    public $type = dl_acj_ResourceType::CSS;
    public $attributes = '';
    public $urls = '';
    public $location = dl_acj_ResourceLocation::Footer;
    public $enabled = true;

}

abstract class dl_acj_ResourceType {

    const CSS = 0;
    const Javascript = 1;

}

abstract class dl_acj_ResourceLocation {

    const Header = 0;
    const Footer = 1;

}
