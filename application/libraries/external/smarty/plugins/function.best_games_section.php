<?php 

	function smarty_function_best_games_section($params, &$smarty) {
		
		$bestTitle = $params['bestTitle'];
		$image 	   = $params['image'];
		$gameTitle = $params['gameTitle'];
		$desc      = $params['desc'];
		$playNow   = $params['playNow'];
		
		$style 	= "<div style=\"";
		if($bestTitle != "STAFF PICK"){
		$style .= "border-right: #cccccc solid 1px;";
		}
		$style .= "float: left; width: 189px; height: 262px;\">";
		$style .= "<div style=\"text-align: center; padding-left: 10px; padding-right: 13px;\">";
		$style .= "<h3 style=\"margin-bottom: 10px;\">{$bestTitle}</h3>";
		$style .= "<a href=\"{$playNow}\"><img width=\"167\" height=\"126\" src=\"{$image}\" alt=\"{$gameTitle}\" /></a>";
		$style .= "</div>";
		$style .= "<div style=\"float:left; padding-left: 13px; padding-right: 13px;\">";
		$style .= "<p style=\"font-size:12px; font-weight:bold; margin-top: 5px;\">{$gameTitle}</p>";
		$style .= "<p style=\"font-size:11px; margin-top: 5px; margin-bottom: 5px;\">{$desc}</p>";
		$style .= "<a class=\"play-now\" href=\"{$playNow}\">play now</a>";
		$style .= "</div>";
		$style .= "</div>";
		
		return $style;
		
	}

?>