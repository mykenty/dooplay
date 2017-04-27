<?php

if($ads = get_option('ads_spot_home')) { echo '<div class="module_home_ads">'. stripslashes($ads). '</div>'; } ?>