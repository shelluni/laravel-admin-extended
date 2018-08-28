<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div align="center">
    <table>
        <tbody><tr id="divHidden">
            <td colspan="8">
                <br>

                <input type="button" id="printBtn" value="打印" onclick="newPrint()" class="formButton">
            </td>
        </tr>
        </tbody></table>
</div>
<br/>
<div id="printDiv" align="center">
    <div style="width:660px" align="center">
        <div align="center" style="font-weight: bold;font-family:宋体;font-size: 20px;color:#000000 ">{{$printTitle}}</div>
        <table style="width: 660px" align="center" cellpadding="0" cellspacing="0">
            <tbody><tr>
                <td>
                    <div style="width: 660px" align="center">
                        <table style="width: 100%;"> <tbody><tr><td>统计时间：从 {{$start_at}} 到 {{$end_at}}</td><td style="text-align:right">打印日期：{{date('Y-m-d', time())}}</td></tr></tbody></table>
                        <table id="printTable" style="WIDTH: 660px;border: 1px black solid;border-collapse: collapse" bordercolor="#000000" cellspacing="0" cellpadding="0" border="1">
                            <thead id="headTable">
                                <tr>
                                    @foreach($printData['printHeaders'] as $header)
                                    <td nowrap="">
                                        &nbsp;&nbsp;{{$header}}&nbsp;&nbsp;
                                    </td>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody id="bodyTable" name="bodyTable">
                            @if(!empty($printData['printData']))
                                @foreach($printData['printData'] as $print)
                                    <tr>
                                        @foreach($print as $p)
                                            <td>
                                                {{$p}}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            @else
                                <br/>
                                <div style="color:red;font-size: 14px;">没有载入打印数据，请返回上一页重新选择打印选项，点击查询后重试！</div>
                                <br/>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

</div>
<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/PrintArea/2.4.1/jquery.PrintArea.js"></script>
<script>
    /**
    * var defaults = { mode       : modes.iframe,
                 standard   : standards.html5,
                 popHt      : 500,
                 popWd      : 400,
                 popX       : 200,
                 popY       : 200,
                 popTitle   : '',
                 popClose   : false,
                 extraCss   : '',
                 extraHead  : '',
                 retainAttr : ["id","class","style"] };
    * */
    function newPrint() {
        $('#printDiv').printArea({'popTitle' : '统计打印'});
    }
</script>
</body>
</html>
