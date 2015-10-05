<ul id="category_list">
<?php foreach($Category as $id=>$name) { if (strpos($id,'/')==false) {?>
<li class="category_list_item"<?php if ($type==$id) echo ' style="background-color:#A7C992"'; ?>>
<a href="category.php?type=<?php echo $id; ?>">
<?php echo $name; if (CON_hide_img_left!="y") { ?><div class="logo"><img src="http://commondatastorage.googleapis.com/ngsy/cimage/<?php echo $id; ?>.png"></div><?php } ?>
</a>
</li>
<?php }} ?>
</ul>