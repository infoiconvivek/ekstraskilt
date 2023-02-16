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
			<span style="font-weight: 500; font-size: 28px; text-transform: uppercase; line-height: 33px">Hi {{$arr['user']->firstname}} {{$arr['user']->lastname}},</span><br>
			<span style="font-weight: 500; font-size: 16px; text-transform: uppercase; line-height: 25px">{{ __('email.Thank you for shopping with CBD Logistics!') }}</span>
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
						<p style="border-bottom: 1px solid rgba(214, 212, 212, 1); margin: 3px 0 7px; text-transform: uppercase; font-weight: 500; font-size: 18px; padding-bottom: 10px">
							 {{ __('email.Order details') }}						</p>


							@php 
							$getPaymenthod = $arr['order']->payment_method;
                            if($getPaymenthod == 'coinbase')
							{
								$newpayMethod = "Crypto Currency Payments";
							} else if($getPaymenthod == 'credit_card')
							{
								$newpayMethod = "Visa/Master Card";
							} else if($getPaymenthod == 'post_finance')
							{
								$newpayMethod = "Post Finance";
							} else if($getPaymenthod == 'bank_transfer')
							{
								$newpayMethod = "Bank Transfer";
							} else
							{
								$newpayMethod = $arr['order']->payment_method;
							}
							@endphp
						<span style="color: rgba(119, 119, 119, 1)">
							<span style="color: rgba(51, 51, 51, 1)"><strong>{{ __('email.Order') }}:</strong></span> Order Placed on {{date('m/d/Y H:i:s')}}<br><br>
							<span style="color: rgba(51, 51, 51, 1)"><strong>{{ __('email.Payment') }}:</strong></span> {{$newpayMethod}}
						</span>
					</font>
				</td>
				<td width="10" style="padding: 7px 0">&nbsp;</td>
			</tr>
		</tbody></table>
	</td>
</tr>
<tr>
	<td style="padding: 7px 0">
		<font size="2" color="#555454">
			<table bgcolor="#ffffff" style="width: 100%; border-collapse: collapse">
				<tbody><tr>
					<th bgcolor="#f8f8f8" style="border: 1px solid rgba(214, 212, 212, 1); background-color: rgba(251, 251, 251, 1); color: rgba(51, 51, 51, 1); font-family: Arial; font-size: 13px; padding: 10px">{{ __('email.Reference') }}</th>
					<th bgcolor="#f8f8f8" style="border: 1px solid rgba(214, 212, 212, 1); background-color: rgba(251, 251, 251, 1); color: rgba(51, 51, 51, 1); font-family: Arial; font-size: 13px; padding: 10px">{{ __('email.Product') }}</th>
					<th bgcolor="#f8f8f8" style="border: 1px solid rgba(214, 212, 212, 1); background-color: rgba(251, 251, 251, 1); color: rgba(51, 51, 51, 1); font-family: Arial; font-size: 13px; padding: 10px" width="17%">{{ __('email.Unit price') }}</th>
					<th bgcolor="#f8f8f8" style="border: 1px solid rgba(214, 212, 212, 1); background-color: rgba(251, 251, 251, 1); color: rgba(51, 51, 51, 1); font-family: Arial; font-size: 13px; padding: 10px">{{ __('email.Quantity') }}</th>
					<th bgcolor="#f8f8f8" style="border: 1px solid rgba(214, 212, 212, 1); background-color: rgba(251, 251, 251, 1); color: rgba(51, 51, 51, 1); font-family: Arial; font-size: 13px; padding: 10px" width="17%">{{ __('email.Total price') }}</th>
				</tr>
				<tr>
					<td colspan="5" style="border: 1px solid rgba(214, 212, 212, 1); text-align: center; color: rgba(119, 119, 119, 1); padding: 7px 0">
						&nbsp;&nbsp;</td></tr>


@foreach($arr['order_items'] as $items )
  <tr>
	<td style="border: 1px solid rgba(214, 212, 212, 1)">
		<table>
			<tbody><tr>
				<td width="10">&nbsp;</td>
				<td>
					<font size="2" color="#555454">
					{{$items->reference}}
					</font>
				</td>
				<td width="10">&nbsp;</td>
			</tr>
		</tbody></table>
	</td>
	<td style="border: 1px solid rgba(214, 212, 212, 1)">
		<table>
			<tbody><tr>
				<td width="10">&nbsp;</td>
				<td>
					<font size="2" color="#555454">
						<strong>{{$items->name_en.'_'.$locale}}</strong>
						
						
					</font>
				</td>
				<td width="10">&nbsp;</td>
			</tr>
		</tbody></table>
	</td>
	<td style="border: 1px solid rgba(214, 212, 212, 1)">
		<table>
			<tbody><tr>
				<td width="10">&nbsp;</td>
				<td align="right">
					<font size="2" color="#555454">
					{{strtoupper($items->currency)}}{{$items->unit_price}}
					</font>
				</td>
				<td width="10">&nbsp;</td>
			</tr>
		</tbody></table>
	</td>
	<td style="border: 1px solid rgba(214, 212, 212, 1)">
		<table>
			<tbody><tr>
				<td width="10">&nbsp;</td>
				<td align="right">
					<font size="2" color="#555454">
					{{$items->quantity}}
					</font>
				</td>
				<td width="10">&nbsp;</td>
			</tr>
		</tbody></table>
	</td>
	<td style="border: 1px solid rgba(214, 212, 212, 1)">
		<table>
			<tbody><tr>
				<td width="10">&nbsp;</td>
				<td align="right">
					<font size="2" color="#555454">
					{{strtoupper($items->currency)}} {{$items->total_price}}
					</font>
				</td>
				<td width="10">&nbsp;</td>
			</tr>
		</tbody></table>
	</td>
</tr>

@endforeach
   
					
				
				<tr>
					<td colspan="5" style="border: 1px solid rgba(214, 212, 212, 1); text-align: center; color: rgba(119, 119, 119, 1); padding: 7px 0">
						&nbsp;&nbsp;
					</td>
				</tr>
				<tr>
					<td bgcolor="#f8f8f8" colspan="4" style="border: 1px solid rgba(214, 212, 212, 1); color: rgba(51, 51, 51, 1); padding: 7px 0">
						<table style="width: 100%; border-collapse: collapse">
							<tbody><tr>
								<td width="10" style="color: rgba(51, 51, 51, 1); padding: 0">&nbsp;</td>
								<td align="right" style="color: rgba(51, 51, 51, 1); padding: 0">
									<font size="2" color="#555454">
										<strong>Products</strong>
									</font>
								</td>
								<td width="10" style="color: rgba(51, 51, 51, 1); padding: 0">&nbsp;</td>
							</tr>
						</tbody></table>
					</td>
					<td bgcolor="#f8f8f8" align="right" colspan="4" style="border: 1px solid rgba(214, 212, 212, 1); color: rgba(51, 51, 51, 1); padding: 7px 0">
						<table style="width: 100%; border-collapse: collapse">
							<tbody><tr>
								<td width="10" style="color: rgba(51, 51, 51, 1); padding: 0">&nbsp;</td>
								<td align="right" style="color: rgba(51, 51, 51, 1); padding: 0">
									<font size="2" color="#555454">
									{{strtoupper($arr['order']->currency)}} {{$arr['order']->total}}
									</font>
								</td>
								<td width="10" style="color: rgba(51, 51, 51, 1); padding: 0">&nbsp;</td>
							</tr>
						</tbody></table>
					</td>
				</tr>
				<tr>
					<td bgcolor="#f8f8f8" colspan="4" style="border: 1px solid rgba(214, 212, 212, 1); color: rgba(51, 51, 51, 1); padding: 7px 0">
						<table style="width: 100%; border-collapse: collapse">
							<tbody><tr>
								<td width="10" style="color: rgba(51, 51, 51, 1); padding: 0">&nbsp;</td>
								<td align="right" style="color: rgba(51, 51, 51, 1); padding: 0">
									<font size="2" color="#555454">
										<strong>{{ __('email.Discounts') }}</strong>
									</font>
								</td>
								<td width="10" style="color: rgba(51, 51, 51, 1); padding: 0">&nbsp;</td>
							</tr>
						</tbody></table>
					</td>
					<td bgcolor="#f8f8f8" colspan="4" style="border: 1px solid rgba(214, 212, 212, 1); color: rgba(51, 51, 51, 1); padding: 7px 0">
						<table style="width: 100%; border-collapse: collapse">
							<tbody><tr>
								<td width="10" style="color: rgba(51, 51, 51, 1); padding: 0">&nbsp;</td>
								<td align="right" style="color: rgba(51, 51, 51, 1); padding: 0">
									<font size="2" color="#555454">
									{{strtoupper($arr['order']->currency)}} {{$arr['order']->discount}}
									</font>
								</td>
								<td width="10" style="color: rgba(51, 51, 51, 1); padding: 0">&nbsp;</td>
							</tr>
						</tbody></table>
					</td>
				</tr>
			
				<tr>
					<td bgcolor="#f8f8f8" colspan="4" style="border: 1px solid rgba(214, 212, 212, 1); color: rgba(51, 51, 51, 1); padding: 7px 0">
						<table style="width: 100%; border-collapse: collapse">
							<tbody><tr>
								<td width="10" style="color: rgba(51, 51, 51, 1); padding: 0">&nbsp;</td>
								<td align="right" style="color: rgba(51, 51, 51, 1); padding: 0">
									<font size="2" color="#555454">
										<strong>{{ __('email.Shipping') }}</strong>
									</font>
								</td>
								<td width="10" style="color: rgba(51, 51, 51, 1); padding: 0">&nbsp;</td>
							</tr>
						</tbody></table>
					</td>
					<td bgcolor="#f8f8f8" colspan="4" style="border: 1px solid rgba(214, 212, 212, 1); color: rgba(51, 51, 51, 1); padding: 7px 0">
						<table style="width: 100%; border-collapse: collapse">
							<tbody><tr>
								<td width="10" style="color: rgba(51, 51, 51, 1); padding: 0">&nbsp;</td>
								<td align="right" style="color: rgba(51, 51, 51, 1); padding: 0">
									<font size="2" color="#555454">
									{{strtoupper($arr['order']->currency)}} {{$arr['order']->shipping_amount}}
									</font>
								</td>
								<td width="10" style="color: rgba(51, 51, 51, 1); padding: 0">&nbsp;</td>
							</tr>
						</tbody></table>
					</td>
				</tr>
				{{--
				<tr>
					<td bgcolor="#f8f8f8" colspan="4" style="border: 1px solid rgba(214, 212, 212, 1); color: rgba(51, 51, 51, 1); padding: 7px 0">
						<table style="width: 100%; border-collapse: collapse">
							<tbody><tr>
								<td width="10" style="color: rgba(51, 51, 51, 1); padding: 0">&nbsp;</td>
								<td align="right" style="color: rgba(51, 51, 51, 1); padding: 0">
									<font size="2" color="#555454">
										<strong>{{ __('email.Total Tax paid') }}</strong>
									</font>
								</td>
								<td width="10" style="color: rgba(51, 51, 51, 1); padding: 0">&nbsp;</td>
							</tr>
						</tbody></table>
					</td>
					<td bgcolor="#f8f8f8" colspan="4" style="border: 1px solid rgba(214, 212, 212, 1); color: rgba(51, 51, 51, 1); padding: 7px 0">
						<table style="width: 100%; border-collapse: collapse">
							<tbody><tr>
								<td width="10" style="color: rgba(51, 51, 51, 1); padding: 0">&nbsp;</td>
								<td align="right" style="color: rgba(51, 51, 51, 1); padding: 0">
									<font size="2" color="#555454">
										€18.92
									</font>
								</td>
								<td width="10" style="color: rgba(51, 51, 51, 1); padding: 0">&nbsp;</td>
							</tr>
						</tbody></table>
					</td>
				</tr>
				--}}
				<tr>
					<td bgcolor="#f8f8f8" colspan="4" style="border: 1px solid rgba(214, 212, 212, 1); color: rgba(51, 51, 51, 1); padding: 7px 0">
						<table style="width: 100%; border-collapse: collapse">
							<tbody><tr>
								<td width="10" style="color: rgba(51, 51, 51, 1); padding: 0">&nbsp;</td>
								<td align="right" style="color: rgba(51, 51, 51, 1); padding: 0">
									<font size="2" color="#555454">
										<strong>{{ __('email.Total paid') }}</strong>
									</font>
								</td>
								<td width="10" style="color: rgba(51, 51, 51, 1); padding: 0">&nbsp;</td>
							</tr>
						</tbody></table>
					</td>
					<td bgcolor="#f8f8f8" colspan="4" style="border: 1px solid rgba(214, 212, 212, 1); color: rgba(51, 51, 51, 1); padding: 7px 0">
						<table style="width: 100%; border-collapse: collapse">
							<tbody><tr>
								<td width="10" style="color: rgba(51, 51, 51, 1); padding: 0">&nbsp;</td>
								<td align="right" style="color: rgba(51, 51, 51, 1); padding: 0">
									<font size="4" color="#555454">
									{{strtoupper($arr['order']->currency)}} {{($arr['order']->total) + $arr['order']->shipping_amount}}
									</font>
								</td>
								<td width="10" style="color: rgba(51, 51, 51, 1); padding: 0">&nbsp;</td>
							</tr>
						</tbody></table>
					</td>
				</tr>
				</tbody>
			</table>
		</font>
	</td>
</tr>
<tr>
	<td style="border: 1px solid rgba(214, 212, 212, 1); background-color: rgba(248, 248, 248, 1); padding: 7px 0">
		<table style="width: 100%">
			<tbody><tr>
				<td width="10" style="padding: 7px 0">&nbsp;</td>
				<td style="padding: 7px 0">
					<font size="2" color="#555454">
						<p style="border-bottom: 1px solid rgba(214, 212, 212, 1); margin: 3px 0 7px; text-transform: uppercase; font-weight: 500; font-size: 18px; padding-bottom: 10px">
						{{ __('email.Shipping') }}						</p>
						<span style="color: rgba(119, 119, 119, 1)">
							<span style="color: rgba(51, 51, 51, 1)"><strong>{{ __('email.Carrier') }}:</strong></span> {{$arr['order']->shipping_method}}<br><br>
							<span style="color: rgba(51, 51, 51, 1)"><strong>{{ __('email.Payment') }}:</strong></span> {{$arr['order']->payment_method}}
						</span>
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
	<td style="padding: 7px 0">
		<table style="width: 100%">
			<tbody><tr>
				<td width="310" style="border: 1px solid rgba(214, 212, 212, 1); background-color: rgba(248, 248, 248, 1); padding: 7px 0">
					<table style="width: 100%">
						<tbody><tr>
							<td width="10" style="padding: 7px 0">&nbsp;</td>
							<td style="padding: 7px 0">
								<font size="2" color="#555454">
									<p style="border-bottom: 1px solid rgba(214, 212, 212, 1); margin: 3px 0 7px; text-transform: uppercase; font-weight: 500; font-size: 18px; padding-bottom: 10px">
									{{ __('email.Delivery address') }}									</p>
									<span style="color: rgba(119, 119, 119, 1)">
									<span style="font-weight: bold">{{$arr['user']->firstname}} {{$arr['user']->lastname}}</span><br>{{$arr['order_address']->ship_full_address}}<br>{{$arr['order_address']->ship_zip_code}}<br>{{$arr['order_address']->ship_city}}<br>{{$arr['order_address']->ship_state}}<br>{{$arr['order_address']->ship_country}}<br>{{$arr['user']->mobile}}
									</span>
									
								</font>
							</td>
							<td width="10" style="padding: 7px 0">&nbsp;</td>
						</tr>
					</tbody></table>
				</td>
				<td width="20" style="padding: 7px 0">&nbsp;</td>
				<td width="310" style="border: 1px solid rgba(214, 212, 212, 1); background-color: rgba(248, 248, 248, 1); padding: 7px 0">
					<table style="width: 100%">
						<tbody><tr>
							<td width="10" style="padding: 7px 0">&nbsp;</td>
							<td style="padding: 7px 0">
								<font size="2" color="#555454">
									<p style="border-bottom: 1px solid rgba(214, 212, 212, 1); margin: 3px 0 7px; text-transform: uppercase; font-weight: 500; font-size: 18px; padding-bottom: 10px">
									{{ __('email.Billing address') }}									</p>
									<span style="color: rgba(119, 119, 119, 1)">
									<span style="font-weight: bold">{{$arr['user']->firstname}} {{$arr['user']->lastname}}</span><br>{{$arr['order_address']->bill_full_address}}<br>{{$arr['order_address']->bill_zip_code}}<br>{{$arr['order_address']->bill_city}}<br>{{$arr['order_address']->bill_state}}<br>{{$arr['order_address']->bill_country}}<br>{{$arr['user']->mobile}}
									</span>
									
								</font>
							</td>
							<td width="10" style="padding: 7px 0">&nbsp;</td>
						</tr>
					</tbody></table>
				</td>
			</tr>
		</tbody></table>
	</td>
</tr>
<tr>
	<td style="padding: 0 !important">&nbsp;</td>
</tr>

@if($getPaymenthod == 'bank_transfer')
<tr>
	<td style="padding: 7px 0">
		<font size="2" color="#555454">
			<span>
				@if($arr['order']->currency == 'chf')
				<b>{{ __('payment.Account Holder') }}:</b>
				<p>Orgena SA</p>
				<p>Stradon 116</p>
				<p>CH – 6557 Cama</p>
				<p>IDI: CHE-190.569.496</p>

				<b>{{ __('payment.Bank Information') }}:</b>
				<p>Postfinance AG</p>
				<p>Mingerstrasse 20</p>
				<p>3030 Bern</p>
				<p>IBAN: CH0309000000883775143</p>
				<p>BIC/SWIFFT: POFICHBEXXX</p>
				<p>Currency: CHF</p>
				@else
				<b>{{ __('payment.Account Holder') }}:</b>
				<p>Orgena SA</p>
				<p>Stradon 116</p>
				<p>CH – 6557 Cama</p>
				<p>IDI: CHE-190.569.496</p>

				<b>{{ __('payment.Bank Information') }}:</b>
				<p>Postfinance AG</p>
				<p>Mingerstrasse 20</p>
				<p>3030 Bern</p>
				<p>IBAN: CH3009000000155946991</p>
				<p>BIC/SWIFFT: POFICHBEXXX</p>
				<p>EuroSIC Clearing-Nr.: 090002</p>
				<p>Currency: EUR</p>

				@endif

		  </span>
		</font>
	</td>
</tr>
@endif

<tr>
	<td style="padding: 7px 0">
		<font size="2" color="#555454">
			<span>
			{{ __('email.You can review your order and download your invoice from the') }} <a href="{{url('user/orders')}}" style="color: rgba(51, 127, 241, 1)">{{ __('email.Order history') }}</a> {{ __('email.section of your customer account by clicking') }} <a href="{{url('user/account')}}" style="color: rgba(51, 127, 241, 1)"> {{ __('email.My account') }} </a>. </span>
		</font>
	</td>
</tr>
<tr>
	<td style="padding: 7px 0">
		<font size="2" color="#555454">
			<span>
			{{ __('email.If you have a guest account, you can follow your order via the') }} <a href="{{url('user/orders')}}" style="color: rgba(51, 127, 241, 1)">{{ __('email.Guest Tracking') }}</a> {{ __('email.section on CBD Logistics') }}.</span>
		</font>
	</td>
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