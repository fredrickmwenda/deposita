@extends('layouts.app')
@push('css')
    <!-- select2 css -->
	<link href="{{asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content') 
<div class="page-content">
	<div class="container-fluid">
	    <div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0 font-size-18">Create Cashier Record </h4>
				</div>
			</div>
		</div>                      
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">

						<h4 class="card-title">Cashier Record Information</h4>
						<form  id="transaction-form">
						<!-- method="POST" action="{{route('transaction.store')}}" novalidate -->
							@csrf
							<div class="row">
							    <div class="col-sm-6" id ="date-set">
								    <div class="mb-3">
										<label for="date">Date</label>
										<input type="date" class="form-control" id="date" name="date">
									</div>		
								</div>
								<div class="col-sm-6">
									<div class="mb-3">
										<label for="shift">Shift Type</label>

										<select class="form-control" name="shift" id="shift">
											<option>Select Shift</option>
											<option value="0"> Day Shift</option>
											<option value="1"> Night Shift</option>
										</select>
										
									</div>									
								</div>
								


	
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="mb-3">
										<label for="attendant">Attendant</label>

										<select class="form-control" name="attendant_id" id="attendant">
											<option value="">Select Attendant</option>
											@foreach($attendants as $attendant)
											  <option value="{{$attendant->id}}">{{$attendant->name}} </option>
											@endforeach
										</select>
										
									</div>									
								</div>
								
							</div>
							<div class="row">
								<div class="col-sm-2">
									<div class="mb-3">
										<label for="total">Total Drop</label>
										<input type="text" class="form-control" id="total" name="total" readonly>									
									</div>									
								</div>


								<div class="col-sm-2" id="cash-div">
									<div class="mb-3">
										<label for="cash"> Total Cash </label>
										<input type="number" class="form-control" id="cash" name="cash" value="0">
									</div>
								</div>



								<div class="col-sm-2" id="coin-amount-div">
									<div class="mb-3">
										<label for="amount">Total Coin</label>
										<input type="number" class="form-control" id="amount" name="amount"  value="0">
									</div>
								</div>

								<div class="col-sm-3">
								    <div class="mb-3">
										<label for="expected"> Expected</label>
										<input type="number" class="form-control" id="expected" name="expected">
									</div>									
								</div>

								<!--difference -->
								<div class="col-sm-3">
								    <div class="mb-3">
										<label for="difference"> Difference</label>
										<input type="text" class="form-control" id="difference" name="difference" readonly>
									</div>
								</div>
							</div>

							<div class="row mb-4">

								<div class="col-sm-12">
									<div class="mb-3">
										<label for="coin">Comment</label>
										<textarea class="form-control" name="comment" id="comment" cols="10" rows="3"></textarea>									
									</div>

									<div class="d-flex flex-wrap gap-2" style="float:left">
								<button type="button" class="btn btn-secondary waves-effect waves-light" id="add-button">Add </button>
							</div>
								</div>


							</div>


							<div class="d-flex flex-wrap gap-2" style="float:right">
								<button type="submit" class="btn btn-primary waves-effect waves-light" id="submit-button">Submit</button>
							</div>
						</form>

						<table class="table">
							<thead>
								<tr>
									<th>Shift </th>
									<th>Date</th>
									<th>Attendant ID</th>
									<th>Drop</th>
									<th>Coins</th>
									<th>Cash</th>
									<th>Expected</th>
									<th>Difference</th>									
									<th> Comment </th>								
									<th></th>
								</tr>
							</thead>
							<tbody id="transaction-table-body"></tbody>
						</table>

					</div>
				</div>


			</div>
		</div>
	</div>
</div>
@endsection

@push('js')
<script src="{{ asset('assets/libs/select2/js/select2.min.js')}}"></script>

<script>
	$('#attendant').select2();
</script>
<script>
	$(document).ready(function() {
		$("#add-coin").click(function(e) {
			e.preventDefault();
			$("#coin-type-div").show();
			$("#coin-amount-div").show();
		});
		$('#expected').on('keyup', calculateDifference);
		$('#amount').on('blur', calculateDifference);

		function calculateDifference() {
			var expected = $('#expected').val().trim(); // Trim whitespace from the input
			console.log(expected);
			console.log('This is expected');
			if (expected === '') {
				expected = 0;
			} else {
				
				// Use parseFloat to extract the numerical value
				expected = parseFloat(expected.replace(/,/g, ''));

				// Check if the result is a valid number (not NaN)
				if (isNaN(expected)) {
					// If the value is NaN, it means it contains invalid characters, so set it to 0
					expected = 0;
				}
			}


			var total = $('#total').val();
			total = parseFloat(total.replace(/,/g, ''));
			var coin = $('#amount').val();
			if (coin === '') {
				coin = 0;
			} else {
				coin = parseFloat(coin);
			}
			
			var cash = $('#cash').val();
			if (cash === '') {
				cash = 0;
			} else {
				cash = parseFloat(cash);
			}

			
			

			total_cash = total + cash;
			console.log(total_cash);
			console.log('This is total_cash');
			var difference = total_cash - expected + coin;
			$('#difference').val(difference.toLocaleString());

			if (difference < 0) {
				$('#difference').css('border', '1px solid red');
			} else {
				$('#difference').css('border', '1px solid green');
			}
		}


    });

	
	// <!--on select of an attendant get the total-->
	$(document).ready(function() {
		$('#attendant').change(function(){			
			var attendeeId = $(this).val();
			var shift = $("#shift").val();
			//console.log(attendeeId);
			//console.log(shift);
			var date = $("#date").val();
			console.log(date);
			$.ajax({
				url: "{{route('transaction.getAttendants')}}",
				type: 'GET',
				data: { 
					attendeeId: attendeeId,
					date: date,
					shift: shift	 
				},
				success: function(total) {
					var numericTotal = parseFloat(total);
					var formattedTotal = '';
					if (!isNaN(numericTotal)) {
						formattedTotal = numericTotal.toLocaleString();
					}
					//console.log(formattedTotal);
					$('#total').val(formattedTotal);
				}
			});
		});
	});

	$('#cancel_button').click(function() {
		$('#transaction-form').trigger("reset");
	});

	



</script>
<script src="{{ asset('assets/js/transaction.js')}}"></script>
@endpush
