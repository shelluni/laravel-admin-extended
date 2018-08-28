<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title></title> 
	<style>
@media print {
	#buttonDiv {
		display: none;
	}
}

body {
	text-align: center;
	font-size: 10.5pt;
	margin: 0;
	padding: 0;
	font-family: '宋体';
	background-color: #FFFFFF;
}

div {
	margin: auto;
	text-align: center;
}

.A4 {
	width: 488.5pt;
}

.A4 table {
	border-collapse: collapse;
	width: 90%;
	margin: auto;
}

.A4 table td {
	border: 1px solid #000000;
	margin: 0;
	word-break: break-all;
	padding: 6pt 4.5pt;
	height: 20pt;
}

.ttt table td {
	border: 0px solid #000000;
	margin: 0;
	font-size: 12pt;
}

.STYLE1 {
	font-size: 9pt
}

.space {
	white-space: nowrap;
}
</style>
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
</head>
<body>
	<object id="WebBrowser"
		classid="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2" width="0"
		height="0"></object>
	<div id="buttonDiv">
		<button id="printButton" onclick="javascript:doPrint();" type="button">打印</button>
	</div>
	<div class="A4" style="page-break-after:always;margin-top:10mm">
		<h1 style="letter-spacing:6pt">2018年度北京市级中医药继续教育项目</h1>
		<h1 style="letter-spacing:3pt">学术活动申报表</h1>
		<table>
			<tr>
				<td width="18%">学术活动名称</td>
				<td width="32">{{ $app->name }}</td>
				<td width="20%">所属专业委员会</td>
				<td width="30%">{{ $app->committee }}</td>
			</tr>
			<tr>
				<td>负责人</td>
				<td>{{ $app->leader }}</td>
				<td>计划参加人数</td>
				<td>{{ $app->training_number }}人</td>
			</tr>
			@if(count($app->terms) > 0)
			@foreach($app->terms as $term)
				<tr>
					<td colspan="1">培训地点与日期</td>
					<td colspan="3">{{ $term->locationObject->name }} {{ $term->start_at }} —— {{ $term->end_at }}</td>
				</tr>
			@endforeach
			@endif
			<tr>
				<td>申报单位</td>
				<td colspan="3">{{ $app->host }}</td>
			</tr>
			<tr>
				<td>联系电话</td>
				<td>{{ $app->contact }}</td>
				<td>电子邮箱</td>
				<td>{{ $app->email }}</td>
			</tr>
			<tr>
				<td>学时数</td>
				<td>{{ $app->AutoTrainingHours }}学时</td>
				<td>申请学分</td>
				<td>{{ $app->AutoCredit }}分</td>
			</tr>
			<tr>
				<td>学术活动<br />内容</td>
				<td style="height:120mm;text-align:justify;vertical-align:text-top;"
					colspan="3">{{ $app->content }}</td>
			</tr>
		</table>
	</div>
	<div class="A4" style="page-break-after:always;margin-top:10mm">
		<table>
			<tr>
				<td style="text-align:center;  border-top-width:1px; width:18%;"
					colspan="6">主办单位<br />意见</td>
				<td colspan="6" valign="bottom" style="border-top-width:1px;">
					<table>
						<tr style=" height:195pt; text-align:left; vertical-align:top ">
							<td colspan="4" style="border:none;"></td>
						</tr>
						<tr>
							<td width="5%" style="border:none;">&nbsp;</td>
							<td width="42%" align="right" style="border:none;">（盖章）</td>
							<td width="53%" style="border:none;">&nbsp;&nbsp;&nbsp;&nbsp;年&nbsp;&nbsp;月&nbsp;&nbsp;日</td>
							<td width="5%" style="border:none;">&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td style="text-align:center;   border-top-width:0px; width:18%;"
					colspan="6">专家组<br />评审意见</td>
				<td colspan="6" valign="bottom" style="border-top-width:0px;">
					<table>
						<tr style=" height:225pt; text-align:left; vertical-align:top ">
							<td colspan="4" style="border:none;"></td>
						</tr>
						<tr>
							<td width="5%" style="border:none;">&nbsp;</td>
							<td width="42%" align="right" style="border:none;">（签字）</td>
							<td width="53%" style="border:none;">&nbsp;&nbsp;&nbsp;&nbsp;年&nbsp;&nbsp;月&nbsp;&nbsp;日</td>
							<td width="5%" style="border:none;">&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td style="text-align:center;   border-top-width:0px; width:18%;"
					colspan="6">北京市中医管理局中医药继续教育委员会审批意见</td>
				<td colspan="6" valign="bottom" style="border-top-width:0px;">
					<table>
						<tr style=" height:225pt; text-align:left; vertical-align:top ">
							<td colspan="4" style="border:none;"></td>
						</tr>
						<tr>
							<td width="5%" style="border:none;">&nbsp;</td>
							<td width="42%" align="right" style="border:none;">（盖章）</td>
							<td width="53%" style="border:none;">&nbsp;&nbsp;&nbsp;&nbsp;年&nbsp;&nbsp;月&nbsp;&nbsp;日</td>
							<td width="5%" style="border:none;">&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
</body>

</html>

