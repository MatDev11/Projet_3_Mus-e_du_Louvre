var $type = $('#commande_type_tarif'),
    $currentTime = new Date(),
    $time = $currentTime.getHours(),
    $date = $currentTime.toLocaleDateString(),
    $valinputDate = $('#commande_date_commande');

$(function () {
    //datepicker vue calendrier
    $('#datepicker').datepicker(
        {
            // beforeShowDay: $.datepicker.noWeekends,
            beforeShowDay: function (date) {

                if (date.getDay() == 0 || date.getDay() == 2) { // La semaine commence à 0 = Dimanche

                    return [false, ''];

                } else {

                    return [true, ''];

                }
            },

            dateFormat: 'dd/mm/yy',

            //Fr datepicker
            closeText: 'Fermer',
            prevText: 'Précédent',
            nextText: 'Suivant',
            currentText: 'Aujourd\'hui',
            monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
            dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
            dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
            dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
            weekHeader: 'Sem.',
            dateFormat: 'dd/mm/yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: '',//Fr datepicker

            minDate: 0//Saisie à partir du jj
        });

    CheckHeure();
    //MAJ du champ date
    $('#datepicker').change(function () {
        $('#commande_date_commande').val($('#datepicker').val());
        CheckHeure();

    });
});

//Validator pour la demis journee
function CheckHeure() {
    if ($time >= '14') {
        if ($valinputDate.val() === $date) {
            $type.prop("checked", true);
        }
        else {
            $type.prop("checked", false);
        }
    }

};






