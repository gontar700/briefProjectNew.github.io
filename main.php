<!DOCTYPE html>
<html dir="rtl" lang="he-IL">
<head>
    <link rel="stylesheet" href="http://www.danielgontar.com/web_portfolio/briefProjectNew/style/css/grid.css">
    <link rel="stylesheet" href="style/css/myStyle.css">
    <script src="script/myScript.js"></script>
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script> google.charts.load('current', {'packages':['corechart']}); </script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta charset="UTF-8">
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<main class="container12">
<?php
include_once "classes/Functions.php";           // we will show all tasks for that user for that day
if (empty($_SESSION['login']))                  // if we just entered the page after login
{
    include_once "verification.php";
    if ($_SESSION['login']==6)                  // manager login
    {
        functions::showSmallMessage();
        functions::drawManagerMessages();
        functions::selectCommentsForDisplay();
        functions::drawChartsStruct1();         // the chart function is called internaly from this function
    }
    else
    {
        functions::showSmallMessage();         // greethings message for designer
        functions::buildFirstHeadLine();
        functions::buildRows();
    }
}
else
{
    switch ($_SESSION['login'])
    {
        case 1:     // backword in days forward
        {
            functions::showSmallMessage();         // greethings message for designer
            functions::buildFirstHeadLine();
            functions::buildRows();                // extracing the data
            break;
        }
        case 2:     // update
        {
            functions::showSmallMessage();         // greethings message for designer
            functions::buildFirstHeadLine();
            functions::buildUpdateFormRow();       // new input row
            break;
        }
        case 3:     // add new Brief
        {
            functions::showSmallMessage();          // greethings message for designer
            functions::buildFirstHeadLine();
            functions::buildAddFormRow();           // new input row
            break;
        }
        case 4:     // specific date input page
        {
            functions::showSmallMessage();           // greethings message for designer
            functions::buildFirstHeadLine();
            functions::buildDateInput();             // new input row for date input
            break;
        }
        case 5:     // specific date result
        {
            functions::showSmallMessage();           // greethings message for designer
            functions::buildFirstHeadLine();
            functions::buildRowsSpecificDate($_SESSION['specificDate']);            // new input row for date input
            break;
        }
        case 6:     // first page og manager , $_SESSION['LOGIN'] is not empty
        {
            functions::showSmallMessage();
            functions::drawManagerMessages();
            functions::selectCommentsForDisplay();
            functions::drawChartsStruct1();         // the chart function is called internaly from this function
            break;
        }
        case 7:     // Write a comment for manager to read
        {
            functions::showSmallMessage();           // greethings message for designer
            functions::buildFirstHeadLine();
            functions::buildCommentInput();          // new input row for date input
            break;
        }
        case 16:    // Manager second page showing total working hours segmentation
        {
            functions::showSmallMessage();
            functions::drawManagerMessages();
            functions::selectCommentsForDisplay();
            functions::drawChartsStruct2();         // the chart function is called internaly from this function
            break;
        }
        case 26:    // Manager third page showing cusomers total tasks segmentation
        {
            functions::showSmallMessage();
            functions::drawManagerMessages();
            functions::selectCommentsForDisplay();
            functions::drawChartsStruct3();         // the chart function is called internaly from this function
            break;
        }
        case 36:    // displaying all tasks to manager
        {
            functions::showSmallMessage();
            functions::buildFirstHeadLine();
            functions::buildRows();
            break;
        }
    }
}
if ($_SESSION['login']==6 || $_SESSION['login']==16 || $_SESSION['login']==26)
{
    include_once "managerFooter.php";
}
else
{
    include_once "footer.php";
}
?>
</main>