
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>delhistory</title>
</head>
<body>
<?php
    $sn = $_REQUEST["sn"];
    $pw = $_REQUEST["enterPw"];
    $ph = $_REQUEST["phone"];
        try {
            require("db_connect.php");
            $query = $db->query("select * from reservation where reservation_sn = $sn and reservation_pw ='$pw'");
            if ($row = $query->fetch(PDO::FETCH_ASSOC)) { 
                
                $db->exec("delete from reservation where reservation_sn = $sn and reservation_pw = '$pw'");
                $db->exec("delete from screening where reservation_sn = $sn");
                $db->exec("delete from seat where reservation_sn = $sn");
            
            }
            
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
        header("Location:history.php?phone=$ph");
        exit();
?>    
</body>
</html>