<?php
namespace wdpf\pagination;
class pagination{
    public $pageName;
    public $rowsSize;
    public $beganRow;
    private $link;
    private $pageNo;
    private $totalRows;
    private $list;
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
        $this->validation();
        $this->beganRow = ($this->pageNo-1)*$this->rowsSize;
    }
    private function validation(){
        $data = isset($_GET[$this->pageName]) && $_GET[$this->pageName]>0 ? $_GET[$this->pageName] : 1;
        $data = (int) $data === 0 ? 1 : (int) $data;
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
		$this->pageNo = $data;
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
        $this->validation();
        return $this;
    }
    public function style(){
        echo <<<html
<style>
.pagination{}
.pagination>ul{
    margin: 0;
    padding: 0;
}
.pagination>ul>li{
    list-style: none;
    display: inline-block;
    float: left;
    padding: 8px 8px;
    background-color: #EDEFF6;
}
.pagination>ul>li>a{
    color: black;
    text-decoration: none;
    font-size: large;
}
</style>
<div class="pagination">
    <ul class="pagination">
        {$this->pagination()}
    </ul>
</div>
html;
    }
    public function pagiForm(){
        echo <<<html
<style>
.pagination{}
.pagination>form{}
.pagination>form>input{
    padding:5px;
    width: 100px;
}
.pagination>form>button{
    padding:5px;
}
.pagination>ul{
    margin: 0;
    padding: 0;
}
.pagination>ul>li{
    list-style: none;
    display: inline-block;
    float: left;
    padding: 8px 8px;
    background-color: #EDEFF6;
}
.pagination>ul>li>a{
    color: black;
    text-decoration: none;
    font-size: large;
}
</style>
<div class="pagination">
    {$this->form()}
    <ul class="pagination">
        {$this->pagination()}
    </ul>
</div>
html;
    }
    public function pagination(){
        $prevPage = (( $this->pageNo - 1 ) > 0) ? ($this->pageNo - 1) : 1;
        $prev_disabled = ($this->pageNo == 1) ? "display:none;" : "";
        $this->list .= "<li style='{$prev_disabled}'><a href='?{$this->pageName}=1{$this->link}'>First</a></li>";
        $this->list .= "<li style='{$prev_disabled}'><a href='?{$this->pageName}={$prevPage}{$this->link}'>Previous</a></li>";
        $this->simple();
        $nextPage = (($this->pageNo+1) < $this->totalRows) ? ($this->pageNo+1) : $this->totalRows;
        $next_disabled = ($this->pageNo == $this->totalRows) ? "display:none;" : "";
        $this->list .= "<li style='{$next_disabled}'><a href='?{$this->pageName}={$nextPage}{$this->link}'>Next</a></li>";
        $this->list .= "<li style='{$next_disabled}' ><a href='?{$this->pageName}={$this->totalRows}{$this->link}'>Last</a></li>";
        return $this->list;
    }
    public function simple(){
        for ($i=1; $i <= $this->totalRows ; $i++) {
            $active = ($this->pageNo == $i) ? "background-color:#1F88D9;" : "";
            if (abs($this->pageNo - $i) < 5) {
                $this->list .= "<li style='{$active}'><a href='?{$this->pageName}={$i}{$this->link}'>{$i}</a></li>";
            }
        }
        return $this->list;
    }
    public function form(){
        return <<<html
<form method="get">
    <input type="number" name="{$this->pageName}" min="1" max="{$this->totalRows}"/>
    <button type="submit" value="submit">GO</button>
</form>
html;
    }
    public function bootstrap(){
        $prevPage = (( $this->pageNo - 1 ) > 0) ? ($this->pageNo - 1) : 1;
        $prev_disabled = ($this->pageNo == 1) ? "disabled" : "";
        $this->list .= "<li class='page-item {$prev_disabled}'><a class='page-link' href='?{$this->pageName}=1{$this->link}'>First</a></li>";
        $this->list .= "<li class='page-item {$prev_disabled}'><a class='page-link' href='?{$this->pageName}={$prevPage}{$this->link}'>Previous</a></li>";
        for ($i=1; $i <= $this->totalRows ; $i++) {
            $active = ($this->pageNo == $i) ? "active" : "";
            if (abs($this->pageNo - $i) < 5) {
                $this->list .= "<li class='page-item {$active}'><a class='page-link' href='?{$this->pageName}={$i}{$this->link}'>{$i}</a></li>";
            }
        }
        $nextPage = (($this->pageNo+1) < $this->totalRows) ? ($this->pageNo+1) : $this->totalRows;
        $next_disabled = ($this->pageNo == $this->totalRows) ? "disabled" : "";
        $this->list .= "<li class='page-item {$next_disabled}'><a class='page-link' href='?{$this->pageName}={$nextPage}{$this->link}'>Next</a></li>";
        $this->list .= "<li class='page-item {$next_disabled}'><a class='page-link' href='?{$this->pageName}={$this->totalRows}{$this->link}'>Last</a></li>";
        return $this->list;
    }
}
?>
