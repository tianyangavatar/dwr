<?php 
    require_once("../Node/system.class.php");
    $staff_id = -1;

    if($system->CheckSessionLogin())
        $staff_id = $_SESSION[$system->GetSessionVar()];
    else
        header("Location:../index.php");
    $user = $system->GetStaffbystaff_id($staff_id);
    $staffs = array();
    $dt= date("Y-m-d",time());
    if(isset($_POST['setdate']))
    {
      $dt = $_POST['setdate'];
      //echo "dddddd";
    }
    $department_id = -2;
    if(isset($_GET['department_id']))
      $department_id = $_GET['department_id'];//$system->GetDepartmentofLeader($staff_id);
    else
    {
      $bms = $system->Getdepartment();
      $department_id = (empty($bms))?-2:$bms[0]['id'];
    }
    $xqj = date('w',strtotime($dt)); 
    $xqj = ($xqj==0)?7:$xqj;  
?>

<!DOCTYPE HTML>
<html>
 <head>
  <title> DWR管理系统</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link href="../assets/css/dpl-min.css" rel="stylesheet" type="text/css" />
  <link href="../assets/css/bui-min.css" rel="stylesheet" type="text/css" />
   <link href="../assets/css/main-min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="../Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="../Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="../Css/style.css" />
    <script type="text/javascript" src="../Js/jquery.js"></script>
    <script type="text/javascript" src="../Js/jquery.sorted.js"></script>
    <script type="text/javascript" src="../Js/bootstrap.js"></script>
    <script type="text/javascript" src="../Js/ckform.js"></script>
    <script type="text/javascript" src="../Js/common.js"></script>

    <link rel="stylesheet" href="../Js/jquery-ui-1.11.2.custom/jquery-ui.css">
  <script src="../Js/jquery-ui-1.11.2.custom/external/jquery/jquery.js"></script>
  <script src="../Js/jquery-ui-1.11.2.custom/jquery-ui.js"></script>

 </head>
 <body>

  <div class="header">
    
      <div class="dl-title">
       <!--<img src="/chinapost/Public/assets/img/top.png">-->
      </div>

    <div class="dl-log">欢迎您，<span class="dl-log-user"><?php echo $user['name'];?></span><a href="logout.php" title="退出系统" class="dl-log-quit">[退出]</a>
    </div>
  </div>
   <div class="content">
    <div class="dl-main-nav">
      <div class="dl-inform"><div class="dl-inform-title"><s class="dl-inform-icon dl-up"></s></div></div>
      <ul id="J_Nav"  class="nav-list ks-clear">
            <li class="nav-item dl-selected"><div class="nav-item-inner nav-home">系统管理</div></li>   <li class="nav-item dl-selected"><div class="nav-item-inner nav-order">业务管理</div></li>       

      </ul>
    </div>
    <ul id="J_NavContent" class="dl-tab-conten">

    </ul>
   </div>

   
  <script>
  $(function() {
    $( "#datepicker" ).datepicker({
      showWeek: true,
      firstDay: 1,
      dateFormat:"yy-mm-dd"
    });
  });
  </script>

</head>
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

<form class="form-inline definewidth m20" action="index.php" method="post">
    选择周：
    <input type="text" name="setdate" id="datepicker" class="abc input-default" placeholder="" value="">&nbsp;&nbsp; 
    <button type="submit" class="btn btn-primary">查询</button>&nbsp;&nbsp; <button type="button" class="btn btn-success" id="addnew">新增周报</button>
</form>
<table class="table table-bordered table-hover definewidth m10">
   
    <?php
    
          while ( $xqj>0) {
            $staffs = $system->GetWorkloadofDepartment($department_id,$dt);
           
            ?>
            <thead>
                <tr>
                <th colspan=5>日期<?php echo $dt;?></th>
                <th colspan=1 style='align:right'>确认人数:<?php echo count($staffs);?></th> 
                </tr>
            </thead>
        <?php
          $xqj= $xqj-1;
          $time = strtotime($dt)-86400;
          $dt = date("Y-m-d",intval($time));
          echo "<thead>
                <tr>
                <th>名字</th>
                <th>工作时间</th>  
                <th>项目名称</th>
                <th>项目内容</th>
                <th>所用时间</th>
                <th>上传文件</th>
                </tr>
          </thead>";
           foreach ($staffs as $key => $renayun) {
           //print_r($renayun);
           //echo "ddddddddddddddddddddddddd</br>"
           echo "<tr style='border-bottom:2px'>";
           $staffdi = $renayun['id'];
           $name = $system->GetRealnamebystaff_id($staffdi);
           echo "<td style='vertical-align:middle;border-bottom:1px solid'><a href='../ld/ldchakan.php?staff_id=$staffdi&setdate=$dt'>$name</a></td>";
           echo "<td style='vertical-align:middle;border-bottom:1px solid;padding-left:0px;border-left:1px solid #DDD;padding-right:0px;padding-bottom:0px;padding-top:0px'><table style='width:100%;padding-left:0px'><tr><td style='border:0px;'>".$renayun['starttime']."</td></tr>
                            <tr><td>".$renayun['endtime']."</td></tr></table></td>";
           $shixiangs = $renayun['shixiang'];
           echo "<td style='vertical-align:middle;border-bottom:1px solid;padding-left:0px;border-left:0px;padding-right:0px;padding-bottom:0px;padding-top:0px'><table style='width:100%;padding-left:0px'>";
           foreach ($shixiangs as $key => $value) {
               echo "<tr><td>".$value['work_matter_name']."</td></tr>";
           }
           echo "</table></td>";
           echo "<td style='vertical-align:middle;border-bottom:1px solid;padding-left:0px;border-left:0px;padding-right:0px;padding-bottom:0px;padding-top:0px'><table style='width:100%;margin-left:0px'>";
           foreach ($shixiangs as $key => $value) {
               echo "<tr><td>".$value['work_matter_content']."</td></tr>";
           }
           echo "</table></td>";
           echo "<td style='vertical-align:middle;border-bottom:1px solid;padding-left:0px;border-left:0px;padding-right:0px;padding-bottom:0px;padding-top:0px'><table style='width:100%;padding-left:0px'>";
           foreach ($shixiangs as $key => $value) {
               echo "<tr><td>".$value['work_matter_time']."小时</td></tr>";
           }
           echo "</table></td>";
           echo "<td style='vertical-align:middle;border-bottom:1px solid;padding-left:0px;border-left:0px;padding-right:0px;padding-bottom:0px;padding-top:0px'><table style='width:100%;padding-left:0px'>";
           foreach ($shixiangs as $key => $value) {
               if($value['work_matter_remark']!='')
                echo "<tr><td>".$value['work_matter_remark']."</td></tr>";
                else
                    echo "<tr><td>暂无</td></tr>";
           }
           echo "</table></td>";
       }
     }
   
       ?>
    <!--
	     <tr>
            <td colspan="5">系统管理</td>
            <td><a href="edit.html">编辑</a></td>
        </tr>
        <tr>
                <td>机构管理</td>
                <td>Admin</td>
                <td>Merchant</td>
                <td>index</td>
                <td>0</td>
                <td><a href="edit.html">编辑</a></td>
            </tr><tr>
                <td>权限管理</td>
                <td>Admin</td>
                <td>Node</td>
                <td>index</td>
                <td>0</td>
                <td><a href="edit.html">编辑</a></td>
            </tr><tr>
                <td>角色管理</td>
                <td>Admin</td>
                <td>Role</td>
                <td>index</td>
                <td>0</td>
                <td><a href="edit.html">编辑</a></td>
            </tr><tr>
                <td>用户管理</td>
                <td>Admin</td>
                <td>User</td>
                <td>index</td>
                <td>0</td>
                <td><a href="edit.html">编辑</a></td>
            </tr><tr>
                <td>菜单管理</td>
                <td>Admin</td>
                <td>Menu</td>
                <td>index</td>
                <td>0</td>
                <td><a href="edit.html">编辑</a></td>
            </tr><tr>
            <td colspan="5">明信片管理</td>
            <td><a href="edit.html">编辑</a></td>
        </tr>
        <tr>
                <td>批次管理</td>
                <td>Admin</td>
                <td>LabelSet</td>
                <td>index</td>
                <td>0</td>
                <td><a href="edit.html">编辑</a></td>
            </tr><tr>
                <td>明信片查询</td>
                <td>Admin</td>
                <td>Label</td>
                <td>index</td>
                <td>0</td>
                <td><a href="edit.html">编辑</a></td>
            </tr><tr>
                <td>明信片生成</td>
                <td>Admin</td>
                <td>Label</td>
                <td>apply</td>
                <td>1</td>
                <td><a href="edit.html">编辑</a></td>
            </tr>
        -->
            </tr></table>

</body>
</html>
 <script type="text/javascript" src="../assets/js/jquery-1.8.1.min.js"></script>
  <script type="text/javascript" src="../assets/js/bui-min.js"></script>
  <script type="text/javascript" src="../assets/js/common/main-min.js"></script>
  <script type="text/javascript" src="../assets/js/config-min.js"></script>
 <?php 
      echo "<script>
    BUI.use('common/main',function(){
      var config = [{id:'1',menu:[{text:'查看日报',items:[";
    foreach ($bms as $key => $value) {
      # code...
      $id = $value['id'];
      $name = $value['name'];
      echo "{id:'$id',text:'$name',href:'department.php?department_id=$id'},";
    }
    echo "{id:'100',text:'个人中心',href:'../Role/center.php'}";
    echo " ]}]},
      {id:'7',homePage : '9',menu:[{text:'业务管理',items:[{id:'9',text:'查询业务',href:'Node/index.html'}]}]}];
      new PageUtil.MainPage({
        modulesConfig : config
      });
    });
  </script>";
  ?>

<script>
    $(function () {
        

		$('#addnew').click(function(){

				window.location.href="add.html";
		 });


    });
	
</script>

<script>
   function subform(obj){
   // alert(obj.id);
   var result = document.getElementById("starttime_"+obj.id).value;
   var password = document.getElementById("endtime_"+obj.id).value;

   //alert(result);
   if(result == ""  ){
     alert("填写"+obj.id+"开始时间");
     return false;
   }
   if(password == ""  ){
    alert("填写结束时间");
     return false;
   }
  document.getElementById("formid_"+obj.id).submit()
}
    
</script>