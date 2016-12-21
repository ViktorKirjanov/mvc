<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paxful MVC test</title>

    <!-- Bootstrap -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/bootstrap-select.js"></script>

    <link rel="stylesheet" type="text/css" href="/assets/css//bootstrap-select.min.css">

    <link rel="stylesheet/less" type="text/css" href="/assets/css/style.less">
    <script src="/assets/js/less.min.js"></script>

    <script src="/assets/js/script.js"></script>
</head>
<body>


<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">PAXFUL MVC TEST</a>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="/">Home</a></li>
                <?php if (Session::get("loggedIn")) { ?>
                    <li><a href="/dashboard">Dashboard</a></li>
                <?php } ?>
            </ul>


            <?php if (!Session::get("loggedIn")) { ?>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/user/login">Login</a></li>
                    <li><a href="/user/signup">Signup</a></li>
                </ul>
            <?php } else { ?>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/">Hello, <?php echo(Session::get('full_name')); ?> !!!</a></li>
                    <?php if(isset($this->wallet)){?>
                    <li>
                        <div id="wallet">
                            <?php echo (float)$this->wallet; ?>
                            <span class="glyphicon glyphicon-btc"></span>
                        </div>
                    </li>
                    <?php } ?>
                    <li><a href="/user/logout">Logout</a></li>
                </ul>
            <?php } ?>
        </div>
    </div>
</nav>


