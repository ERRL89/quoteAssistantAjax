<?php

	////////////////////////////////////////////////////////////////////////////////////
	//                                                                                //
	// EN ESTA SECCIÓN SE INCLUIRÁN TODAS LAS FUNCIONES GENERALES QUE SON USADAS      //
	// POR LAS DISTINTAS ÁREAS QUE COMPONEN EL SISTEMA DE LA INTRANET.                //
	// 																	              //
	// PUEDES AÑADIR TANTAS FUNCIONES NECESITES, SIEMPRE Y CUANDO CUMPLAN LA REGLA    //
	// PRINCIPAL, LA CUAL ES QUE MÁS DE UN ÁREA NECESITE DE ESTAS FUNCIONES,          //
	// EN CASO CONTRARIO, DEBES COLOCARLA EN SU ARCHIVO "functions.php" LOCAL         //
	//                                                                                //
	////////////////////////////////////////////////////////////////////////////////////

    ///////////////// FUNCIÓN PARA VERIFICAR LA SESIÓN DEL USUARIO /////////////////
    function evaluateSession($partnerAreaId, $authorizedArea)
    {
        $folderBase = $GLOBALS['folderBase'];
        if($partnerAreaId == '')
        {
            header("location: /{$folderBase}login.php");
            die();
        }
        else if($partnerAreaId != $authorizedArea)
        {
            header("location: /{$folderBase}validateLogin.php");
            die();
        }
    }
    ///////////////// FUNCIÓN PARA VERIFICAR LA SESIÓN DEL USUARIO /////////////////

	///////////////// FUNCIÓN PARA CONVERTIR FECHA EN TEXTO /////////////////
    function dateToLabel($date, $mode = '') 
    {
        $fecha = substr($date, 0, 10);
        $numeroDia = date('d', strtotime($fecha));
        $dia = date('l', strtotime($fecha));
        $mes = date('F', strtotime($fecha));
        $anio = date('Y', strtotime($fecha));
        $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
        $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
        $nombredia = str_replace($dias_EN, $dias_ES, $dia);
        $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        $nombreMes = str_replace($meses_EN, $meses_ES, $mes);

        switch($mode)
        {
        	case 'minimal':
        	{
        		$label = $numeroDia."/".$nombreMes."/".$anio;
        		break;
        	}
        	case 'period':
        	{
        		$label = $nombreMes." ".$anio;
        		break;
        	}
        	case 'classic':
        	{
        		$label = $numeroDia." de ".$nombreMes." del ".$anio;
        		break;
        	}
        	case 'full':
        	{
        		$label = $nombredia." ".$numeroDia." de ".$nombreMes." del ".$anio;
        		break;
        	}
        	default:
        	{
        		$label = $numeroDia." de ".$nombreMes." del ".$anio;
        		break;
        	}
        }
        return $label;
    }
    ///////////////// FUNCIÓN PARA CONVERTIR FECHA EN TEXTO /////////////////

	///////////////// FUNCIÓN PARA ENVIAR EMAIL  /////////////////////

	#USO DE NAMESPACES NECESARIOS PARA USAR PHPMAILER
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	#

	#ESTRUCTURA DE COMO SE DEBEN DE MANDAR LOS ARGUMENTOS
	# $recipients => array(array()^n); -- Ejemplo ---> array(array('email' => 'ejemplo@acil.mx', 'name' => 'nombre_ejemplo'))

	# $sender => array(array()^n); -- (ESTE ARGUMENTO YA ESTA CONFIGURADO EN EL ARCHIVO CONF.PHP)

	# $mailSubject => string;

	# $mailPath => string;

	# $mailData => array(array()^n) -- Ejemplo ---> array(array('var_name' => 'cerrador', 'var_val' => $cerrador)) 
	# *Los var_name deben ser los nombres de las variables que necesita tu plantilla de correo*

	# $mailHost => string; -- (ESTE ARGUMENTO YA ESTA CONFIGURADO EN EL ARCHIVO CONF.PHP) 

	# $mailUser => string; -- (ESTE ARGUMENTO YA ESTA CONFIGURADO EN EL ARCHIVO CONF.PHP)

	# $mailPass => string; -- (ESTE ARGUMENTO YA ESTA CONFIGURADO EN EL ARCHIVO CONF.PHP)

	# $attachments => array(); -- Ejemplo ---> array('foto_ejemplo1.jpg', '../icons/foto_ejemplo2.png') -- (PARAMETRO OPCIONAL)

	function sendEmail($recipients, $sender, $mailSubject ,$mailPath, $mailData, $host, $user, $password, $attachments = array())
	{
		
		//Create an instance; passing `true` enables exceptions
		$mail = new PHPMailer(true);

		try 
		{
			//Server settings
			$mail->isSMTP(); //Send using SMTP
			$mail->Host       = $host; //Set the SMTP server to send through
			$mail->SMTPAuth   = true; //Enable SMTP authentication
			$mail->Username   = $user; //SMTP username
			$mail->Password   = $password; //SMTP password
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
			$mail->Port       = 465;    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
			$mail->CharSet    = "UTF-8";                       

			//Recipients (Destinatarios y remitente)
			#Remitente
			$mail->setFrom($sender['email'], $sender['name']);
			#

			#Destinatarios
			foreach($recipients as $recipient){
				$mail->addAddress($recipient['email'], $recipient['name']);
			}
			#

			//Attachments (Archivos adjuntos)
			#Archivos
			if(count($attachments) > 0){
				foreach ($attachments as $attachment) {
					$mail->addAttachment($attachment);
				}
			}
			#

			//Content (Contenido)
			#Se instancian variables necesarias para el correo
			foreach($mailData as $data){
				${$data['var_name']} = $data['var_val']; 
			}
			#

			#Se añade cuerpo de correo
			require($mailPath);
			#

			//Content
			$mail->isHTML(true);  //Set email format to HTML
			$mail->Subject = $mailSubject;
			$mail->Body    = $message;
			//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			$mail->send();
			
		} catch (Exception $e) {
			throw new Exception("Ocurrió un error al enviar correo: " . $e->getMessage());
		}

	}

	///////////////// FUNCIÓN PARA ENVIAR EMAIL  /////////////////////

?>