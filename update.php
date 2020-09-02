<?php
    $num     = $_REQUEST["num"    ];
    
    $title   = $_REQUEST["title"  ];
    $writer  = $_REQUEST["writer" ];
    $content = $_REQUEST["content"];
    
    if ($title && $writer && $content) {
        try {
            require("db_connect.php");
    
            $regtime = date("Y-m-d H:i:s");
            
            $db->exec("update board set writer='$writer', title='$title', content='$content', 
                       regtime='$regtime' where num=$num");
                       
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
         
        $page = empty($_REQUEST["page"]) ? 1 : $_REQUEST["page"];        
        header("Location:view.php?num=$num&page=$page");
        exit();
    }        
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>

<script>
    alert('모든 항목이 빈칸 없이 입력되어야 합니다.');
    history.back();
</script>

</body>
</html>
