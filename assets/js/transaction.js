$(document).ready(function() {
    // Retrieve transaction data from localstorage
    let transactions = localStorage.getItem('transactions');
    transactions = transactions ? JSON.parse(transactions) : [];

    // Add event listener to Add button
    $('#add-button').click(function() {
        // Retrieve form data
        let shiftValue = $('#shift').val();
        let formData = {
            shift: shiftValue === '1' ? 'Night' : 'Day',
            date: $('#date').val(),
            //shift: $('#shift').val(),
            // date: ($('#shift').val() == 1) ? $('#start-day').val() : $('#date').val(),
            attendant_id: $('#attendant').val(),
            total_drop: $('#total').val(),
            expected: $('#expected').val(),
            difference: $('#difference').val(),
            total_coins: $('#amount').val(),
        };

        // Add form data to transactions array
        transactions.push(formData);
    
        // Save transactions array to localstorage
        localStorage.setItem('transactions', JSON.stringify(transactions));

        let attendantName = '';
        $.ajax({
            url: '/attendants/' + formData.attendant_id,
            type: 'GET',
            dataType: 'json',
            async: false,
            success: function(response) {
                console.log(response);
                attendantName = response.card_name;
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
        
    
        // Add new row to transaction table
        let newRow = $('<tr>');
        newRow.append($('<td>').text(formData.shift));
        newRow.append($('<td>').text(formData.date));
        newRow.append($('<td>').text(attendantName));
        newRow.append($('<td>').text(formData.total_drop));
        newRow.append($('<td>').text(formData.expected));
        newRow.append($('<td>').text(formData.difference));
        newRow.append($('<td>').text(formData.total_coins));
        newRow.append($('<td>').html('<button type="button" class="btn btn-danger btn-sm delete-button">Delete</button>'));
        $('#transaction-table-body').append(newRow);
    
        // Clear form inputs
        // $('#shift').val('');
        // $('#date').val('');
        $('#attendant option:selected').remove();
        $('#total').val('');
        $('#expected').val('');
        $('#difference').val('');
        $('#amount').val('0');
    });
    
    // Add event listener to Delete buttons
    $(document).on('click', '.delete-button', function() {
        let index = $(this).closest('tr').index();
        transactions.splice(index, 1);
        localStorage.setItem('transactions', JSON.stringify(transactions));
        $(this).closest('tr').remove();
    });
    
    // Add event listener to Submit button
    $('#submit-button').click(function() {
        $('#transaction-form').submit();
    });
    
    // Handle form submission
    $('#transaction-form').submit(function(event) {
        event.preventDefault();
        if (transactions.length === 0) {
            toastr.error('No transaction data available.');
            return;
        }
        let csrfToken = $('meta[name="csrf-token"]').attr('content');
        let formData = {
            transactions: transactions
        };
        formData._token = csrfToken;
        console.log(transactions);
        $.ajax({
            url: '/transaction/store',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Clear localstorage and transaction table
                    localStorage.removeItem('transactions');
                    $('#transaction-table-body').empty();
    
                    // Display success message
                    // alert(response.message);
                    toastr.success(response.message);
                    
                } else {
                    // alert('');
                    toastr.error('Failed to save transactions.');
                }
            },
            error: function(xhr, status, error) {
                console.log('error');
                toastr.error(error);
            }
        });
    });

});
    