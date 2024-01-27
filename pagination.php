<?php
namespace vendor\pagination;
class pagination{
    public $pageName;
    public $rowsSize;
    public $beganRow;
    private $link;
    private $pageNo;
    private $totalRows;
    function __construct(){
        $this->pageName = "page";
        $this->rowsSize = 10;
        $this->link = null;
    }
    public function backend($pageName = false, $rowsSize = false){
        if($pageName){
            $this->pageName = $pageName;
        }
        if($rowsSize){
            $this->rowsSize = $rowsSize;
        }
        $this->pageNo = isset($_GET[$this->pageName]) && $_GET[$this->pageName]>0 ? $_GET[$this->pageName] : 1;
        $this->beganRow = ($this->pageNo-1)*$this->rowsSize;
    }
    public function frontend($totalRows, $pageName = false, $rowsSize = false, $link = false){
        $this->totalRows = ceil($totalRows/$this->rowsSize);
        if($pageName){
            $this->pageName = $pageName;
        }
        if($rowsSize){
            $this->rowsSize = $rowsSize;
        }
        if($link){
            $this->link = $link;
        }
        $this->pageNo = isset($_GET[$this->pageName]) && $_GET[$this->pageName]>0 ? $_GET[$this->pageName] : 1;
        return $this;
    }
    public function pagination(){
        $prevPage = (( $this->pageNo - 1 ) > 0) ? ($this->pageNo - 1) : 1;
        $prev_disabled = ($this->pageNo == 1) ? "display:none;" : "";
        echo "<li style='{$prev_disabled}'><a href='?{$this->pageName}=1{$this->link}'>First</a></li>";
        echo "<li style='{$prev_disabled}'><a href='?{$this->pageName}={$prevPage}{$this->link}'>Previous</a></li>";
        $this->simple();
        $nextPage = (($this->pageNo+1) < $this->totalRows) ? ($this->pageNo+1) : $this->totalRows;
        $next_disabled = ($this->pageNo == $this->totalRows) ? "display:none;" : "";
        echo "<li style='{$next_disabled}'><a href='?{$this->pageName}={$nextPage}{$this->link}'>Next</a></li>";
        echo "<li style='{$next_disabled}' ><a href='?{$this->pageName}={$this->totalRows}{$this->link}'>Last</a></li>";
    }
    public function simple(){
        for ($i=1; $i <= $this->totalRows ; $i++) {
            $active = ($this->pageNo == $i) ? "background-color:green;" : "";
            if (abs($this->pageNo - $i) < 5) {
                echo "<li style='{$active}'><a href='?{$this->pageName}={$i}{$this->link}'>{$i}</a></li>";
            }
        }
    }
    public function bootstrap(){
        $prevPage = (( $this->pageNo - 1 ) > 0) ? ($this->pageNo - 1) : 1;
        $prev_disabled = ($this->pageNo == 1) ? "disabled" : "";
        echo "<li class='page-item {$prev_disabled}'><a class='page-link' href='?{$this->pageName}=1{$this->link}'>First</a></li>";
        echo "<li class='page-item {$prev_disabled}'><a class='page-link' href='?{$this->pageName}={$prevPage}{$this->link}'>Previous</a></li>";
        for ($i=1; $i <= $this->totalRows ; $i++) {
            $active = ($this->pageNo == $i) ? "active" : "";
            if (abs($this->pageNo - $i) < 5) {
                echo "<li class='page-item {$active}'><a class='page-link' href='?{$this->pageName}={$i}{$this->link}'>{$i}</a></li>";
            }
        }
        $nextPage = (($this->pageNo+1) < $this->totalRows) ? ($this->pageNo+1) : $this->totalRows;
        $next_disabled = ($this->pageNo == $this->totalRows) ? "disabled" : "";
        echo "<li class='page-item {$next_disabled}'><a class='page-link' href='?{$this->pageName}={$nextPage}{$this->link}'>Next</a></li>";
        echo "<li class='page-item {$next_disabled}'><a class='page-link' href='?{$this->pageName}={$this->totalRows}{$this->link}'>Last</a></li>";
    }
}
?>
