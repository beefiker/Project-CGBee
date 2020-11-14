
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

    .boardList{
        width:100%;
        height:100%;
        display:flex;
        flex-direction:column;
        justify-content:center;
        align-items:center;
    }
    .eventItems {
        position: relative;
        width:80%;
        min-height: 50px;
        background-color:#f8f9fa;
        float:left;
        display:flex;
        flex-direction:column;
        justify-content:center;
        align-items:center;
        box-shadow: 10px 5px 5px black;
        margin-bottom:25px;
    }
    #boardlist {
        width: 100%;
    }
    .eventImg{
        width:120px;
        height:175px;
        margin-right:30px;
    }
    .a{
        background-color:#e9ecef;
        color:#242424;
        width:95%;
        padding-left:5%;
        height:60px;
        display:flex;
        align-items:center;
        font-size: 17px;
    }
    .contents{
        position:relative;
        width:95%;
        color:#495057;
        word-break:break-all;
        padding:2.5%;
        margin-bottom:50px;
        font-size: 15px;
    }

    @media (max-width: 1300px) {
        .a{
           font-size:16px; 
        }
        .contents{
            font-size:14px;
        }
    }
    @media (max-width: 700px) {
        .a{
           font-size:15px; 
        }
        .contents{
            font-size:13px;
        }
    }
    </style>
</head>
<body>

    <ul class="boardList">
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

                    if($eventImg){
                    echo    "<li class='eventItems'>",
                                "<div class='a'>",
                                    $title,
                                "</div>",
                                "<p class='contents'>","<img class='eventImg' src='$eventImg'>", $contents ,"</p>",
                            "</li>";
                    }else{
                        echo    "<li class='eventItems'>",
                        "<div class='a'>",
                            $title,
                        "</div>",
                        "<p class='contents'>", $contents ,"</p>",
                    "</li>";
                    }
                }
            } catch (PDOException $e) {
                exit($e->getMessage());
            }
        ?>
    </ul>

</body>
</html>
