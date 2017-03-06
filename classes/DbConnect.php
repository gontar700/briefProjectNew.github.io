<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 10/07/2016
 * Time: 16:32
 */
class DbConnect
{
    private $serverName;
    private $username;
    private $password;
    private $dbName;
    private $mysqli;
    function __construct($serverName, $username, $password , $dbName)
    {
        $this->set_server($serverName);
        $this->set_username($username);
        $this->set_password($password);
        $this->set_dbName($dbName);
        $this->set_mysqli();
    }
    function set_server($serverName)
    {
        $this->serverName = $serverName;
    }
    function set_username($username)
    {
        $this->username = $username;
    }
    function set_password($password)
    {
        $this->password = $password;
    }
    function set_dbName($dbName)
    {
        $this->dbName = $dbName;
    }
    function set_mysqli()
    {
        $this->mysqli = new mysqli($this->serverName,$this->username,$this->password,$this->dbName);
        mysqli_set_charset($this->mysqli, "utf8");
    }
    function userVerification($username, $password)
    {
        $query = "SELECT * FROM `designer` WHERE `username` = '$username'";
        if (!$this->mysqli->query($query, MYSQLI_STORE_RESULT)) // the query didn't succeeded
        {
            throw new DbConnectionException ("<br>username or password are incorrect");
        }
        else
        {
            return $this->mysqli->query($query, MYSQLI_STORE_RESULT);
        }
    }
    function getDesignerDetails($username)
    {
        $query = "SELECT * FROM `designer` WHERE `username` = '$username'";
        if (!$this->mysqli->query($query, MYSQLI_STORE_RESULT)) // the query didn't succeeded
        {
            throw new DbConnectionException ("<br>Designer details selection didn't succeed");
        }
        else
        {
            return $this->mysqli->query($query, MYSQLI_STORE_RESULT);
        }

    }
    function getBriefs($designerId,$day)
    {
        $dateTimeStamp = time() - $day*60*60*24;
        $dateToString = date ("Y-m-d",$dateTimeStamp);
        $query = "SELECT * FROM `designer` AS a JOIN `briefs` AS b 
                  WHERE a.`id` = b.`designerId` AND b.`date` ='$dateToString'
                  AND a.`id` = '$designerId'
                  ORDER BY b.`id` DESC";
        //echo $query;
        if (!$this->mysqli->query($query, MYSQLI_STORE_RESULT)) // the query didn't succeeded
        {
            throw new DbConnectionException ("<br>Brief selection didn't succeed");
        }
        else
        {
            return $this->mysqli->query($query, MYSQLI_STORE_RESULT);
        }
    }
    function getAllBriefs($day)
    {
        $dateTimeStamp = time() - $day*60*60*24;
        $dateToString = date ("Y-m-d",$dateTimeStamp);
        $query = "SELECT * FROM `designer` AS a JOIN `briefs` AS b
                  WHERE a.`id` = b.`designerId` AND b.`date` ='$dateToString'
                  ORDER BY b.`id` DESC";
        //echo $query;
        if (!$this->mysqli->query($query, MYSQLI_STORE_RESULT)) // the query didn't succeeded
        {
            throw new DbConnectionException ("<br>Brief selection didn't succeed");
        }
        else
        {
            return $this->mysqli->query($query, MYSQLI_STORE_RESULT);
        }
    }
    function getBriefsBriefId($briefId)
    {
        $query = "SELECT * FROM `briefs` 
                  WHERE `id` = $briefId";

        if (!$this->mysqli->query($query, MYSQLI_STORE_RESULT)) // the query didn't succeeded
        {
            throw new DbConnectionException ("<br>Brief details selection didn't succeed");
        }
        else
        {
            return $this->mysqli->query($query, MYSQLI_STORE_RESULT);
        }
    }
    function addNewBrief($designerId, $customer, $date, $fromHour, $tillHour, $freeText)
    {

        $query = "INSERT INTO `briefs` (`id`, `designerId`, `matnas`, `date`, `fromHour`, `tillHour`, `freeText`) 
                  VALUES (NULL , '$designerId', '$customer', '$date', '$fromHour', '$tillHour', '$freeText')";
        //echo $query;
        if (!$this->mysqli->query($query, MYSQLI_STORE_RESULT)) // the query didn't succeeded
        {
            throw new DbConnectionException ("<br>Brief addition didn't succedd");
           // echo $query;
        }
        else
        {
            return ("Brief for ".$customer." was add");
        }
    }
    function updateBrief($id, $designerId, $customer, $date, $fromHour, $tillHour, $freeText)
    {
        $query = "UPDATE `briefs`  
                  SET `id` = '$id' , `designerId` = '$designerId', `matnas`= '$customer', `date` = '$date' , `fromHour` = '$fromHour', `tillHour` = '$tillHour', `freeText`= '$freeText'
                  WHERE `id` = '$id'";

        if (!$this->mysqli->query($query, MYSQLI_STORE_RESULT)) // the query didn't succeeded
        {
            throw new DbConnectionException ("<br>Brief addition didn't succeed");
        }
        else
        {
            return ("Brief No. ".$id." was updated");
        }
    }
    function getBriefsDate($designerId, $date)
    {
        $query = "SELECT * FROM `briefs` 
                  WHERE `designerId`='$designerId' AND `date` = '$date'";
        if (!$this->mysqli->query($query, MYSQLI_STORE_RESULT)) // the query didn't succeeded
        {
           throw new DbConnectionException ("<br>Brief Selection for this date didn't succeed");
        }
        else
        {
            return ($this->mysqli->query($query, MYSQLI_STORE_RESULT));
        }
    }
    function getBriefsDateAllDesigner ($date)
    {
        $query = "SELECT * FROM `briefs` as A JOIN `designer` as B 
                  WHERE A.`designerId` = B.`id` AND 
                  `date` = '$date' ORDER BY A.`id` DESC";
        if (!$this->mysqli->query($query, MYSQLI_STORE_RESULT)) // the query didn't succeeded
        {
            // throw new DbConnectionException ("<br>Brief Selection for this date didn't succeed");
            echo $query;
        }
        else
        {
            return ($this->mysqli->query($query, MYSQLI_STORE_RESULT));
        }
    }
    function getCustomerName ($custName)
    {
        $query = "SELECT `name` FROM `customer`  
                  WHERE `name` LIKE '$custName%' LIMIT 1";
        if (!$this->mysqli->query($query, MYSQLI_STORE_RESULT)) // the query didn't succeeded
        {
            throw new DbConnectionException ("<br>Brief Selection for this date didn't succeed");
        }
        else
        {
            return ($this->mysqli->query($query, MYSQLI_STORE_RESULT));
        }
    }
    function NumberTasksMonth1($monthBeg , $monthEnd)
    {
        $query = "SELECT COUNT(*) FROM `briefs`
                  WHERE `designerId`=1 AND (`date` > '$monthBeg' OR `date` = '$monthBeg') AND (`date` < '$monthEnd' OR `date` = '$monthEnd')";

        if (!$this->mysqli->query($query, MYSQLI_STORE_RESULT)) // the query didn't succeeded
        {
            throw new DbConnectionException ("<br>Brief Selection for this date didn't succeed");

        }
        else
        {
             return $this->mysqli->query($query, MYSQLI_STORE_RESULT);
        }
    }
    function NumberTasksMonth2($monthBeg , $monthEnd)
    {
        $query = "SELECT COUNT(*) FROM `briefs`
                  WHERE `designerId`=2 AND (`date` > '$monthBeg' OR `date` = '$monthBeg') AND (`date` < '$monthEnd' OR `date` = '$monthEnd')";
        if (!$this->mysqli->query($query, MYSQLI_STORE_RESULT)) // the query didn't succeeded
        {
            throw new DbConnectionException ("<br>Brief Selection for this date didn't succeed");
        }
        else
        {
            return ($this->mysqli->query($query, MYSQLI_STORE_RESULT));
        }
    }
    function NumberTasksMonth3($monthBeg , $monthEnd)
    {
        $query = "SELECT COUNT(*) FROM `briefs`
                  WHERE `designerId`=3 AND (`date` > '$monthBeg' OR `date` = '$monthBeg') AND (`date` < '$monthEnd' OR `date` = '$monthEnd')";
        if (!$this->mysqli->query($query, MYSQLI_STORE_RESULT)) // the query didn't succeeded
        {
            throw new DbConnectionException ("<br>Brief Selection for this date didn't succeed");
        }
        else
        {
            return ($this->mysqli->query($query, MYSQLI_STORE_RESULT));
        }
    }
    function totalHourAmount1($monthBeg , $monthEnd)
    {
        $query = "SELECT SUM(`tillHour`-`fromHour`)/10000 FROM `briefs`
                  WHERE designerId=1 AND (`date` > '$monthBeg' OR `date` = '$monthBeg') AND (`date` < '$monthEnd' OR `date` = '$monthEnd')";
        if (!$this->mysqli->query($query, MYSQLI_STORE_RESULT)) // the query didn't succeeded
        {
            throw new DbConnectionException ("<br>Total working hours calculation didn't succeed");
        }
        else
        {
            return ($this->mysqli->query($query, MYSQLI_STORE_RESULT));
        }
    }
    function totalHourAmount2($monthBeg , $monthEnd)
    {
        $query = "SELECT SUM(`tillHour`-`fromHour`)/10000 FROM `briefs`
                  WHERE designerId=2 AND (`date` > '$monthBeg' OR `date` = '$monthBeg') AND (`date` < '$monthEnd' OR `date` = '$monthEnd')";
        if (!$this->mysqli->query($query, MYSQLI_STORE_RESULT)) // the query didn't succeeded
        {
            throw new DbConnectionException ("<br>Total working hours calculation didn't succeed");
        }
        else
        {
            return ($this->mysqli->query($query, MYSQLI_STORE_RESULT));
        }
    }
    function totalHourAmount3($monthBeg , $monthEnd)
    {
        $query = "SELECT SUM(`tillHour`-`fromHour`)/10000 FROM `briefs`
                  WHERE designerId=3 AND (`date` > '$monthBeg' OR `date` = '$monthBeg') AND (`date` < '$monthEnd' OR `date` = '$monthEnd')";
        if (!$this->mysqli->query($query, MYSQLI_STORE_RESULT)) // the query didn't succeeded
        {
            throw new DbConnectionException ("<br>Total working hours calculation didn't succeed");
        }
        else
        {
            return ($this->mysqli->query($query, MYSQLI_STORE_RESULT));
        }
    }
    function taskAmountEilat($monthBeg, $monthEnd)
    {
        $query = "SELECT DISTINCT COUNT(*) FROM `briefs` AS a JOIN `customer` AS b
                  WHERE a.`matnas` = b.`name`
                  AND b.`id`=6
                  AND (`date` > '$monthBeg' OR `date` = '$monthBeg') AND (`date` < '$monthEnd' OR `date` = '$monthEnd')";

        if (!$this->mysqli->query($query, MYSQLI_STORE_RESULT)) // the query didn't succeeded
        {
            throw new DbConnectionException ("<br>Total tasks Eilat calculation didn't succeed");
        }
        else
        {
            return ($this->mysqli->query($query, MYSQLI_STORE_RESULT));
        }
    }
    function taskAmountBS($monthBeg, $monthEnd)
    {
        $query = "SELECT COUNT(*) FROM `briefs` AS a JOIN `customer` AS b
                  WHERE a.`matnas` = b.`name`
                  AND b.`id`=1
                  AND (`date` > '$monthBeg' OR `date` = '$monthBeg') AND (`date` < '$monthEnd' OR `date` = '$monthEnd')";

        if (!$this->mysqli->query($query, MYSQLI_STORE_RESULT)) // the query didn't succeeded
        {
            throw new DbConnectionException ("<br>Total tasks Bet-Shemesh calculation didn't succeed");
        }
        else
        {
            return ($this->mysqli->query($query, MYSQLI_STORE_RESULT));
        }
    }
    function taskAmountME($monthBeg, $monthEnd)
    {
        $query = "SELECT COUNT(*) FROM `briefs` AS a JOIN `customer` AS b
                  WHERE a.`matnas` = b.`name`
                  AND b.`id`=7
                  AND (`date` > '$monthBeg' OR `date` = '$monthBeg') AND (`date` < '$monthEnd' OR `date` = '$monthEnd')";

        if (!$this->mysqli->query($query, MYSQLI_STORE_RESULT)) // the query didn't succeeded
        {
            throw new DbConnectionException ("<br>Total tasks Maale Edomim calculation didn't succeed");
        }
        else
        {
            return ($this->mysqli->query($query, MYSQLI_STORE_RESULT));
        }
    }
    function taskAmountKA($monthBeg, $monthEnd)
    {
        $query = "SELECT COUNT(*) FROM `briefs` AS a JOIN `customer` AS b
                  WHERE a.`matnas` = b.`name`
                  AND b.`id`=5
                  AND (`date` > '$monthBeg' OR `date` = '$monthBeg') AND (`date` < '$monthEnd' OR `date` = '$monthEnd')";

        if (!$this->mysqli->query($query, MYSQLI_STORE_RESULT)) // the query didn't succeeded
        {
            throw new DbConnectionException ("<br>Total tasks Kiriat-Ata calculation didn't succeed");
        }
        else
        {
            return ($this->mysqli->query($query, MYSQLI_STORE_RESULT));
        }
    }
    function taskAmountHolon($monthBeg, $monthEnd)
    {
        $query = "SELECT COUNT(*) FROM `briefs` AS a JOIN `customer` AS b
                  WHERE a.`matnas` = b.`name`
                  AND b.`id`=3
                  AND (`date` > '$monthBeg' OR `date` = '$monthBeg') AND (`date` < '$monthEnd' OR `date` = '$monthEnd')";

        if (!$this->mysqli->query($query, MYSQLI_STORE_RESULT)) // the query didn't succeeded
        {
            throw new DbConnectionException ("<br>Total tasks Holon calculation didn't succeed");
        }
        else
        {
            return ($this->mysqli->query($query, MYSQLI_STORE_RESULT));
        }
    }
    function taskAmountRehovot($monthBeg, $monthEnd)
    {
        $query = "SELECT COUNT(*) FROM `briefs` AS a JOIN `customer` AS b
                  WHERE a.`matnas` = b.`name`
                  AND b.`id`=12
                  AND (`date` > '$monthBeg' OR `date` = '$monthBeg') AND (`date` < '$monthEnd' OR `date` = '$monthEnd')";

        if (!$this->mysqli->query($query, MYSQLI_STORE_RESULT)) // the query didn't succeeded
        {
            throw new DbConnectionException ("<br>Total tasks Rehovot calculation didn't succeed");
        }
        else
        {
            return ($this->mysqli->query($query, MYSQLI_STORE_RESULT));
        }
    }
    function sendCommentSubmit($text,$designerId)
    {
        $query = "INSERT INTO `comments` (`text`,`designerId`)
                  VALUES ('$text' , '$designerId')";
        if (!$this->mysqli->query($query, MYSQLI_STORE_RESULT)) // the query didn't succeeded
        {
            throw new DbConnectionException ("<br>Comment was not submited");
        }
        else
        {
            return ("Comment was submited successfully");
        }
    }
    function selectComments()
    {
        $query = "SELECT a.`text` , b.`name` FROM `comments` AS a JOIN `designer` AS b
                  WHERE a.`designerId` = b.`id`
                  ORDER BY a.`id` DESC LIMIT 10";
        if (!$this->mysqli->query($query, MYSQLI_STORE_RESULT)) // the query didn't succeeded
        {
            throw new DbConnectionException ("<br>Could not select comments");
        }
        else
        {
            return ($this->mysqli->query($query, MYSQLI_STORE_RESULT));
        }
    }
    function getBriefSlim($id)
    {
        $query = "SELECT * FROM `briefs`
                  WHERE `id` = $id ";
        if (!$this->mysqli->query($query, MYSQLI_STORE_RESULT)) // the query didn't succeeded
        {
            throw new DbConnectionException ("<br>Brief selection didn't succeed");
        }
        else
        {
            return $this->mysqli->query($query, MYSQLI_STORE_RESULT);
        }
    }
    function getBriefSlims($id1 , $id2)
    {
        $query = "SELECT * FROM `briefs`
                  WHERE (`id`> $id1 || `id` = $id1) && (`id`< $id2 || `id` = $id2)";
        if (!$this->mysqli->query($query, MYSQLI_STORE_RESULT)) // the query didn't succeeded
        {
            throw new DbConnectionException ("<br>Brief selection didn't succeed");
        }
        else
        {
            return $this->mysqli->query($query, MYSQLI_STORE_RESULT);
        }
    }
    function deleteBriefSlim($id1,$id2)
    {
        $query1 = "SELECT * FROM `briefs`
                   WHERE (`id`>$id1 || `id`=$id1) && (`id`<$id2 || `id`=$id2)";
        $query2 = "DELETE FROM `briefs`
                   WHERE (`id`>$id1 || `id`=$id1) && (`id`<$id2 || `id`=$id2)";
        if (!$this->mysqli->query($query1)->num_rows == 0) // the query didn't succeeded
        {
            $this->mysqli->query($query2 ,  MYSQLI_STORE_RESULT);
            return 'Briefs deleted succefully.';
        }
        else {
            return 'These brief numbers do not exist.';
        }
    }
    function updateBriefSlim($id, $designerId, $customer, $date, $fromHour, $tillHour, $freeText)
    {
        $query1 = "SELECT * FROM `briefs`
                   WHERE (`id`=$id)";
        $query2 = "UPDATE `briefs`
                  SET `id` = '$id' , `designerId` = '$designerId', `matnas`= '$customer', `date` = '$date' , `fromHour` = '$fromHour', `tillHour` = '$tillHour', `freeText`= '$freeText'
                  WHERE `id` = '$id'";

        if (!$this->mysqli->query($query1)->num_rows == 0) // the query didn't succeeded
        {
            $this->mysqli->query($query2 ,  MYSQLI_STORE_RESULT);
            return ("Brief No. ".$id." was updated");
        }
        else
        {
            return ("This brief number does not exist.");
        }
    }
}
?>

