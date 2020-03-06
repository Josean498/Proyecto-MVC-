<?php
 require_once('fpdf/fpdf.php');
 require_once('class/mi_pdf.php');
    class Equipos Extends Controller {

        function __construct() {

            parent ::__construct();
            
            
        }

        function render() {
            session_start();
            $equipos = $this->model->get();
            $this->view->datos = $equipos;
            $this->view->render('equipos/index');
        }

        function create() {
            session_start();
            // $categorias = $this->model->getCategorias();
            // $this->view->categorias = $categorias;

            if(!isset($this->view->equipo)) $this->view->equipo = null;
            $this->view->render('equipos/create/index');
        }

        function edit($param) {
            session_start();
            $this->view->id = $param[0];

            $this->view->equipo = $this->model->getEquipo($this->view->id);
            $this->view->equipo["id"] = $param[0];

            $this->view->render('equipos/edit/index');        
        }

        function delete($param) {
            $this->model->delete($param[0]);
            
            $equipos = $this->model->get();
            $this->view->datos = $equipos;
            
            $this->view->render('equipos/index');
        }

        function show($param = null) {
            session_start();
            $this->view->id = $param[0];

            $this->view->equipo = $this->model->getEquipo($param[0]);
            $this->view->equipo["id"] = $param[0];

            if (!isset($this->view->equipo)) $this->view->equipo = null;
            $this->view->render('equipos/show/index');
        }

        function registrar($param = null) {
            
            # Sanear datos $_POST del formulario

            $equipo = 
            [
                'nombre'    => filter_var($_POST['nombre'], FILTER_SANITIZE_STRING),
                'numPiloto'    => filter_var($_POST['numPiloto'], FILTER_SANITIZE_NUMBER_FLOAT),
                'nacionalidad'    => filter_var($_POST['nacionalidad'], FILTER_SANITIZE_STRING),
                'imagen'          => $_FILES['imagen']
            ];


            # Validar datos del formulario

            $errores = array();

            # Valiar descripción
            

            # Validar nombre
            if (empty($equipo['nombre'])) {
                $errores['nombre'] = "Campo obligatorio";
            } else if (!filter_var($equipo['nombre'], FILTER_SANITIZE_STRING)) {
                $errores['nombre'] = "Valor no permitido";

            }

            # Validar nacionalidad
            if (empty($equipo['nacionalidad'])) {
                $errores['nacionalidad'] = "Campo obligatorio";
            } else if (!filter_var($equipo['nacionalidad'], FILTER_SANITIZE_STRING)) {
                $errores['nacionalidad'] = "Valor no permitido";

            }

            # Validar imagen con rango
            $options = array(
                'options' => array(
                    'min_range' => 0,
                    'max_range' => 1000,
                )
            );

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
            
            if (($equipo['imagen']['error'] !== UPLOAD_ERR_OK )) {
                
                $errores['imagen'] = $FileUploadErrors[$equipo['imagen']['error']];
                
            }  else 
            
            if (is_uploaded_file($equipo['imagen']['tmp_name'])) {

                $info = new SplFileInfo($equipo['imagen']['tmp_name']);
                
                # Validamos tamaño máximo 2MB personalizado
                # MAX_FILE_SIZE hace la misma validación con HTML
                $max_tamano = 2 * 1024 * 1024;
                
                if ($info->getSize() > $max_tamano ) {
                    $errores['imagen'] = "Tamaño de archivo no permitido. Máximo 2MB";
                }

                # Validamos el tipo
                $info = new SplFileInfo($equipo['imagen']['name']);
                $tipos_permitidos =['jpeg', 'JPEG','jpg', 'JPG', 'gif', 'GIF',  'png', 'PNG'];
                
                if (!in_array ($info->getExtension(), $tipos_permitidos )) {
                    $errores['imagen'] = "Tipo no permitido. Sólo JPG, PNG y GIF";
                }
                
            }

            if (!empty($errores)) {
                
                // var_dump($equipo);
                // var_dump($errores);
                // exit(0);
                # Datos no validados
                $this->view->errores = $errores;
                $this->view->mensaje = "Errores en el formulario.";
                $this->view->equipo = $equipo;
                $this->create();

                
            } else {
   
                # Datos validados: insertamos registros y movemos imagen 
                move_uploaded_file($equipo['imagen']['tmp_name'],"imagenes/".$equipo['imagen']['name']);
                
                # Actualizo el campo imagen con name
                $equipo['imagen'] = $equipo['imagen']['name'];
        
                # La función insert devuelve el mensaje resultante de añadir el registro
                $mensaje=$this->model->insert($equipo);


                
                $this->view->mensaje = $mensaje;
                $this->render();
                
            } 

            
            
        }

        function actualizar() {
            # Sanear datos $_POST del formulario
            $equipo = 
            [
                'id'     => $_POST['id'],
                'nombre'    => filter_var($_POST['nombre'], FILTER_SANITIZE_STRING),
                'numPiloto'    => filter_var($_POST['numPiloto'], FILTER_SANITIZE_NUMBER_FLOAT),
                'nacionalidad'    => filter_var($_POST['nacionalidad'], FILTER_SANITIZE_STRING),
                'imagen'          => $_FILES['imagen']
                
            ];
            $errores = array();

            # Valiar descripción
            

            # Validar nombre
            if (empty($equipo['nombre'])) {
                $errores['nombre'] = "Campo obligatorio";
            } else if (!filter_var($equipo['nombre'], FILTER_SANITIZE_STRING)) {
                $errores['nombre'] = "Valor no permitido";

            }

            # Validar nacionalidad
            if (empty($equipo['nacionalidad'])) {
                $errores['nacionalidad'] = "Campo obligatorio";
            } else if (!filter_var($equipo['nacionalidad'], FILTER_SANITIZE_STRING)) {
                $errores['nacionalidad'] = "Valor no permitido";

            }

            # Validar imagen con rango
            $options = array(
                'options' => array(
                    'min_range' => 0,
                    'max_range' => 1000,
                )
            );

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
            // var_dump($equipo);
            // exit(0);
            
            if (($equipo['imagen']['error'] !== UPLOAD_ERR_OK )) {
                
                $errores['imagen'] = $FileUploadErrors[$equipo['imagen']['error']];
                
            }  else 
            
            if (is_uploaded_file($equipo['imagen']['tmp_name'])) {

                $info = new SplFileInfo($equipo['imagen']['tmp_name']);
                
                # Validamos tamaño máximo 2MB personalizado
                # MAX_FILE_SIZE hace la misma validación con HTML
                $max_tamano = 2 * 1024 * 1024;
                
                if ($info->getSize() > $max_tamano ) {
                    $errores['imagen'] = "Tamaño de archivo no permitido. Máximo 2MB";
                }

                # Validamos el tipo
                $info = new SplFileInfo($equipo['imagen']['name']);
                $tipos_permitidos =['jpeg', 'JPEG','jpg', 'JPG', 'gif', 'GIF',  'png', 'PNG'];
                
                if (!in_array ($info->getExtension(), $tipos_permitidos )) {
                    $errores['imagen'] = "Tipo no permitido. Sólo JPG, PNG y GIF";
                }
                
            }

            if (!empty($errores)) {
                
                // var_dump($equipo);
                // var_dump($errores);
                // exit(0);
                # Datos no validados
                $this->view->errores = $errores;
                $this->view->mensaje = "Errores en el formulario.";
                $this->view->equipo = $equipos;
                $this->edit();

                
            } else {
   
                # Datos validados: insertamos registros y movemos imagen 
                move_uploaded_file($equipo['imagen']['tmp_name'],"imagenes/".$equipo['imagen']['name']);
                
                # Actualizo el campo imagen con name
                $equipo['imagen'] = $equipo['imagen']['name'];
        
                # La función insert devuelve el mensaje resultante de añadir el registro
                $mensaje=$this->model->update($equipo);


                
                $this->view->mensaje = $mensaje;
                $this->render();
                
            }
    }

    public function ordenar($param = null){
        $this->view->editar = $this->editar;
        $this->view->crear = $this->crear;
        $this->view->borrar = $this->borrar;
        if (!isset($_SESSION)){
            session_start();
        }
        $equipos = $this->model->ordenar($param);
        $this->view->datos = $equipos;
        
        $this->view->render('equipos/index');
    }

    public function buscar($param = null){
        $this->view->editar = $this->editar;
        $this->view->crear = $this->crear;
        $this->view->borrar = $this->borrar;
        if (!isset($_SESSION)){
            session_start();
        }
        $param = $_GET['expresion'];
        $equipos = $this->model->buscar($param);
        $this->view->datos = $equipos;
        
        $this->view->render('equipos/index');
    }

    public function imprimir_pdf(){
        $pdf = new mi_pdf();
        $pdf->Addpage();
        $pdf->SetFont('Courier', '', 10);

        $pdf-> Cabecera_archivos();

        $archivos = $this->model->get();
        $total_capacidad = 0;

        foreach( $archivos as $i => $archivo){

            $pdf->Cell(10,8,utf8_decode($archivo->id),0,0);

            $pdf->Cell(30,8,utf8_decode($archivo->nombre),0,0);

            $pdf->Cell(50,8,utf8_decode($archivo->numPiloto),0,0);

            $pdf->Cell(50,8,utf8_decode($archivo->imagen),0,0);

            $pdf->Cell(40,8,utf8_decode($archivo->nacionalidad),0,1);

        }

        $pdf->Cell(45,10,utf8_decode('Numero de registros: '), 'T', 0);
        $pdf->Cell(45,10,utf8_decode($i+1), 'T', 0);
        $pdf->Cell(90,8,utf8_decode(''), 'T', 1, 'R');

        $pdf->Output('I', 'equipos.pdf');


    }

}
?>