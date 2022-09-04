<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="_token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('/assets/img/favicon.png') }}">
    <!-- end plugin css -->

    <!-- common css -->
    <style>
        /* bad css practice start */
        body {font-family: "Overpass", sans-serif;}
        .invoice_header .col-md-6 {width:50%;}
        .col-md-6 {width:50%;}
        .smallTableInvoice table th, .smallTableInvoice table td {border: 0;padding: 5px;padding-left:0;}
        .smallTableInvoice {max-width:50%;float:right;}
        body, .main-wrapper, .page-wrapper, table {background-color: #fff;}
        .invoice_wrapper {margin-top:20px;}
        table tr th,table tr td {text-align:left;}
        #dataTableExample {border: none;border-collapse:collapse;}
        #dataTableExample thead tr th, #dataTableExample tbody tr td {padding:10px;text-align:left;color:#696969;padding-left:0;}
        #dataTableExample thead {border:1px solid #696969;border-left:0;border-right:0;}
        #dataTableExample tbody tr td strong {color:#484848}
        #dataTableExample tbody {margin-top:20px;border:0;padding-left:10px;}
        #dataTableExample tbody tr.dynamicRowItems td.idNumber {padding-left:5px;}
        #dataTableExample tbody tr.dynamicRowItems,
        #dataTableExample tbody tr.totalsRow {margin-top:10px;background-color: #d8dee1;border:0;margin:0;padding:0;}
        /* bad css practice end */
    </style>
    <!-- end common css -->

    @stack('style')
</head>

<body data-base-url="{{ url('/') }}">
    <div class="main-wrapper" id="app">
        <div class="page-wrapper">
            <div class="invoice_wrapper">
                <div>
                    <div class="row invoice_header" style="display:flex;margin-bottom:50px;font-size:14px;margin-top:0;line-height:12px;">
                        <div class="col-md-6 text-left" style="max-width:45%;">
                            <div class="logo_img_invoice">
                                <img src="{{$base64}}" style="width:240px;">
                            </div>
                        </div>
                        <div class="col-md-6 text-right" style="max-width:40%;float:right;margin-top:0;text-align:right;">
                            <h1>Invoice</h1>
                            <p><strong>NTN: </strong>4680278027</p>
                            <p><strong>Reg. No.: </strong>2016/ 202994/ 07</p>
                            <p><strong>FBR Reg: </strong>MAAA0649426</p>
                        </div>
                    </div>
                    <div class="row" style="display:flex;margin-top:20px;font-size:10px;line-height:12px;">
                        <div class="col-md-6 text-left" style="max-width:45%;">
                            <p>Jinnah Street</p>
                            <p>Penthouse 319-Js</p>
                            <p>Gulberg Greens, ISB</p>
                            <p>+4400</p>
                            <p>info@wizz.pk</p>
                        </div>
                        <div class="col-md-6 smallTableInvoice" style="max-width:40%;float:right;">
                            <div class="table-responsive">
                                <table class="table" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <th></th>
                                            <td>4710295009</td>
                                        </tr>
                                        <tr>
                                            <th>INVOICE NO.</th>
                                            <td>PO-0001</td>
                                        </tr>
                                        <tr>
                                            <th>DATE</th>
                                            <td>{{ Carbon\Carbon::now()->format('d/m/Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Purchase Order No.</th>
                                            <td>4503944241</td>
                                        </tr>
                                        <tr>
                                            <th>Vendor No.</th>
                                            <td>2021</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
	
                    <div class="row" style="display:flex;margin-top:20px;font-size:10px">
                        <div class="col-md-12" style="width:100%">
                            <div class="table-responsive" style="width:100%">
                                <table id="dataTableExample" class="table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Vehicle</th>
                                            <th>Route</th>
                                            <th>Date</th>
                                            <th>Rate</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $total = 0;
                                        ?>
                                        
                                        @foreach($trips as $key => $trip)
                                            <tr class="dynamicRowItems">
                                                <td class="idNumber">{{$key+1}}</td>
                                                <td style="width:30%;">{{ $trip->vehicle->name }}</td>
                                                <td style="width:30%;">{{ $trip->route->name }}</td>
                                                <td>{{ $trip->date }}</td>
                                                <td>{{ $trip->rate }}</td>
                                                <?php 
                                                    $total = $total + $trip->rate;
                                                ?>
                                            </tr>
                                        @endforeach
                                        <tr class="totalsRow">
                                            
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="totalsData"><strong>TOTAL</strong></td>
                                            <td class="totalsData"><strong>PKR {{ $total }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="display:flex;margin-top:20px;font-size:10px;line-height:10px;">
                        <div class="col-md-12">
                            <p><small class="text-muted"><b>Make all checks payable to:</b></small></p>
                            <p><small class="text-muted"><b>Account Name:</b> Wizz Express & Logistics</small></p>
                            <p><small class="text-muted"><b>Bank:</b> Bank Alfalah</small></p>
                            <p><small class="text-muted"><b>Account No.:</b> 62626578473</small></p>
                        </div>
                    </div>
                    <div class="row" style="display:flex;margin-top:20px;font-size:10px;line-height:15px;text-align:center;">
                        <div class="col-md-12">
                            <strong><em>THANK YOU FOR YOUR BUSINESS!</em></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>