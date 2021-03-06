<?php
//
// xilla_tag.php - Xilla php tag library
//
//      write html tags as statements, building up an array tree of tags,
//      from which html is generated, automatically indenting and generating closing tags
//
// copyright (c) gordon anderson 2009
// This file may be used and redistributed in source form under BSD or MIT Licence
//


function indent($nspace)
{
    $sp="";
    for ($i=0;$i<$nspace;$i++)
        $sp .= "  ";
    return $sp;
}


function tg($name, $vars, $body="")
{
    // body can be any of -
    //  -   a string
    //  -   a tag with a body [an array with a "tag"
    //  -   an array of tags
    
    return array("tag"=>$name, "vars"=>$vars, "body"=> $body );
}


function tagvars($vars)
{
    $tv="";
    $showposn=0;
    if (is_array($vars))
    {
        foreach($vars as $att  => $val)
        {
            $tv .= " {$att}=\"{$val}\"";
        }
    }
    return $tv; 
}


function render_tag($mtag, $indent=0)
{
    //recursive tag render - turn tag array tree into rendered html

    $tag=$mtag["tag"];

    $ind=indent($indent);
    $tagvars=tagvars($mtag['vars']);

    // body can be any of -
    //  -   a string
    //  -   a tag with a body [an array with a "tag" element]
    //  -   an array of tags [an array with no "tag" element]

    $body = $mtag["body"];

    if (is_string($body))
    {
        // string - always inline
        echo "{$ind}<{$tag}{$tagvars}>{$body}</$tag>\n";
    }
    else if (is_array($body))
    {
        echo "{$ind}<{$tag}{$tagvars}>\n";

        if (isset($body['tag']))
        {
            // sub tag
            render_tag($body, $indent+1);
        }
        else 
        {
            // sub list
            foreach ($body as $item)
                render_tag($item, $indent+1);
        }

        echo "{$ind}</{$tag}>\n";
    }
}


// convenience tag aliases / shortcuts

function html($args, $body="")      {return tg("html", $args, $body);}
function head($args, $body="")      {return tg("head", $args, $body);}
function title($args, $body="")     {return tg("title", $args, $body);}
function meta($args, $body="")      {return tg("meta", $args, $body);}
function hlink($args, $body="")     {return tg("link", $args, $body);}      // hlink not link, as it seems to be reserved in php
function body($args, $body="")      {return tg("body", $args, $body);}
function tbody($args, $body="")     {return tg("tbody", $args, $body);}
function script($args, $body="")    {return tg("script", $args, $body);}	
function div($args, $body="")       {return tg("div", $args, $body);}
function span($args, $body="")      {return tg("span", $args, $body);}
function img($args, $body="")       {return tg("img", $args, $body);}
function a($args, $body="")         {return tg("a", $args, $body);}
function table($args, $body="")     {return tg("table", $args, $body);}
function tr($args, $body="")        {return tg("tr", $args, $body);}
function td($args, $body="")        {return tg("td", $args, $body);}
function th($args, $body="")        {return tg("th", $args, $body);}
function form($args, $body="")      {return tg("form", $args, $body);}
function input($args, $body="")     {return tg("input", $args, $body);}
function select($args, $body="")    {return tg("select", $args, $body);}
function option($args, $body="")    {return tg("option", $args, $body);}
function textarea($args, $body="")  {return tg("textarea", $args, $body);}
function nobr($args, $body="")      {return tg("nobr", $args, $body);}
function h1($args, $body="")        {return tg("h1", $args, $body);}


function meta_xhtml($charset='utf-8')
{
    return
        meta(array("http-equiv"=>"Content-Type", "content"=>"application/xhtml+xml;charset={$charset}"));
}

function doctype_xtml()
{
    return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">' . "\n";
}

function xid($id)
{
    return array("id"=>$id);
}

function xclass($class)
{
    return array("class"=>$class);
}


function input_hidden($hname, $hvalue)
{
    return input(array("name"=>$hname, "value"=>$hvalue, "type"=>"hidden"), "");
}


function space_px($width_px)
{
    return div(array("style"=>"width:{$width_px}"), "&nbsp;");
}


function droplist($vars, $drops, $selected)
{
    $optiontags=array();

    foreach($drops as $key => $val)
    {
		$hkey = htmlspecialchars($key);	
		$hval = htmlspecialchars($val);
		
        if ($key==$selected)
            array_push($optiontags, option(array("value"=>$hkey, "selected"=>"selected"), $hval)); 
        else
            array_push($optiontags, option(array("value"=>$hkey), $hval)); 
    }

    return select($vars, $optiontags);
}


?>
