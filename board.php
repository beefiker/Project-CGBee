
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    .eventItems {
        position: relative;
        width:500px;
        min-height: 100px;
        background-color:#191f26;
        float:left;
        display:flex;
        flex-direction:column;
        justify-content:center;
        align-items:center;
    }
    #boardlist {
        width: 100%;
    }
    .eventImg{
        width:75px;
        height:75px;
        margin-right:30px;
    }
    .a{
        background-color:none;
        border:2px solid white;
        border-radius:0px 10px 0 0;
        color:white;
        width:400px;
        height:75px;
        display:flex;
        align-items:center;
    }
    .contents{
        position:relative;
        width:380px;
        min-height:10px;
        border:2px solid white;
        border-radius:0 0 0 10px;
        background-color:white;
        word-break:break-all;
        padding:10px;
        margin-bottom:100px;
    }
    </style>
</head>
<body>

    <ul>
    <?php
    try {
        require("db_connect.php");

        $query = $db->query("select * from board");
        
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {    
        $id = $row["id"];
        $title = $row["title"];
        $contents = $row["contents"];
        $write_date = $row["write_date"];
        $eventImg = $row["eventImg"];

        echo    "<li class='eventItems'>",
                    "<div class='a'>",
                        "<img class='eventImg' src='$eventImg'>",$title,
                    "</div>",
                    "<p class='contents'>", $contents ,"</p>",
                "</li>";

        }
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
?>
    </ul>

</body>
</html>
