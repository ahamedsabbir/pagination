# make object
use vendor\pagination as pagi;
$pagination = new pagi\pagination();
or
$pagination = new vendor\pagination\pagination();

# for server page
$pagination->backend('p', 20);
$totalRecord = SELECT * FROM `product` LIMIT $pagination->beganRow, $pagination->rowsSize;

# for clint site view
$pagination->frontend($totalRecord, 'p', 20)->pagination();

# multiple pagenation system
$page = "&page=".$_GET["page"];
$pagination->frontend($totalRecord, 'p', 20, $page)->bootstrap();
