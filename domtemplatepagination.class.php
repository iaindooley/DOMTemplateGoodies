<?php

class pagination{
    public $template;    
    public $leftSegmentWidth;
    public $middleSegmentWidth;
    public $rightSegmentWidth;
    public $pageSize;
    public $numberOfElements;
    public $numberOfPages;
    public $activePaginationElement;
    public $normalPaginationElement;
    public $disabledPaginationElement;
    public $paginationHolderElement;
    public $urlParametersArray;
    //public $;
    
    public function __construct($template){
		$this->template = $template;
		$leftSegmentWidth = 3;
		$middleSegmentWidth = 3;
		$rightSegmentWidth = 3;
	}
	
	public function generatePages(Array $options){
		
		$pthis->paginationHolderElement = $this->template->query($options['paginationHolderElement'])->item(0);
		$this->disabledPaginationElement = $this->template->query($options['disabledPaginationElement'])->item(0)->cloneNode(true);
		$this->normalPaginationElement = $this->template->query($options['normalPaginationElement'])->item(0)->cloneNode(true);
		$this->activePaginationElement = $this->template->query($options['activePaginationElement'])->item(0)->cloneNode(true);
		
		$this->numberOfElements = $options['numberOfElements'];
		$this->pageSize = $options['pageSize'];
		$this->leftSegmentWidth = $options['leftSegmentWidth'];
		$this->middleSegmentWidth = $options['middleSegmentWidth'];
		$this->rightSegmentWidth = $options['rightSegmentWidth'];

		$this->urlParametersArray = $options['urlParametersArray'];
		$this->currentPageNumber = $options['currentPageNumber'];
		
		$allElementsInside = $this->doc->query($paginationHolderElement.'/*');
		foreach($allElementsInside as $element)
			$element->parentNode->removeChild($element);

		$this->numberOfPages = ceil($this->numberOfElements/$this->pageSize);

		$this->paginationHolderElement->nodeValue = "";
//		$preparedGetParameters = array('search' => $this->getParameters);
		if($this->currentPageNumber == 1){
			$disabledPaginationElement->nodeValue = "first page";
			$paginationHolderElement->appendChild($disabledPaginationElement->cloneNode(true));
		}
		else{
			$normalPaginationElement->nodeValue = "first page";
			$this->urlParametersArray['pageNumber'] = 1;
			$normalPaginationElement->setAttribute('href', 'index.php?r=Reports&'.http_build_query($preparedGetParameters));
			$paginationHolderElement->appendChild($normalPaginationElement->cloneNode(true));
		}

		$firstSeparatorPresent = false;
		$secondSeparatorPresent = false;
		for($i=1; $i <= $numberOfPages; $i++){
			if(!$firstSeparatorPresent && $i>$leftSegmentWidth){
				$firstSeparatorPresent = true;
				if($this->pageNumber > $leftSegmentWidth + $leftSegmentWidth-1){
					$disabledPaginationElement->nodeValue = "...";
					$paginationHolderElement->appendChild($disabledPaginationElement->cloneNode(true));
				}
			}
			if(!$secondSeparatorPresent && $i == $numberOfPages - $rightSegmentWidth+1){
				$secondSeparatorPresent = true;
				if($this->pageNumber < $numberOfPages - $rightSegmentWidth -1){
					$disabledPaginationElement->nodeValue = "...";
					$paginationHolderElement->appendChild($disabledPaginationElement->cloneNode(true));
				}
			}
			if( $i<$leftSegmentWidth+1 || ($i<=$this->pageNumber+floor($middleSegmentWidth/2) && $i>=$this->pageNumber-floor($middleSegmentWidth/2)) || $i>$numberOfPages - $rightSegmentWidth){
				if($this->pageNumber == $i){
					$activePaginationElement->nodeValue = $i;
					$paginationHolderElement->appendChild($activePaginationElement->cloneNode(true));
				}
				else{
					$normalPaginationElement->nodeValue = $i;
					$preparedGetParameters['search']['pageNumber'] = $i;
					$normalPaginationElement->setAttribute('href', 'index.php?r=Reports&'.http_build_query($preparedGetParameters));
					$paginationHolderElement->appendChild($normalPaginationElement->cloneNode(true));
				}
			}
		}

		if($this->pageNumber == $numberOfPages){
			$disabledPaginationElement->nodeValue = "last page";
			$paginationHolderElement->appendChild($disabledPaginationElement->cloneNode(true));
		}
		else{
			$normalPaginationElement->nodeValue = "last page";
			$preparedGetParameters['search']['pageNumber'] = $numberOfPages;
			$normalPaginationElement->setAttribute('href', 'index.php?r=Reports&'.http_build_query($preparedGetParameters));
			$paginationHolderElement->appendChild($normalPaginationElement->cloneNode(true));
		}
	}
}

?>
