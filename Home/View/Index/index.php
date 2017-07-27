
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<table align="center" bgcolor="pink" border="1px" width="600px" rules="all">
    <th>序号</th>
    <th>名字</th>
    <th>性别</th>
    <th>年龄</th>
    <th>学历</th>
    <th>工资</th>
    <th>奖金</th>
    <th>籍贯</th>
    <th>操作</th>
    <{foreach $arr as $v}>
    <tr style="height: 50px">
        <td><{$v['id']}></td>
        <td><{$v['name']}></td>
        <td><{$v['sex']}></td>
        <td><{$v['age']}></td>
        <td><{$v['edu']}></td>
        <td><{$v['salary']}></td>
        <td><{$v['bonus']}></td>
        <td><{$v['city']}></td>
        <td><a href="javascript:void (0)" onclick="confirmedit(<{$v['id']}>)">修改</a>|<a style="color: red" href="javascript:void (0)" onclick="confirmdel(<{$v['id']}>)">删除</a></td>

    </tr>
<{/foreach}>
</table>
<script>
confirmdel(id){
    if(window.confirm("您确定删除吗")){
        location.href="?c=index&a=delete&id="+id
    }
}
</script>
</body>
</html>