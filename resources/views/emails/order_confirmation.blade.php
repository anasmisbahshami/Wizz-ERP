<!DOCTYPE html>
<html>
<head>
<title>Order Confirmation | W-{{$order->id}}</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<style type="text/css">
body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
img { -ms-interpolation-mode: bicubic; }

img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
table { border-collapse: collapse !important; }
body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }


a[x-apple-data-detectors] {
    color: inherit !important;
    text-decoration: none !important;
    font-size: inherit !important;
    font-family: inherit !important;
    font-weight: inherit !important;
    line-height: inherit !important;
}

@media screen and (max-width: 480px) {
    .mobile-hide {
        display: none !important;
    }
    .mobile-center {
        text-align: center !important;
    }
}
div[style*="margin: 16px 0;"] { margin: 0 !important; }
</style>
<body style="margin: 0 !important; padding: 0 !important; background-color: #eeeeee;" bgcolor="#eeeeee">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td align="center" style="background-color: #eeeeee;" bgcolor="#eeeeee">
        
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
            <tr>
                <td align="center" valign="top" style="font-size:0; padding: 35px;" bgcolor="#F44336">
                <div style="width:100%;">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td align="center" valign="top" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 36px; font-weight: 800; line-height: 48px;" class="mobile-center">
                                <h3 style="font-size: 30px; font-weight: 800; margin: 0; color: #ffffff;text-align:center;">Wizz Express & Logistics</h3>
                            </td>
                        </tr>
                    </table>
                </div>
                </td>
            </tr>
            <tr>
                <td align="center" style="padding: 35px 35px 20px 35px; background-color: #ffffff;" bgcolor="#ffffff">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                    <tr>
                        <td align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 25px;">
                            <img src="https://img.icons8.com/carbon-copy/100/000000/checked-checkbox.png" width="125" height="120" style="display: block; border: 0px;" />
                            <h2 style="font-size: 30px; font-weight: 800; line-height: 36px; color: #333333; margin: 0;">
                                Thank You For Your Order!
                            </h2>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 10px;">
                            <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;">
                                We'll send you another email, when your order starts with tracking details.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" style="padding-top: 20px;">
                            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td width="75%" align="left" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                                        Order Confirmation #
                                    </td>
                                    <td width="25%" align="left" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                                        W-{{$order->id}}
                                    </td>
                                </tr>
                                @foreach ($order->items as $item)
                                <tr>
                                    <td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">{{$item->name}}</td>
                                    <td width="25%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">Rs {{number_format($item->price, 2)}}</td>
                                </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" style="padding-top: 20px;">
                            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;">TOTAL</td>
                                    <td width="25%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;">Rs {{number_format($order->items->sum('price'), 2)}}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                </td>
            </tr>
             <tr>
                <td align="center" height="100%" valign="top" width="100%" style="padding: 0 35px 35px 35px; background-color: #ffffff;" bgcolor="#ffffff">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:660px;">
                    <tr>
                        <td align="center" valign="top" style="font-size:0;">
                          <div class="row">
                            <div class="col-md-6" style="display:inline-block; max-width:50%; min-width:240px; vertical-align:top; width:100%;">
                                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:300px;">
                                    <tr>
                                        <td align="left" valign="top" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px;">
                                            <p style="font-weight: 800;">Delivery Address</p>
                                            <p>{{$order->items[0]->delivery_address}}</p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6" style="display:inline-block; max-width:50%; min-width:240px; vertical-align:top;float: left;">
                                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:300px;">
                                    <tr>
                                        <td align="left" valign="top" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px;">
                                            <p style="font-weight: 800;">Estimated Delivery Date</p>
                                            <span style="float:left;">N/A</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                          </div>
                        </td>
                    </tr>
                </table>
                </td>
            </tr>
            <tr>
                <td align="center" style=" padding: 35px; background-color: #ff7361;" bgcolor="#1b9ba3">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                    <tr>
                        <td align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 25px;">
                            <h2 style="font-size: 24px; font-weight: 800; line-height: 30px; color: #ffffff; margin: 0;">
                                Click the button below to confirm your order.
                            </h2>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 25px 0 15px 0;">
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="center" style="border-radius: 5px;" bgcolor="#66b3b7">
                                      <a href="{{url('/order/confirm/'.encrypt($order->id))}}" style="font-size: 18px; font-family: Open Sans, Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; border-radius: 5px; background-color: #F44336; padding: 15px 30px; border: 1px solid #F44336; display: block;">Confirm Order</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                </td>
            </tr>
            <tr>
                <td align="center" style="padding: 35px; background-color: #ffffff;" bgcolor="#ffffff">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                    <tr>
                        <td align="center">
                            <img src="{{asset('assets/images/footer-logo.png')}}" style="display: block; border: 0px;height:35px;"/>
                        </td>
                    </tr><br>
                    <tr>
                        <td align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 24px; padding: 5px 0 10px 0;">
                            <p style="font-size: 14px; font-weight: 800; line-height: 18px; color: #333333;">
                                404 Gulbery<br>
                                ISB, PK 4400
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 24px;">
                            <p style="font-size: 14px; font-weight: 400; line-height: 20px; color: #777777;">
                                If you didn't ordered using this email address, please ignore this email or <a href="#" target="_blank" style="color: #777777;">unsusbscribe</a>.
                            </p>
                        </td>
                    </tr>
                </table>
                </td>
            </tr>
        </table>
        </td>
    </tr>
</table>

</body>
</html>