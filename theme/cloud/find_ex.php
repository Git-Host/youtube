<?php 
$pageTitle = AdvancedSearch." - ".WEBSITE_TITLE;
$pageHideLeft = 1;
$pageHideRight = 1;
include(THEME_PATH."/header.php");
?>
	<h3><?php echo AdvancedSearch; ?></h3>
	  <table width="100%" border="0">
        <tr>
		  <td width="50%" valign="top">
<h4><?php echo SearchVideos; ?></h4>
			<form action="find.php" method="get" onSubmit="searchfilter('keyworda','keyworda2');">
			  <input id="keyworda" type="text" class="input_big" maxlength="60">
              <input name="keyword" type="hidden" size="20" maxlength="80" id="keyworda2">
              <input name="ss" type="hidden" size="20" maxlength="80" value="y">
            <fieldset>
			<?php foreach ($Search_Mode as $item_id=>$item_name) { ?>
			<label><input name="type" type="radio" value="<?php echo $item_id; ?>"><?php echo $item_name; ?>
			<blockquote><?php echo $Search_Mode_des[$item_id]; ?></blockquote></label>
			<?php } ?></fieldset><br>
			<fieldset>
			<legend><?php echo OptionsForNormalSearch ?></legend>
              <label><?php echo Category ?>: 
              <select name="cat" id="cat">
                <option value=""><?php echo AllCategory ?></option><?php foreach ($Category as $ca=>$cb) { if (strpos($ca,'/')===false) { ?>
                <option value="<?php echo $ca; ?>"><?php echo $cb; ?></option><?php }} ?>
              </select></label><br>
              <label><input name="caption" type="checkbox" id="caption" value="yes"><?php echo MustWithSubtitle ?></label>
              </fieldset>
			<input name="" type="submit" value="<?php echo Search; ?>">
			</form>
		</td>
		  <td valign="top">
<h4><?php echo SpecialFunctions; ?></h4>
		<form action="find.php" method="get">
			<fieldset>
				<legend><?php echo PersonalVideos; ?></legend>
				<label><?php echo UserName; ?><input name="keyword" type="text" maxlength="20"></label>
				<select name="p_type" id="p_type">
				<?php foreach ($PersonResult as $item_id=>$item_name) { ?>
					<option value="<?php echo $item_id; ?>"><?php echo $item_name; ?></option>
				<?php } ?></select>
				<input name="type" type="hidden" value="personal">
            	<input name="" type="submit" value="<?php echo Search; ?>">
			</fieldset>
		</form>
		<form action="find.php" method="get">
			<fieldset>
				<legend><?php echo ItemsOfOnePlaylist; ?></legend>
				<label><?php echo IDOfThePlaylist; ?><input name="keyword" type="text" maxlength="16"></label>
				<input name="type" type="hidden" value="playlist">
				<input name="" type="submit" value="<?php echo Search; ?>">
			</fieldset>
		</form>
<?php include(THEME_PATH."/footer.php"); ?>