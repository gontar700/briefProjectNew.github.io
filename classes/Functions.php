<?php
/**
 * Created by PhpStorm.
 * User: gontar700
 * Date: 19/07/2016
 * Time: 14:41
 */
function __autoload($classname)
{
    include_once $classname.".php";
}
session_start();
class Functions
{
    static function showSmallMessage()
    {
        echo '<h2>טוב שחזרת '.$_SESSION['designerDetails'][3].", היום ה- ".date("d.m.Y",time()-$_SESSION['dayCounter']*60*60*24).'</h2>';
        
    }
    static function buildFirstHeadLine()
    {
        echo '
        <table id="mainTable"> <thead>
        <tr>
            <th style="width:9em">מספר משימה</th>
            <th style="width:15em">לקוח</th>
            <th style="width:7.5em">משעה</th>
            <th style="width:9em">עד שעה</th>
            <th style="width:7.5em">תאריך</th>
            <th style="width:23em">מלל חופשי</th>
            <th style="background: #FFFFFF"></th>
        </tr>
        </thead><tbody>';
    }
    static function buildRows()
    {
        $dbConnection = new DbConnect ('localhost', 'gontar_test', 'Dg270882', 'gontar_test');
        if($_SESSION['login']==36) // manager watching all tasks
        {
            $result = $dbConnection->getAllBriefs($_SESSION['dayCounter']);
        }
        else
        {
            $result = $dbConnection->getBriefs($_SESSION['designerDetails'][0],$_SESSION['dayCounter']);
        }
        $rowNum =1;
        while ($row = $result->fetch_row()) {
            $rowBckColor = $rowNum % 2;
            $rowBckColor = ($rowBckColor == 0 ? "#8bc9e3":"#eceeef"); // switching backgroundcolors
            echo '
            <tr>
                <td style="background:'.$rowBckColor.';width:15em;height:1.5em;align-content:center;text-align: center;font-size: 1.2em"><div id="mission">'.$row[4].'</div></td>
                <td style="background:'.$rowBckColor.';width:7.5em;height:1.5em;align-content:center;text-align: center;font-size: 1.2em"><div id="cust">'.$row[6].'</td>
                <td style="background:'.$rowBckColor.';width:9em;height:1.5em;align-content:center;text-align: center;font-size: 1.2em"><div id="hour1">'.$row[8].'</td>
                <td style="background:'.$rowBckColor.';width:7.5em;height:1.5em;align-content:center;text-align: center;font-size: 1.2em" ><div id="hour2">'.$row[9].'</td>
                <td style="background:'.$rowBckColor.';width:23em;height:1.5em;align-content:center;text-align: center;font-size: 1.2em"><div id="date">'.$row[7].'</td>
                <td style="background:'.$rowBckColor.';width:23em;height:1.5em;align-content:center;text-align: center;font-size: 1.2em"><div id="text">'.$row[10].'</td>
                <td><button id="clickBtnSave" onclick="update('.$row[4].')">עדכן</button></td>
            </tr>';
            $rowNum++;
        }
    }
    static function buildUpdateFormRow()
    {
        echo '
            <tr>
                <td style="width:5em;height:1.5em;align-content:center;text-align: center;font-size: 1.2em">'.$_SESSION["missionToUpdate"].'</td>
                <td style="width:15em"> <input type="text" id="cust" value = '.$_SESSION["valuesToUpdate"]["customer"].' style="width:100%;height:1.5em;align-content:center;text-align: center;font-size: 1.2em" onkeyup="autocomp(this.value)"></td>
                <td style="width:7.5em"> <input type="text" id="hour1" value = '.$_SESSION["valuesToUpdate"]["hour1"].' style="width:100%;height:1.5em;align-content:center;text-align: center;font-size: 1.2em"></td>
                <td style="width:9em"> <input type="text" id="hour2" value = '.$_SESSION["valuesToUpdate"]["hour2"].' style="width:100%;height:1.5em;align-content:center;text-align: center;font-size: 1.2em"> </td>
                <td style="width:7.5em"> <input type="text" id="date" value = '.$_SESSION["valuesToUpdate"]["date"].' style="width:100%;height:1.5em;align-content:center;text-align: center;font-size: 1.2em" ></td>
                <td style="width:23em"> <input type="text" id="text" value = '.$_SESSION["valuesToUpdate"]["text"].' style="width:100%;height:1.5em;align-content:center;text-align: center;font-size: 1.2em"></td>
                <td><button class="btn-primary" id="btn1" onclick="finalupdate()">שמור</button></td>
            </tr>';
        echo '</tbody></table></div>';
        echo '<script>$(document).ready(function() {
                // hour1 validation
                $("#hour1").on("input", function (){
                 var input =$(this);
                 var re = /[0-9]{2}[:]{1}[0-9]{2}[:]{1}[0-9]{2}/;
                 var is_hour = re.test(input.val());
                 if(is_hour)
                 {input.removeClass("invalid").addClass("valid");}
                 else
                 {input.removeClass("valid").addClass("invalid");}
                });
                $("#hour2").on("input", function (){
                 var input =$(this);
                 var re = /[0-9]{2}[:]{1}[0-9]{2}[:]{1}[0-9]{2}/;
                 var is_hour = re.test(input.val());
                 if(is_hour)
                 {input.removeClass("invalid").addClass("valid");}
                 else
                 {input.removeClass("valid").addClass("invalid");}
                });
                $("#date").on("input", function (){
                 var input =$(this);
                 var re = /[0-9]{4}[-]{1}[0-9]{2}[-]{1}[0-9]{2}/;
                 var is_date = re.test(input.val());
                 if(is_date)
                 {input.removeClass("invalid").addClass("valid");}
                 else
                 {input.removeClass("valid").addClass("invalid");}
                });
            });
        </script>';
    }
    static function buildAddFormRow()
    {
        echo '
            <tr>
                <td></td>
                <td style="width:15em"> <input type="text" id="cust" style="width:100%;height:1.5em;align-content:center;text-align: center;font-size: 1.2em" onkeyup="autocomp(this.value)"></td>
                <td style="width:7.5em"> <input type="text" id="hour1" style="width:100%;height:1.5em;align-content:center;text-align: center;font-size: 1.2em"></td>
                <td style="width:9em"> <input type="text" id="hour2"   style="width:100%;height:1.5em;align-content:center;text-align: center;font-size: 1.2em"> </td>
                <td style="width:7.5em"> <input type="text" id="date" style="width:100%;height:1.5em;align-content:center;text-align: center;font-size: 1.2em" ></td>
                <td style="width:23em"> <input type="text" id="text"  style="width:100%;height:1.5em;align-content:center;text-align: center;font-size: 1.2em"></td>
                <td><button id="clickBtnSave" onclick="addRow()">שמור</button></td>
            </tr>';
        echo '</tbody></table></div>';
        echo '<script>$(document).ready(function() {
                // hour1 validation
                $("#hour1").on("input", function (){
                 var input =$(this);
                 var re = /[0-9]{2}[:]{1}[0-9]{2}[:]{1}[0-9]{2}/;
                 var is_hour = re.test(input.val());
                 if(is_hour)
                 {input.removeClass("invalid").addClass("valid");}
                 else
                 {input.removeClass("valid").addClass("invalid");}
                });
                $("#hour2").on("input", function (){
                 var input =$(this);
                 var re = /[0-9]{2}[:]{1}[0-9]{2}[:]{1}[0-9]{2}/;
                 var is_hour = re.test(input.val());
                 if(is_hour)
                 {input.removeClass("invalid").addClass("valid");}
                 else
                 {input.removeClass("valid").addClass("invalid");}
                });
                $("#date").on("input", function (){
                 var input =$(this);
                 var re = /[0-9]{4}[-]{1}[0-9]{2}[-]{1}[0-9]{2}/;
                 var is_date = re.test(input.val());
                 if(is_date)
                 {input.removeClass("invalid").addClass("valid");}
                 else
                 {input.removeClass("valid").addClass("invalid");}
                });
            });
        </script>';
    }
    static function buildDateInput()
    {
        echo '
            <tr>
                <td></td>
                <td style="width:15em"></td>
                <td style="width:7.5em"> </td>
                <td style="width:9em"></td>
                <td style="width:7.5em"> <input type="text" id="date" style="width:100%;height:1.5em;align-content:center;text-align: center;font-size: 1.2em" ></td>
                <td style="width:23em"> </td>
                <td><button id="clickBtnSave" onclick="goToDate()">עבור</button></td>
            </tr>';
        echo '</tbody></table></div>';
        echo '<script>$(document).ready(function() {
                $("#date").on("input", function (){
                 var input =$(this);
                 var re = /[0-9]{4}[-]{1}[0-9]{2}[-]{1}[0-9]{2}/;
                 var is_date = re.test(input.val());
                 if(is_date)
                 {input.removeClass("invalid").addClass("valid");}
                 else
                 {input.removeClass("valid").addClass("invalid");}
                });
            });
        </script>';
    }
    static function buildRowsSpecificDate($date)
    {
        $dbConnection = new DbConnect ('localhost', 'gontar_test', 'Dg270882', 'gontar_test');
        $result = $dbConnection->getBriefsDateAllDesigner($date);
        $rowNum = 1;
        while ($row = $result->fetch_row())
        {
            $rowBckColor = $rowNum % 2;
            $rowBckColor = ($rowBckColor == 0 ? "#8bc9e3":"#eceeef"); // switching backgroundcolors
            echo '
            <tr>
                <td style="background:'.$rowBckColor.';width:15em;height:1.5em;align-content:center;text-align: center;font-size: 1.2em"><div id="mission">'.$row[0].'</div></td>
                <td style="background:'.$rowBckColor.';width:7.5em;height:1.5em;align-content:center;text-align: center;font-size: 1.2em"><div id="cust">'.$row[2].'</div></td>
                <td style="background:'.$rowBckColor.';width:9em;height:1.5em;align-content:center;text-align: center;font-size: 1.2em"><div id="hour1">'.$row[4].'</div></td>
                <td style="background:'.$rowBckColor.';width:7.5em;height:1.5em;align-content:center;text-align: center;font-size: 1.2em" ><div id="hour2">'.$row[5].'</div></td>
                <td style="background:'.$rowBckColor.';width:23em;height:1.5em;align-content:center;text-align: center;font-size: 1.2em"><div id="date">'.$date.'</div></td>
                <td style="background:'.$rowBckColor.';width:23em;height:1.5em;align-content:center;text-align: center;font-size: 1.2em"><div id="text">'.$row[6].'</div></td>
                <td><button id="clickBtnSave" onclick="update('.$row[0].')">עדכן</button></td>
            </tr>';
            $rowNum++;
        }
        echo'</tbody></table></div>';
    }
    static function buildCommentInput()
    {
        echo '
            <tr>
                <td></td>
                <td style="width:15em"></td>
                <td style="width:7.5em"> </td>
                <td style="width:9em"></td>
                <td style="width:7.5em"></td>
                <td style="width:23em"> <input type="text" id="text" style="width:100%;height:30px;align-content:center;text-align: center;font-size: 1.2em" ></td>
                <td><button id="clickBtnSave" onclick="sendCommentSubmit()">שלח</button></td>
            </tr>';
        echo '</tbody></table></div>';
    }
    /*---------------------------------------------------------------------------------------------*/
    static function drawManagerMessages()
    {
        echo '<div id="managerMessages"></div>';
    }
    static function drawChartsStruct1()
    {
        echo '
        <div class="column6">
            <h3>פילוח משימות חודשי</h3>
            <div id="piechart1"></div>
        </div>

        <div class="column6">
            <h3>פילוח משימות רבעוני</h3>
            <div id="piechart2"></div>
        </div>

        <div class="column6">
            <h3>פילוח משימות חציוני</h3>
            <div id="piechart3"></div>
        </div>

        <div class="column6">
            <h3>פילוח משימות שנתי</h3>
            <div id="piechart4"></div>
        </div>';

        for ($i=1;$i<5;$i++)
        {
            Functions::showCharts($i);
        }
    }
    static function drawChartsStruct2()
    {
        echo '
        <div class="column6">
            <h3>פילוח סה"כ שעות עבודה חודשיות</h3>
            <div id="piechart1"></div>
        </div>

        <div class="column6">
            <h3>פילוח סה"כ שעות עבודה רבעוניות</h3>
            <div id="piechart2"></div>
        </div>

        <div class="column6">
            <h3>פילוח סה"כ שעות עבודה חצי שנתיות</h3>
            <div id="piechart3"></div>
        </div>

        <div class="column6">
            <h3>פילוח סה"כ שעות עבודה שנתיות</h3>
            <div id="piechart4"></div>
        </div>';

        for ($i=1;$i<5;$i++)
        {
            Functions::showCharts($i);
        }
    }
    static function drawChartsStruct3()
    {
        echo '
        <div class="column6">
            <h3>פילוח משימות ללקוח חודשי</h3>
            <div id="piechart1"></div>
        </div>

        <div class="column6">
            <h3>פילוח משימות ללקוח רבעוני</h3>
            <div id="piechart2"></div>
        </div>

        <div class="column6">
            <h3>פילוח משימות ללקוח חצי שנתי</h3>
            <div id="piechart3"></div>
        </div>

        <div class="column6">
            <h3>פילוח משימות ללקוח שנתי</h3>
            <div id="piechart4"></div>
        </div>';
        for ($i=1;$i<5;$i++)
        {
            Functions::showCharts($i);
        }
    }
    static function showCharts($period)
    {

        $dbConnection = new DbConnect ('localhost', 'gontar_test', 'Dg270882', 'gontar_test');
        $currentYear = date("Y");
        switch ($period)
        {
            case 1: // this month
                $startDate = date("Y-m-d",strtotime(date("Y-m-d",time()))-30*24*3600);
                $endDate = date("Y-m-d",time());
                break;
            case 2: // this quarter meanig 3 month back
                $startDate = date("Y-m-d",strtotime(date("Y-m-d",time()))-90*24*3600);
                $endDate = date("Y-m-d",time());
                break;
            case 3: // this half year
                $startDate = date("Y-m-d",strtotime(date("Y-m-d",time()))-180*24*3600);
                $endDate = date("Y-m-d",time());
                break;
            case 4: // this year
                $startDate = date("Y-m-d",strtotime(date("Y-m-d",time()))-360*24*3600);
                $endDate = date("Y-m-d",time());
                break;
        }
        // if $_SESSION['login'] ==6 then first charts will be displayed - total tasks if == 16 secondcharts and so on
        switch ($_SESSION['login'])
        {
            case 6:
                $result1 = $dbConnection->NumberTasksMonth1($startDate,$endDate); // num of tasks of first designer
                $result2 = $dbConnection->NumberTasksMonth2($startDate,$endDate); // num of tasks of second designer
                $result3 = $dbConnection->NumberTasksMonth3($startDate,$endDate); // num of tasks of second designer
                $title = 'Task amount segmentation';
                break;
            case 16:
                $result1 = $dbConnection->totalHourAmount1($startDate,$endDate); // total hours of first designer
                $result2 = $dbConnection->totalHourAmount2($startDate,$endDate); // total hours of second designer
                $result3 = $dbConnection->totalHourAmount3($startDate,$endDate); // total hours of second designer
                $title = 'Total hours amount segmentation';
                break;
            case 26:
                $result1 = $dbConnection->taskAmountEilat($startDate,$endDate);
                $result2 = $dbConnection->taskAmountBS($startDate,$endDate);
                $result3 = $dbConnection->taskAmountME($startDate,$endDate);
                $result4 = $dbConnection->taskAmountKA($startDate,$endDate);
                $result5 = $dbConnection->taskAmountHolon($startDate,$endDate);
                $result6 = $dbConnection->taskAmountRehovot($startDate,$endDate);
                break;
        }
        $row1 = $result1->fetch_row()[0];
        $row2 = $result2->fetch_row()[0];
        $row3 = $result3->fetch_row()[0];
        if ($_SESSION['login']==26)
        {
            $row4 = $result4->fetch_row()[0];
            $row5 = $result5->fetch_row()[0];
            $row6 = $result6->fetch_row()[0];
        }
        echo '
            <script>
                google.charts.setOnLoadCallback(drawChart);
                function drawChart()
                {
                    if ('.$_SESSION['login'].'==6 || '.$_SESSION['login'].'==16)
                    {
                        var data = google.visualization.arrayToDataTable([
                        ["Category", "Amount"],
                        ["Zeev", '.floor($row1).'],
                        ["Hadas", '.floor($row2).'],
                        ["Shimrit", '.floor($row3).']
                        ]);
                    }
                    else
                    {
                        var data = google.visualization.arrayToDataTable([
                        ["Category", "Amount"],
                        ["Eilat", '.$row1.'],
                        ["Beit-Shemesh", '.$row2.'],
                        ["Maale-Adumim", '.$row3.'],
                        ["Kiriat-Ata", '.$row4.'],
                        ["Holon", '.$row5.'],
                        ["Rehovot", '.$row6.']
                        ]);
                    }
                    var options =
                    {
                        title: \''.$title.'\',
                        colors: [\'blue\', \'red\', \'yellow\', \'green\', \'purple\', \'pink\'],
                        is3D: true
                    };
                        switch ('.$period.')
                        {
                            case 1:
                                var chart = new google.visualization.PieChart(document.getElementById(\'piechart1\'));
                                chart.draw(data, options);
                            break;
                            case 2:
                                var chart = new google.visualization.PieChart(document.getElementById(\'piechart2\'));
                                chart.draw(data, options);
                            break;
                            case 3:
                                var chart = new google.visualization.PieChart(document.getElementById(\'piechart3\'));
                                chart.draw(data, options);
                            break;
                            case 4:
                                var chart = new google.visualization.PieChart(document.getElementById(\'piechart4\'));
                                chart.draw(data, options);
                            break;
                        }
                }
            </script>';
    }
    static function selectCommentsForDisplay()
    {
        $dbConnection = new DbConnect ('localhost', 'gontar_test', 'Dg270882', 'gontar_test');
        $result = $dbConnection->selectComments();
        $str = [];
        $i = 0;
        while ($row = $result->fetch_row()) {
            $str[$i] = $row[1] . ':' . ' ' . $row[0] . ' ';
            $i++;

        }
        echo '<script>
        $(document).ready(function(){
            $("#managerMessages").html("'.$str[0].'").animate({paddingRight:"60%"},7000,
                function(){
                    $("#managerMessages").html("*").animate({paddingRight:"-=750px"},100,
                    function(){
                     $("#managerMessages").html("'.$str[1].'").animate({paddingRight:"60%"},7000,
                            function(){$("#managerMessages").html("*").animate({paddingRight:"-=750px"},100,
                                    function(){
                                        $("#managerMessages").html("'.$str[2].'").animate({paddingRight:"60%"},7000,
                                              function(){
                                                    $("#managerMessages").html("*").animate({paddingRight:"-=750px"},100,
                                                    function(){
                                                        $("#managerMessages").html("'.$str[3].'").animate({paddingRight:"60%"},7000,
                                                            function(){
                                                                $("#managerMessages").html("*").animate({paddingRight:"-=750px"},100,
                                                                    function(){
                                                                            $("#managerMessages").html("' . $str[4] . '").animate({paddingRight:"60%"},7000,
                                                                            function(){
                                                                                $("#managerMessages").html("*").animate({paddingRight:"-=750px"},100,
                                                                                    function(){
                                                                                        $("#managerMessages").html("' . $str[5] . '").animate({paddingRight:"60%"},7000,
                                                                                            function(){
                                                                                                $("#managerMessages").html("*").animate({paddingRight:"-=750px"},100);
                                                                                           });  });  });   });  });    });  });  }); }); });  }); });
                </script>';
    }
}
if (isset($_GET['dayCounter']))
{
    $_SESSION['dayCounter']+=$_GET['dayCounter'];
    if ($_SESSION['login']!=36)   // Manager login and not worker login , session will remain unchanged
    {
        $_SESSION['login']=1;  // regular worker login -> updating $_session to 1
    }
}
if (isset($_GET['update']))
{
    $_SESSION['missionToUpdate']=$_GET['update'];
    $dbConnection = new DbConnect ('localhost', 'gontar_test', 'Dg270882', 'gontar_test');
    $result = $dbConnection->getBriefsBriefId($_SESSION['missionToUpdate']);
    $row = $result->fetch_row();
    $_SESSION['valuesToUpdate']['customer'] = $row[2];
    $_SESSION['valuesToUpdate']['date'] = $row[3];
    $_SESSION['valuesToUpdate']['hour1'] = $row[4];
    $_SESSION['valuesToUpdate']['hour2'] = $row[5];
    $_SESSION['valuesToUpdate']['text'] = $row[6];
    $_SESSION['login']=2;
}
if (isset($_GET['finalUpdate']) && isset($_GET['customer'])&& isset($_GET['date']) && isset($_GET['hour1'])&& isset($_GET['hour2']) && isset($_GET['text']))
{
    $dbConnection = new DbConnect ('localhost', 'gontar_test', 'Dg270882', 'gontar_test');
    echo ($dbConnection->updateBrief($_SESSION['missionToUpdate'],$_SESSION['designerDetails'][0], $_GET['customer'], $_GET['date'], $_GET['hour1'], $_GET['hour2'], $_GET['text']));
    $_SESSION['login']=1;  // back to state 1 , login = phase in system
}
if (isset($_GET['add']) && isset($_GET['customer'])&& isset($_GET['date']) && isset($_GET['hour1'])&& isset($_GET['hour2']) && isset($_GET['text']))
{
    $dbConnection = new DbConnect ('localhost', 'gontar_test', 'Dg270882', 'gontar_test');
    echo ($dbConnection->addNewBrief($_SESSION['designerDetails'][0],$_GET['customer'], $_GET['date'], $_GET['hour1'], $_GET['hour2'], $_GET['text']));
    $_SESSION['login']=1;  // back to state 1 , main phase in system
}
if (isset($_GET['newBrief'])) // new brief
{
    $_SESSION['login']=3;
}

if (isset($_GET['exit'])) // exit
{
    session_destroy();
    echo "להתראות";
}
if (isset($_GET['specificDate']))  // go to date input
{
    $_SESSION['login']=4;
}
if (isset($_GET['goToDate'])&& isset($_GET['specificDate']))
{
    $_SESSION['specificDate']=$_GET['specificDate'];
    $_SESSION['login']=5;
    $dif = time()-strtotime($_GET['specificDate']);
    $_SESSION['dayCounter'] = floor($dif/(3600*24));    // calculating the differance between today date and specific date ,
    // if specific date is in the past => daycounter > 0 needed to be divided because timestamp units
    //echo floor($dif/(3600*24));
}
if (isset($_GET['custname']))
{
    $dbConnection = new DbConnect ('localhost', 'gontar_test', 'Dg270882', 'gontar_test');
    $result = $dbConnection->getCustomerName($_GET['custname']);
    $row = $result->fetch_row();
    echo $row[0];
}
if (isset($_GET['comment']))
{
    $_SESSION['login']=7;
}
if (isset($_GET['commentSubmit']))
{
    $dbConnection = new DbConnect ('localhost', 'gontar_test', 'Dg270882', 'gontar_test');
    $result = $dbConnection->sendCommentSubmit($_GET['commentSubmit'],$_SESSION['designerDetails'][0]);
    echo $result;
}
if (isset($_GET['nextPieCharts']))
{
    if ($_GET['nextPieCharts']==1) // Going forword
    {
        if ($_SESSION['login']==6 || $_SESSION['login']==16)
        {
            $_SESSION['login']+=10;
        }
        else
        {
            echo ("No more pages");
        }
    }
    else                            // Going backword
    {
        if ($_SESSION['login']==26 || $_SESSION['login']==16)
        {
            $_SESSION['login']-=10;
        }
        else
        {
            echo ("No more pages");
        }
    }
}
if (isset($_GET['checkTasks']))
{
    $_SESSION['login']=36;
}