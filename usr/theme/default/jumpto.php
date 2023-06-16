<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        jumping...<?php echo $WEB_INFO['webtitle']; ?>
    </title>
    <link rel="shortcut icon" href="/favicon.ico">
    <style>
        h1 {
            text-align: center;
            font-size: 500%;
            color: white;
            margin: 10%;
        }

        h4,
        h5 {
            text-align: center;
            color: white;
        }
    </style>
</head>

<body style="background-color: <?php echo $THEME_SET['mainColor'] ?>;">
    <h1 id="timer">5</h1>
    <h5 id="tips"></h5>
    <h4 style="text-decoration: none;"><?php echo APP_COPYRIGHT ?></h4>
    <script type="text/javascript">
        let maxTime = 5;
        setInterval(() => {
            maxTime -= 1;
            document.getElementById("timer").innerHTML = maxTime;
            maxTime == 1 ? self.location.href = "<?php echo $DATA['url'] ?>" : null;
            maxTime < -3 ? document.getElementById('tips').innerHTML = "???尼咋还没走啊w(ﾟДﾟ)w?陌生人" : null;
        }, 1000)
    </script>
</body>

</html>