<?php require "captiveportal-Controller.php"; ?>
<!DOCTYPE html>
<html lang="<?=CPLANG?>">
    <head>
        <meta charset="UTF-8">
        <title><?=$ct['titlestring']?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?=$ct['description']?>">
        <meta name="author" content="<?=$ct['brand']?>">
        <link href="captiveportal-main.css" rel="stylesheet" type="text/css" />
        <script src="captiveportal-jQuery.js" type="text/javascript" ></script>
        <script src="captiveportal-parsley.js" type="text/javascript" ></script>
        <script src="captiveportal-mask.js" type="text/javascript" ></script>
        <script src="captiveportal-sets.js" type="text/javascript" ></script>
    </head>
    <body>
        <section class="logo">&nbsp;</section>
        <?php if($login!=true) : ?>
        <section id="conditions">
            <div class="control-group grey">
                <div class="titulo"><?=$l[CPLANG]['termsOfUse_string']?></div>
                <button name="close-terms" id="close-terms" type="button" class="btn btn-signin right float">
                    <?=$l[CPLANG]['termsOfUseRead_string']?>
                </button>
            </div>
            <div class="control-group">
                <div>
                    <p><?=$l[CPLANG]['generalUseMessage_string']?></p>
                <?php include "captiveportal-term.html"; ?>
                </div>
            </div>
        </section>
        <section id="main">
            <div class="titulo"><?=$l[CPLANG]['welcome_string']?></div>
            <div class="control-group<?=(count($errormessage)>0)?' showerror':' hideerror'?>">
                <svg viewBox="0 0 24 24">
                    <path fill-rule="nonzero" d="M20.94 19.1L19.08 21 12 14.27 4.95 21l-1.89-1.9 6.71-7.07L3 4.93 4.89 3 12 9.79 19.11 3 21 4.93l-6.77 7.1z"></path>
                </svg>
                <div class="erro">
                    <strong><?=$l[CPLANG]['error_string']?></strong>
                    <br /><?=($errormessage['error']=='Field Required')?'<strong>'.$l[CPLANG]['fieldrequired'].'</strong>
                    <br>'.$errormessage['context']:''?>
                    <?=(CPDEBUG)?'<strong>'.$errormessage['error'].'</strong>
                    <br>'.var_dump($errormessage['context']):$l[CPLANG]['genericerror']?>
                </div>
            </div>
            <div class="control-group"><?=$l[CPLANG]['welcomeMessage_string']?></div>
            <form id="enregistrement" name="enregistrement" method="post" action="" data-parsley-validate="">
                <input id="lang" name="lang" type="hidden" value="<?=CPLANG?>">
                <div class="control-group">
                    <div class="controls">
                        <input type="text" id="uniqueId" name="uniqueId" placeholder="CPF" value="<?=$fd['uniqueId']?>" data-parsley-cpf="1" data-parsley-minlength="14" data-parsley-required="1" maxlength="14" >
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <input type="text" id="clientName" name="clientName" placeholder="Nome" value="<?=$fd['clientName']?>" data-parsley-minlength="8" data-parsley-required="1" >
                        </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <input type="email" id="emailAddress" name="emailAddress" placeholder="Email" value="<?=$fd['emailAddress']?>" data-parsley-required="1" >
                    </div>
                </div>
                <div class="check-group">
                    <div class="controls">
                        <input type="checkbox" name="newsletter" id="newsletter" value="newsletter"<?=($fd['newsletter']==1 ? ' checked': '')?>>
                        <label for="newsletter">
                            <span></span>
                            <?=$l[CPLANG]['newsletter_string']?>
                        </label>
                    </div>
                </div>
                <div class="check-group">
                    <div class="controls">
                        <input type="checkbox" name="termsOfUse" id="termsOfUse" value="termsOfUSe" required>
                        <label for="termsOfUse">
                            <span></span>
                            <?=$l[CPLANG]['termsOfUseAccept_string']?>
                            <a href="#" class="curpointer" id="open-terms" name="open-terms">
                                <?=$l[CPLANG]['termsOfUse_string']?>
                            </a>
                        </label>
                    </div>
                    <span id="termsOfUseVal"></span>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <input type="submit" class="btn btn-signin right" value="<?=$l[CPLANG]['connect_string']?>">
                    </div>
                </div>
            </form>
            <div class="control-group grey">
                <div class="msgs">
                    <?=$today?><br />
                    <?=$ct['companySite']?>
                </div>
            </div>
            <footer>cpOS | ra &copy;<?=date('Y')?></footer>
        </section>
        <?php else: ?>
        <section id="main">
            <div class="control-group"><?=$l[CPLANG]['login_message']?></div>
                <form name="loginForm" method="post" action="$PORTAL_ACTION$">
                <input name="auth_user" type="hidden" value="<?=$userName; ?>">
                <input name="auth_pass" type="hidden" value="<?=$password; ?>">
                
                <input name="zone" type="hidden" value="$PORTAL_ZONE$">
                <input name="redirurl" type="hidden" value="$PORTAL_REDIRURL$">
                <div class="control-group">
                    <input id="submitbtn" name="accept" type="submit" value="<?=$l[CPLANG]['continue_button']?>" class="btn btn-signin right">
                </div>                
            </form><input name="lang" type="hidden" value="<?=CPLANG?>">
            <footer>cpOS | ra &copy;<?=date('Y')?></footer>
        </section>
        <?php endif ?>
        <?=($v->getDebug()===true) ? 'ERROR LOG: ' . $v->getErrors() : ''?>
    </body>
</html>
