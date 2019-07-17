<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{asset('favicon.ico')}}">

    <title>FIA</title>

    <style type="text/css">
		body { font-family: "poppins", Arial, sans-serif; font-size: 16px; line-height: 1.4; margin: 0; padding: 0; }
		.clearfix:before, .clearfix:after { content:" "; display: table; }
		.clearfix:after { clear: both; }
		.invoice-wrap { margin: 0 auto; width: 700px; }
		.header h1 { color: #f05a22; font-size: 30px; margin: 0; padding: 30px 0 15px ; text-transform: uppercase; }
		.header .logo { float: left; width: 50%; }
		.header .logo img { width: 220px; }
		.header .last { text-align: right; }
		.header .last p { margin: 0; }
		.info-1 { margin-bottom: 50px; margin-top: 30px; }
		.info-1 .col-1 {float: left;width: 360px;}
		.info-1 .col-2 {float: right;width: 222px;}
		.info-2 { margin-bottom: 50px; margin-top: 30px; text-align: center; }
		.lb, .gr { float: left; }
		.lb { padding-right: 5px; }
		.gr-1 { margin-bottom: 20px; }
		.gr-1 .lb { width: 40%; }
		.gr-1 .gr { width: 50%; }
		.gr-2 .lb {padding-right: 10px;width: 110px;}
		.gr-2 .lb span { float: right; }
		.gr-2 .gr {width: 100px;}
		.gr-3 .lb { width: 50px; }
		.gr-3 .gr { width: 50%; }
		.tb-1 { margin: 50px 0; width: 100%; }
		.tb-1 th, .tb-1 td { border: none; padding: 15px 20px; vertical-align: top; }
		.tb-1 th { background: #f48120; color: #fff; font-weight: normal; text-align: left; }
		.tb-1 th:last-child { border-left: #fff solid 2px; border-radius: 0 10px 0 0; text-align: right; }
		.tb-1 th:first-child { border-radius: 10px 0 0 0; }
		.tb-1 tbody td { border-bottom: #f48120 solid 2px; border-left: #f48120 solid 2px; }
		.tb-1 tbody td:last-child { border-right: #f48120 solid 2px; border-left: none; }
		.tb-1 tbody tr:last-child td:last-child { border-radius: 0 0 10px 0; }
		.tb-1 tbody tr:last-child td:first-child { border-radius: 0 0 0 10px; }
		.tb-1 tfoot td { padding: 5px 20px; }
		.tb-1 tfoot tr:first-child td { padding-top: 40px; }
		.tb-1 tfoot td:first-child, .tb-1 tfoot td:last-child { text-align: right; }
		.tb-1 tfoot .type td { padding-right: 0; }
		.tb-1 tfoot hr { border-top: #f48120 solid 1px; float: right; width: 380px; }
		.tb-1 p { margin: 0 0 10px; }
		footer { bottom: 10px; font-size: .9em; left: 0; margin: 0 auto; position: fixed; right: 0; text-align: right; width: 700px; z-index: 2; }
		footer .content { background: #fff; position: relative; }
		footer .line-1, footer .line-2 { background: #017cba; height: 10px; left: 0; position: fixed; bottom: 15px; width: 50%; z-index: -1; }
		footer .line-2 { border-radius: 0 10px 0 0; bottom: 5px; position: absolute; width: 23%; z-index: 3; }
	</style>


</head>

<body>

<div class="invoice-wrap">
    <div class="header clearfix">
        <div class="logo">
            <img src="{{asset('images/fia-logo.jpg')}}" alt="FIA"/>
        </div>
        @if($data['transaction_id'])
            <div class="last">
                <h1>{{masterSetting()->tax_invoice_text}}</h1>

                <p>Paypal Transaction ID<br/>
                    <strong>{{$data['transaction_id']}}</strong></p>
            </div>
        @endif
    </div>
    <div class="info-1 clearfix">
        <div class="col-1">
            @if($data['organization'])
                <div class="gr-1 clearfix">
                    <div>Bill To:</div>
                    <div></div>
                </div>
                <div class="gr-3 clearfix">
                    <div><strong>Company:</strong></div>
                    <div>{{$data['organization']}}</div>
                </div>
                <div class="gr-3 clearfix">
                    <div>Address:</div>
                    <div>{{$data['address1'].' '.$data['address2']}}</div>
                </div>
            @endif
        </div>
        <div class="col-2">
            <div class="gr-2 clearfix">
                <div class="lb">GST Reg. No <span>:</span></div>
                <div class="gr">{{masterSetting()->gst_no}}</div>
            </div>
            <div class="gr-2 clearfix">
                <div class="lb">Invoice No <span>:</span></div>
                <div class="gr">{{$data['order_id']}}</div>
            </div>
            <div class="gr-2 clearfix">
                <div class="lb">Invoice Date <span>:</span></div>
                <div class="gr">{{date('d M Y', strtotime($data['created_at']))}}</div>
            </div>
            <div class="gr-2 clearfix">
                <div class="lb">Currency <span>:</span></div>
                <div class="gr">{{$data['currency']}}</div>
            </div>
        </div>
    </div>
    <div class="gr-3 clearfix">
        <div><strong>Attention:</strong></div>
        <div></div>
    </div>

    <div class="gr-3 clearfix">
        <div>Name:</div>
        <div>{{$data['firstname'].' '.$data['lastname']}}</div>
    </div>
    <table cellpadding="0" cellspacing="0" class="tb-1">
        <thead>
        <tr>
            <th>DESCRIPTION</th>
            <th colspan="2">AMOUNT</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="height: 300px;">
                <p>Membership Signup</p>
                <ul>
                    <li>Consectetuer Adipiscing</li>
                    <li>Sed Diam Nonummy</li>
                    <li>Nbh Fuismod Dincidunt</li>
                    <li>Dolore Nagna Aliquam Erat Volutpat</li>
                </ul>
            </td>
            <td style="width: 20px;">$</td>
            <td style="width: 120px;">{{$data['price']}}</td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td>Total Before GST:</td>
            <td style="width: 20px;">$</td>
            <td style="width: 120px;">{{$data['price']}}</td>
        </tr>
        <tr>
            <td>GST:</td>
            <td style="width: 20px;">$</td>
            <td style="width: 120px;">{{$data['gst']}}</td>
        </tr>
        <tr class="type">
            <td colspan="3">
                <hr/>
            </td>
        </tr>
        <tr>
            <td><strong>Total Inc GST:</strong></td>
            <td style="width: 20px;"><strong>$</strong></td>
            <td style="width: 120px;"><strong>{{$data['total']}}</strong></td>
        </tr>
        </tfoot>
    </table>
    <div class="info-2">
        {{masterSetting()->invoice_footer}}
    </div>
</div>

<footer>
    <div class="line-1"></div>
    <div class="line-2"></div>
    <div class="content">{{masterSetting()->invoice_footer_address}}</div>
</footer>

</body>
</html>
