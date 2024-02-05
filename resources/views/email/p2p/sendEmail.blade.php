@include('email.header')
<tr><td colspan='3' align='center' height='1' style='padding:0px;'></td></tr>
<tr><td align='left' style='padding-top:0px;'>&nbsp;</td><td style='text-align:left;font-size:15px;color:#000;padding-top:0px;'>Dear {{ $user->name }},</td><td align='left' style='padding-top:0px;'>&nbsp;</td></tr>
<tr><td colspan='3' align='center' height='1' style='padding:0px;'></td></tr>
<tr><td align='left' style='padding-top:0px;'>&nbsp;</td><td style='text-align:left;font-size:15px;color:#000;padding-top:0px;line-height: 26px;'>Thank you for signing up with {{ config('app.name') }}<br />To complete your account verification, please verify your email address by clicking on the "confirmation" link below</td><td align='left' style='padding-top:0px;'>&nbsp;</td></tr>
<tr><td colspan='3' align='center' height='30' style='padding:0px;'></td></tr>
<tr><td align='center'>&nbsp;</td><td align='center'><a href="{{route('sendEmailDone', ['email' => \Crypt::encryptString($user->email), 'verifyToken' => $user->id])}}" style='color:#fff;padding:14px 22px;text-decoration:none;background-color:#040406;text-transform:uppercase;font-size:15px;font-weight:600;'>Confirmation Link</a></td><td align='center'>&nbsp;</td></tr>
<tr><td colspan='3' align='center' height='30' style='padding:0px;'></td></tr>
@include('email.footer')