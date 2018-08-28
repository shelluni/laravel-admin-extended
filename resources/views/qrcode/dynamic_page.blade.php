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
    <style type="text/css">
        /* Global style */
        body{
            background-color: #fff;
            font:20px/1.3 'Arial','Microsoft YaHei';
            color: #212832;
            padding: 0;
            margin:0;
        }
        img {
            width: 100%;
            border:0;
            display: block;
        }
        .clearfix:before,
        .clearfix:after{
            content: " ";
            display: table;
        }
        .clearfix:after {
            clear: both;
        }
        .k-header{
            background-color: #383d43;
            height: 68px;
            line-height: 68px;
            color: #fff;
            font-size: 24px;
            padding:0 30px;
        }
        .k-header button{
            float: right;
            border:0;
            font-size: 18px;
            line-height: 36px;
            padding:0 20px;
            margin-left:30px;
            margin-top: 15px;
        }
        .k-project-name{
            font-size: 30px;
            text-align: center;
            margin:25px;
        }
        .k-project-name span{
            margin-left: 30px;
        }
        .k-main{
            padding:0 15% 30px;
        }
        .k-main-left{
            float: left;
            width: 44%;
            min-width: 400px;
        }
        .k-main-right{
            float: right;
            width: 53%;
        }
        .k-main-up{
            background-color: #4484f7;
            color: #fff;
            font-size: 36px;
            line-height: 70px;
            text-align: center;
            font-style: italic;
            margin-bottom: 10px;
        }
        .k-main-erweima{
            padding:10px;
            border:1px dashed #4484f7;
        }
        .k-main-erweimats{
            font-size: 24px;
            margin-top: 20px;
            text-align: center;
        }
        .k-main-erweimats span{
            color: #4484f7;
        }
        .k-main-r-ts{
            color: #5d646e;
            font-size: 16px;
            margin-top: 20px;
        }
        .k-main-r-ts span{
            font-size: 18px;
            color: #212832;
            float: right;
        }
        @media screen and (max-height: 719px) {
            .k-main{
                padding:0 5% 30px;
            }
        }
        @media screen and (max-width: 1024px) {
            .k-main{
                padding:0 5% 30px;
            }
        }
        @media screen and (max-width: 960px) {
            .k-main{
                padding:0 8% 0;
            }
            .k-main-left{
                min-width: auto;
                max-width: 340px;
            }
            .k-main-right{
                min-width: auto;
                max-width: 440px;
            }
            .k-header{
                height:48px;
                line-height:48px;
                font-size: 18px;
                padding:0 10px;
            }
            .k-header button{
                margin-top:5px;
            }
            .k-main-up {
                font-size: 26px;
                line-height: 50px;
            }
        }
    </style>
</head>
<body>
<!-- 头部 -->
<div class="k-header clearfix">
    北京市中医管理局 — {{ date("Y") }}年北京市级中医药继续教育项目
    <button class="btn btn-primary" id="down_btn">下课签到</button>
    <button class="btn btn-primary" id="up_btn">上课签到</button>
</div>

<!-- 项目名称 -->
<h3 class="k-project-name" id="tips"></h3>

<div class="k-main clearfix">
    <div class="k-main-left">
        <div class="k-main-up" id="qrcode_tips"></div>
        <div class="k-main-erweima" id="qrcode_area" style="display: none"><img id="qrcode" up-data-src='{{ admin_url("/project/{$project->id}/stage/{$stage->id}/qrcode/dynamic/sign_in") }}' down-data-src='{{ admin_url("/project/{$project->id}/stage/{$stage->id}/qrcode/dynamic/sign_out") }}'/></div>
        <div class="k-main-erweimats">微信扫码，<span>完善信息拿学分</span></div>
    </div>
    <div class="k-main-right">
        <div><img src="/image/explain.jpg" alt=""></div>
        <div class="clearfix k-main-r-ts"><span>主办单位：{{$project->host->name}}</span>客服电话：84212015</div>
    </div>
</div>
</body>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="/js/jquery-3.2.1.slim.min.js"></script>
<script src="/js/popper.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script>
    $(function () {
        var imgIns;
        var tips = "{{$project->name}} - 第{{$stage->sort}}期";

        $("#up_btn").click(function () {
            clearInterval(imgIns);
            refreshUpImage();
            imgIns = setInterval('refreshUpImage()',6000);
            $("#tips").text(tips);
            $("#qrcode_tips").text('上课签到二维码');
            $('#qrcode_area').show();
        });

        $("#down_btn").click(function () {
            clearInterval(imgIns);
            refreshDownImage();
            imgIns = setInterval('refreshDownImage()',6000);
            $("#tips").text(tips);
            $("#qrcode_tips").text('下课签到二维码');
            $('#qrcode_area').show();
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