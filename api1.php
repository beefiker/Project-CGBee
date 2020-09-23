<!doctype html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>

<?php 
//접속 할 URL을 지정
$url = "https://yts-proxy.now.sh/list_movies.json?sort_by=rating&limit=15";
$url_like = "https://yts-proxy.now.sh/list_movies.json?sort_by=like_count&limit=15";
//  Initiate curl session
$handle = curl_init();
// Will return the response, if false it prints the response
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($handle, CURLOPT_URL,$url);
// Execute the session and store the contents in $result
$result1=curl_exec($handle);
// Closing the session
$result1 = file_get_contents($url);


curl_setopt($handle, CURLOPT_URL,$url_like);
// Execute the session and store the contents in $result
$result2=curl_exec($handle);
// Closing the session
$result2 = file_get_contents($url_like);

$data1 = json_decode($result1);
// var_dump($data);
$list1 = $data1->data->movies;
$data2 = json_decode($result2);
var_dump($list1);
$list2 = $data2->data->movies;
// echo $list[0]->id;
echo count($list1), "<br>";
for($i=0; $i<count($list1); $i++){
    $id = $list1[$i]->id;
    $title = $list1[$i]->title;
    $year = $list1[$i]->year;
    $rating = $list1[$i]->rating;
    $runtime = $list1[$i]->runtime;
    // $genres = $list[$i]->genres;
    $summary = $list1[$i]->summary;
    $language = $list1[$i]->language;
    $imgsrc = $list1[$i]->background_image;
    $uploaded_date = $list1[$i]->date_uploaded;
    echo "ㅁㅁㅁㅁㅁㅁ ",$id, $title, $year, $rating, $runtime, $genres, $summary, $language,
    $imgsrc, $uploaded_date, "<br>";
}

echo count($list2), "<br>";
for($i=0; $i<count($list2); $i++){
    $id = $list2[$i]->id;
    $title = $list2[$i]->title;
    $year = $list2[$i]->year;
    $rating = $list2[$i]->rating;
    $runtime = $list2[$i]->runtime;
    // $genres = $list[$i]->genres;
    $summary = $list2[$i]->summary;
    $language = $list2[$i]->language;
    $imgsrc = $list2[$i]->background_image;
    $uploaded_date = $list2[$i]->date_uploaded;
    echo "ㅁㅁㅁㅁㅁㅁ ",$id, $title, $year, $rating, $runtime, $genres, $summary, $language,
    $imgsrc, $uploaded_date, "<br>";
}

// var_dump($list);
curl_close($handle);

?>    

</body>
</html>