

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>申报学术活动报表</title>
		

<style media="print">
    @page {
        size: auto;
        margin: 0mm;
    }
    </style>
	<script type="text/javascript">
		var HKEY_Root, HKEY_Path, HKEY_Key;
		HKEY_Root = "HKEY_CURRENT_USER";
		HKEY_Path = "\\Software\\Microsoft\\Internet Explorer\\PageSetup\\";
		//设置网页打印的页眉页脚为空
		function PageSetup_Null() {
			if (!!window.ActiveXObject || "ActiveXObject" in window) {
				try {
					var Wsh = new ActiveXObject("WScript.Shell");
					HKEY_Key = "header";
					Wsh.RegWrite(HKEY_Root + HKEY_Path + HKEY_Key, "");
					HKEY_Key = "footer";
					Wsh.RegWrite(HKEY_Root + HKEY_Path + HKEY_Key, "");
					HKEY_Key = "margin_bottom";
					Wsh.RegWrite(HKEY_Root + HKEY_Path + HKEY_Key, "0.750000");
					HKEY_Key = "margin_top";
					Wsh.RegWrite(HKEY_Root + HKEY_Path + HKEY_Key, "0.750000");
					HKEY_Key = "margin_left";
					Wsh.RegWrite(HKEY_Root + HKEY_Path + HKEY_Key, "0.750000");
					HKEY_Key = "margin_right";
					Wsh.RegWrite(HKEY_Root + HKEY_Path + HKEY_Key, "0.750000");
					HKEY_Key = "Shrink_To_Fit";
					Wsh.RegWrite(HKEY_Root + HKEY_Path + HKEY_Key, "yes");
				} catch (e) {
					alert(e);
				}
			}
		}
		function doPrint() {
			PageSetup_Null();
			window.print(); //直接打印
		}
		window.onload = function() {
			var logicalYDPI = screen.logicalYDPI;
			if (logicalYDPI == undefined) {
				logicalYDPI = 96;
			}
			var pxMM = 25.4 / logicalYDPI;
			var a4Height = 258;
			var a4Height1 = 258;
			var buttonDiv = document.getElementById("buttonDiv");
			var nowOffsetTop = 0;
			var nowOffsetTop1 = 0;

			var tableObj = document.getElementById("teachers");
			var trs = tableObj.rows;
			for ( var i = 0; trs && i < trs.length; i++) {
				var trObj = trs[i];
				var nowObjBottom = nowOffsetTop
						+ ((trObj.clientHeight + 1) * pxMM);
				if (nowObjBottom >= a4Height) {
					trObj.style.pageBreakBefore = "always";
					nowOffsetTop = 0;
				}
				nowOffsetTop += ((trObj.clientHeight + 1) * pxMM);
			}
			var rowNum = Math.floor((a4Height - nowOffsetTop) / (20 + pxMM));
			while (rowNum > 0) {
				rowObj = tableObj.insertRow(tableObj.rows.length);
				rowObj.style.height = "15mm";
				rowObj.insertCell(rowObj.cells.length);
				rowObj.insertCell(rowObj.cells.length);
				rowObj.insertCell(rowObj.cells.length);
				rowObj.insertCell(rowObj.cells.length);
				rowObj.insertCell(rowObj.cells.length);
				rowObj.insertCell(rowObj.cells.length);
				rowObj.insertCell(rowObj.cells.length);
				rowNum--;
			}
			tableObj.rows[0].cells[0].rowSpan = tableObj.rows.length;

			var tableObj1 = document.getElementById("recentProjects");
			var trs1 = tableObj1.rows;
			for ( var i = 0; trs1 && i < trs1.length; i++) {
				var trObj1 = trs1[i];
				var nowObjBottom1 = nowOffsetTop1
						+ ((trObj1.clientHeight + 1) * pxMM);
				if (nowObjBottom1 >= a4Height1) {
					trObj1.style.pageBreakBefore = "always";
					nowOffsetTop1 = 0;
				}
				nowOffsetTop1 += ((trObj1.clientHeight + 1) * pxMM);
			}
			var rowNum1 = Math.floor((a4Height1 - nowOffsetTop1) / (30 + pxMM));
			while (rowNum1 > 0) {
				rowObj1 = tableObj1.insertRow(tableObj1.rows.length);
				rowObj1.style.height = "15mm";
				rowObj1.insertCell(rowObj1.cells.length);
				rowObj1.insertCell(rowObj1.cells.length);
				rowObj1.insertCell(rowObj1.cells.length);
				rowObj1.insertCell(rowObj1.cells.length);
				rowObj1.insertCell(rowObj1.cells.length);
				rowObj1.insertCell(rowObj1.cells.length);
				rowNum1--;
			}
			tableObj1.rows[0].cells[0].rowSpan = tableObj1.rows.length;
		};
	</script>


		<style>
			@media print {
				#buttonDiv {
					display: none;
				}
				table {width:95%;font-size:8pt;}
				.context {width:95%;font-size:8pt;}
				.title {width:95%;font-size:8pt;}
			}
			.w3cbbs {
				page-break-after: always;
			}
			#buttonDiv {text-align:center;}
			body {text-align:center;font-size:9pt;}
			table {border-collapse:collapse;border:0;width:950px;border-spacing:0;text-align:center;margin:auto;table-layout:fixed;}
			.context td {border:1px #000080 solid;text-align:center;height:22px;word-break:break-all;}
			.context thead td {background-color:#E6ECFF;}
			.context tbody td {background-color:#ECF5E4;}
			.title td {border:0;}
		</style>
	</head>
	<body>
		<object id=WebBrowser classid=CLSID:8856F961-340A-11D0-A96B-00C04FD705A2 width=0 height=0></object>
		<div id="buttonDiv">
		<button id="printButton" onclick="javascript:doPrint();" type="button">打印</button>
	</div>
		<table class="title">
		{{--<tr>--}}
		    {{--<td style="font-size:14pt;">测试科室11</td>--}}
		{{--</tr>--}}
		<tr>
		    <td style="font-size:18pt;">申报学术活动报表</td>
		</tr>
		</table>
		<table class="context">
		  <thead>
		  <tr>
		    <td style="width:9%;">申请代码</td>
		    <td style="width:20%;">学术活动名称</td>
		    <td style="width:34%;">所属专业委员会</td>
		    <td style="width:9%;">学术活动负责人</td>
		  </tr>
		  </thead>
		  <tbody>
		  @if(!empty($data))
			  @foreach($data as $tr)
				  <tr>
					  <td>{{ $tr->sn }}</td>
					  <td>{{ $tr->name }}</td>
					  <td>{{ $tr->committee }}</td>
					  <td>{{ $tr->leader }}</td>
				  </tr>
			  @endforeach
		  @endif
		  </tbody>
		</table>
	</body>
</html>
