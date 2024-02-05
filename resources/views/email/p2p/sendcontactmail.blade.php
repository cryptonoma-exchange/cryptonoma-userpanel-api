@include('email.header')

<tr><td align='left'>&nbsp;</td><td style='text-align:center;font-size:20px;color:#515151;font-weight:600;'>Welcome to {{ config('app.name') }}</td><td align='left'>&nbsp;</td></tr>
<tr><td colspan='3' align='center' height='1' style='padding:0px;'></td></tr>
<tr><td align='left' style='padding-top:0px;'>&nbsp;</td><td style='text-align:left;font-size:15px;color:#000;padding-top:0px;'>New user has been Contact our site</td><td align='left' style='padding-top:0px;'>&nbsp;</td></tr>
<tr><td colspan='3' align='center' height='1' style='padding:0px;'></td></tr>
<tr><td colspan='3' align='center' height='1' style='padding:0px;'></td></tr>
<tr>
<td align='left' style='padding-top:0px;'>&nbsp;</td><td style='text-align:left;font-size:15px;color:#000;padding-top:0px;'>Name : {{ $request->name }}</td><td align='left' style='padding-top:0px;'>&nbsp;</td>
<td align='left' style='padding-top:0px;'>&nbsp;</td><td style='text-align:left;font-size:15px;color:#000;padding-top:0px;'>Email : {{ $request->email }}</td><td align='left' style='padding-top:0px;'>&nbsp;</td>
<td align='left' style='padding-top:0px;'>&nbsp;</td><td style='text-align:left;font-size:15px;color:#000;padding-top:0px;'>Subject : {{ $request->subject }}</td><td align='left' style='padding-top:0px;'>&nbsp;</td>
<td align='left' style='padding-top:0px;'>&nbsp;</td><td style='text-align:left;font-size:15px;color:#000;padding-top:0px;'>Phoneno : {{ $request->phone }}</td><td align='left' style='padding-top:0px;'>&nbsp;</td>
<td align='left' style='padding-top:0px;'>&nbsp;</td><td style='text-align:left;font-size:15px;color:#000;padding-top:0px;'>Message : {{ $request->message }}</td><td align='left' style='padding-top:0px;'>&nbsp;</td>
</tr>
<tr><td colspan='3' align='center' height='30' style='padding:0px;'></td></tr>



@include('email.footer')
