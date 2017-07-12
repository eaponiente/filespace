<style>
html, body {
	background:#dfdfdf;
}
</style>
<table width="600" style="margin:10px auto;">
	<tr>
		<td style="background:#2b2e3c;  padding:8px;">
			<img src="{{ url('img/filespace.png')}}" />
		</td>
	</tr>
	<tr>
		<td style="background:#fff;  padding:30px 20px;">
			<div style="font-weight:bold; color:#2b2e3c; font-size:16px;">Dear {{ $name }} from {{ $org }}</div>
			<div style="margin-top:10px; color:#2b2e3c; font-size:16px;">
				Thanks for your report. We have assigned the following code to this case:
			</div>

			<div style="border:2px dashed #cacedd; background:#eff1f8; padding:15px 5px; margin-top:15px;color:#e15a48; text-decoration:none; font-size:18px; font-weight:bold; text-align:center; ">
				{{ $code }}
			</div>
			
			<div style="margin-top:10px; color:#2b2e3c; font-size:16px;">
				We will inform you on the result of our investigation within 72 hours.
			</div>
			<div style="margin-top:20px; font-weight:bold; color:#2b2e3c; font-size:16px;">
				Your sincerely,<br />
				The FileSpace.io Team
			</div>
		</td>
	</tr>
</table>