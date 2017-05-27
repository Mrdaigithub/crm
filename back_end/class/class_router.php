<?php

/**
 * Created by PhpStorm.
 * User: mrdai
 * Date: 2017/5/11
 * Time: 14:59
 */
class class_router
{
    function __construct()
    {
        $this->url = parse_url($_SERVER['REQUEST_URI']);
        $this->url = $this->url['path'];
        $this->url = $this->url[strlen($this->url)-1] === '/' ? str_pop($this->url) : $this->url;
    }

    function addRoute($method, $url_pattern, $filename)
    {
        $url_pattern = $url_pattern[strlen($url_pattern) - 1] === '/' ?
            str_pop($url_pattern) : $url_pattern;
        $url_pattern = str_replace('/', '\/', $url_pattern);
        if (preg_match("/^$url_pattern$/i", $this->url) && $_SERVER['REQUEST_METHOD'] === $method) {
            include "$filename";
        }
    }
}