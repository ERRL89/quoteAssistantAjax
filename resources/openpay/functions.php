<?php

    //Revisa el listado de usuarios registrados en Open Pay Devuelve "1"-> Existe, Devuelve "0"-> No existe
    function searchUser2($email){
        global $openpay;
        try {
            $findData = array(
                'offset' => 0,
                'limit' => 0);
            
            $customerList = $openpay->customers->getList($findData);

            foreach($customerList as $customer){
                $emailCustomer=$customer->email; 
                //echo $emailCustomer."<br>";
                $idCustomer=$customer->id;
                //echo $idCustomer."<br>";

                //Valida si ya existe el correo electronico, si existe obtiene id de cliente $id_api
                if($emailCustomer==$email){
                    $id_api=$idCustomer;  
                    return [true,$id_api]; 
                }else{
                    return [false];
                }      
            }   
        }

        catch(Exception $e){
            return 0;
        }

    }

    //funcion que agrega nuevo cliente y genera su $id_api
    function addNewCustomer($nombreTitularCard, $email, $telefono, $direccionTDC, $cpTDC, $estadoTDC,$municipioTDC){
        global $openpay;
        try{
            $customerData = array(
                'name' => "$nombreTitularCard",
                'email' => "$email",
                'phone_number' => "$telefono",
                'address' => array(
                    'line1' => $direccionTDC,
                    'postal_code' => $cpTDC,
                    'state' => $estadoTDC,
                    'city' => $municipioTDC,
                    'country_code' => 'MX'));
            //Se agrega nuevo cliente y se genera su $id_api
            $customer = $openpay->customers->add($customerData);
            $id_api = $customer->id;
            return [true, $id_api];
        }
        catch(Exception $e){ 
            return [false]; 
        }
    }

    //Funcion que agrega nueva tarjeta a customer
    function addCardCustomer($numeroTarjeta, $expiracion, $nombreTitularCard, $codigoSeguridad, $calleTDC, $coloniaTDC, $cpTDC, $estadoTDC, $municipioTDC, $id_api){
        global $openpay;

        $num_tarjeta = "";
        $digitos = explode(" ", $numeroTarjeta);
        $limite = count($digitos);
        for($i = 0; $i < $limite; $i++){
            $num_tarjeta = "$num_tarjeta"."$digitos[$i]";
        }
        $expira = explode("/", $expiracion);
        $exp_month = $expira[0];
        $exp_year = $expira[1];

        try{
            $cardData = array(
            'holder_name' => "$nombreTitularCard",
            'card_number' => "$num_tarjeta",
            'cvv2' => "$codigoSeguridad",
            'expiration_month' => "$exp_month",
            'expiration_year' => "$exp_year",
            'address' => array(
                    'line1' => "$calleTDC",
                    'line2' => "$coloniaTDC",
                    'line3' => "",
                    'postal_code' => "$cpTDC",
                    'state' => "$estadoTDC",
                    'city' => "$municipioTDC",
                    'country_code' => 'MX'));
                        
            $customer = $openpay->customers->get($id_api);//Se posiciona sobre el customer creado
            $card = $customer->cards->add($cardData);
            //Obtiene datos de tarjeta agregada
            $tarjeta = $card->card_number;
            $id_tarjeta = $card->id;
            //echo "Tarjeta: ".$tarjeta."<br>"; 
            return [$tarjeta, $id_tarjeta];
        }

        catch(OpenpayApiTransactionError $e){
                $fallo = 1;
                $codigoError= $e->getErrorCode();
                return [$codigoError];
                //echo "Codigo de Error: ". $codigoError;
        } 
    }

    //Revisa si el customer tiene tarjetas registradas y elimina las que tiene
    function verifyDeleteCards($id_api){
        global $openpay;
        try{
            $findData = array(
                'offset' => 0,
                'limit' => 0);
            $customer = $openpay->customers->get($id_api);
            $cardList = $customer->cards->getList($findData);
            //Extrae ID de tarjeta registrada
            
            if (!empty($cardList)) {//El cliente no tiene tarjeta
                foreach($cardList as $cardID){
                    try{
                        $cardRegister=$cardID->id;
                        $card = $customer->cards->get($cardRegister);
                        $card->delete(); 
                    }
                    catch(Exception $e){
                    }   
                }   
            }
        }
        catch(Exception $e){  
        }
    }

    //Funcion que agrega nueva suscripcion
    function addSuscription($id_plan, $tarjeta, $id_api){
        global $openpay;
        try{
            $subscriptionDataRequest = array(
            'plan_id' => "$id_plan",
            'source_id' => "$tarjeta");
        
            $customer = $openpay->customers->get($id_api);
            $subscription = $customer->subscriptions->add($subscriptionDataRequest);
            $idSuscripcion=$subscription->id;
            $typeCard=$subscription->card->type;
            $typeBrand=$subscription->card->brand;
            $cardNumber=$subscription->card->card_number;
            $nameUser=$subscription->card->holder_name;
            
            $plan = $openpay->plans->get($id_plan);
            $nombre_plan = $plan->name;
            $costo_plan = '$ '.number_format($plan->amount, 2, '.', '');
            $tipo_plan = $plan->repeat_unit;
            if($tipo_plan == "month"){
                $tipo_plan = "Mensual";
            }
            else if($tipo_plan == "year"){
                $tipo_plan = "Anual";
            }

            return [$cardNumber, $nameUser, $typeCard, $typeBrand, $idSuscripcion];
        }
        catch(Exception $e){
            $fallo = 1;
            $cardNumber="";
            return [$cardNumber];
        }
    }

    //Funcion que agrega cargo unico
    function addCharge($tarjeta, $id_api, $kit, $costo, $deviceSessionId){
        global $openpay;
        try{
            $chargeData = array(
                'source_id' => $tarjeta,
                'method' => 'card',
                'amount' => round($costo*1.16),
                'description' => 'DEPÓSITO - '.$kit,
                'device_session_id' => $deviceSessionId);
            
            $customer = $openpay->customers->get($id_api);
            $charge = $customer->charges->create($chargeData); 
            $idCharge=$charge->id;
            $descriptionCharge=$charge->description;
            return [$idCharge, $descriptionCharge];
        }
        catch(Exception $e){ 
            $idCharge="";
            return [$idCharge];
        }
    }

?>


