<?php 
include('local/language.php');
$page = 1;
if (isset($_GET['id']))
	$ID=$_GET['id'];
if (isset($_GET['page']))
	$page=strval($_GET['page']);

include_once('lib/mq.php');
include_once("lib/apirequest.php");
initGFW('lib/mglib.txt');

$xml_comment = xml_load2(ytapi.'videos/'.$ID.'/comments?max-results=15&start-index='.(($page-1)*15+1).'&rand='.rand(0,8964));
if ($xml_comment == NULL) {
	$error = true;
} else {
	$opensearch = $xml_comment->children('http://a9.com/-/spec/opensearchrss/1.0/');
	$comments = array();
	$comments_has_prev = ($page>1);
	$comments_has_next = (count($xml_comment->entry)>=15);
	$comments_pages = ceil(($opensearch->totalResults)/15);
	if ($xml_comment != NULL)
		foreach ($xml_comment->entry as $entry) {
			$tauthor = $entry->author->name;
			$tcontent = $entry->content;
			$tdate = date("Y-m-d H:i:s",strtotime($entry->published));
			if (!hasBadKey($tcontent)) {
				array_push($comments,array("author"=>$tauthor,"content"=>$tcontent,"published"=>$tdate));
			}
		}
}
include(THEME_PATH."/comment_ajax.php");
?>