/**
 * Created by gontar700 on 19/07/2016.
 */
var xhr;
xhr = new XMLHttpRequest();
function home()
{
    window.location.assign("index.html");
}
function prev(dayCounter)
{

    xhr.abort();
    xhr.open("GET","classes/Functions.php?dayCounter="+dayCounter,true);
    xhr.onreadystatechange=function()
    {
        if(xhr.readyState==4 && xhr.status==200)
        {
            window.location.assign("http://www.danielgontar.com/web_portfolio/briefProjectNew/main.php");
        }
    };
    xhr.send(null);
}
function update(missionNumber)
{
    var customer = document.getElementById("cust").value;
    var date = document.getElementById("date").value;
    var hour1 = document.getElementById("hour1").value;
    var hour2 = document.getElementById("hour2").value;
    var text = document.getElementById("text").value;
    xhr.abort();
    xhr.open("GET","classes/Functions.php?update="+missionNumber+"&customer="+customer+"&date="+date+"&hour1="+hour1+"&hour2="+hour2+"&text="+text ,true);
    xhr.onreadystatechange=function()
    {
        if(xhr.readyState==4 && xhr.status==200)
        {
            window.location.assign("http://www.danielgontar.com/web_portfolio/briefProjectNew/main.php");
        }
    };
    xhr.send(null);
}
function finalupdate()
{
    var customer = document.getElementById("cust").value;
    var date = document.getElementById("date").value;
    var hour1 = document.getElementById("hour1").value;
    var hour2 = document.getElementById("hour2").value;
    var text = document.getElementById("text").value;
    var pattHour = new RegExp("[0-9]{2}[:]{1}[0-9]{2}[:]{1}[0-9]{2}");
    var pattDate = new RegExp("[0-9]{4}[-]{1}[0-9]{2}[-]{1}[0-9]{2}");
    if (pattDate.test(date) && pattHour.test(hour1) && pattHour.test(hour2))
    {
        xhr.abort();
        xhr.open("GET","classes/Functions.php?finalUpdate="+1+"&customer="+customer+"&date="+date+"&hour1="+hour1+"&hour2="+hour2+"&text="+text ,true);
        xhr.onreadystatechange=function()
        {
            if(xhr.readyState==4 && xhr.status==200)
            {
                alert(xhr.response);
                window.location.assign("http://www.danielgontar.com/web_portfolio/briefProjectNew/main.php");
            }
        };
        xhr.send(null);
    }
    else
    {
        alert ("Please type correct date pattern: yyyy-mm-dd and correct hour pattern: hh:mm:ss in all relevant fields");
    }
}
function newMission()
{
    xhr.abort();
    xhr.open("GET","classes/Functions.php?newBrief="+1);
    xhr.onreadystatechange=function()
    {
        if(xhr.readyState==4 && xhr.status==200)
        {
            window.location.assign("http://www.danielgontar.com/web_portfolio/briefProjectNew/main.php");
        }
    };
    xhr.send(null);
}
function exit()
{
    xhr.abort();
    xhr.open("GET","classes/Functions.php?exit="+1);
    xhr.onreadystatechange=function()
    {
        if(xhr.readyState==4 && xhr.status==200)
        {
            window.location.assign("http://www.danielgontar.com/web_portfolio/briefProjectNew/");
        }
    };
    xhr.send(null);
}
function addRow()
{
    var customer = document.getElementById("cust").value;
    var date = document.getElementById("date").value;
    var hour1 = document.getElementById("hour1").value;
    var hour2 = document.getElementById("hour2").value;
    var text = document.getElementById("text").value;
    var pattHour = new RegExp("[0-9]{2}[:]{1}[0-9]{2}[:]{1}[0-9]{2}");
    var pattDate = new RegExp("[0-9]{4}[-]{1}[0-9]{2}[-]{1}[0-9]{2}");
    if (pattDate.test(date) && pattHour.test(hour1) && pattHour.test(hour2))
    {
        xhr.abort();
        xhr.open("GET","classes/Functions.php?add="+1+"&customer="+customer+"&date="+date+"&hour1="+hour1+"&hour2="+hour2+"&text="+text);
        xhr.onreadystatechange=function()
        {
            if(xhr.readyState==4 && xhr.status==200)
            {
                alert(xhr.response);
                window.location.assign("http://www.danielgontar.com/web_portfolio/briefProjectNew/main.php");
            }
        };
        xhr.send(null);
    }
    else
    {
        alert ("Please type correct date pattern: yyyy-mm-dd and correct hour pattern: hh:mm:ss in all relevant fields");
    }
}
function getBriefsDateInputPage()
{
    xhr.abort();
    xhr.open("GET","classes/Functions.php?specificDate="+1);
    xhr.onreadystatechange = function()
    {
        if(xhr.readyState==4 && xhr.status==200)
        {
            window.location.assign("http://www.danielgontar.com/web_portfolio/briefProjectNew/main.php");
        }
    };
    xhr.send(null);
}
function goToDate()
{
    var specificDate = document.getElementById("date").value;
    var pattDate = new RegExp("[0-9]{4}[-]{1}[0-9]{2}[-]{1}[0-9]{2}");
    if (pattDate.test(specificDate))
    {
        xhr.abort();
        xhr.open("GET","classes/Functions.php?goToDate="+1+"&specificDate="+specificDate);
        xhr.onreadystatechange = function()
        {
            if(xhr.readyState==4 && xhr.status==200)
            {
                window.location.assign("http://www.danielgontar.com/web_portfolio/briefProjectNew/main.php");
            }
        };
        xhr.send(null);
    }
    else
    {
        alert ("Please type correct date pattern: yyyy-mm-dd relevant field");
    }
}
function autocomp(custname)
{
    xhr.abort();
    xhr.open("GET","classes/Functions.php?custname="+custname);
    xhr.onreadystatechange = function()
    {
        if(xhr.readyState==4 && xhr.status==200)
        {
            document.getElementById('cust').value = xhr.response;
        }
    };
    xhr.send(null);
}
function sendComment()
{
    xhr.abort();
    xhr.open("GET","classes/Functions.php?comment="+1);
    xhr.onreadystatechange = function()
    {
        if(xhr.readyState==4 && xhr.status==200)
        {
            window.location.assign("http://www.danielgontar.com/web_portfolio/briefProjectNew/main.php");
        }
    };
    xhr.send(null);
}
function sendCommentSubmit()
{
    var commentText = document.getElementById('text').value;
    xhr.abort();
    xhr.open("GET","classes/Functions.php?commentSubmit="+commentText);
    xhr.onreadystatechange = function()
    {
        if(xhr.readyState==4 && xhr.status==200)
        {
            alert (xhr.response);
            window.location.assign("http://www.danielgontar.com/web_portfolio/briefProjectNew/main.php");
        }
    };
    xhr.send(null);
}
function nextPieCharts()
{
    xhr.abort();
    xhr.open("GET","classes/Functions.php?nextPieCharts="+1);
    xhr.onreadystatechange = function()
    {
        if(xhr.readyState==4 && xhr.status==200)
        {
            if (xhr.response!='')
            {
                alert(xhr.response);
            }
            window.location.assign("http://www.danielgontar.com/web_portfolio/briefProjectNew/main.php");
        }
    };
    xhr.send(null);
}
function prevPieCharts()
{
    xhr.abort();
    xhr.open("GET","classes/Functions.php?nextPieCharts="+2);
    xhr.onreadystatechange = function()
    {
        if(xhr.readyState==4 && xhr.status==200)
        {
            if (xhr.response!='')
            {
                alert(xhr.response);
            }
            window.location.assign("http://www.danielgontar.com/web_portfolio/briefProjectNew/main.php");
        }
    };
    xhr.send(null);
}
function checkTasks()
{
    xhr.abort();
    xhr.open("GET","classes/Functions.php?checkTasks="+1);
    xhr.onreadystatechange = function()
    {
        if(xhr.readyState==4 && xhr.status==200)
        {
            window.location.assign("http://www.danielgontar.com/web_portfolio/briefProjectNew/main.php");
        }
    };
    xhr.send(null);
}
