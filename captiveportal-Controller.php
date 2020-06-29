<?php
/**
 * @author Rafael Antonio / https://github.com/r4phf43l
 */

require "captiveportal-Config.php";
require "captiveportal-Data.php";
global $zone, $redirurl, $regDate;
global $userName, $password;
global $language;
$errormessage = [];

$zone = filter_input(INPUT_GET, 'zone');
$redirurl = filter_input(INPUT_GET, 'redirurl');
$language = CPLANG;

$v = new Data\UsersDB(DBHOST, DBUSER, DBPASS, DBSCHM);
$v->setDebug(CPDEBUG);
/* CONNECT */
if ($v!=true) {
    $errormessage = [
        'id' => '01', 'error' => 'Connection', 'context' => 'Trying to connect to DB server',
    ];
}

/* VALIDATE MACADDRESS */
$macAddress = $v->getNetwork()['mac'];
$ipAddress = $v->getNetwork()['ip'];
$date = new DateTime();
$regDate = $date->getTimestamp();
$monthList = $l[CPLANG]['month'];
$today = str_replace('%m%', $l[CPLANG]['month'][date('n')-1], $l[CPLANG]['today']);

if ($macAddress==null) {
    $errormessage = [
        'id' => '02', 'error' => 'Getting MAC', 'context' => 'Trying to get MAC Address',
    ];
}

/* IF POST */
if(filter_input(INPUT_POST, 'termsOfUse') && $v->state != 'Error') {
    
    try {
        $nl = (filter_input(INPUT_POST, 'newsletter')=='newsletter' ? '1' : '0');
        $fd = [
            'clientName' => htmlspecialchars ( strip_tags( filter_input(INPUT_POST, 'clientName') ) ),
            'uniqueId' => (validateCPF(filter_input(INPUT_POST, 'uniqueId')) ? filter_input(INPUT_POST, 'uniqueId') : ''),
            'emailAddress' => filter_input(INPUT_POST, 'emailAddress', FILTER_VALIDATE_EMAIL),
            'newsletter' => $nl
        ];
        validateFields($fd);
    } catch(Exception $x) {
        $errormessage = [
            'id' => '03', 'error' => 'Field Required', 'context' => $x->getMessage()
        ];       
    }
    
    if ($macAddress!=null && count($errormessage)==0) {
        $f = [
            'clientName' => $fd['clientName'],
            'macAddress' => $macAddress,
            'ipAddress' => $ipAddress,
            'newsletter' => $fd['newsletter'],
            'emailAddress' => $fd['emailAddress']
        ];
        $w = [ 'uniqueId' => $fd['uniqueId'] ];
        $wr = [ 'username' => $userName ];
        $userName = $fd['uniqueId'];
        $password = $fd['emailAddress'];
        
        if ($v->state != 'Error') {
            $u = $v->issetItem('regusers', ['uniqueId' => $fd['uniqueId']]);
            if ($v->state != 'Error') {
                if ($u==true) {
                    $r = $v->updateItem('regusers', $f, $w);
                } else {
                    $f = array_merge($f, $w);            
                    $r = $v->insertItem('regusers', $f);
                }
            }
        }

        if ($v->state != 'Error') {
            $p = $v->issetItem('radcheck', ['username' => $userName]);
            if ($v->state != 'Error') {
                if ($p==true) {
                    $fr = [ 'value' => $password ];
                    $s = $v->updateItem('radcheck', $fr, $wr);
                } else {        
                    $fr = [
                        'username' => $userName,
                        'attribute' => 'Cleartext-Password',
                        'value' => $password,
                        'op' => ':='
                    ];        
                    $s = $v->insertItem('radcheck', $fr);
                }
            }
        }

        if ($v->state != 'Error') {
            $g = $v->issetItem('radusergroup', ['username' => $userName]);
            if ($g==true && $v->state != 'Error') {     
                $fg = [ 'username' => $userName, 'groupname' => FRGROUP ];  
                $t = $v->insertItem('radusergroup', $fg);
            }
        }

        
        $login = count($errormessage)==0 && $v->state != 'Error' ? true : false;
    } else {
        $login = false;
    }
}
