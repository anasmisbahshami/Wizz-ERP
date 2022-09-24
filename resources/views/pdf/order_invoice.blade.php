<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Order Invoice W-{{$order->id}}</title>
    <style>
      .clearfix:after {
        content: "";
        display: table;
        clear: both;
    }

    a {
      color: #5D6975;
      text-decoration: underline;
    }

    body {
      position: relative;
      width: 21cm;  
      height: 29.7cm; 
      margin: 0 auto; 
      color: #001028;
      background: #FFFFFF; 
      font-family: Arial, sans-serif; 
      font-size: 12px; 
      font-family: Arial;
    }

    header {
      padding: 10px 0;
      margin-bottom: 30px;
    }

    #logo {
      text-align: center;
      margin-bottom: 10px;
    }

    #logo img {
      width: 90px;
    }

    h1 {
      border-top: 1px solid  #5D6975;
      border-bottom: 1px solid  #5D6975;
      color: #5D6975;
      font-size: 2.4em;
      line-height: 1.4em;
      font-weight: normal;
      text-align: center;
      margin: 0 0 20px 0;
      background: url({{$base641}});
    }

    #project {
      float: left;
    }

    #project span {
      color: #5D6975;
      text-align: right;
      width: 52px;
      margin-right: 10px;
      display: inline-block;
      font-size: 0.8em;
    }

    #company {
      float: right;
      text-align: right;
    }

    #project div,
    #company div {
      white-space: nowrap;        
    }

    table {
      width: 100%;
      border-collapse: collapse;
      border-spacing: 0;
      margin-bottom: 20px;
    }

    table tr:nth-child(2n-1) td {
      background: #F5F5F5;
    }

    table th,
    table td {
      text-align: center;
    }

    table th {
      padding: 5px 20px;
      color: #5D6975;
      border-bottom: 1px solid #C1CED9;
      white-space: nowrap;        
      font-weight: normal;
    }

    table .service,
    table .desc {
      text-align: left;
    }

    table td {
      padding: 20px;
      text-align: right;
    }

    table td.service,
    table td.desc {
      vertical-align: top;
    }

    table td.unit,
    table td.qty,
    table td.total {
      font-size: 1.2em;
    }

    table td.grand {
      border-top: 1px solid #5D6975;;
    }

    #notices .notice {
      color: #5D6975;
      font-size: 1.2em;
    }

    footer {
      color: #5D6975;
      width: 100%;
      height: 30px;
      position: absolute;
      bottom: 0;
      border-top: 1px solid #C1CED9;
      padding: 8px 0;
      text-align: center;
    }
    </style>
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="{{$base64}}">
      </div>
      <h1>INVOICE-W-{{$order->id}}</h1>
    <div class="row">
      <div id="project" class="col-md-6" style="float: left;">
        <div><span>TYPE</span> {{$order->type}}</div>
        <div><span>CLIENT</span> {{$order->user->name}}</div>
        <div><span>ADDRESS</span> 796 Silver Harbour, TX 79273, US</div>
        <div><span>EMAIL</span> <a href="mailto:{{$order->user->email}}">{{$order->user->email}}</a></div>
        <div><span>CNIC</span> 42201-1617464-1</div>
        <div><span>DATE</span> {{ \Carbon\Carbon::now()->format('F d, Y') }}</div>
      </div>
      <div class="col-md-6" style="float: right;">
        <div>Wizz Express & Logistics</div>
        <div>455 Gulberg Green,<br /> ISB 85004, PK</div>
        <div>(021) 570-8056</div>
        <div><a href="mailto:wizz-express@logistics.com">wizz-express@logistics.com</a></div>
      </div>
    </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="service">ITEM NAME</th>
            <th class="desc">DELIVERY ADDRESS</th>
            <th class="service">WEIGHT</th>
            <th class="service">QTY</th>
            <th class="total">TOTAL</th>
          </tr>
        </thead>
        <tbody>
          @php $subtotal = 0; @endphp
          @foreach ($order->items as $item)
          <tr>
            <td class="service">{{$item->name}}</td>
            <td class="desc">{{$item->delivery_address}}</td>
            <td class="service">{{number_format($item->weight, 2)}}</td>
            <td class="service">{{$item->quantity}}</td>
            <td class="total">Rs {{number_format($item->price, 2)}}</td>
          </tr>
          @php $subtotal += $item->price; @endphp
          @endforeach
          @php $gst = (16/100)*$subtotal; @endphp
          <tr>
            <td colspan="4">SUBTOTAL</td>
            <td class="total">Rs {{ number_format($subtotal, 2) }}</td>
          </tr>
          <tr>
            <td colspan="4">GST 16%</td>
            <td class="total">Rs {{ number_format($gst, 2) }}</td>
          </tr>
          <tr>
            <td colspan="4" class="grand total">GRAND TOTAL</td>
            <td style="float: right;margin-left:30px;" class="grand total" style="font-size:14px;text-align: center;">Rs <span style="@if($order->type == 'Subscription') text-decoration:line-through; @endif">{{ number_format(($gst+$subtotal), 2) }}</span> &nbsp;<span style="text-decoration: none;">({{$order->status}})</span></td>
          </tr>
        </tbody>
      </table>
      <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
      </div>
    </main>
    <footer>
      Invoice generated by computer is valid without the signature and seal.
    </footer>
  </body>
</html>