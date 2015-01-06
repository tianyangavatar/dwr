<?php
	 require_once("../Node/system.class.php");
	 if(!$system->CheckSessionLogin())
	 {
	 	header('Location:../index.php');
	 }
     $czid = $_GET['czid'];
     $user = $system->GetStaffbystaff_id($czid);
     //print_r($user);
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="../Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="../Css/style.css" />
    <script type="text/javascript" src="../Js/jquery.js"></script>
    <script type="text/javascript" src="../Js/jquery.sorted.js"></script>
    <script type="text/javascript" src="../Js/bootstrap.js"></script>
    <script type="text/javascript" src="../Js/ckform.js"></script>
    <script type="text/javascript" src="../Js/common.js"></script>

    <style type="text/css">
        body {
            padding-bottom: 40px;
        }
        .sidebar-nav {
            padding: 9px 0;
        }

        @media (max-width: 980px) {
            /* Enable use of floated navbar text */
            .navbar-text.pull-right {
                float: none;
                padding-left: 5px;
                padding-right: 5px;
            }
        }


    </style>
</head>
<body>
<form action="oprdo.php?czid=<?php echo $czid;?>" method="post" class="definewidth m20">
    <table class="table table-bordered table-hover definewidth m10">
        <tr>
            <td width="10%" class="tableleft">登录名称</td>
            <td><input type="text" name="dlname" value='<?php echo $user['name']?>'/></td>
        </tr>
        <tr>
            <td width="10%" class="tableleft">登录密码</td>
            <td><input type="text" name="dlpass" value='<?php echo $user['password']?>'/></td>
        </tr>
        <tr>
            <td width="10%" class="tableleft">所属部门</td>
            <td>
                <select name="departmentid">
                    <option selected value='<?php echo $user['department_id']?>' >
                        <?php
                        //print_r($user);
                            $bid = $user['department_id'];  
                            $bmname=$system->GetDepartmentbydepartment_id($bid);
                            $name = $bmname['name'];
                            if($bid=='-1')
                                echo "<option value='-1' selected>暂无</option>";
                            else if ($bid=='0')
                                echo "<option value='0' selected>中心</option>";
                            else
                                echo "<option value='$bid' selected>$name</option>";
                            ?>

                    </option>
                    
                    <?php
                        $departments = $system->Getdepartment();
                        foreach ($departments as $key => $department) {
                            $id = $department['id'];
                            $name = $department['name'];
                            if($bid!=$id)
                                echo "<option value='$id'>$name</option>";
                        }
                    ?>
                </select>
            </td>
        </tr>
         <tr>
            <td width="10%" class="tableleft">权限</td>
            <td>
                <select name="authority">
                    <?php
                    $authority = $user['authority'];
                    if($authority=='0')
                        echo "<option value='0' selected>员工</option>";
                    else
                        echo "<option value='0'>员工</option>";
                    if($authority=='1')
                        echo "<option value='1' selected>部门领导</option>";
                    else
                        echo "<option value='1'>部门领导</option>";
                    if($authority=='2')
                        echo "<option value='2' selected>中心领导</option>";
                    else
                        echo "<option value='2'>中心领导</option>";
                    ?>
                </select>
            </td>
        </tr>
         <tr>
            <td width="10%" class="tableleft">真实名称</td>
            <td><input type="text" name="realname" value="<?php echo $user['realname']?>"/></td>
        </tr>
        <tr>
            <td width="10%" class="tableleft">联系邮箱</td>
            <td><input type="text" name="email" value="<?php echo $user['email']?>"/></td>
        </tr>
        <!--<tr>
            <td class="tableleft">状态</td>
            <td>
                <input type="radio" name="status" value="1" checked/> 启用  <input type="radio" name="status" value="0"/> 禁用
            </td>
        </tr>
        <tr>
            <td class="tableleft">权限</td>
            <td>
                <ul><li><label class='checkbox inline'><input type='checkbox' name='group[]' value='' />公用节点</label><ul><li><label class='checkbox inline'><input type='checkbox' name='node[]' value='21' />省市区级联数据</label><li><label class='checkbox inline'><input type='checkbox' name='node[]' value='22' />省市区数据获取</label></ul></li><li><label class='checkbox inline'><input type='checkbox' name='group[]' value='' />明信片批次管理</label><ul><li><label class='checkbox inline'><input type='checkbox' name='node[]' value='25' />明信片批次管理</label><li><label class='checkbox inline'><input type='checkbox' name='node[]' value='26' />明信片批次添加</label><li><label class='checkbox inline'><input type='checkbox' name='node[]' value='27' />明信片批次编辑</label></ul></li><li><label class='checkbox inline'><input type='checkbox' name='group[]' value='' />标签管理</label><ul><li><label class='checkbox inline'><input type='checkbox' name='node[]' value='17' />标签查询</label><li><label class='checkbox inline'><input type='checkbox' name='node[]' value='18' />标签生成</label><li><label class='checkbox inline'><input type='checkbox' name='node[]' value='19' />批量贴标签</label><li><label class='checkbox inline'><input type='checkbox' name='node[]' value='20' />标签编辑</label><li><label class='checkbox inline'><input type='checkbox' name='node[]' value='23' />标签生成下载（请和标签生成同时选中）</label><li><label class='checkbox inline'><input type='checkbox' name='node[]' value='24' />文件下载（请和标签生成、查询同时选中）</label></ul></li><li><label class='checkbox inline'><input type='checkbox' name='group[]' value='' />权限</label><ul><li><label class='checkbox inline'><input type='checkbox' name='node[]' value='1' />权限列表</label><li><label class='checkbox inline'><input type='checkbox' name='node[]' value='2' />权限添加</label><li><label class='checkbox inline'><input type='checkbox' name='node[]' value='3' />权限编辑</label><li><label class='checkbox inline'><input type='checkbox' name='node[]' value='4' />权限删除</label></ul></li><li><label class='checkbox inline'><input type='checkbox' name='group[]' value='' />用户</label><ul><li><label class='checkbox inline'><input type='checkbox' name='node[]' value='9' />用户列表</label><li><label class='checkbox inline'><input type='checkbox' name='node[]' value='10' />用户添加</label><li><label class='checkbox inline'><input type='checkbox' name='node[]' value='11' />用户编辑</label><li><label class='checkbox inline'><input type='checkbox' name='node[]' value='12' />用户删除</label></ul></li><li><label class='checkbox inline'><input type='checkbox' name='group[]' value='' />菜单管理</label><ul><li><label class='checkbox inline'><input type='checkbox' name='node[]' value='13' />菜单列表</label><li><label class='checkbox inline'><input type='checkbox' name='node[]' value='14' />菜单新增</label><li><label class='checkbox inline'><input type='checkbox' name='node[]' value='15' />菜单编辑</label><li><label class='checkbox inline'><input type='checkbox' name='node[]' value='16' />菜单删除</label></ul></li><li><label class='checkbox inline'><input type='checkbox' name='group[]' value='' />角色</label><ul><li><label class='checkbox inline'><input type='checkbox' name='node[]' value='5' />角色列表</label><li><label class='checkbox inline'><input type='checkbox' name='node[]' value='6' />角色添加</label><li><label class='checkbox inline'><input type='checkbox' name='node[]' value='7' />角色编辑</label><li><label class='checkbox inline'><input type='checkbox' name='node[]' value='8' />角色删除</label></ul></li></ul> 
            </td>
        </tr>
    -->
        <tr>
            <td class="tableleft"></td>
            <td>
                <button type="submit" class="btn btn-primary" name="addid" id="addid" type="button">保存</button> &nbsp;&nbsp;<button type="button" class="btn btn-success" name="backid" id="backid">返回列表</button>
            </td>
        </tr>
    </table>
</form>
</body>
</html>
<script>
    $(function () {
        $(':checkbox[name="group[]"]').click(function () {
            $(':checkbox', $(this).closest('li')).prop('checked', this.checked);
        });

        $('#backid').click(function(){
                window.location.href="adddo.html";
         });
    });
</script>