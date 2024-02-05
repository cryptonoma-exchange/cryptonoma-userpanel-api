@include('email.header')
<tr><td align='left'>&nbsp;</td><td style='text-align:center;font-size:20px;color:#515151;font-weight:600;'>Your one time password (OTP)</td><td align='left'>&nbsp;</td></tr>
<tr><td colspan='3' align='center' height='1' style='padding:0px;'></td></tr>
<tr><td align='left' style='padding-top:0px;'>&nbsp;</td><td style='text-align:left;font-size:15px;color:#000;padding-top:0px;'>Your Verification Code: {{ $user }}</td><td align='left' style='padding-top:0px;'>&nbsp;</td></tr>
<tr><td colspan='3' align='center' height='1' style='padding:0px;'></td></tr>
<tr><td align='left' style='padding-top:0px;'>&nbsp;</td><td style='text-align:left;font-size:15px;color:#000;padding-top:0px;line-height: 29px;'>Never share this OTP with anyone else. <br />Tip - If you did not request this OTP, or if you feel someone else may be trying to login to your account, please change your twofactor authentication immediately.</td><td align='left' style='padding-top:0px;'>&nbsp;</td></tr>
<tr><td colspan='3' align='center' height='30' style='padding:0px;'></td></tr>
@include('email.footer')
