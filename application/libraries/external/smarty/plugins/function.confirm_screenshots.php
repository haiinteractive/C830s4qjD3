<?php 
	function smarty_function_confirm_screenshots($params, &$smarty) {
		
		$browser = $params['browser'];
		$image = $params['image'];
		
		$style = "<div id=\"{$browser}\" class=\"screenshots\"";
		
		if($browser == "internet explorer"){
			$style .= " style=\"margin-right: 53px;\" ";
		}
		
		$style .= ">";
		
		$style .= "<div class=\"screen-headers\">";
		$style .= "<h4>{$browser}</h4>";
		$style .= "</div>";
		$style .= "<img src=\"{$image}\" alt=\"{$browser}\" />";
		
		$style .= "</div>";
		
		return $style;
		
	}

?>