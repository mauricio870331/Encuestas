<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

class Conexion {

    private $con;
    private $stm;
    private $rs;

    public function __construct($bd) {
        try {
            $this->con = new PDO('mysql:host=localhost;dbname=' . $bd . ';charset=utf8', 'root', '', array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ));
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function desconectar() {
        $this->stm = null;
        $this->rs = null;
        $this->con = null;
    }

    public function findAll($tabla) {
        $this->stm = $this->con->prepare("select * from " . $tabla);
        $this->stm->execute();
        $this->rs = $this->stm->fetchAll(PDO::FETCH_OBJ);
        return $this->rs;
    }

    public function findAll2($query){
        $this->stm = $this->con->prepare($query);
        $this->stm->execute();
        $this->rs = $this->stm->fetchAll(PDO::FETCH_OBJ);
        return $this->rs;
    }

    public function showProcedures($tabla) {
        $this->stm = $this->con->prepare($tabla);
        $this->stm->execute();
        $this->rs = $this->stm->fetchAll(PDO::FETCH_OBJ);
        return $this->rs;
    }

    public function findAllSP($procedimiento, $valor = "") {
        $params = explode(",", $valor);
        switch ($procedimiento) {
            case "listarUsuarioApp":
                $this->stm = $this->con->prepare("call listarUsuarioApp()");
                $this->stm->execute();
                $this->rs = $this->stm->fetchAll(PDO::FETCH_OBJ);
                break;
            case "listarFactura":
                $this->stm = $this->con->prepare("call listarFactura('" . $valor . "')");
                $this->stm->execute();
                $this->rs = $this->stm->fetchAll(PDO::FETCH_OBJ);
                break;
            case "existUser":
                $this->stm = $this->con->prepare("call existUser('" . $params[0] . "','" . $params[1] . "')");
                $this->stm->execute();
                $this->rs = $this->stm->fetchAll(PDO::FETCH_OBJ);
                break;
            default:
                break;
        }

        return $this->rs;
    }

    public function findById($tabla, $fieldId, $id) {

        //

        $this->stm = $this->con->prepare("select * from " . $tabla . " where " . $fieldId . " = ?");

        $this->stm->execute(array($id));
        $this->rs = $this->stm->fetchAll(PDO::FETCH_OBJ);
        return $this->rs;
    }

    public function execQuery($query) {
        $this->stm = $this->con->prepare($query);
        return $this->stm->execute();
    }

    public function getUltimoId($campo_id, $tabla = "") {
        $query = "SELECT MAX($campo_id) AS id FROM $tabla";
        $this->stm = $this->con->prepare($query);
        $this->stm->execute();
        $this->rs = $this->stm->fetch(PDO::FETCH_OBJ);
        return $this->rs->id;
    }

    public function checkID($tabla, $fieldId, $id) {
        $this->stm = $this->con->prepare("select * from " . $tabla . " where " . $fieldId . " = ?");
        $this->stm->execute(array($id));
        if ($this->stm->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public function getTotalFilas() {
        return $this->stm->rowCount();
    }

    public function login($id, $password) {
        $sql = "select * from administradores where usuario = '" . $id . "' and password = '" . $password . "'";
        $this->stm = $this->con->prepare($sql);
        $this->stm->execute();
        $this->rs = $this->stm->fetchAll(PDO::FETCH_OBJ);
        return $this->rs;
    }

}

?>