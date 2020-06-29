<?php
/**
 * @author Rafael Antonio / https://github.com/r4phf43l
*/

namespace Data;

class connectDb {	
    protected $link, $h, $u, $p, $s, $r;
    protected $debug = false;
    protected $errors;
    public $status, $state;
    
    function __construct($h, $u, $p, $s) {
        try {
            $d = "mysql:host=$h;dbname=$s";
            $this->link = new \PDO($d, $u, $p, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
            $this->status = $this->link->getAttribute(\PDO::ATTR_CONNECTION_STATUS);
        } catch (\PDOException $e) {
            $this->listErrors($e->getMessage(), ' Connect ');
            return false;
        }
        return true;
    }
    function __destroy():void { $this->link->close(); }
    public function setDebug(bool $d):void { $this->debug = $d; }
    public function getDebug():bool  { return $this->debug; }
    public function getPassview():string {
        $r = ($this->debug) ? $this->p : null;
        return $r;
    }
    protected function listErrors($e, $c):void {
        $this->state = 'Error';       
        $this->errors[count($this->errors)] = $e . ' [ ' . $c . ' ]';
    }
    public function getErrors() {
        $r = ($this->debug) ? $this->errors : null;
        return implode( ' :: ' , $r);
    }
}

class UsersDb extends connectDb {
    private $ipAddress, $macAddress, $lines, $arp;
    protected $s, $f, $w, $k, $v, $pf, $pw, $ss, $sql, $stmt, $c;    
    
    function getNetwork(): array {
        $this->ipAddress = $_SERVER['REMOTE_ADDR'];
        $arp = `arp $this->ipAddress`;
        $lines = explode(" ", $arp);
        if (!empty($lines[3])) {
            $this->macAddress = $lines[3];
        } else {
            $this->macAddress = "00:00:00:11:22:33";
        }
        return ["ip" => $this->ipAddress, "mac" => $this->macAddress];
    }
    
    function issetItem (string $s, array $w):bool {        
        foreach ($w as $k => $v) {
            $pw .= ($pw=="") ? "" : " AND ";
            $pw .= $k . " = :" . $k;
        }
        $ss = htmlspecialchars(strip_tags($s));
        $sql = "SELECT * FROM " . $ss . " WHERE " . $pw;
        $c = $this->runPDO($sql, $w, true);
        return ($c!='') ? true : false;
    }
    
    function updateItem(string $s, array $f, array $w):bool {        
        foreach ($f as $k => $v) {
            $pf .= ($pf=="") ? "" : ", ";
            $pf .= $k . " = :" . $k;
        }
        foreach ($w as $k => $v) {
            $pw .= ($pw=="") ? "" : " AND ";
            $pw .= $k . " = :" . $k;
        }
        $ss = htmlspecialchars(strip_tags($s));
        $sql = "UPDATE " . $ss . " SET " . $pf . " WHERE " . $pw;            
        $c = $this->runPDO($sql, array_merge($f, $w));
        return $c;
    }
    
    function insertItem( string $s, array $f):bool {        
        foreach ($f as $k => $v) {
            $pf .= ($pf=="") ? "" : ", ";            
            $pk .= ($pk=="") ? "" : ", ";
            $pf .= ":" . $k;
            $pk .= $k;
        }
        $ss = htmlspecialchars(strip_tags($s));
        $sql = "INSERT INTO " . $ss . "(" . $pk . ") VALUES (" . $pf . ")";
        $c = $this->runPDO($sql, $f);
        return $c;
    }
    
    private function runPDO(string $sql, array $strings, bool $fetch = null) {
        try {
            $stmt = $this->link->prepare($sql);
            if ($fetch===true) {
                $stmt->execute($strings);
                $c = $stmt->fetch();
            } else {                
                $c = $stmt->execute($strings);
            }            
        } catch (\PDOException $e) {
            $this->listErrors($e->getMessage(), $sql);
            return false;
        }
        return $c;
    }
}
