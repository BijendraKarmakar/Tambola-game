$(document).ready(function(){
    jQuery('#generate').click(function(e){
        //e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            }
        });
        $.ajax({
            url: '/getTickets',
            method: 'post',
            data: {
                'clicked': 1
            },
            success: function(result){
                $('.ticket-list >div').html(result);
//                console.log(result);
            },
            error: function(result){
                console.log(result);
            }
        });
    });
});