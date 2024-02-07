<?php
date_default_timezone_set('America/La_Paz');
require ('conexion.php');

class Invoice
{

    private $invoiceOrderTable = 'cotizacion';
    private $invoiceOrderItemTable = 'items_cotizacion';
    private $dbConnect = false;

    public function __construct()
    {
        global $conexion;
        $this->dbConnect = $conexion;
    }

    private function getData($sqlQuery)
    {
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        if (!$result) {
            die('Error in query: ' . mysqli_error());
        }
        $data = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

	public function getInvoiceList($limit, $offset, $searchValue = '')
    {
        $searchQuery = '';
        if ($searchValue != '') {
            $searchQuery = " WHERE cliente_nombre LIKE '%" . $searchValue . "%' OR nota LIKE '%" . $searchValue . "%'";
        }

        //$sqlQuery = "SELECT * FROM $this->invoiceOrderTable" . $searchQuery . " LIMIT $limit OFFSET $offset";
        //return $this->getData($sqlQuery);

        $sqlQuery = "SELECT * FROM $this->invoiceOrderTable" . $searchQuery . " ORDER BY fecha_cotizacion desc LIMIT $limit OFFSET $offset";
        return $this->getData($sqlQuery);
    }
	



    private function getNumRows($sqlQuery)
    {
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        if (!$result) {
            die('Error in query: ' . mysqli_error());
        }
        $numRows = mysqli_num_rows($result);
        return $numRows;
    }

    public function getTotalRecords()
    {
        $sqlQuery = "SELECT COUNT(*) as total_records FROM $this->invoiceOrderTable";
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        $row = mysqli_fetch_assoc($result);
        $totalRecords = $row['total_records'];
        return $totalRecords;
    }

    

    public function loadItemsList()
    {
        $sqlQuery = "SELECT * FROM productos"; // Reemplaza "productos" con el nombre de tu tabla de productos
        $items = $this->getData($sqlQuery);

        $htmlOptions = "";
        foreach ($items as $item) {
            $htmlOptions .= '<option value="' . $item['p_descripcion'] . '">' . $item['p_descripcion'] . '</option>';
        }

        echo $htmlOptions;
    }

    public function loadItems()
    {
        $productDescription = $_POST['p_descripcion'];
        $sqlQuery = "SELECT * FROM productos WHERE p_descripcion = '$productDescription'";
        $item = $this->getData($sqlQuery);

        // Verificar si se encontró el producto
        if (!empty($item)) {
            $product = $item[0];
            $response = [
                'id_producto' => $product['id_producto'],
                'p_descripcion' => $product['p_descripcion'],
                'p_precioc' => $product['p_precioc'],
                'p_preciov' => $product['p_preciov'],
                'p_marca' => $product['p_marca'],
                'p_unidad' => $product['p_unidad']
            ];
        } else {
            $response = [
                'id_producto' => '',
                'p_descripcion' => '',
                'p_precioc' => '',
                'p_preciov' => '',
                'p_marca' => '',
                'p_unidad' => ''
            ];
        }

        echo json_encode($response);
    }

    public function saveInvoice($POST)
    {
        $sqlInsert = "
            INSERT INTO " . $this->invoiceOrderTable . "(id_usuario, 
            cliente_nombre,
            fecha_cotizacion, 
            cliente_direccion, 
            total_antes_impuestos, 
            total_impuestos, 
            porcentaje, 
            transporte, 
            total_despues_impuestos,
            total_antes_impuestos_c, 
            order_amount_paid, 
            order_total_amount_due, 
            total_gastos, 
            total_ganancia, 
            porcentaje_ganancia, 
            nota,
            tiempo_garantia, 
            validez_cotizacion, 
            tiempo_entrega) 
            VALUES ('" . $POST['u'] . "',
             '" . $POST['companyName'] . "',
             '" . $POST['datetime'] . "',
             '" . $POST['address'] . "',
             '" . $POST['subTotal'] . "',
             '" . $POST['taxAmount'] . "',
             '" . $POST['taxRate'] . "',
             '" . $POST['transporte'] . "',
             '" . $POST['totalAftertax'] . "',
             '" . $POST['subtotal_c'] . "',
             '" . $POST['amountPaid'] . "',
             '" . $POST['amountDue'] . "',
             '" . $POST['total_gastos'] . "',
             '" . $POST['total_ganancia'] . "',
             '" . $POST['porcentaje_ganancia'] . "',
             '" . $POST['notes'] . "',
             '" . $POST['tiempo_garantia'] . "',
             '" . $POST['validez_cotizacion'] . "',
             '" . $POST['tiempo_entrega'] . "')";
        mysqli_query($this->dbConnect, $sqlInsert);
        $lastInsertId = mysqli_insert_id($this->dbConnect);
        for ($i = 0; $i < count($POST['productCode']); $i++) {
            $sqlInsertItem = "
            INSERT INTO " . $this->invoiceOrderItemTable . "(id_cotizacion,
            codigo_item,
            nombre_item,
            cantidad_item,
            precio_item,
            subtotal_item,
            marca_item,
            unidad_item,
            precio_item_c,
            subtotal_item_c) 
            VALUES ('" . $lastInsertId . "',
            '" . $POST['productCode'][$i] . "',
            '" . $POST['productName'][$i] . "',
            '" . $POST['quantity'][$i] . "',
            '" . $POST['price'][$i] . "',
            '" . $POST['total'][$i] . "',
            '" . $POST['marca'][$i] . "',
            '" . $POST['unidad'][$i] . "',
            '" . $POST['pricec'][$i] . "',
            '" . $POST['totalc'][$i] . "')";
            mysqli_query($this->dbConnect, $sqlInsertItem);
        }
    }

    public function updateInvoice($POST)
    {
        if ($POST['invoiceId']) {
            $sqlInsert = "
                UPDATE " . $this->invoiceOrderTable . " 
                SET cliente_nombre = '" . $POST['companyName'] . "',
                cliente_direccion= '" . $POST['address'] . "',
                total_antes_impuestos = '" . $POST['subTotal'] . "',
                total_impuestos = '" . $POST['taxAmount'] . "',
                porcentaje = '" . $POST['taxRate'] . "',
                transporte = '" . $POST['transporte'] . "',
                total_despues_impuestos = '" . $POST['totalAftertax'] . "',
                total_antes_impuestos_c = '" . $POST['subtotal_c'] . "',
                order_amount_paid = '" . $POST['amountPaid'] . "',
                order_total_amount_due = '" . $POST['amountDue'] . "',
                total_gastos = '" . $POST['total_gastos'] . "',
                total_ganancia = '" . $POST['total_ganancia'] . "',
                porcentaje_ganancia = '" . $POST['porcentaje_ganancia'] . "',
                nota = '" . $POST['notes'] . "',
                tiempo_garantia = '" . $POST['tiempo_garantia'] . "',
                validez_cotizacion = '" . $POST['validez_cotizacion'] . "',
                tiempo_entrega = '" . $POST['tiempo_entrega'] . "' WHERE id_cotizacion = '" . $POST['invoiceId'] . "'";
            mysqli_query($this->dbConnect, $sqlInsert);
        }
        $this->deleteInvoiceItems($POST['invoiceId']);
        for ($i = 0; $i < count($POST['productCode']); $i++) {
            $sqlInsertItem = "
                INSERT INTO " . $this->invoiceOrderItemTable . "(id_cotizacion, 
                codigo_item, 
                nombre_item, 
                cantidad_item, 
                precio_item, 
                subtotal_item,
                marca_item,
                unidad_item,
                precio_item_c,
                subtotal_item_c) 
                VALUES ('" . $POST['invoiceId'] . "',
                '" . $POST['productCode'][$i] . "',
                '" . $POST['productName'][$i] . "',
                '" . $POST['quantity'][$i] . "',
                '" . $POST['price'][$i] . "',
                '" . $POST['total'][$i] . "',
                '" . $POST['marca'][$i] . "',
                '" . $POST['unidad'][$i] . "',
                '" . $POST['pricec'][$i] . "',
                '" . $POST['totalc'][$i] . "')";
            mysqli_query($this->dbConnect, $sqlInsertItem);
        }
    }



    public function getInvoiceDetails($invoiceId)
{
    $sql = "SELECT * FROM " . $this->invoiceOrderTable . " WHERE id_cotizacion = '" . $invoiceId . "'";
    $result = mysqli_query($this->dbConnect, $sql);

    if ($result) {
        $invoiceDetails = mysqli_fetch_assoc($result);

        // Obtener ítems asociados a la cotización
        $itemsSql = "SELECT * FROM " . $this->invoiceOrderItemTable . " WHERE id_cotizacion = '" . $invoiceId . "'";
        $itemsResult = mysqli_query($this->dbConnect, $itemsSql);

        if ($itemsResult) {
            $items = [];
            while ($item = mysqli_fetch_assoc($itemsResult)) {
                $items[] = $item;
            }
            $invoiceDetails['items'] = $items;
        } else {
            $invoiceDetails['items'] = [];
        }

        return $invoiceDetails;
    } else {
        return false;
    }
}

    
    public function duplicateInvoice($invoiceId)
{
    $existingInvoice = $this->getInvoiceDetails($invoiceId);

    $clienteNombre = $existingInvoice['cliente_nombre'];
    $clienteDireccion = $existingInvoice['cliente_direccion'];
    $fechaCotizacion = date('Y-m-d H:i:s');  // Puedes ajustar esto según tus necesidades

    // Duplicar en COTIZACION
    $sqlDuplicate = "
        INSERT INTO " . $this->invoiceOrderTable . " 
        (id_usuario, cliente_nombre, fecha_cotizacion, cliente_direccion, 
        total_antes_impuestos, total_impuestos, porcentaje, transporte, 
        total_despues_impuestos, total_antes_impuestos_c, order_amount_paid, 
        order_total_amount_due, total_gastos, total_ganancia, porcentaje_ganancia, 
        nota, tiempo_garantia, validez_cotizacion, tiempo_entrega) 
        VALUES 
        ('" . $existingInvoice['id_usuario'] . "', '$clienteNombre', '$fechaCotizacion', '$clienteDireccion', 
        '" . $existingInvoice['total_antes_impuestos'] . "', '" . $existingInvoice['total_impuestos'] . "', '" . $existingInvoice['porcentaje'] . "', '" . $existingInvoice['transporte'] . "', 
        '" . $existingInvoice['total_despues_impuestos'] . "', '" . $existingInvoice['total_antes_impuestos_c'] . "', '" . $existingInvoice['order_amount_paid'] . "', 
        '" . $existingInvoice['order_total_amount_due'] . "', '" . $existingInvoice['total_gastos'] . "', '" . $existingInvoice['total_ganancia'] . "', '" . $existingInvoice['porcentaje_ganancia'] . "', 
        '" . $existingInvoice['nota'] . "', '" . $existingInvoice['tiempo_garantia'] . "', '" . $existingInvoice['validez_cotizacion'] . "', '" . $existingInvoice['tiempo_entrega'] . "')";

    mysqli_query($this->dbConnect, $sqlDuplicate);

    // Obtener el nuevo ID de la cotización duplicada en COTIZACION
    $lastInsertId = mysqli_insert_id($this->dbConnect);

    // Duplicar ítems en ITEMS_COTIZACION
    foreach ($existingInvoice['items'] as $item) {
        $codigoItem = $item['codigo_item'];
        $nombreItem = $item['nombre_item'];
        $cantidadItem = $item['cantidad_item'];
        $precioItem = $item['precio_item'];
        $subtotalItem = $item['subtotal_item'];
        $marcaItem = $item['marca_item'];
        $unidadItem = $item['unidad_item'];
        $precioItemC = $item['precio_item_c'];
        $subtotalItemC = $item['subtotal_item_c'];

        $sqlInsertItem = "
            INSERT INTO " . $this->invoiceOrderItemTable . "(id_cotizacion,
            codigo_item, nombre_item, cantidad_item, precio_item, subtotal_item,
            marca_item, unidad_item, precio_item_c, subtotal_item_c) 
            VALUES 
            ('$lastInsertId', '$codigoItem', '$nombreItem', '$cantidadItem', '$precioItem', '$subtotalItem',
            '$marcaItem', '$unidadItem', '$precioItemC', '$subtotalItemC')";
            
        mysqli_query($this->dbConnect, $sqlInsertItem);
    }

    return $lastInsertId;
}

    





















    public function getInvoice($invoiceId)
    {
        $sqlQuery = "SELECT * FROM  $this->invoiceOrderTable  WHERE id_cotizacion = '$invoiceId'";
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        $data = mysqli_fetch_assoc($result);
        return $data;
    }

    public function getInvoiceItems($invoiceId)
    {
        $sqlQuery = "SELECT * FROM $this->invoiceOrderItemTable WHERE id_cotizacion = '$invoiceId'";
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }

    public function deleteInvoice($invoiceId)
    {
        $sqlQuery = "DELETE FROM " . $this->invoiceOrderTable . " WHERE id_cotizacion = '" . $invoiceId . "'";
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        if ($result) {
            $this->deleteInvoiceItems($invoiceId);
            return true;
        } else {
            return false;
        }
        
    }

    private function deleteInvoiceItems($invoiceId)
    {
        $sqlQuery = "
            DELETE FROM " . $this->invoiceOrderItemTable . "
            WHERE id_cotizacion = '" . $invoiceId . "'";
        mysqli_query($this->dbConnect, $sqlQuery);
        return true;
    }

    public function generateInvoiceNumber()
    {
        $sqlQuery = "SELECT MAX(id_cotizacion) as invoice_num FROM $this->invoiceOrderTable";
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        $row = mysqli_fetch_assoc($result);
        $invoiceNumber = $row['invoice_num'];
        return $invoiceNumber;
    }
}

?>

