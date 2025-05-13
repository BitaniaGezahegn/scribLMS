<?php
class Paginate
{
    public $data;
    public $itemsPerPage;
    public $currentPage;
    public $totalItems;
    public $totalPages;
    public $pagedData;
    public $offset;

    function __construct($data, $itemsPerPage = 9, $currentPage = 1) {
        $this->data = $data;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->paginateData();
    }
    
    function paginateData() {
        $this->totalItems = count($this->data);
        $this->totalPages = ceil($this->totalItems / $this->itemsPerPage);
    
        $this->currentPage = max(1, min($this->currentPage, $this->totalPages));
    
        $this->offset = ($this->currentPage - 1) * $this->itemsPerPage;
        $this->pagedData = array_slice($this->data, $this->offset, $this->itemsPerPage);
    }

    function setPage($page) {
        $this->currentPage = $page;
        $this->paginateData();
    }
    
    function getPage() {
        
        return [
            'data' => $this->pagedData,
            'currentPage' => $this->currentPage,
            'totalPages' => $this->totalPages,
            'totalItems' => $this->totalItems,
            'itemsPerPage' => $this->itemsPerPage,
        ];
    }

    function setItemsPerPage($itemsPerPage) {
        $this->itemsPerPage = $itemsPerPage;
        $this->paginateData();
    }

    function getNextPage() {
        $this->setPage($this->currentPage += 1);
        return $this->getPage();
    }
    function getPreviousPage() {
        $this->setPage($this->currentPage -= 1);
        return $this->getPage();
    }
}
?>