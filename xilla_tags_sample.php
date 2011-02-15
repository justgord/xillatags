<?php
//
// xilla tags example
//
// copyright (c) gordon anderson 2009 anderson web systems webxilla.com
// This file may be used and redistributed in source form under BSD or MIT Licence
//
require 'lib/xilla_tag.php';


function sample_header($pagename, $slogan)
{
    return 
        div(xid("header"), 
          array(
            h1("", $pagename),
            ($slogan ? span("", $slogan) : "")));
}

function sample_contents($object)
{
    $row_list = array(
            tr("",
              array(
                th("", "ID"),
                th("", "Name"),
                th("", "Value"))));

    foreach ($object as $c)
    {
        $summary = 
            tr(array("class"=>get_class($c), "id"=>"{$c->ID}"),
              array(
                td("", "{$c->ID}"),
                td("", $c->Name),
                td("", $c->Value)));

        array_push($row_list, $summary);
    }

    return 
        div(xid('content'),
            table(xclass('config_list'), 
                $row_list));
}

function sample_footer($author)
{
    return 
        div(array("id"=>"footer"),
            span(array("class"=>"author"), $author)
        );
}

function sample_page($title, $pagename, $slogan, $author, $object)
{
    return 
        html("",
          array(
            head("",
              array(
                meta_xhtml(),
                title("", $title ? $title : $pagename))),
            body("", 
              array(
                sample_header($pagename, $slogan),
                sample_contents($object),
                sample_footer($author)
        ))));
}


///  test it ---


class BasicConfigVar
{
    var $ID;
    var $Name;
    var $Value;

    function __construct($cid, $cname, $cvalue)
    {
        $this->ID = $cid;
        $this->Name = $cname;
        $this->Value = $cvalue;
    }
};


    $title      = "Title";
    $pagename   = "Pagename";
    $slogan     = "Slogan";
    $author     = "Random Hacker";
    $object     = array(new BasicConfigVar(111, "greets", "hello!"), new BasicConfigVar(222, "greets", "namaste"));    

    printf(doctype_xtml());

    echo render_tag(sample_page($title, $pagename, $slogan, $author, $object));

?>
