<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$project->name}}项目 - 第{{$stage->sort}}期二维码</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="/css/bootstrap.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="/js/html5shiv.min.js"></script>
    <script src="/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<p style="text-align: center;margin-top:20px"><input class="btn btn-primary" id="up_btn" type="button" value="展示上课签到码">&nbsp;&nbsp;&nbsp;<input id="down_btn" class="btn btn-primary" type="button" value="展示下课签到码"></p>
<h2 style="text-align: center">{{ date("Y") }}年北京市级中医药继续教育项目</h2>
<h5 style="text-align: center;margin-top: 20px" id="tips"></h5>
<p style="text-align: center"><img id="qrcode" up-data-src='{{ admin_url("/project/{$project->id}/stage/{$stage->id}/qrcode/dynamic/sign_in") }}' down-data-src='{{ admin_url("/project/{$project->id}/stage/{$stage->id}/qrcode/dynamic/sign_out") }}'/></p>

</body>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="/js/jquery-3.2.1.slim.min.js"></script>
<script src="/js/popper.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script>
    $(function () {
        var imgIns;
        var tips = "{{$project->name}} - 第{{$stage->sort}}期 - ";

        $("#up_btn").click(function () {
            clearInterval(imgIns);
            refreshUpImage();
            imgIns = setInterval('refreshUpImage()',10000);
            $("#tips").text(tips+'上课签到')
        });

        $("#down_btn").click(function () {
            clearInterval(imgIns);
            refreshDownImage();
            imgIns = setInterval('refreshDownImage()',10000);
            $("#tips").text(tips+'下课签到')
        });
    });
    
    function refreshUpImage() {
        $('#qrcode').attr('src',$('#qrcode').attr('up-data-src')+'?'+new Date().getTime());
    }

    function refreshDownImage() {
        $('#qrcode').attr('src',$('#qrcode').attr('down-data-src')+'?'+new Date().getTime());
    }
</script>
</html>