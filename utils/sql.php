<?php
session_start();
$connection=new mysqli("localhost","root","","schemalogico");
if($connection->connect_errno){
    printf("connection error: %s",$connection->connect_errno);
    session_destroy();
}

/*
questa funzione esegue query di selezione in accordo a la tabella desiderata ($table), i campi desiderati ($fields),
e i campi di filtraggio ($filters) come coppie chiave valore
*/
function query_get($table, $fields=[], $filters=[]){ 
    global $connection;
    $query="SELECT ";
    if($fields){
        $i=0;
        foreach($fields as $field){
            if($i==count($fields)-1)
                $query.="$field ";
            else
                $query.="$field, ";
            $i++;
        }
        $query.="FROM $table ";
    }else
        $query.="* FROM $table ";
    
    if($filters){
        $query.="WHERE ";
        $i=0;
        foreach($filters as $key => $value){
            $query.="$key = '$value' ";
            if($i<count($filters)-1)
                $query.="AND ";
            $i++;
        }
    }

    $res= $connection->query($query);
    $get_results=[];
    if($res->num_rows>0){
        foreach($res as $index=> $row) {
            foreach($row as $key=> $value) {
                $get_results[$index][$key]=$value;
            }
        }
    }
    return $get_results;
}

/*
questa funzione esegue query di selezione in accordo a la tabella desiderata ($table), i campi desiderati ($fields),
e i campi di filtraggio sono solo interi($filters) come coppie chiave valore
*/
function query_get_int($table, $fields=[], $filters=[]){ 
    global $connection;
    $query="SELECT ";
    if($fields){
        $i=0;
        foreach($fields as $field){
            if($i==count($fields)-1)
                $query.="$field ";
            else
                $query.="$field, ";
            $i++;
        }
        $query.="FROM $table ";
    }else
        $query.="* FROM $table ";
    
    if($filters){
        $query.="WHERE ";
        $i=0;
        foreach($filters as $key => $value){
            $query.="$key = $value ";
            if($i<count($filters)-1)
                $query.="AND ";
            $i++;
        }
    }
    
    $res= $connection->query($query);
    $get_results=[];
    if($res->num_rows>0){
        foreach($res as $index=> $row) {
            foreach($row as $key=> $value) {
                $get_results[$index][$key]=$value;
            }
        }
    }
    return $get_results;
}

/*
questa funzione esegue query di selezione in join tra le tabelle specificate in $tables, i campi desiderati ($fields),
e i campi di filtraggio ($filters) come coppie chiave valore e i campi in join in $joinFields
*/
function query_get_join($tables=[], $fields=[], $filters=[], $joinFields=[], $orderByFields=[], $order, $limit){ 
    global $connection;
    $query="SELECT DISTINCT ";
    if($fields){
        $i=0;
        foreach($fields as $field){
            if($i==count($fields)-1)
                $query.="$field ";
            else
                $query.="$field, ";
            $i++;
        }
        $query.="FROM ";
    }else
        $query.="* FROM ";

    $i=0;
    foreach($tables as $table){
        if($i==count($tables)-1)
            $query.=" $table ";
        else
            $query.=" $table, ";
        $i++;
    }
    
    if($filters || $joinFields){
        $query.="WHERE ";
        $i=0;
        foreach($filters as $key => $value){
            $query.="$key = '$value' ";
            if($i<count($filters)-1)
                $query.="AND ";
            $i++;
        }
        $i=0;
        foreach($joinFields as $fieldOne => $fieldTwo){
            $query.="$fieldOne = $fieldTwo ";
            if($i<count($joinFields)-1)
                $query.="AND ";
            $i++;
        }
    }

    if($orderByFields){
        $query.="ORDER BY ";
        $i=0;
        foreach($orderByFields as $field){
            if($i<count($orderByFields)-1)
                $query.="$field, ";
            else 
                $query.="$field";
            $i++;
        }
        $query.=" $order ";
    }

    if($limit > -1){
        $query.=" LIMIT $limit ";
    }

    $res= $connection->query($query);
    $get_results=[];
    if($res->num_rows>0){
        foreach($res as $index=> $row) {
            foreach($row as $key=> $value) {
                $get_results[$index][$key]=$value;
            }
        }
    }
    return $get_results;
}

/*questa funzione si occupa di inserire i valori che gli vengono dati e controlla che sia andato a buon fine*/
function query_insert($table, $values){
    global $connection;
    $keys = [];
    $values_ = [];
    foreach($values as $key => $value){
        $keys[] = $key;
        $values_[] = "'".$value."'"; 
    }
    $query = "INSERT INTO $table (".implode(", ", $keys).") VALUES (".implode(", ", $values_).")";

    $res = $connection->query($query);
    if(!$res){
        echo "Error: " . $query . "<br>" . $connection->error;
        exit;
    }
    return;
}

/*questa funzione fa l'update dei valori specificati */
function query_update($table, $values, $filters){
    global $connection;
    $query ="UPDATE $table SET ";
    $i=0;
    foreach($values as $key => $value){
        $query.= $key. "='".$value."'"; 
        if($i<count($values)-1)
            $query.=",";
        $i++;
    }
    $query .= " WHERE ";
    $i=0;
    foreach($filters as $key => $value){
        $query.= $key. "=".$value; 
        if($i<count($filters)-1)
            $query.=" AND ";
        $i++;
    }

    $res = $connection->query($query);
    if(!$res){
        echo "Error: " . $query . "<br>" . $connection->error;
        exit;
    }
    return;
}