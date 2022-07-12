        $(".profil_form").on('submit', function(e)
        {
            e.preventDefault();
            //let search = document.

            let url = '../model/profil/search.php';
            let xhttp = new XMLHttpRequest();
            xhttp.onload = function() 
            {

                console.log(this.responseText);
            } 
            xhttp.open("get", url, true);
            xhttp.send();
            console.log(url);
        })

    // function loadDoc() 
    // {
    //     e.preventDefault();
    //     let url = '../model/profil/search.php';
    //     console.log(url);
        // let xhttp = new XMLHttpRequest();
        // xhttp.onload = function() 
        // {
        //     console.log(this.responseText);
        // } 
        // xhttp.open("POST", "");
        // xhttp.send();
//    }

//     $(document).ready(() =>
// {
//     $(".comment-form").on('submit', function(e)
//     {
//         e.preventDefault();

//         let url = 'save.php';
//         let data = $(this).serialize();
//         $.post(url, data, function(reponse)
//         {
//             $('.form-loader').hide();
//             $('.status').text("Envoyer"); 
//             $('#pseudo,#email,#message').val(' '); 

//             $('.comment').prepend(reponse);
//         });

//         $('.form-loader').show();
//         $('.status').text("En cours d'envoi...");
//     })
// })