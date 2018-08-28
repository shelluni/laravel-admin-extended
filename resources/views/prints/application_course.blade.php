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
	<div class="A4" style="page-break-after:always;">
		<div style="width:60%;padding:10% 0 5% 27%;">申请代码：{{ $app->sn }}</div>
		<div>
			<h1 style="line-height:2em;">
				2018年度北京市级中医药继续教育项目<br /> <span style=" letter-spacing:1.5em;">申报表</span>
			</h1>
		</div>
		<div>
			<div style="height:400px;"></div>
			<div class="ttt">
				<table width="90%" style="text-align:left;">
					<tr>
						<td width="19%"></td>
						<td width="15%" valign="bottom">项目名称</td>
						<td width="40%" colspan="2"
							style="border-bottom: 1px solid #000080;vertical-align:bottom;">{{ $app->name }}</td>
						<td width="19%"></td>
					</tr>
					<tr>
						<td width="19%"></td>
						<td width="15%" valign="bottom">所在学科</td>
						<td width="40%" colspan="2" style="border-bottom: 1px solid #000080;vertical-align:bottom;">{{ !$app->training_subject ?: $app->trainingSubjectObject->name }} </td>
						<td width="19%"></td>
					</tr>
					<tr>
						<td></td>
						<td valign="bottom">申办单位</td>
						<td
							style="border-bottom: 1px solid #000080;vertical-align:bottom;">{{ $app->host }}（盖章）</td>
						<td
							style="border-bottom: 1px solid #000080;vertical-align:bottom;text-align:left;"></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td valign="bottom">负责人姓名</td>
						<td
							style="border-bottom: 1px solid #000080;vertical-align:bottom;text-align:left;"
							colspan="2">{{ $app->leader }}</td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td valign="bottom">联系电话</td>
						<td
							style="border-bottom: 1px solid #000080;vertical-align:bottom;text-align:left;"
							colspan="2">{{ $app->contact }}</td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td valign="bottom">申报时间</td>
						<td colspan="2" style="border-bottom: 1px solid #000080;vertical-align:bottom;">{{ substr($app->declared_at,0,10) }}</td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td valign="bottom">申报类别</td>
						<td colspan="2" style="border-bottom: 1px solid #000080;vertical-align:bottom;">{{ !$app->category ?: $app->categoryObject->name }}</td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td valign="bottom">&nbsp;</td>
						<td colspan="2">&nbsp;</td>
						<td></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="A4" style="page-break-after:always;margin-top:5mm">
		<table>
			<!-- <tr>
			<td   colspan="6">一、基本信息</td>
		</tr> -->
			<tr>
				<td rowspan="3" width="8%">主办单位</td>
				<td colspan="2">名称</td>
				<td colspan="3">{{ $app->host }}</td>
			</tr>
			<tr>
				<td colspan="2">项目负责人</td>
				<td>{{ $app->leader }}</td>
				<td>联系电话</td>
				<td>{{ $app->contact }}</td>
			</tr>
			<tr>
				<td colspan="2">资质</td>
				<td colspan="3" style="text-align: left;">
					<input type="checkbox" id="qualification1" name="qualification" disabled {{ !in_array(1,$app->qualification) ?: 'checked' }} /> 央属、市属三级医疗机构 <br />
					<input type="checkbox" id="qualification2" name="qualification" disabled {{ !in_array(2,$app->qualification) ?: 'checked' }} /> 区属二级及以上中医、中西医、民族医医疗机构 <br />
					<input type="checkbox" id="qualification3" name="qualification" disabled {{ !in_array(3,$app->qualification) ?: 'checked' }} /> 教育部登记注册的开设中医药类专业的教育机构 <br />
					<input type="checkbox" id="qualification4" name="qualification" disabled {{ !in_array(4,$app->qualification) ?: 'checked' }} /> 区级以上中医药科研机构 <br />
					<input type="checkbox" id="qualification5" name="qualification" disabled {{ !in_array(5,$app->qualification) ?: 'checked' }} /> 区级以上中医药学术团体 <br />
					<input type="checkbox" id="qualification6" name="qualification" disabled {{ !in_array(6,$app->qualification) ?: 'checked' }} /> 国家中医药管理局、北京市中医管理局重点学科或重点专科（专病） <br />
					<input type="checkbox" id="qualification7" name="qualification" disabled {{ !in_array(7,$app->qualification) ?: 'checked' }} /> 全国名家研究室、名医传承工作站 <br />
					<input type="checkbox" id="qualification8" name="qualification" disabled {{ !in_array(8,$app->qualification) ?: 'checked' }} /> 北京市薪火传承“3+3”工作室（站） <br />
					<input type="checkbox" id="qualification9" name="qualification" disabled {{ !in_array(9,$app->qualification) ?: 'checked' }} /> 受北京市中医管理局中医药继续教育委员会委托开办中医药继续教育项目的单位
				</td>
			</tr>
			<tr>
				<td colspan="3">实施方式</td>
				<td colspan="3">{{ !$app->implementation ?: $app->implementationObject->name }}</td>
			</tr>
			<tr>
				<td colspan="2" rowspan="2">培训对象</td>
				<td colspan="2">培训范围</td>
				<td colspan="2"><input type="checkbox" id="range1" name="range" {{ !in_array(1,$app->training_range) ?: 'checked' }} disabled />全市
					<input type="checkbox" id="range1" name="range" disabled {{ !in_array(2,$app->training_range) ?: 'checked' }} />本区
					<input type="checkbox" id="range2" name="range" disabled {{ !in_array(3,$app->training_range) ?: 'checked' }} />农村
					<input type="checkbox" id="range3" name="range" disabled {{ !in_array(4,$app->training_range) ?: 'checked' }} />城市社区
				</td>
			</tr>
			<tr>
				<td colspan="2">人员层次</td>
				<td colspan="2"> 
					<input type="checkbox" id="peopleLevel1" name="peopleLevel" disabled {{ !in_array(1,$app->training_level) ?: 'checked' }} />初级以下
					<input type="checkbox" id="peopleLevel2" name="peopleLevel" disabled {{ !in_array(2,$app->training_level) ?: 'checked' }} />中级
	            	<input type="checkbox" id="peopleLevel3" name="peopleLevel" disabled {{ !in_array(3,$app->training_level) ?: 'checked' }} />高级
            	
				</td>
			</tr>
			<tr>
				<td colspan="2">计划培训人数</td>
				<td>{{ $app->training_number }}人</td>
				<td colspan="2">收费标准</td>
				<td>{{ $app->training_cost }}元</td>
			</tr>
			@if(count($app->terms) > 0)
			@foreach($app->terms as $term)
			<tr>
				<td colspan="3">培训地点与日期</td>
				<td colspan="3">{{ $term->locationObject->name }} {{ $term->start_at }} —— {{ $term->end_at }}</td>
			</tr>
			@endforeach
			@endif
			<tr>
				<td>教学时数</td>
				<td>{{ $app->AutoTrainingHours }}学时</td>
				<td class="space">考核办法</td>
				<td>{{ !$app->assessment ?: $app->assessmentObject->name }}</td>
				<td>申请学分</td>
				<td>{{ $app->AutoCredit }}分</td>
			</tr>
		</table>
	</div>
	<div class="A4" style="page-break-after:always;margin-top:5mm">
		<table id="teachers">
			<tr>
				<td colspan="6" width="8%">教师</td>
			</tr>
			<tr style="height:10mm;">
				<td width="10%">姓名</td>
				<td width="15%">专业</td>
				<td width="15%">技术职务</td>
				<td width="15%">所在单位</td>
				<td width="15%">授课内容</td>
				<td width="15%">教学时数</td>
				<td width="15%">签字</td>
			</tr>
			@if(count($app->teachers) > 0)
			@foreach($app->teachers as $teacher)
				<tr style="height:15mm;">
					<td>{{ $teacher->name }}</td>
					<td>{{ $teacher->major }}</td>
					<td>{{ $teacher->professionalObject->name }}</td>
					<td>{{ $teacher->OrganizationName }}</td>
					<td>{{ $teacher->course_content }}</td>
					<td>{{ $teacher->hours }}</td>
					<td></td>
				</tr>
			@endforeach
			@endif
		</table>
	</div>
	<div class="A4" style="page-break-after:always;margin-top:5mm">
		<table>
			<tr>
				<td>培训目的</td>
			</tr>
			<tr>
				<td style="height:120mm;text-align:justify;vertical-align:text-top;">{{ $app->purpose }}</td>
			</tr>
			<tr>
				<td>培训主要内容及学术水平</td>
			</tr>
			<tr>
				<td style="height:120mm;text-align:justify;vertical-align:text-top;">{{ $app->content }}</td>
			</tr>
		</table>
	</div>
	<div class="A4" style="page-break-after:always;margin-top:5mm">
		<table id="recentProjects">
			<tr>
				<td colspan="6">主<br />办<br />单<br />位<br />与<br />项<br />目<br />相<br />关<br />工<br />作<br />概<br />况</td>
			</tr>
			<tr style="height:10mm;">
				<td width="12%">项目编号</td>
				<td width="30%">项目名称</td>
				<td width="10%">项目<br />负责人</td>
				<td width="13%">举办时间</td>
				<td width="10%">授予<br />学分数</td>
				<td width="20%">审批单位</td>
			</tr>
			@if(count($app->all_recent) > 0)
			@foreach($app->all_recent as $recent)
				<tr style="height:15mm;">
					<td>{{ $recent->sn }}</td>
					<td>{{ $recent->name }}</td>
					<td>{{ $recent->leader }}</td>
					<td>{{ $recent->start_year }}</td>
					<td>{{ $recent->credit }}</td>
					<td>{{ $recent->auditor }}</td>
				</tr>
			@endforeach
			@endif
		</table>
		<table>
			<tr>
				<td>其他支撑条件</td>
			</tr>
			<tr>
				<td style="height:120mm;text-align:justify;vertical-align:text-top;">{{ $app->host_desc }}</td>
			</tr>
		</table>
	</div>
	<div class="A4" style="page-break-after:always;margin-top:5mm">
		<table>
			<tr>
				<td style="text-align:center;  border-top-width:1px; width:12%;"
					colspan="6">主办单位<br />意见</td>
				<td colspan="6" valign="bottom" style="border-top-width:1px;">
					<table>
						<tr style=" height:170pt; text-align:left; vertical-align:top ">
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
				<td style="text-align:center;   border-top-width:0px; width:12%;"
					colspan="6">专家组<br />评审意见</td>
				<td colspan="6" valign="bottom" style="border-top-width:0px;">
					<table>
						<tr style=" height:200pt; text-align:left; vertical-align:top ">
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
				<td style="text-align:center;   border-top-width:0px; width:12%;"
					colspan="6">北京市中医管理局中医药继续教育委员会审批意见</td>
				<td colspan="6" valign="bottom" style="border-top-width:0px;">
					<table>
						<tr style=" height:200pt; text-align:left; vertical-align:top ">
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
				<td style="text-align:center;   border-top-width:0px; width:12%;"
					colspan="6">备注</td>
				<td colspan="6" valign="bottom" style="border-top-width:0px;">
					<table>
						<tr style=" height:50pt; text-align:left; vertical-align:top ">
							<td colspan="4" style="border:none;">
								
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>

