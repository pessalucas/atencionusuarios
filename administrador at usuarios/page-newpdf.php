<?php

if ( $_GET['nrodenuncia'] ){ 
$nrodenuncia = $_GET['nrodenuncia'];
//Post_id que quiero mostrar
$id_denuncia = $nrodenuncia;

//Cambio la global para operar wordpress y sus funciones sobre el sitio At Usuarios
global $switched;
switch_to_blog(1);

    //Traigo info asociada al post, meta y taxonomys.
    $direccion = get_post_meta( $id_denuncia, 'direccion', true );
    if ( $direccion ){ 
    $vereda    = get_post_meta( $id_denuncia, 'vereda', true );
    $barrio    = get_post_meta( $id_denuncia, 'barrio', true );

    //Traigo la comuna asociada al post
    $comuna  = get_the_terms( $id_denuncia, 'comuna' );
    }else{
        $vereda = '';
        $barrio = '-';
        $comuna = '-';
    }
    $servicios = get_the_terms( $id_denuncia, 'servicios' );
    $obs       = get_post_meta( $id_denuncia, 'obs', true );
    $fecha     = get_the_date( 'd M Y', $id_denuncia );

    $user_id = get_current_user_id();

	//Busco el child id de menor jerarquia
    $count = 0;
    foreach ( $servicios as $servicio ) {
    if( ! get_term_children( $servicios[$count]->term_id, 'servicios' ) ){
        $term_id_anomalia = $servicios[$count]->term_id; }
        $count ++ ;
    }
        
    //Genero una array con las categorias asociadas a la anomalia, de menor jerarquia con orden y estrucutra de array para recorrer
    $ids_anomalia   = array();
    $term_anomalia  = get_term_by( 'id', $term_id_anomalia , 'servicios' );
    $id_anomalia    = $term_anomalia->term_id;
    $name_anomalia  = $term_anomalia->name;
    $id_parent      = $term_anomalia->parent;
    $ids_anomalia[] = $id_anomalia;
    while ( $id_parent!= 0 ) { 
        $term_next      = get_term_by( 'id', $id_parent , 'servicios' );
        $id_anomalia    = $term_next->term_id;
        $id_parent      = $term_next->parent;
        $ids_anomalia[] = $id_anomalia;
    } 

    //Traigo los datos asociados a los IDs de las terms de Servicios
    $anomalia       = get_term_by('id', $ids_anomalia[0] , 'servicios');
    $grupoanomalia  = get_term_by('id', $ids_anomalia[1] , 'servicios');
    $servicio       = get_term_by('id', $ids_anomalia[2] , 'servicios');
    $depto          = get_term_by('id', $ids_anomalia[3] , 'servicios');

    //Traigo la empresa asociada al post
    $empresa = get_the_terms( $id_denuncia, 'empresa' );

    //Traigo la comuna asociada al post
    $procedencia  = get_the_terms( $id_denuncia, 'procedencia' );

    //Traigo estado asociada al post
    $estado  = get_the_terms( $id_denuncia, 'estado' );
    //print_r($estado);

    $address=$direccion;


        
class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    $url_logo = get_stylesheet_directory_uri() . '/assets/img/header/logo.png';
    $nrodenuncia = $_GET['nrodenuncia'];

    //Logotipo
    $this->Image($url_logo,10,8,48);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(100,10,'Denuncia ' . $nrodenuncia ,1,0,'C');
    // Salto de línea
    $this->Ln(20);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',14);

    //Estado de la denuncia
    $pdf->Cell(0,10,'   ESTADO DE LA DENUNCIA: ' ,0,2);
    if ( isset ( $estado[1] ) ){ 
        $pdf->Cell(0,5, utf8_decode( $estado[0]->name . ' - ' . $estado[1]->name  ),0,1);
    }else{
        $pdf->Cell(0,5, utf8_decode( $estado[0]->name  ),0,1);
    }
    $pdf->Cell(0,5,'',0,1);
    $pdf->Cell(0,5,'-------------------------------------------------------------------------------------------------------------------',0,2);

    //Datos generales de la denuncia
    $pdf->Cell(0,5,'',0,1);
    $pdf->Cell(0,10,'   DATOS DE LA DENUNCIA: ',0,2);
    $pdf->Cell(0,5,'Numero de denuncia: ' . $id_denuncia ,0,1);
    $pdf->Cell(0,5, utf8_decode( 'Servicio: ' . $servicio->name ) ,0,1);
    $pdf->Cell(0,5, utf8_decode( 'Anomalia: ' . $grupoanomalia->name . ' - ' . $anomalia->name ),0,1);
    $pdf->Cell(0,5, utf8_decode('Fecha de denuncia: ' . $fecha ),0,1);
    $pdf->Cell(0,5, utf8_decode('Direccion: ' . $direccion ),0,1);
if ( $empresa ){
    $pdf->Cell(0,5,utf8_decode( 'Empresa: ' . $empresa[0]->name ),0,1);
}
if ( $direccion ){ 
    $pdf->Cell(0,5, utf8_decode( 'Comuna: ' . $comuna[0]->name ) ,0,1);
}
    $pdf->Cell(0,5, utf8_decode('Barrio: ' . $barrio ) ,0,1);
    $pdf->MultiCell(0,5, utf8_decode( 'Observacion: ' . $obs ) ,0,1);
    $pdf->Cell(0,5,'',0,1);
    $pdf->Cell(0,5,'-------------------------------------------------------------------------------------------------------------------',0,2);

    //Historial de eventos
    $pdf->Cell(0,5,'',0,1);
    $pdf->Cell(0,10,'   HISTORIAL DE EVENTOS:',0,2);

    $sqlSelect = "SELECT * FROM eventos WHERE id_post = '".$id_denuncia."' ORDER BY id ASC";
    $conn = register_conn();
	if ( $result = $conn->query( $sqlSelect ) ) {
		while($row = $result->fetch_assoc()) {
            $user_data = get_userdata( $row['user_id'] );
            $pdf->Cell(0,5, utf8_decode( $row['obs'] . ' Nuevo estado: ' . $row['nuevo_estado'] )  ,0,1);
            $pdf->Cell(0,5, utf8_decode( 'El dia: ' . $row['fecha'] . '. Por el operador: ' . $user_data->data->user_nicename ),0,1);
            $pdf->Cell(0,2,'',0,1);
        }
												
	} else {
		$pdf->Cell(0,5,'No hay eventos asociados.',0,1);
    }
    $pdf->Cell(0,5,'',0,1);
    $pdf->Cell(0,5,'-------------------------------------------------------------------------------------------------------------------',0,2);

    //Imagenes cargadas en la denuncia
    $pdf->Cell(0,5,'',0,1);
    $pdf->Cell(0,10,'   FOTOS Y RUTAS: ',0,2);

    $attacheds = get_attached_media( '' , $id_denuncia );
    foreach ($attacheds as $attached){
        //print_r($attached);
        $img_src = wp_get_attachment_image_src($attached->ID, 'small');
        $attachment_metadata = wp_get_attachment_metadata( $attached->ID );
        $attached_id    = $attached->ID;
        $attached_user  = get_the_author_meta( 'email',  $attached->post_author );
        $attached_date  = $attached->post_date;
        if( isset( $img_src[0] ) ){ 
        $attached_guid  = $img_src[0]; }
        $attached_type  = $attachment_metadata['attachment_type']; 
            if ( ( $attached->post_mime_type == 'image/jpeg' ) OR ( $attached->post_mime_type == 'image/png' ) OR ( $attached->post_mime_type == 'image/jpg' ) ) {

                
                $pdf->Cell(0,5,'',0,1);
                $pdf->Image( $attached_guid , null , null ,-150 , null );
                $pdf->Cell(0,5, '',0,1);
                $pdf->Cell(0,5,'Fecha de carga: ' . $attached_date,0,2);

                if(  $attached_type != 'FotoDenunciante' ){ 
                    $pdf->Cell(0,5, utf8_decode( 'Cargado por el operador: ' . $attached_user ),0,2);
                }else{
                    $pdf->Cell(0,5, utf8_decode( 'Cargado por denunciante.' ),0,2);
                }
                $pdf->Cell(0,8,'',0,1);
        }}
    $pdf->Cell(0,5,'',0,1);
    $pdf->Cell(0,5,'-------------------------------------------------------------------------------------------------------------------',0,2);
    
    //Comentarios cargados en la denuncia
    $pdf->Cell(0,5,'',0,1);
    $pdf->Cell(0,10,'   COMENTARIOS Y NOTIFICACIONES: ',0,2);

    	//Tomo los comentarios de la id den
        $args = array(
            'post_id' => $id_denuncia, 
            'orderby' => 'date',
            'order'   => 'ASC'
        );
        $comments = get_comments( $args );  //array
        
        foreach ( $comments as $comment ){ 
            if ( $comment->comment_type == 'private' ){ 

                $pdf->MultiCell(0,5, utf8_decode( $comment->comment_content ) ,0,2);
                $pdf->Cell(0,5, utf8_decode( 'Cargado el dia: ' . $comment->comment_date . '. Por el operador: '. $comment->comment_author ) ,0,2);
                $pdf->Cell(0,5,'',0,1);
            }
        }



$pdf->Output();

}
?>

