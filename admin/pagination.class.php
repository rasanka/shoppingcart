<?php

class Pagination{
	var $anchors;
	var $total;
	function loadPagination($numrows,$starting,$recpage,$function)
	{
		$next		=	$starting+$recpage;
		$var		=	((intval($numrows/$recpage))-1)*$recpage;
		$page_showing	=	intval($starting/$recpage)+1;
		$total_page	=	ceil($numrows/$recpage);

		if($numrows % $recpage != 0){
			$last = ((intval($numrows/$recpage)))*$recpage;
		}else{
			$last = ((intval($numrows/$recpage))-1)*$recpage;
		}
		$previous = $starting-$recpage;
		$anc = "<div id='pagination-flickr'>";
		if($previous < 0){
			$anc .= "<span class='previous-off'>First</span>";
			$anc .= "<span class='previous-off'>Previous</span>";
		}else{
			$anc .= "<span class='next'><a href='javascript:".$function."(0);'>First </a></span>";
			$anc .= "<span class='next'><a href='javascript:".$function."($previous);'>Previous </a></span>";
		}
		
		################If you dont want the numbers just comment this block###############	
		$norepeat = 4;//no of pages showing in the left and right side of the current page in the anchors 
		$j = 1;
		$anch = "";
		for($i=$page_showing; $i>1; $i--){
			$fpreviousPage = $i-1;
			$page = ceil($fpreviousPage*$recpage)-$recpage;
			$anch = "<span><a href='javascript:".$function."($page);'>$fpreviousPage </a></span>".$anch;
			if($j == $norepeat) break;
			$j++;
		}
		$anc .= $anch;
		$anc .= "<span class='active'>".$page_showing."</span>";
		$j = 1;
		for($i=$page_showing; $i<$total_page; $i++){
			$fnextPage = $i+1;
			$page = ceil($fnextPage*$recpage)-$recpage;
			$anc .= "<span><a href='javascript:".$function."($page);'>$fnextPage</a></span>";
			if($j==$norepeat) break;
			$j++;
		}
		############################################################
		if($next >= $numrows){
			$anc .= "<span class='previous-off'>Next</span>";
			$anc .= "<span class='previous-off'>Last</span>";
		}else{
			$anc .= "<span class='next'><a href='javascript:".$function."($next);'>Next </a></span>";
			$anc .= "<span class='next'><a href='javascript:".$function."($last);'>Last</a></span>";
		}
			$anc .= "</div>";
		$this->anchors = $anc;
		
		$this->total = "Page : $page_showing <i> Of  </i> $total_page . Total Records Found: $numrows";
	}
}
?>