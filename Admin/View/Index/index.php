
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<table align="center" bgcolor="#eee8aa" border="1px" width="600px" rules="all">
    <th>序号</th>
    <th>名字</th>
    <th>性别</th>
    <th>年龄</th>
    <th>学历</th>
    <th>工资</th>
    <th>奖金</th>
    <th>籍贯</th>
    <th>操作</th>
    <?php  foreach ($arr as $value){


    ?>
    <tr style="height: 50px">
        <td><?php echo $value['id']?></td>
        <td><?php echo $value['name']?></td>
        <td><?php echo $value['sex']?></td>
        <td><?php echo $value['age']?></td>
        <td><?php echo $value['edu']?></td>
        <td><?php echo $value['salary']?></td>
        <td><?php echo $value['bonus']?></td>
        <td><?php echo $value['city']?></td>
        <td><a href="">修改</a>|<a style="color: red" href="">删除</a></td>

    </tr>
    <?php } ?>
</table>

</body>
</html>