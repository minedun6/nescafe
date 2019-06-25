

/////////////////////////////////////Datatable initialisation/////////////////////////////////////////
$.extend( true, $.fn.dataTable.defaults, {
    "oLanguage": {
        "sProcessing":     "Traitement en cours...",
        "sSearch":         "Rechercher&nbsp;:",
        "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
        "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
        "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
        "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        "sInfoPostFix":    "",
        "sLoadingRecords": "Chargement en cours...",
        "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
        "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
        "oPaginate": {
            "sFirst":      "Premier",
            "sPrevious":   "Pr&eacute;c&eacute;dent",
            "sNext":       "Suivant",
            "sLast":       "Dernier"
        },
        "oAria": {
            "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
            "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
        }
    },
    responsive: true,

    //"ordering": false, disable column ordering
    //"paging": false, disable pagination

    "order": [
        [0, 'asc']
    ],

    "lengthMenu": [
        [5, 10, 15, 20, -1],
        [5, 10, 15, 20, "All"] // change per page values here
    ],
    // set the initial value
    "pageLength": 10,

    "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
} );
///////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////Datepicker initialisation/////////////////////////////////////////

    $.fn.datepicker.dates.fr={
        days:["dimanche","lundi","mardi","mercredi","jeudi","vendredi","samedi","dimanche"],
        daysShort:["dim.","lun.","mar.","mer.","jeu.","ven.","sam.","dim."],
        daysMin:["d","l","ma","me","j","v","s","d"],
        months:["janvier","février","mars","avril","mai","juin","juillet","août","septembre","octobre","novembre","décembre"],
        monthsShort:["janv.","févr.","mars","avril","mai","juin","juil.","août","sept.","oct.","nov.","déc."],
        today:"Aujourd'hui",
        clear:"Effacer",
        weekStart:1,
        format:"dd/mm/yyyy"
    }


$.fn.datepicker.defaults.language = 'fr';
////////////////////////////////////////////////////////////////////////////////////////////////////////
$.fn.fileinputLocales['fr'] = {
    fileSingle: 'fichier',
    filePlural: 'fichiers',
    browseLabel: 'Parcourir&hellip;',
    removeLabel: 'Retirer',
    removeTitle: 'Retirer les fichiers sélectionnés',
    cancelLabel: 'Annuler',
    cancelTitle: "Annuler l'envoi en cours",
    uploadLabel: 'Transférer',
    uploadTitle: 'Transférer les fichiers sélectionnés',
    msgNo: 'Non',
    msgCancelled: 'Annulé',
    msgZoomTitle: 'Voir les détails',
    msgZoomModalHeading: 'Aperçu détaillé',
    msgSizeTooLarge: 'Le fichier "{name}" (<b>{size} Ko</b>) dépasse la taille maximale autorisée qui est de <b>{maxSize} Ko</b>.',
    msgFilesTooLess: 'Vous devez sélectionner au moins <b>{n}</b> {files} à transmettre.',
    msgFilesTooMany: 'Le nombre de fichier sélectionné <b>({n})</b> dépasse la quantité maximale autorisée qui est de <b>{m}</b>.',
    msgFileNotFound: 'Le fichier "{name}" est introuvable !',
    msgFileSecured: "Des restrictions de sécurité vous empêchent d'accéder au fichier \"{name}\".",
    msgFileNotReadable: 'Le fichier "{name}" est illisble.',
    msgFilePreviewAborted: 'Prévisualisation du fichier "{name}" annulée.',
    msgFilePreviewError: 'Une erreur est survenue lors de la lecture du fichier "{name}".',
    msgInvalidFileType: 'Type de document invalide pour "{name}". Seulement les documents de type "{types}" sont autorisés.',
    msgInvalidFileExtension: 'Extension invalide pour le fichier "{name}". Seules les extensions "{extensions}" sont autorisées.',
    msgUploadAborted: 'Le téléchargement du fichier a été interrompu',
    msgValidationError: 'Erreur de validation',
    msgLoading: 'Transmission du fichier {index} sur {files}&hellip;',
    msgProgress: 'Transmission du fichier {index} sur {files} - {name} - {percent}% faits.',
    msgSelected: '{n} {files} sélectionné(s)',
    msgFoldersNotAllowed: 'Glissez et déposez uniquement des fichiers ! {n} répertoire(s) exclu(s).',
    msgImageWidthSmall: 'Largeur de fichier image "{name}" doit être d\'au moins {size} px.',
    msgImageHeightSmall: 'Hauteur de fichier image "{name}" doit être d\'au moins {size} px.',
    msgImageWidthLarge: 'Largeur de fichier image "{name}" ne peut pas dépasser {size} px.',
    msgImageHeightLarge: 'Hauteur de fichier image "{name}" ne peut pas dépasser {size} px.',
    msgImageResizeError: "Impossible d'obtenir les dimensions de l'image à redimensionner.",
    msgImageResizeException: "Erreur lors du redimensionnement de l'image.<pre>{errors}</pre>",
    dropZoneTitle: 'Glissez et déposez les fichiers ici&hellip;',
    fileActionSettings: {
        removeTitle: 'Supprimer le fichier',
        uploadTitle: 'Télécharger un fichier',
        indicatorNewTitle: 'Pas encore téléchargé',
        indicatorSuccessTitle: 'Posté',
        indicatorErrorTitle: 'Ajouter erreur',
        indicatorLoadingTitle: 'ajout ...'
    }
};

jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "date-eu-pre": function ( date ) {
        date = date.replace(" ", "");

        if ( ! date ) {
            return 0;
        }

        var year;
        var eu_date = date.split(/[\.\-\/]/);

        /*year (optional)*/
        if ( eu_date[2] ) {
            year = eu_date[2];
        }
        else {
            year = 0;
        }

        /*month*/
        var month = eu_date[1];
        if ( month.length == 1 ) {
            month = 0+month;
        }

        /*day*/
        var day = eu_date[0];
        if ( day.length == 1 ) {
            day = 0+day;
        }

        return (year + month + day) * 1;
    },

    "date-eu-asc": function ( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },

    "date-eu-desc": function ( a, b ) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    },
    "num-doss-pre": function(num){


        num = num.substring((num.length-8),(num.length));
        var num2=num.replace("-","");
        num2=parseInt(num2);
        console.log(num);
        return num2;
    },
    "num-doss-asc": function ( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },

    "num-doss-desc": function ( a, b ) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    },
} );

//////////////////////////////////////

// ECHARTS

