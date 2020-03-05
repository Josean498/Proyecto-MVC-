<?php 

    class equiposModel extends Model {

        public function __construct() {

            parent::__construct();
            
        }

        public function get() {
            try {
                $consultaSQL = "SELECT * FROM equipos ORDER BY id";
    
                $pdo = $this->db->connect();
    
                $stmt = $pdo->prepare($consultaSQL);
                $stmt->setFetchMode(PDO::FETCH_OBJ);
    
                $stmt->execute();
    
                $equiposs = $stmt->fetchAll();
    
                return $equiposs;
                
            } catch(PDOException $e) {
    
                $error = 'Error al leer registros '.$e->getMessage().' en la línea '.$e->getLine();
    
            }
        }

        public function getCategorias() {
            try {
                $consultaSQL = "SELECT * FROM categorias ORDER BY id";
    
                $pdo = $this->db->connect();
    
                $stmt = $pdo->prepare($consultaSQL);
                $stmt->setFetchMode(PDO::FETCH_OBJ);
    
                $stmt->execute();

                return $stmt;
                
            } catch(PDOException $e) {
    
                $error = 'Error al leer registros '.$e->getMessage().' en la línea '.$e->getLine();
    
            }
        }

        public function cabeceraTabla() {
            $cabecera = [
                "Id",
                "Nombre",
                "Nº Pilotos",
                "Imagen",
                "Nacionalidad"
            ];

            return $cabecera;
        }

        public function insert($equipos) {

            try 
            {
            
                $insertSQL ="
    
                INSERT INTO equipos (nombre, numPiloto, imagen, nacionalidad)
                VALUES ( :nombre, :numPiloto, :imagen, :nacionalidad)
    
                ";
    
                $pdo = $this->db->connect();
                $pdoStmt = $pdo->prepare($insertSQL);
    
                $pdoStmt->bindParam(':nombre', $equipos['nombre'], PDO::PARAM_STR, 50);
                $pdoStmt->bindParam(':numPiloto', $equipos['numPiloto'], PDO::PARAM_STR, 50);
                $pdoStmt->bindParam(':imagen', $equipos['imagen'], PDO::PARAM_STR, 50);
                $pdoStmt->bindParam(':nacionalidad', $equipos['nacionalidad'], PDO::PARAM_STR, 50);
        
                $pdoStmt->execute();
    
                return 'Registro Añadido Con Éxito';
                    
            } 
    
            catch (PDOException $e) 
            {
            
                $error = 'Error al añadir registro: ' . $e->getMessage() . " en la línea: " . $e->getLine();
                return $error;
            }
    
            
        }
        public function delete($id) {
            try {
            
                $deleteSQL ="DELETE FROM equipos WHERE id = :id";
    
                $pdo = $this->db->connect();
                $pdoStmt = $pdo->prepare($deleteSQL);
    
                $pdoStmt->bindParam(':id', $id, PDO::PARAM_INT);
        
                $pdoStmt->execute();
    
                return 'Registro borrado Con Éxito';
                    
            } catch (PDOException $e) {
            
                $error = 'Error al borrar registro: ' . $e->getMessage() . " en la línea: " . $e->getLine();
                return $error;
            }
        }

        public function getEquipo($id){
            try{ 
                $sql = "SELECT * FROM equipos WHERE id = :id LIMIT 1";
                $pdo = $this->db->connect();
                $stmt = $pdo->prepare($sql);
                
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $stmt->execute();
                
                $equipos = $stmt->fetch();

            return $equipos;
            }
                
            catch (PDOException $e){
            
            exit($e->getMessage());
            }

        }
        public function update($equipos) {
            // $id = $equipos["id"];
            // var_dump($equipos);
            // exit(0);
            try {
                $updateSQL ="UPDATE equipos SET
                nombre = :nombre,
                numPiloto = :numPiloto,
                imagen = :imagen,
                nacionalidad = :nacionalidad
                WHERE id = :id";
    
                $pdo = $this->db->connect();
                $stmt = $pdo->prepare($updateSQL);
                
                $stmt->bindParam(':id', $equipos['id'], PDO::PARAM_INT);
                $stmt->bindParam(':nombre', $equipos['nombre'], PDO::PARAM_STR, 50);
                $stmt->bindParam(':numPiloto', $equipos['numPiloto'], PDO::PARAM_STR, 50);
                $stmt->bindParam(':nacionalidad', $equipos['nacionalidad'], PDO::PARAM_STR);
                $stmt->bindParam(':imagen', $equipos['imagen'], PDO::PARAM_STR, 50);
        
                $stmt->execute();
    
                return 'Registro actualizado Con Éxito';
                    
            } catch (PDOException $e) {
            
                $error = 'Error al actualizar el registro: ' . $e->getMessage() . " en la línea: " . $e->getLine();
                return $error;
            }
        }

    }
?>  