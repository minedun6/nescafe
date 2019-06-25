jQuery(document).ready(function() {
    var form1 = $('#ilv_form');
    var error1 = $('.alert-danger', form1);
    var success1 = $('.alert-success', form1);

    form1.validate({
        errorElement: 'span',
        errorClass: 'help-block help-block-error',
        focusInvalid: false,
        ignore: "",
        messages: {
            name: {
                minlength: 'Le nom est trop court',
                required: 'Veuillez saisir un nom'
            },
            picture: {
                required: 'Un fichier est obligatoire'

            },
            network_type: {
                require_from_group: 'Veuillez choisir un type de réseau ou un cible'
            },
            target: {
                require_from_group: 'Veuillez choisir un type de réseau ou un cible'

            }


        },
        rules: {
            name: {
                minlength: 2,
                required: true
            },
            picture: {
                required: true

            },
            network_type: {
                require_from_group: [1, ".select"]
            },
            target: {
                require_from_group: [1, ".select"]
            }
        },


        invalidHandler: function(event, validator) {
            success1.hide();
            error1.show();
            App.scrollTo(error1, -200);
        },

        errorPlacement: function(error, element) {
            if (element.is(':checkbox')) {
                error.insertAfter(element.closest(".md-checkbox-list, .md-checkbox-inline, .checkbox-list, .checkbox-inline"));
            } else if (element.is(':radio')) {
                error.insertAfter(element.closest(".fileinput, .fileinput-new"));
            } else if (element.is(':file')) {
                error.insertAfter(element.closest(".fileinput, .fileinput-new"));
            } else {
                error.insertAfter(element);
            }

        },

        highlight: function(element) {
            $(element)
                .closest('.form-group').removeClass('has-info')
                .closest('.form-group').addClass('has-error');
        },

        unhighlight: function(element) {
            $(element)
                .closest('.form-group').removeClass('has-error')
                .closest('.form-group').addClass('has-success');
        },

        success: function(label) {
            label
                .closest('.form-group').removeClass('has-error')
                .closest('.form-group').addClass('has-success');
        },

        submitHandler: function(form) {
            success1.show();
            error1.hide();

            return true;


        }

    });
    ////////////////////////////////////////////////////////////////////////////
    var form2 = $('#note_form');
    form2.validate({
        errorElement: 'span',
        errorClass: 'help-block help-block-error',
        focusInvalid: false,
        ignore: "",
        messages: {
            object: {
                minlength: 'L"objet est trop court',
                required: 'Veuillez saisir un objet'
            },
            note: {
                minlength: 'La note est trop court',
                required: 'Veuillez saisir une note'

            }
        },
        rules: {
            object: {
                minlength: 2,
                required: true
            },
            note: {
                required: true,
                minlength: 20
            }
        },
        invalidHandler: function(event, validator) {
            success1.hide();
            error1.show();
            App.scrollTo(error1, -200);
        },

        errorPlacement: function(error, element) {
            if (element.is(':checkbox')) {
                error.insertAfter(element.closest(".md-checkbox-list, .md-checkbox-inline, .checkbox-list, .checkbox-inline"));
            } else if (element.is(':radio')) {
                error.insertAfter(element.closest(".fileinput, .fileinput-new"));
            } else if (element.is(':file')) {
                error.insertAfter(element.closest(".fileinput, .fileinput-new"));
            } else {
                error.insertAfter(element);
            }

        },

        highlight: function(element) {
            $(element)
                .closest('.form-group').removeClass('has-info')
                .closest('.form-group').addClass('has-error');
        },

        unhighlight: function(element) {
            $(element)
                .closest('.form-group').removeClass('has-error')
                .closest('.form-group').addClass('has-success');
        },

        success: function(label) {
            label
                .closest('.form-group').removeClass('has-error')
                .closest('.form-group').addClass('has-success');
        },

        submitHandler: function(form) {
            success1.show();
            error1.hide();

            return true;


        }

    });
    ///////////////////////////////////////////////////////
    var form3 = $('#network_form');
    form3.validate({
        errorElement: 'span',
        errorClass: 'help-block help-block-error',
        focusInvalid: false,
        ignore: "",
        messages: {
            name: {
                minlength: 'Le nom est trop court',
                required: 'Veuillez saisir un nom'

            },
            type_id: {
                required: 'Veuillez saisir une catégorie'
            },
            town: {
                required: 'Veuillez saisir une ville'
            }
        },
        rules: {
            name: {
                required: true,
                minlength: 4
            },
            type_id: {
                required: true
            },
            town: {
                required: true
            }
        },
        invalidHandler: function(event, validator) {
            success1.hide();
            error1.show();
            App.scrollTo(error1, -200);
        },

        errorPlacement: function(error, element) {
            if (element.is(':checkbox')) {
                error.insertAfter(element.closest(".md-checkbox-list, .md-checkbox-inline, .checkbox-list, .checkbox-inline"));
            } else if (element.is(':radio')) {
                error.insertAfter(element.closest(".fileinput, .fileinput-new"));
            } else if (element.is(':file')) {
                error.insertAfter(element.closest(".fileinput, .fileinput-new"));
            } else {
                error.insertAfter(element);
            }

        },

        highlight: function(element) {
            $(element)
                .closest('.form-group').removeClass('has-info')
                .closest('.form-group').addClass('has-error');
        },

        unhighlight: function(element) {
            $(element)
                .closest('.form-group').removeClass('has-error')
                .closest('.form-group').addClass('has-success');
        },

        success: function(label) {
            label
                .closest('.form-group').removeClass('has-error')
                .closest('.form-group').addClass('has-success');
        },

        submitHandler: function(form) {
            success1.show();
            error1.hide();

            return true;


        }

    });

    /////////////////////////////////////////////////
    var form4 = $('#document_form');
    form4.validate({
        errorElement: 'span',
        errorClass: 'help-block help-block-error',
        focusInvalid: false,
        ignore: "",
        messages: {

            name: {
                minlength: 'Le nom est trop court',
                required: 'Veuillez saisir un nom'

            },
            guideline: {

                required: 'Le fichier est obligatoire'
            },
            fiche: {

                required: 'Le fichier est obligatoire'
            },
            cat: {
                required: 'Veuillez entrer une catégorie'
            },
            scat: {
                required: 'Veuillez entrer une sous catégorie'
            },
            description: {
                required: 'La description est obligatoire'
            }
        },
        rules: {

            name: {
                required: true,
                minlength: 4
            },
            guideline: {
                required: true

            },
            fiche: {
                required: true
            },
            cat: {
                required: true
            },
            scat: {
                required: true
            },
            description: {
                required: true
            }
        },
        invalidHandler: function(event, validator) {
            success1.hide();
            error1.show();
            App.scrollTo(error1, -200);
        },

        errorPlacement: function(error, element) {
            if (element.is(':checkbox')) {
                error.insertAfter(element.closest(".md-checkbox-list, .md-checkbox-inline, .checkbox-list, .checkbox-inline"));
            } else if (element.is(':radio')) {
                error.insertAfter(element.closest(".fileinput, .fileinput-new"));
            } else if (element.is(':file')) {
                error.insertAfter(element.closest(".fileinput, .fileinput-new"));
            } else {
                error.insertAfter(element);
            }

        },

        highlight: function(element) {
            $(element)
                .closest('.form-group').removeClass('has-info')
                .closest('.form-group').addClass('has-error');
        },

        unhighlight: function(element) {
            $(element)
                .closest('.form-group').removeClass('has-error')
                .closest('.form-group').addClass('has-success');
        },

        success: function(label) {
            label
                .closest('.form-group').removeClass('has-error')
                .closest('.form-group').addClass('has-success');
        },

        submitHandler: function(form) {
            success1.show();
            error1.hide();

            return true;


        }

    });


});