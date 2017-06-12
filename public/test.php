<?php
echo "hrere";

 $var = mysqli_query("ALTER TABLE `translations` CHANGE `translatable_type` `translatable_type` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;") or die(mysqli_error()); 
echo $var;
?>