<?php
if ($_POST['msg'] != null) {
    include('./api/index.php');
    header('content-type:text/html');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HSED Query</title>
    <link rel="stylesheet" type="text/css" href="css/default.css" />
    <script>
        function check(form) {
            if (form.q.value == "") {
                alert("Not null");
                form.q.focus();
                return false;
            }
        }
    </script>
</head>

<body id="container">
    <div id="header">
        <h1>HSocial Engineering Data</h1>
    </div>
    <br/><br/>
        
    <form name="from" action="/api/sed" method="post">
        <div id="content">
            <div id="create_form">
                <label>Please input Keyword:
                    <input autocomplete="off" class="inurl" size="100" id="msg" name="msg" value="<?php echo !empty($_POST['msg']) ? $_POST['msg'] : ''; ?>" /></label>
                <p class="ali">
                    <label for="alias">Key Words:</label>
                    <span>User,Email,QQ Account,Forum Account...</span>
                </p>
                <p class="but">
                    <input onClick="check(form)" type="submit" value="Search" class="submit" />
                </p>
            </div>
        </div>
    </form>

    <?php
    if (isset($sedData)) {
        echo "Get {$sedData['count']} results,&nbsp;&nbsp;cost " . substr($sedData['takeTime'], 0, 4) . " seconds";
        if (!empty($sedData['data']) && $sedData['code'] == 500) {
            echo '<ul>';
            foreach ($sedData['data'] as $key => $val) {
                echo "<li>From_[{$key}]_Datas <br />Content: {$val}</li><br />";
            }
            echo '<br /><br /><font color=#ffff00><li>Resources from the Internet.<br />The information here does not represent the views of this site.</li></font>';
            echo '</ul>';
        } else {
            echo '<hr align="center" width="550" color="#2F2F2F" size="1"><font color="#ff0000">We cannot guarantee the entirely accurate,please voluntarily judge.';
            echo '<br />The data is not complete? Do you want to add or remove it?';
            echo '<br />Contact Email:</font>';
            echo '</ul>';
        }
    }
    ?>

    <div id="nav">
        <ul>
            <li class="current"><a href="#">Search Data</a></li>
            <li><a href="" target="_blank">Abouts</a></li>
        </ul>
    </div>

    <div id="footer">
        <p>HSocial Engineering Data &copy;2010-2029 Powered By<a href="#" target="_blank">HSED<a></p>
    </div>
</body>

</html>