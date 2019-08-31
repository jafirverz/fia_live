
<!DOCTYPE html>
<html>
<head>
	<title>FIA</title>

	<style type="text/css">
		@font-face {
			font-family: 'ITCA';
			src: url("fonts/ITCAvantGardeStd-Bk.otf");
			font-weight: normal;
			font-style: normal;
		}
		@font-face {
			font-family: 'ITCA';
			src: url("fonts/ITCAvantGardeStd-Demi.otf");
			font-weight: 600;
			font-style: normal;
		}
		@font-face {
			font-family: 'ITCA';
			src: url("fonts/ITCAvantGardeStd-Bold.otf");
			font-weight: bold;
			font-style: normal;
		}
		img{
			max-width: 600px;
			width: 100%;
		}
	</style>
</head>
<body style="margin: 0; padding: 0;font-family: 'ITCA'; max-width: 600px; width: 100%; text-align: center; color: #000;">
	{!! $data['contents'] !!}
</body>
</html>
