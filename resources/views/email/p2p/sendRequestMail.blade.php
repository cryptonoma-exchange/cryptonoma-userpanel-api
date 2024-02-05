@include('email.header')

<tr>
	<td align='left'>&nbsp;</td><td style='text-align:left;font-size:20px;color:#515151;font-weight:600;'>Welcome to {{ config('app.name') }}</td><td align='left'>&nbsp;</td>
</tr>
<tr>
	<td align="left">&nbsp;</td><td colspan="2" style="text-align: left ; font-size: 15px ; color: #000">Dear {{ $toname }}</td><td align="left">&nbsp;</td></tr>
	<tr><td colspan="3" align="left" height="1" style="padding: 0px"></td></tr>
	<tr><td align="left">&nbsp;</td><td colspan="2" style="text-align: left ; font-size: 15px ; color: #000">
		@if($type=='test')
		You got a new offer to your {{$tradetypemail}} advertisement.
		@else
		Your trade ({{$tktid}}) was {{$type}}. @if($msg!='test') {{$msg}} @endif
		@endif
	</td></tr>
	<tr><td colspan="3" align="left" height="1" style="padding: 0px"></td></tr><tr><td align="left">&nbsp;</td><td style="text-align: left ; font-size: 15px ; color: #000" colspan="2">@if($tradetypemail=='Buy') Seller @else Buyer @endif : {{ $username }}<br>
		Deal: {{ $amount }} {{$currency}} = {{ display_format($btc) }} ({{$trade_price}} {{$currency}}/{{$source}})
	</td></tr>
	<tr><td colspan="3" align="left" height="20" style="padding: 0px"></td></tr><tr><td align="left" style="padding-top: 0px">&nbsp;</td><td style="text-align: left ; font-size: 15px ; color: #000 ; padding-top: 0px" colspan="2">Please respond on website:</td></tr><tr><td align="center">&nbsp;</td><td align="center"><a href="{{url('trademessage/'.$tktid)}}" style="color: #323231 ; padding: 12px 15px ; text-decoration: none ; background-color: #10feec ; text-transform: uppercase ; font-size: 14px ; font-weight: 600" target="_other" rel="nofollow">View Trade</a></td><td align="center">&nbsp;</td></tr><tr><td colspan="3" align="center" height="30" style="padding: 0px"></td>
</tr>
@include('email.footer')