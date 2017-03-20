var $type =$('#commande_type_tarif'),
    $prix =$('#commande_prix'),
    $tarifReduit =$('#visiteur_reduction'),
    $PrixHidden =$('#PrixHidden'),
    $DemiJourneeHidden =$('#demiJournee'),
    $QtePlaceHidden =$('#qtePlace'),
    $prixMaj =$('#visiteur_prix');

var $currentTime = new Date(),
    $time =  $currentTime.getHours() ,
    $date = $currentTime.toLocaleDateString(),
    $annee = $currentTime.getFullYear(),
    $mois  = $currentTime.getMonth() + 1,
    $jour  = $currentTime.getDate(),

    $valinputDate  = $('#commande_date_commande'),
    $JourNaissance = $('#visiteur_dateDeNaissance_day'),
    $MoisNaissance = $('#visiteur_dateDeNaissance_month'),
    $AnneeNaissance = $('#visiteur_dateDeNaissance_year');

var $inputNom = $('#visiteur_nom'),
    $inputPre = $('#visiteur_prenom'),
    $inputPays = $('#visiteur_pays');



$('.MsgTarifReduit').hide();//cache le message du tarif réduit


$( function()
{
    $tarifReduit.click(function() {

       if ($tarifReduit.is(':checked') == false )

       {
           $prixMaj.val($PrixHidden.val());

           $('.MsgTarifReduit').hide();
       }
       else {

           $prixMaj.val(DemiJour(10));

           $('.MsgTarifReduit').show();
        }
    })
})



$(function () {
    //datepicker vue calendrier
    $('#datepicker').datepicker(
        {
       // beforeShowDay: $.datepicker.noWeekends,
        dateFormat: 'dd/mm/yy',

            //Fr datepicker
            closeText: 'Fermer',
            prevText: 'Précédent',
            nextText: 'Suivant',
            currentText: 'Aujourd\'hui',
            monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
            monthNamesShort: ['Janv.','Févr.','Mars','Avril','Mai','Juin','Juil.','Août','Sept.','Oct.','Nov.','Déc.'],
            dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
            dayNamesShort: ['Dim.','Lun.','Mar.','Mer.','Jeu.','Ven.','Sam.'],
            dayNamesMin: ['D','L','M','M','J','V','S'],
            weekHeader: 'Sem.',
            dateFormat: 'dd/mm/yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: '',//Fr datepicker

       // minDate: 0,//Saisie à partir du jj
        });

        CheckHeure();
    //MAJ du champ date
    $('#datepicker').change(function()
    {
        $('#commande_date_commande').val($('#datepicker').val());
        CheckHeure();

    });
});

//Validator pour la demis journee
function CheckHeure()
{
    if( $time >= '14') {
        if ($valinputDate.val() === $date) {
            $type.prop("checked", true);
        }
        else {
            $type.prop("checked", false);
        }
    }

};


//affiche le calendrier lorsqu'on clic dans le champ date
/*
$(function () {

     $("form input.date").datepicker(
         {
            dateFormat: 'dd/mm/yy',
            firstDay: 1,
        }).attr("readonly", "readonly");
    $( "#date" ).datepicker( "hide" );

        CheckHeure();

    $valinputDate.change(function()
    {

        CheckHeure();

    });

    $.datepicker.regional['fr'] =
        {
        closeText: 'Fermer',
        prevText: 'Précédent',
        nextText: 'Suivant',
        currentText: 'Aujourd\'hui',
        monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
        monthNamesShort: ['Janv.','Févr.','Mars','Avril','Mai','Juin','Juil.','Août','Sept.','Oct.','Nov.','Déc.'],
        dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
        dayNamesShort: ['Dim.','Lun.','Mar.','Mer.','Jeu.','Ven.','Sam.'],
        dayNamesMin: ['D','L','M','M','J','V','S'],
        weekHeader: 'Sem.',
        dateFormat: 'dd/mm/yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
        };
    $.datepicker.setDefaults($.datepicker.regional['fr']);

});*/

//Selection de la demis journee
$( function()
{
    $('#commande_type_tarif').click(function() {


        if ($type.is(':checked') == false) {
            $prix.val("16");
        }
        else {
            $prix.val(($prix.val())/2);
        }
    })
});




