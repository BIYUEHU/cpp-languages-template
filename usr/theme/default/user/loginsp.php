<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo 'Login 后台登录' . ' - ' . $WEB_INFO['webtitle'] ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
            /* background: #23242a; */
            background: #ecedf0 url("https://pic.imgdb.cn/item/63c3bdcdbe43e0d30e7d2e90.webp") fixed;
            background-repeat: no-repeat;
            background-size: 100% 100%;
            backdrop-filter: blur(2px)
        }

        .box {
            position: relative;
            width: 380px;
            height: 435px;
            background: #1c1c1c;
            opacity: 0.8;
            border-radius: 8px;
            overflow: hidden;
        }

        .box::before {
            content: '';
            z-index: 1;
            position: absolute;
            top: -50%;
            left: -50%;
            width: 380px;
            height: 420px;
            transform-origin: bottom right;
            background: linear-gradient(0deg, transparent, #45f3ff, #45f3ff);
            animation: animate 6s linear infinite;
        }

        .box::after {
            content: '';
            z-index: 1;
            position: absolute;
            top: -50%;
            left: -50%;
            width: 380px;
            height: 420px;
            transform-origin: bottom right;
            background: linear-gradient(0deg, transparent, #45f3ff, #45f3ff);
            animation: animate 6s linear infinite;
            animation-delay: -3s;
        }

        @keyframes animate {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        form {
            position: absolute;
            inset: 2px;
            background: #28292d;
            padding: 50px 40px;
            border-radius: 8px;
            z-index: 2;
            display: flex;
            flex-direction: column;
        }

        h2 {
            color: #45f3ff;
            font-weight: 500;
            text-align: center;
            letter-spacing: 0.1em;
        }

        .inputBox {
            position: relative;
            width: 300px;
            margin-top: 35px;
        }

        .inputBox input {
            position: relative;
            width: 100%;
            padding: 20px 10px 10px;
            background: transparent;
            outline: none;
            box-shadow: none;
            border: none;
            color: #23242a;
            font-size: 1em;
            letter-spacing: 0.05em;
            transition: 0.5s;
            z-index: 10;
        }

        .inputBox span {
            position: absolute;
            left: 0;
            padding: 20px 0px 10px;
            pointer-events: none;
            font-size: 1em;
            color: #8f8f8f;
            letter-spacing: 0.05em;
            transition: 0.5s;
        }

        .inputBox input:valid~span,
        .inputBox input:focus~span {
            color: #45f3ff;
            transform: translateX(0px) translateY(-34px);
            font-size: 0.75em;
        }

        .inputBox i {
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 2px;
            background: #45f3ff;
            border-radius: 4px;
            overflow: hidden;
            transition: 0.5s;
            pointer-events: none;
            z-index: 9;
        }

        .inputBox input:valid~i,
        .inputBox input:focus~i {
            height: 44px;
        }

        .links {
            display: flex;
            justify-content: space-between;
        }

        .links a {
            margin: 10px 0;
            font-size: 0.75em;
            color: #8f8f8f;
            text-decoration: beige;
        }

        .links a:hover,
        .links a:nth-child(2) {
            color: #45f3ff;
        }

        input[type="submit"],button {
            border: none;
            outline: none;
            padding: 11px 25px;
            background: #45f3ff;
            cursor: pointer;
            border-radius: 4px;
            font-weight: 600;
            width: 100px;
            margin-top: 10px;
        }

        input[type="submit"],button:active {
            opacity: 0.8;
        }
    </style>
</head>

<body>
    <div class="box">
        <form class="layui-form">
            <h2>HULI Core</h2>
            <div class="inputBox">
                <input type="text" id="account" required autocomplete="off">
                <span>Account</span>
                <i></i>
            </div>
            <div class="inputBox">
                <input type="password" id="password" required autocomplete="off">
                <span>Password</span>
                <i></i>
            </div>
            <div class="inputBox">
                <div style="position: relative;">
                    <input type="text" style="width: 150px;" id="captchaimg" type="text" required autocomplete="off">
                    <span>Code</span>
                    <i></i>
                </div>
                <img id="captchaimgImg" style="cursor:pointer;position: absolute;top: 3px;right: 0px;" src="/sys/captchaimg" onclick="javascript:this.src='/sys/captchaimg'" align="absmiddle">
            </div>
            <div class="links">
                <a href="#">Forget passwd ?</a>
                <a href="./loginde">Register</a>
            </div>
            <button type="submit" onclick="doLogin()">Login</button>
        </form>
    </div>
    <script src="//cdn.staticfile.org/jquery/3.7.0/jquery.min.js"></script>
    <script src="//cdn.staticfile.org/layui/2.8.7/layui.js"></script>
    <script src="<? echo $CONFIG['path'] ?>/js/user/index.js"></script>
</body>

</html>