<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Invoice</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
	.invoiceDataContainer
	{
		width: 70%;
		height: auto;
		margin: 0 auto;
		background-color: #b3b3b3;
		border: 2px solid;
		border-radius: 25px;
	}
	.invoiceLabel
	{
		display: inline-block;
		text-align: left;
		width: 30%;
		padding-left: 10px;
		font-weight: 500;
	}
	.invoiceData
	{
		display: inline-block;
		padding: 7px;
		text-align: left;
		width: 50%;
	}
	.invoiceTable
	{
		width: 100%;
		margin: 0 auto;
	}
	.invoiceTable td
	{
		text-align: center;
	}
	h2
	{
		text-align: center;
	}
	.contact
	{
		text-align: center;
	}
	p
	{
		font-weight: 600;
	}

	</style>
</head>

<body>
<h2>Belle-Idee Invoice</h2>
<div class="invoiceDataContainer">
	<div class = "invoiceLabel">
		To:
	</div>
	<div class = "invoiceData">
		{{ $billable->getBillableName() }}
	</div>
	<div class = "invoiceLabel">
		Date:
	</div>
	<div class = "invoiceData">
		{{ $invoice->date()->toFormattedDateString() }}
	</div>
	<div class = "invoiceLabel">
		Product:
	</div>
	<!-- Invoice Info -->
	<div class = "invoiceData">
		{{ $product }}
	</div>
	<div class = "invoiceLabel">
		Invoice Number:
	</div>
	<div class = "invoiceData">
		{{ $invoice->id }}
	</div>
	<!-- Extra / VAT Information -->
	@if (isset($vat))
		<div class = "invoiceLabel">
			VAT:
		</div>
		<div class = "invoiceData">
			{{ $vat }}
		</div>
	@endif
	<!-- Invoice Table -->
<hr/>
		<table class = "invoiceTable">
		<tr>
			<th>Description</th>
			<th>Date</th>
			<th>Amount</th>
		</tr>

		<!-- Display The Invoice Items -->
		@foreach ($invoice->invoiceItems() as $item)
			<tr>
				<td colspan="2">{{ $item->description }}</td>
				<td>{{ $item->dollars() }}</td>
			</tr>
			@endforeach

					<!-- Display The Subscriptions -->
			@foreach ($invoice->subscriptions() as $subscription)
				<tr>
					<td>Subscription ({{ $subscription->quantity }})</td>
					<td>{{ $subscription->startDateString() }} - {{ $subscription->endDateString() }}</td>
					<td>{{ $subscription->dollars() }}</td>
				</tr>
				@endforeach

						<!-- Display The Discount -->
				@if ($invoice->hasDiscount())
					<tr>
						@if ($invoice->discountIsPercentage())
							<td>{{ $invoice->coupon() }} ({{ $invoice->percentOff() }}% Off)</td>
						@else
							<td>{{ $invoice->coupon() }} (${{ $invoice->amountOff() }} Off)</td>
						@endif
						<td>&nbsp;</td>
						<td>-${{ $invoice->discount() }}</td>
					</tr>
					@endif

							<!-- Existing Balance -->
					@if (isset($invoice->starting_balance))
						<tr>
							<td>Starting Balance</td>
							<td>&nbsp;</td>
							<td>{{ $invoice->startingBalanceWithCurrency() }}</td>
						</tr>
						@endif

								<!-- Display The Final Total -->
						<tr style="border-top:2px solid #000000;">
							<td>&nbsp;</td>
							<td style = "text-align:right"><strong>Total</strong></td>
							<td><strong>{{ $invoice->dollars() }}</strong></td>
						</tr>
		</table>
	<hr/>
</div>
<div class = "contact">
	<p>Contact Us</p>
	<div class = "contact">
		Tre-Uniti LLC
	</div>
	<div class = "contact">
		PO Box 888
	</div>
	<div class = "contact">
		Sedro Woolley, WA 98284
	</div>
	<div class = "contact">
		tre-uniti@belle-idee.org
	</div>
	<div class = "contact">
		https://tre-uniti.org
	</div>
</div>
</body>
</html>
