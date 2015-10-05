<script language="JavaScript">
	function changeP(purl,pid) {
		var pimg = document.getElementById(pid);
		if (purl.length > 0) {
			pimg.src = purl;
			//pimg.style.display = "block";
		} else 
			pimg.src = "images/empty_thumb.png";
			//pimg.style.display = "none";
	}
</script>
<?php 
$current_gid = "gallery_";
function vg_head() {
global $current_gid;
$current_gid = "gallery_".rand(0,99999);
?>
<table id="video_gallery">
  <tr>
    <td><ul><?php 
}

function vg_out($id,$title,$author,$descript,$length,$rate,$watchcount,$category_id,$img) {
global $current_gid;
?>
  <li onMouseOver="changeP('<?php echo $img; ?>','<?php echo $current_gid; ?>');" onMouseOut="changeP('','<?php echo $current_gid; ?>');"><a href="watch.php?id=<?php echo $id ?>"><?php echo $title; ?></a></li>
<?php }

function vg_end() {
global $current_gid;
?>
	</ul></td>
    <td width="1"><img id="<?php echo $current_gid; ?>" src="images/empty_thumb.png"></td>
  </tr>
</table>
<?php } ?>