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

$(document).ready(function() {



    //affiche plusieurs formulaire
    /*    var nbre = $QtePlaceHidden.val();
     for(var i=2;i<=nbre;i++)
     {
     var $copie = $('#test').clone();
     $copie.find('.numBillet').html(i)
     $copie.find($inputNom).replaceWith($inputNom.attr('id', 'visiteur_nom-'+i+''))
     $copie.find($inputPre).replaceWith($inputPre.attr('id', 'visiteur_prenom-'+i+''))
     $copie.find($JourNaissance).replaceWith($JourNaissance.attr('id', 'visiteur_dateDeNaissance_day-'+i+''))
     $copie.find($MoisNaissance).replaceWith($MoisNaissance.attr('id', 'visiteur_dateDeNaissance_month-'+i+''))
     $copie.find($AnneeNaissance).replaceWith($AnneeNaissance.attr('id', 'visiteur_dateDeNaissance_year-'+i+''))
     $copie.find($inputPays).replaceWith($inputPays.attr('id', 'visiteur_dateDeNaissance_year-'+i+''))
     $copie.find($tarifReduit).replaceWith($inputPre.attr('id', 'visiteur_pays-'+i+''))
     $copie.find($prixMaj).replaceWith($prixMaj.attr('id', 'visiteur_prix-'+i+''))
     $copie.appendTo('#ajout');
     console.log(i);

     }*/
    // for (var i=1; i<= $QtePlaceHidden.val(); i++) {

    //   console.log(i);
    //  }


});

$('#add_Test').click(function(){

console.log('ok');

    var $container = $('#Billet_visiteur');
    var index = $container.find(':input').length;

    var template = $container.attr('data-prototype')

            .replace(/__visiteur__/g,index)
        ;

    // On crée un objet jquery qui contient ce template
    var $prototype = $(template);

    // On ajoute au prototype un lien pour pouvoir supprimer la catégorie
    addDeleteLink($prototype);

    // On ajoute le prototype modifié à la fin de la balise <div>
    $container.append($prototype);

    // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
        index++;

   /* var $container = $('#test'),
        index = $container.find(':input').length;

    addCategory($container);
// La fonction qui ajoute un formulaire CategoryType
    function addCategory($container) {
        // Dans le contenu de l'attribut « data-prototype », on remplace :
        // - le texte "__name__label__" qu'il contient par le label du champ
        // - le texte "__name__" qu'il contient par le numéro du champ
        var template = $inputNom.attr('id')
                .replace('id', 'id' + (index+1))


            ;

        // On crée un objet jquery qui contient ce template
        var $prototype = $(template);



        // On ajoute le prototype modifié à la fin de la balise <div>
        $container.append($prototype);

        // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
        index++;
    }*/
});



$JourNaissance.change(function()

{


    var $dateNaissance =new Date($MoisNaissance.val()+'/'+$JourNaissance.val()+'/'+$AnneeNaissance.val()),
         $start= $dateNaissance,
        //var $end= $currentTime,
        // var $end= new Date("02-02-2020") ,
        $end= new Date($jour+"/"+$mois+"/"+$annee) ,
        $days = ($end- $start)/ (1000 * 60 * 60 * 24)/365.2425  ;   //alert($days+'----'+$end+'-----'+$dateNaissance);

    if($days >= '60') {


       $prixMaj.val( DemiJour(12));
        $tarifReduit.prop("disabled", true);
    }
    else if($days < '60' && $days >= '12' )
    {
        alert('-60 +12');
        $prixMaj.val(DemiJour(16));
        $tarifReduit.prop("disabled", false);

    }
    else if($days < '12' && $days>= '4' )
    {
        alert('-12 +4');
        $prixMaj.val(DemiJour(8));
        $tarifReduit.prop("disabled", true);

    }

    else
    {
        alert('-4');
        $prixMaj.val(DemiJour(0));
        $tarifReduit.prop("disabled", true);

    }
});

function DemiJour(nombre)
{
    if ( $DemiJourneeHidden.val() == '1' )

    {

        return nombre/2;

    }
    else
    {

        return nombre;
    }
};

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
            $type.prop("disabled", true);
            $prix.val("8");
        }
        else {
            $type.prop("checked", false);
            $type.prop("disabled", false);
            $prix.val("16");
        }
    }


    if ($type.is(':checked') == false) {
        $prix.val("16");
    }
    else {
        $prix.val("8");
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




