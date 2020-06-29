Parsley.addMessages('en', {
  defaultMessage: "This value seems to be invalid.",
  type: {
    email:        "This value should be a valid email.",
    url:          "This value should be a valid url.",
    number:       "This value should be a valid number.",
    integer:      "This value should be a valid integer.",
    digits:       "This value should be digits.",
    alphanum:     "This value should be alphanumeric."
  },
  notblank:       "This value should not be blank.",
  required:       "This value is required.",
  pattern:        "This value seems to be invalid.",
  min:            "This value should be greater than or equal to %s.",
  max:            "This value should be lower than or equal to %s.",
  range:          "This value should be between %s and %s.",
  minlength:      "This value is too short. It should have %s characters or more.",
  maxlength:      "This value is too long. It should have %s characters or fewer.",
  length:         "This value length is invalid. It should be between %s and %s characters long.",
  mincheck:       "You must select at least %s choices.",
  maxcheck:       "You must select %s choices or fewer.",
  check:          "You must select between %s and %s choices.",
  equalto:        "This value should be the same.",
  euvatin:        "It's not a valid VAT Identification Number.",
});

Parsley.addMessages('pt-br', {
  defaultMessage: "↑ Este valor parece ser inválido.",
  type: {
    email:        "↑ Este campo deve ser um email válido.",
    url:          "↑ Este campo deve ser um URL válida.",
    number:       "↑ Este campo deve ser um número válido.",
    integer:      "↑ Este campo deve ser um inteiro válido.",
    digits:       "↑ Este campo deve conter apenas dígitos.",
    alphanum:     "↑ Este campo deve ser alfa numérico."
  },
  notblank:       "↑ Este campo não pode ficar vazio.",
  required:       "↑ Este campo é obrigatório.",
  pattern:        "↑ Este campo parece estar inválido.",
  min:            "↑ Este campo deve ser maior ou igual a %s.",
  max:            "↑ Este campo deve ser menor ou igual a %s.",
  range:          "↑ Este campo deve estar entre %s e %s.",
  minlength:      "↑ Este campo é pequeno demais. Ele deveria ter %s caracteres ou mais.",
  maxlength:      "↑ Este campo é grande demais. Ele deveria ter %s caracteres ou menos.",
  length:         "↑ O tamanho deste campo é inválido. Ele deveria ter entre %s e %s caracteres.",
  mincheck:       "↑ Você deve escolher pelo menos %s opções.",
  maxcheck:       "↑ Você deve escolher %s opções ou mais",
  check:          "↑ Você deve escolher entre %s e %s opções.",
  equalto:        "↑ Este valor deveria ser igual."
});

/**
 * Description of captiveportal-js-settings
 *
 * @author Rafael Antonio / https://github.com/r4phf43l
 */

$(document).ready(function(){
    
if($('#submitbtn').length>0) { $('#submitbtn').click(); exit }
if($('#lang').length>0) { Parsley.setLocale($('#lang').val()); }

$('#close-terms').on('click', function(){ $('#conditions').hide() })
$('#open-terms').on('click', function(){ $('#conditions').show() })

$('#enregistrement').parsley();
    function chk_cpf(cpf) {
        cpf = cpf.toString().replace(/[^\d]+/g,'');	
        if (cpf.length != 11) { return false; }
        if (cpf.match('/(\d)\1{10}/')) { return false; }
        for (t = 9; t < 11; t++) {
            for (d = 0, c = 0; c < t; c++) { d += cpf[c] * ((t + 1) - c); }
            d = ((10 * d) % 11) % 10;
            if (cpf[c] != d) { return false; }
        } return true;
    }

    window.Parsley
        .addValidator('cpf', {
            validateString: function(value) {     
                return chk_cpf(value);
            },
            messages: {
                'en': '↑ Invalid CPF (example: 001.234.567-89) ¬',
                'pt-br': '↑ CPF Inválido (exemplo: 001.234.567-89) ¬',
            }
    });
    $('#uniqueId').mask('000.000.000-00', {reverse: true});
});
