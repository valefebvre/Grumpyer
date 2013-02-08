<?php

class Database extends PDO {
     
    private $engine;
    private $host;
    private $database;
    private $user;
    private $pass;
     
    public function __construct(){
        $this->engine = 'mysql';
        $this->host = 'XXXXXXXXXXXXXXX';
        $this->database = 'XXXXXXXXXXXXXXX';
        $this->user = 'XXXXXXXXXXXXXXX';
        $this->pass = 'XXXXXXXXXXXXXXX';
        $dns = $this->engine.':dbname='.$this->database.";host=".$this->host;
        parent::__construct( $dns, $this->user, $this->pass );
    }
     
    public function alterationAction($query)
    {
        $count = parent::exec($query);
        $error = parent::errorInfo();
        if ($error[0] == 00000) $error[2] = '';
	        $resultarray = array(
	        	'rows_affected' => $count,
	        	'error' => $error[2]
	        );
        return $resultarray;       
    }
     
    public function selectAction($query)
    {
        $sth = parent::prepare($query);
        if(!$sth->execute()){
            $result = array(
            	1=>'false',
            	2=>'There was an error in sql syntax.'
            );
            return $result;
        }
        $result = $sth->fetchAll();
        return $result;
    }
}