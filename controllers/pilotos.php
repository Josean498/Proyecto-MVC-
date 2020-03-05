<?php

    class Pilotos Extends Controller {

        function __construct() {

            parent ::__construct();
            
            
        }

        function render() {
            session_start();
            $pilotos = $this->model->get();
            $this->view->datos = $pilotos;
            $this->view->render('pilotos/index');
        }

        function create() {
            $categorias = $this->model->getCategorias();
            $this->view->categorias = $categorias;

            if(!isset($this->view->piloto)) $this->view->piloto = null;
            $this->view->render('pilotos/create/index');
        }

        function edit() {
            $this->view->render('pilotos/edit/index');
        }

        function delete() {
            $this->view->render('pilotos/delete/index');
        }

        function registrar($param = null) {
            
            # Sanear datos $_POST del formulario

            $piloto = 
            [
                'id'     => filter_var($_POST['id'], FILTER_SANITIZE_STRING),
                'nombre'    => filter_var($_POST['nombre'], FILTER_SANITIZE_NUMBER_FLOAT),
                'nacionalidad'    => filter_var($_POST['nacionalidad'], FILTER_SANITIZE_NUMBER_FLOAT),
                'equipo_id'    => filter_var($_POST['nacionalidad'], FILTER_SANITIZE_NUMBER_INT),
                'ranking'    => filter_var($_POST['ranking'], FILTER_SANITIZE_NUMBER_INT),
            ];


            # Validar datos del formulario

            $errores = array();

            # Valiar descripción
            if (empty($piloto['id'])) {
                $errores['id'] = "Campo obligatorio";
            }

            # Validar nombre
            if (empty($piloto['nombre'])) {
                $errores['nombre'] = "Campo obligatorio";
            } else if (!filter_var($piloto['nombre'], FILTER_VALIDATE_FLOAT)) {
                $errores['nombre'] = "Valor no permitido";

            }

            # Validar nacionalidad
            if (empty($piloto['nacionalidad'])) {
                $errores['nacionalidad'] = "Campo obligatorio";
            } else if (!filter_var($piloto['nacionalidad'], FILTER_VALIDATE_FLOAT)) {
                $errores['nacionalidad'] = "Valor no permitido";

            }

            # Validar imagen con rango
            $options = array(
                'options' => array(
                    'min_range' => 0,
                    'max_range' => 1000,
                )
            );
            
            if (!filter_var($piloto['imagen'], FILTER_VALIDATE_INT, $options)) {
                $errores['imagen'] = "Valor fuera de rango";

            }

            # Validar nacionalidad con rango
            $options = array(
                'options' => array(
                    'min_range' => 1,
                    'max_range' => 10,
                )
            );
            
            if (!filter_var($piloto['nacionalidad'], FILTER_VALIDATE_INT, $options)) {
                $errores['nacionalidad'] = "Valor fuera de rango";
            }

            # Validar imagen jpg, gif, png


            # Comprobamos antes si ha ocurrido algún error en la subida de archivo

            $FileUploadErrors = array(
                0 => 'No hay error, fichero subido con éxito.',
                1 => 'El fichero subido excede la directiva upload_max_filesize de php.ini.',
                2 => 'El fichero subido excede la directiva MAX_FILE_SIZE especificada en el formulario HTML.',
                3 => 'El fichero fue sólo parcialmente subido.',
                4 => 'No se subió ningún fichero.',
                6 => 'Falta la carpeta temporal.',
                7 => 'No se pudo escribir el fichero en el disco.',
                8 => 'Una extensión de PHP detuvo la subida de ficheros.',
            );
            
            if (($piloto['imagen']['error'] !== UPLOAD_ERR_OK )) {
                
                $errores['imagen'] = $FileUploadErrors[$piloto['imagen']['error']];
                
            }  else 
            
            if (is_uploaded_file($piloto['imagen']['tmp_name'])) {

                $info = new SplFileInfo($piloto['imagen']['tmp_name']);
                
                # Validamos tamaño máximo 2MB personalizado
                # MAX_FILE_SIZE hace la misma validación con HTML
                $max_tamano = 2 * 1024 * 1024;
                
                if ($info->getSize() > $max_tamano ) {
                    $errores['imagen'] = "Tamaño de archivo no permitido. Máximo 2MB";
                }

                # Validamos el tipo
                $info = new SplFileInfo($piloto['imagen']['name']);
                $tipos_permitidos =['jpeg', 'JPEG','jpg', 'JPG', 'gif', 'GIF',  'png', 'PNG'];
                
                if (!in_array ($info->getExtension(), $tipos_permitidos )) {
                    $errores['imagen'] = "Tipo no permitido. Sólo JPG, PNG y GIF";
                }
                
            }

            if (!empty($errores)) {
                
                # Datos no validados
                $this->view->errores = $errores;
                $this->view->mensaje = "Errores en el formulario.";
                $this->view->piloto = $piloto;
                $this->create();

                
            } else {
   
                # Datos validados: insertamos registros y movemos imagen 
                move_uploaded_file($piloto['imagen']['tmp_name'],"imagenes/".$piloto['imagen']['name']);
                
                # Actualizo el campo imagen con name
                $piloto['imagen'] = $piloto['imagen']['name'];
        
                # La función insert devuelve el mensaje resultante de añadir el registro
                $mensaje=$this->model->insert($piloto);
                
                $this->view->mensaje = $mensaje;
                $this->render();
                
            } 

            
            
        }
    }
?>