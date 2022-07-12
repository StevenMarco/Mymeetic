// $('document').ready(function()
// {
//     alert('jQuery prêt à vous aider !');
// });

$(document).ready(() =>
{
    $(".comment-form").on('submit', function(e)
    {
        e.preventDefault();

        let url = 'save.php';
        let data = $(this).serialize();
        $.post(url, data, function(reponse)
        {
            $('.form-loader').hide();
            $('.status').text("Envoyer"); 
            $('#pseudo,#email,#message').val(' '); 

            $('.comment').prepend(reponse);
        });

        $('.form-loader').show();
        $('.status').text("En cours d'envoi...");
    })
})