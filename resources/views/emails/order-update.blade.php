
@php
$locale = app()->getLocale();
@endphp
<div>


	
		<table style="width: 100%; margin-top: 10px; box-shadow: 0 0 5px rgba(175, 175, 175, 1); filter: progid:DXImageTransform.Microsoft.Shadow(color=#afafaf,Direction=134,Strength=5)">
			<tbody><tr>
				<td style="width: 20px; padding: 7px 0">&nbsp;</td>
				<td align="center" style="padding: 7px 0">
					<table bgcolor="#ffffff" style="width: 100%">
						<tbody><tr>
							<td align="center" style="border-bottom: 4px solid rgba(51, 51, 51, 1); padding: 7px 0">
								<a title="Cbd Logistics Shop" href="https://www.cbdlogistics.swiss/en/" style="color: rgba(51, 127, 241, 1)">
									<img loading="lazy" src="https://www.cbdlogistics.swiss/public/image/logo.jpg" alt="Cbd Logistics Shop" style="height:60px;">
								</a>
							</td>
						</tr>

<tr>
	<td align="center" style="padding: 7px 0">
		<font size="2" color="#555454">
			<span style="font-weight: 500; font-size: 28px; text-transform: uppercase; line-height: 33px">{{$arr['user']->firstname}} {{$arr['user']->lastname}},</span><br>
			<span style="font-weight: 500; font-size: 16px; text-transform: uppercase; line-height: 25px">{{ __('email.Order Status Changed') }} </span>
		</font>
	</td>
</tr>
<tr>
	<td style="padding: 0 !important">&nbsp;</td>
</tr>
<tr>
	<td style="border: 1px solid rgba(214, 212, 212, 1); background-color: rgba(248, 248, 248, 1); padding: 7px 0">
		<table style="width: 100%">
			<tbody><tr>
				<td width="10" style="padding: 7px 0">&nbsp;</td>
				<td style="padding: 7px 0">
					<font size="2" color="#555454">
						<p style="border-bottom: 1px solid rgba(214, 212, 212, 1); margin: 3px 0 7px; font-weight: 500; font-size: 16px; padding-bottom: 10px">
						{{ __('email.Thank you for ordering from CBD Logistics.') }}
						<br>
						{{ __('email.Your order') }} #{{$arr['order']->reference_no}} {{ __('email.has been') }} {{$arr['status']->name}}.
						<br>
						{{ __('email.You can review your order status at any time by visiting') }} <a href="{{url('user/orders')}}">{{ __('email.Your Account') }}</a>.

			          </p>
						
					</font>
				</td>
				<td width="10" style="padding: 7px 0">&nbsp;</td>
			</tr>
		</tbody></table>
	</td>
</tr>


<tr>
	<td style="padding: 0 !important">&nbsp;</td>
</tr>





						<tr>
							<td style="padding: 0 !important">&nbsp;</td>
						</tr>
						<tr>
							<td style="border-top: 4px solid rgba(51, 51, 51, 1); padding: 7px 0">
								<span><a href="{{url('/')}}" style="color: rgba(51, 127, 241, 1)">Cbd Logistics</a> </span>
							</td>
						</tr>
					</tbody></table>
				</td>
				<td style="width: 20px; padding: 7px 0">&nbsp;</td>
			</tr>
		</tbody></table>
	


</div>