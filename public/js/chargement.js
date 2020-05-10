//console.log('page de chargement activé');

// $('.cleanButton').modal('hide') 
//$('.cleanButton').modal('show');

$(document).ready(function () {

    $('.cleanButton').click(function () {
            var contenu = document.clean_options_form[0].value;
            if(contenu == ''){
                console.log('contenu vide');
            }
            else{
                console.log('contenu selectionné');
                $('#modal').modal('show');
            }
    });
});


