<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        table     { width:680px; text-align:center; }
        th        { background-color:cyan; }
        
        .num      { width: 80px; }
        .title    { width:230px; }
        .writer   { width:100px; }
        .regtime  { width:180px; }
                
        a:link    { text-decoration:none; color:blue; }
        a:visited { text-decoration:none; color:gray; }
        a:hover   { text-decoration:none; color:red;  }
		
		.left     { text-align:left; }
    </style>
</head>
<body>

<table>
    <tr>
        <th class="num"    >번호    </th>
        <th class="title"  >제목    </th>
        <th class="writer" >작성자  </th>
        <th class="regtime">작성일시</th>
        <th>                조회수  </th>
    </tr>
    
<?php
    $listSize = 5;
    $page = empty($_REQUEST["page"]) ? 1 : $_REQUEST["page"];
    
    try {
        require("db_connect.php");

        // 페이지네이션 시작/끝 번호 계산
        $paginationSize = 3;
        
        $firstLink = floor(($page - 1) / $paginationSize) * $paginationSize + 1;
        $lastLink = $firstLink + $paginationSize - 1;
        
        $numRecords = $db->query("select count(*) from board")->fetchColumn();
        $numPages = ceil($numRecords / $listSize);
        if ($lastLink > $numPages) {
            $lastLink = $numPages;
        }
        
        // 페이지에 해당하는 데이터 읽기 + 출력
        $start = ($page - 1) * $listSize;
        $query = $db->query("select * from board order by num desc limit $start, $listSize");
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
?>            
        <tr>
            <td><?=$row["num"]?></td>
            <td class="left"><a href="view.php?num=<?=$row["num"]?>&page=<?=$page?>"><?=$row["title"]?></a></td>
            <td><?=$row["writer"]?></td>
            <td><?=$row["regtime"]?></td>
            <td><?=$row["hits"]?></td>
        </tr>
<?php            
        }
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
?>
   
</table>

<br>
<div style="width:680px; text-align:center">
<?php
    if ($firstLink > 1) {
?>
        <a href="list.php?page=<?=($firstLink - 1)?>">&lt;</a>
<?php
    }
    
    for($i = $firstLink; $i <= $lastLink; $i++) {
?>
        <a href="list.php?page=<?=$i?>"><?=$i?></a> 
<?php
    }
    
     if ($lastLink < $numPages) {
?>
         <a href="list.php?page=<?=($lastLink + 1)?>">&gt;</a>
<?php
     }         
?>    
</div>

<br>
<input type="button" value="글쓰기" onclick="location.href='write.php'">

</body>
</html>