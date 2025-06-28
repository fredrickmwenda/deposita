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
					<h4 class="mb-sm-0 font-size-18">Edit Cashier Record </h4>

				</div>
			</div>
		</div>                      
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">

						<!-- <h4 class="card-title">Transaction Information</h4> -->
						<form class="needs-validation" method="POST" action="{{route('transaction.update', $transaction->id )}}" novalidate id="transact_edit_form">
							@csrf
							<div class="row">
								<div class="col-sm-6">
									<div class="mb-3">
									    <label for="attendant">Attendant </label>
										<select id="attendant_name"name="attendant_id" id="attendant" class="form-control select2" required disabled>
											<option value="">Select Attendant</option>
											@foreach($attendants as $attendant)
												<option value="{{$attendant->id}}" {{ $transaction->attendant_id == $attendant->id  ? 'selected' : '' }}>{{$attendant->name}}</option>
											@endforeach
										</select>
										<!-- <input type="text" class="form-control"  required  value="{{ $transaction->attendant->name }}" readonly> -->
										
									</div>									
								</div>
								
								<div class="col-sm-6">
									<div class="mb-3">
										<label for="date">Date</label>
										<input type="date" class="form-control" id="date" name="date" required value="{{$transaction->date}}" readonly>
									</div>									
								</div>
							</div>

							
							<div class="row">
								<div class="col-sm-2">
									<div class="mb-3">
										<label for="total">Total Drop</label>
										<input type="text" class="form-control" id="total" name="total" required readonly value="{{number_format($transaction->total) }}">									
									</div>									
								</div>

								<div class="col-sm-2">
									<div class="mb-3">
										<label for="cash">Total Cash</label>
										   <input type="text" class="form-control" id="cash" name="cash" required value="{{ number_format(floatval($transaction->cash ?? 0), 2) }}">

										<!-- <input type="text" class="form-control" id="cash" name="cash" required  value="{{number_format($transaction->cash ?? 0) }}">									 -->
									</div>									
								</div>

								<div class="col-sm-2">
									<div class="mb-3">
										<label for="coins"> Coin</label>
										<input type="number" class="form-control" id="coins" name="coins" required value="{{number_format($transaction->coins ?? 0)}}" >
									</div>									
								</div>
                            <!-- </div>
							<div class="row"> -->
								<div class="col-sm-2">
									<div class="mb-3">
										<label for="recovery"> Recovery</label>
										<input type="number" class="form-control" id="recovery" name="recovery" required value="{{ number_format($transaction->recoveries()->sum('recovery_amount') ?? 0)  }}" readonly>
									</div>
								</div>

								<div class="col-sm-2">
									<div class="mb-3">
										<label for="expected"> Expected</label>
										<input type="text" class="form-control" id="expected" name="expected" required value="{{ number_format(intval($transaction->expected)) }}">
									</div>									
								</div>


								

								<!--difference -->
								<div class="col-sm-2">
									<div class="mb-3">
										<label for="difference"> Difference</label>
										<input type="text" class="form-control" id="difference" name="difference" required  value="{{$transaction->difference}}"readonly>
									</div>
								</div>

							</div>
	
							<div class="row mb-4">

								<div class="col-sm-12">
									<div class="mb-3">
										<label for="coin">Comment</label>
										<textarea class="form-control" name="comment" id="comment" cols="10" rows="3">{{$transaction->comment}}</textarea>									
									</div>
								</div>


							</div>

							<div class="d-flex flex-wrap gap-2" style="float:right">
								<button type="submit" class="btn btn-primary waves-effect waves-light" id="submit_edit">Submit</button>
								<a href="{{ route('storage.list')}}" type="button" class="btn btn-secondary waves-effect waves-light">Cancel</a>
								<!-- <button type="button" class="btn btn-secondary waves-effect waves-light" id="cancel_button">Cancel</button> -->
							</div>
						</form>
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
	$(".select2").select2();
</script>



<script>
	$(document).ready(function() {
		// var previousRecoveryValue = {{ $transaction->recovery ?? 'null' }};
		$("#add-coin").click(function(e) {
			e.preventDefault();
			$("#coin-type-div").show();
			$("#coin-amount-div").show();
		});

		$('#cash').on('keyup', function(){
			var cash = $(this).val();
			if (cash.includes(',')) {
			 cash = parseFloat(cash.replace(/,/g, ''));
			} else {
			 cash = parseFloat(cash);
			}
			console.log(cash);
			var total = $('#total').val();
			total = parseFloat(total.replace(/,/g, ''));
			var coins = $('#coins').val();
			coins = parseFloat(coins);
			// console.log(coins);
			
			var recovery = $('#recovery').val();
			recovery = parseFloat(recovery);

			var expected = $('#expected').val();
			expected = parseFloat(expected.replace(/,/g, ''));


			total_cash = total + cash;
			console.log(total_cash)
			
			var difference = total_cash +recovery+coins - expected;
			console.log(difference);
			$('#difference').val(difference.toLocaleString());
			//if the value is negative, soround the input with red border
			//if the value is positive, soround the input with green border
			if (difference < 0) {
				$('#difference').css('border', '1px solid red');
			}
			else {
				$('#difference').css('border', '1px solid green');
			}
		});
		
		$('#coins').on('keyup', function(){
			var coins = $(this).val();
			coins = parseFloat(coins);
			// console.log(coins);
			var expected = $('#expected').val();
			expected = parseFloat(expected.replace(/,/g, ''));	
			var total = $('#total').val();
			total = parseFloat(total.replace(/,/g, ''));
		    // var total = $('#transaction_total').text();
			//console.log(total);

			
			var recovery = $('#recovery').val();
			recovery = parseFloat(recovery);

			var cash = $('#cash').val();
			if (cash.includes(',')) {
			 cash = parseFloat(cash.replace(/,/g, ''));
			} else {
			 cash = parseFloat(cash);
			}
			total_cash = total + cash;
			console.log(total_cash);
			
			var difference = total_cash +coins - expected;
			// console.log(difference);
			$('#difference').val(difference.toLocaleString());
			//if the value is negative, soround the input with red border
			//if the value is positive, soround the input with green border
			if (difference < 0) {
				$('#difference').css('border', '1px solid red');
			}
			else {
				$('#difference').css('border', '1px solid green');
			}
		});
		$('#expected').on('keyup', function(){
			var expected = $(this).val();
			expected = parseFloat(expected.replace(/,/g, ''));	
			var total = $('#total').val();
			total = parseFloat(total.replace(/,/g, ''));
		    // var total = $('#transaction_total').text();
			console.log(total);
			var coins = $('#coins').val();
			coins = parseFloat(coins);
			console.log(coins);
			
			var recovery = $('#recovery').val();
			recovery = parseFloat(recovery);

			var cash = $('#cash').val();
			if (cash.includes(',')) {
			   cash = parseFloat(cash.replace(/,/g, ''));
			} else {
			    cash = parseFloat(cash);
			}
			total_cash = total + cash;
			
			var difference = total_cash +recovery+coins - expected;
			console.log(difference);
			$('#difference').val(difference.toLocaleString());
			//if the value is negative, soround the input with red border
			//if the value is positive, soround the input with green border
			if (difference < 0) {
				$('#difference').css('border', '1px solid red');
			}
			else {
				$('#difference').css('border', '1px solid green');
			}
		});
		$('#submit_edit').click(function() {
			$('#transact_edit_form').submit();
	    });
    });
	// <!--on choose ose of the shift and date, get the attendants name of that shift and date -->
	$("#shift").change(function() {
		var shift = $(this).val();
		
		setTimeout(function() {
			console.log(shift);
			var date = $("#date").val();
			console.log(date);
			$.ajax({
				url: "{{route('transaction.getAttendants')}}",
				type: "GET",
				data: {
					shift: shift,
					date: date
				},
				success: function(data) {
					// append them on select tag
					$("#attendant").empty();
					if ($.isEmptyObject(data)) {
						// Add an empty option with a message if the response is empty
						var option = new Option('No attendants found', '');
						$('#attendant').append(option);
					} 
					else {
						$("#attendant").append('<option>Select Attendant</option>');
						console.log(data);
						// 25: 'IBRAHIM HASSAN', 26: 'IBRAHIM HASSAN', 27: 'VINCENT PILI', 28: 'JESSE NJUGUNA', 29: 'YOSUF M MOHAMED', 30: 'WALID ABDULLAHI', 31: 'TALSAN OMAR', 32: 'TALSAN OMAR', 33: 'IBRAHIM HASSAN', 34: 'TALSAN OMAR', 35: 'JACKSON MUTHAMA', 36: 'TALSAN OMAR', 37: 'VINCENT PILI', 38: 'VINCENT PILI', 39: 'JESSY NJOROGE', 40: 'JESSY NJOROGE', 41: 'IBRAHIM HASSAN', 42: 'JACKSON MUTHAMA', 43: 'JESSE NJUGUNA', 44: 'MATHEW RONO'
						$.each(data.attendantsData, function(key, value) {										
							$("#attendant").append('<option value="' + key + '">' + value + '</option>');
						});
						// $.each(data.attendantsData, function(id, name) {
						// 	var option = new Option(name, id);
						// 	$('#attendant').append(option);
						// });
					}
					// Refresh the Select2 dropdown
					$('#attendant').select2();
				},
				error: function(error) {
					console.log(error);
				}
		    });
			
		}, 5000);

	});
	// <!--on select of an attendant get the total-->
	$(document).ready(function() {
		$('#attendant').change(function(){
			
			var attendeeId = $(this).val();
			var date = $("#date").val();
			//get value of selected shift
			var shift = $("#shift").val();
			console.log(attendeeId);
            console.log(date);
			console.log(shift);
			$.ajax({
				url: '/getTotalForAttendee',
				type: 'GET',
				data: { 
					attendeeId: attendeeId,
					date: date,
					shift: shift	 
				},
				success: function(total) {
				console.log(total);
				$('#total').val(total);
				}
			});
			// getTotalForAttendee(attendeeId, date, shift);
		});
	});
	// function getTotalForAttendee(attendeeId, date, shift) {
	// 	$.ajax({
	// 		url: '/getTotalForAttendee',
	// 		type: 'GET',
	// 		data: { 
	// 			attendeeId: attendeeId,
	// 			date: date,
	// 			shift: shift	 
	// 		},
	// 		success: function(total) {
	// 		console.log(total);
	// 		$('#total').val(total);
	// 		}
	// 	});
	// }
	// on click of the cancel button, clear the form
	$('#cancel_button').click(function() {
		$('#transaction-form').trigger("reset");
	});
	// differnce is total - expected
	// $(document).ready(function() {

	// });
</script>
@endpush
