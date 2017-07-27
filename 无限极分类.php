<?php
$a=@mysql_connect("localhost","root","root");
if (!$a) {
	echo "mysql is wrong";
}
$b=@mysql_select_db("test");
if (!$b) {
	echo "db is wrong";
}

mysql_query("set names utf8");
$sql="SELECT * from test";
$res=mysql_query($sql);
 // var_dump($res);
$arrs=array();
while ($row=mysql_fetch_assoc($res)) {
	$arrs[]=$row;
}
 // print_r($arrs);

function digui($arrs,$level=0,$pid=0){
	static $re_arr=array();
	foreach ($arrs as  $arr) {
		if ($arr['pid']==$pid) {

			$arr['level']=$level;
            $re_arr[]=$arr;
			digui($arrs,$level+1,$arr['id']);
		}

	}
    return $re_arr;

	}

	$l_arr=digui($arrs);
print_r($l_arr);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<table align="center" width="600px" bgcolor="pink">
    <?php  foreach ($l_arr as $v){?>
    <tr>
        <td height="20px">
            <?php echo str_repeat("----",$v['level'])?>

            <?php echo $v['name']?>
        </td>
    </tr>
    <?php  } ?>
</table>
</body>
</html>







