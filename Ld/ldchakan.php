<?php 
    require_once("../Node/system.class.php");
    require_once("../project/prostatchart.class.php");
    $staff_id = -1;
    if($system->CheckSessionLogin())
        $staff_id = (isset($_GET['staff_id']))?$_GET['staff_id']:$staff_id;
    else
        header("Location:../index.php");
    $shixiangs = array();
    $dt= date("Y-m-d",time());
    if(isset($_GET['setdate']))
    {
      $dt = $_GET['setdate'];
      //echo "dddddd";
    }
    else if(isset($_POST['setdate']))
    {
        $dt = $_POST['setdate'];
    }

    if(isset($_POST['staff_id4']))
    {
        $staff_id = $_POST['staff_id4'];
    }

    $xqj = date('w',strtotime($dt));
    $xqj = ($xqj==0)?7:$xqj;

    $obj = new ProStatChart("00CC33","999999");
    $chart_length=200;
    $chart_height=40;
    $hundredstaturationname="work done is 8 hours";
    $obj->SetHundredSaturationnamecolor("#00CC00");
    $obj->SetHundredSaturationnamesize("80%");

    $progressarray = array('0-40' =>"work too little" , '40-80' =>"work not well", '80-120' =>"work done!", 
        '120-200' =>"work so hard!");
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

     <link rel="stylesheet" href="../Js/jquery-ui-1.11.2.custom/jquery-ui.css">
  <script src="../Js/jquery-ui-1.11.2.custom/external/jquery/jquery.js"></script>
  <script src="../Js/jquery-ui-1.11.2.custom/jquery-ui.js"></script>

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
    <script>
  $(function() {
    $( "#datepicker" ).datepicker({
      showWeek: true,
      firstDay: 1,
      dateFormat:"yy-mm-dd"
    });
  });
  </script>
<form class="form-inline definewidth m20" action="ldchakan.php?staff_id=$staff_id" method="post">
    选择周：
    <input type='hidden' name='staff_id4' value='<?php echo $staff_id;?>'>
    <input type="text" name="setdate" id="datepicker" class="abc input-default" placeholder="" value="">&nbsp;&nbsp; 
    <button type="submit" class="btn btn-primary">查询</button>&nbsp;&nbsp; <button type="button" class="btn btn-success" id="addnew">返回部门日报</button>
</form>
<table class="table table-bordered table-hover definewidth m10">
   
    <?php
        $time = strtotime($dt);
        ?>
          <thead>
                <tr>
                <th colspan=6>本周工作</th>
                 </tr>
            </thead>
            <?php
        while($xqj>0)
        {
            $work_loads = $system->GetWorkloadofstaff_idDate($staff_id,$dt);
            //print_r($work_loads);
            if(!empty($work_loads))
            {
                $work_matters = $work_loads[0];
                echo "<tr><td style='vertical-align:middle;border-bottom:1px solid;padding-left:0px;padding-right:0px;padding-bottom:0px;padding-top:0px'>日期:";
                echo $dt;
                if($system->IsWorkday($dt))
                    echo "【工作日】";
                else
                    echo "【非工作日】";
                //define chart width and length
                $chart_width = 30;
                $chart_length = 80;
                $divsaturation = $obj->GetSaturationChart($chart_length,$chart_width,$hundredstaturationname,floatval($work_matters['progress']/100),$progressarray);
                echo "<td style='vertical-align:middle;border-bottom:1px solid;padding-left:0px;padding-right:0px;padding-bottom:0px;padding-top:0px'>时间：".$work_matters['starttime']."至".$work_matters['endtime']."</td>";
                echo "<td style='vertical-align:middle;border-bottom:1px solid;padding-left:0px;padding-right:0px;padding-bottom:0px;padding-top:0px'>饱和度:".$divsaturation."</td>";
                echo "</td><td style='vertical-align:middle;border-bottom:1px solid;padding-left:0px;padding-right:0px;padding-bottom:0px;padding-top:0px'>工作量:".$work_matters['work_load']."</td>";
                $work_matters_all = $work_matters['work_matters'];
                if(!empty($work_matters_all))
                {
                    echo "<td style='vertical-align:middle;border-bottom:1px solid;padding-left:0px;border-left:0px;padding-right:0px;padding-bottom:0px;padding-top:0px'><table style='width:100%'>";
                    foreach ($work_matters_all as $key => $value) {
                        echo "<tr>";
                        echo "<td>".$value['work_matter_name'].":</td>";
                        echo "<td>".$value['work_matter_content']."</td>";
                        echo "<td>时间:".$value['work_matter_time']."</td>";
                        if(!empty($value['work_matter_remark']))
                            echo "<td>".$value['work_matter_remark']."</td>";
                        else
                            echo "<td>"."暂无"."</td>";
                        echo "</tr>";
                    }
                    echo "</table></td>";
                }
                else
                {
                     echo "<td style='vertical-align:middle;border-bottom:1px solid;padding-left:0px;padding-right:0px;padding-bottom:0px;padding-top:0px'><table>";
                     echo "<tr>";
                        echo "<td>"."未填".":</td>";
                        echo "<td>"."未填"."</td>";
                        echo "<td>时间:0</td>";
                        echo "<td>无</td>";
                        echo "</tr>";
                    echo "</table></td>";
                }
                 $now = date("Y-m-d",time());
                $now = strtotime($now);
                $tdt = strtotime($dt);
            }
            else
            {
                echo "<tr><td>日期:";
                echo $dt;
                if($system->IsWorkday($dt))
                    echo "【工作日】";
                else
                    echo "【非工作日】</td>";
                echo "<td colspan='4'>您忘记确认本日工作了</td>";
                $now = date("Y-m-d",time());
                $now = strtotime($now);
                $tdt = strtotime($dt);
               }
            //print_r($shixiangs);
            $xqj=$xqj-1;
            $time = $time-86400;
            $dt=date("Y-m-d",$time);
        }
    ?>
         </table>

</body>
</html>
<script>
    $(function () {
        

        $('#addnew').click(function(){

                window.location.href="../DR/index.php";
         });


    });
    
</script>