<?php
$host = 'localhost'; 
$database = 'menu'; 
$user = 'root'; 
$password = ''; 

$connect = mysqli_connect($host, $user, $password, $database);
// Check connection
if (!$connect) {
      die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM  categories";
$result=mysqli_query($connect, $sql);

if (mysqli_num_rows($result) > 0){
    $cats = array();
    while($cat =  mysqli_fetch_assoc($result)){
        $cats_ID[$cat['id']][] = $cat;
        $cats[$cat['parent_id']][$cat['id']] =  $cat;
    }
}
var_dump($cats);

function build_tree($cats,$parent_id,$only_parent = false){
    if(is_array($cats) and isset($cats[$parent_id])){
        $tree = '<ul>';
        if($only_parent==false){
            foreach($cats[$parent_id] as $cat){
                $tree .= '<li>'.$cat['name'].' #'.$cat['id'];
                $tree .=  build_tree($cats,$cat['id']);
                $tree .= '</li>';
            }
        }elseif(is_numeric($only_parent)){
            $cat = $cats[$parent_id][$only_parent];
            $tree .= '<li>'.$cat['name'].' #'.$cat['id'];
            $tree .=  build_tree($cats,$cat['id']);
            $tree .= '</li>';
        }
        $tree .= '</ul>';
    }
    else return null;
    return $tree;
}

echo build_tree($cats,0);
?>