$.ajaxSetup({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
});

$('#loginForm').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        method: 'post',
        url: '/verify-sign-in',
        data: $('#loginForm').serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.status_code == 0) {
                window.location.href = "{{route('dashboard')}}";
            } else {
                $('#error').html('<div>' + response.msg + '</div>');
            }
        },
        error: function(xhr, status, error) {
            console.log(error); 
            alert(xhr.responseJSON.message);
            // if (xhr.responseJSON && xhr.responseJSON.message === 'Too many failed login attempts.') {
            //     // Redirect to the sign-in page with an error message
            //     // window.location.href = "/sign-in";
            //     alert("Error")
            // } else {
            //     console.log(error); // Displaying the error in the console for debugging
            // }
        }
    });
});

// $.ajaxSetup({
//     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
// });

// $('#loginForm').on('submit', function(e) {
//     e.preventDefault();

//     $.ajax({
//         method: 'post',
//         url: '/verify-sign-in',
//         data: $('#loginForm').serialize(),
//         dataType: 'json',
//         success: function(response) {
//             if (response.status_code == 0) {
//                 window.location.href = "/dashboard";
//             } else {
//                 $('#error').html('<div>' + response.msg + '</div>');
//             }
//         },
//         error: function(xhr, status, error) {
//             console.log(error); 
//             if (xhr.responseJSON && xhr.responseJSON.message.startsWith('Too many login attempts')) {
//                 alert(xhr.responseJSON.message);
//             } else {
//                 console.log(error); // Displaying the error in the console for debugging
//             }
//             // alert(xhr.responseText);
//         }
       
//     });
// });

