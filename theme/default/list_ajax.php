<?php
header('Content-Type: text/plain');
$i=0;foreach ($videos as $entry) {	?>
<li class="vitem" id="<?php echo $entry['id']; ?>"><a href="javascript:;" onClick="playItem('<?php echo $entry['id']; ?>',<?php echo $i; ?>);" id="<?php echo $entry['id']; ?>_a"><?php echo $entry['title']; ?></a></li>
<?php $i++; }?>