<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

use Illuminate\Routing\UrlGenerator;

use App\products;

use App\sells;

use App\entryqueue;

use App\gainorloss;

use App\maps;

use DB;

use App\notifications;

class sellsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        $carts = array();
    

        if (!Session::has('clientname') AND !Session::has('total')) {

            Session::put('clientname', 'Anounimous');
            Session::put('clientcontacts', '0000');
            Session::put('clientdocid', '0000');
            Session::put('totaliquido', 0);
            Session::put('iva', 0);
            Session::put('total', 0);

        }

        if (Session::exists('cart')) {

            $carts = Session::get('cart');

            


        }

        return view('sells.index', compact('carts'));

         

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updatequantity(Request $request, $id_product,$newqty) {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        $carts = Session::get('cart');

        $newcart = array();

        foreach($carts as $cart) {

            if ($cart['id'] == $id_product) {

                $cart['qty'] = $newqty;
                $cart['sobtotal'] = $newqty * $cart['price'];

            }

            $newcart[] = $cart;

        }

        Session::put('cart', $newcart);

        $this->displayRows();


    }

    public function displayRows() {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        $finalResults = '';

        $total = 0;

        $iva = 0;

        $carts = Session::get('cart');

        foreach ($carts as $cart) {

            $finalResults .= '<tr>';
            $finalResults .= '<td>' . $cart['id'] . '</td>';
            $finalResults .= '<td>' . $cart['description'] . '</td>';
            $finalResults .= '<td>' . number_format($cart['price'], 2, '.', ',') . '</td>';

            $finalResults .= "<td><input type='text' class='input-sm' id= '". $cart['id'] . "' value='". $cart['qty'] ."' onchange='updaterow(". $cart['id'] . ")' style='text-align:left; border:0px solid transparent;'></td>";

            $finalResults .= '<td>' . number_format($cart['sobtotal'], 2, '.', ',') . '</td>';
            $finalResults .= '<td><button onclick="removerow(' . $cart['id'] . ')" class="btn btn-round btn-xs mr-1" style="border-color:red; color:red;"><span class="now-ui-icons ui-1_trash"></span> </button></td>';
            $finalResults .= '</tr>';

            $total =  $total + $cart['price'] * $cart['qty'];

            if ($this->isTributable($cart['id'])){

                $iva = $iva + $cart['price'] * $cart['qty']*0.17;

            } else {

                $iva = $iva;
            }

            

        }

        
        Session::put('totaliquido', $total);
        Session::put('iva', $iva);
        Session::put('total', $total+$iva);
        $comiva = number_format(($iva), 2, '.', ',');
        $ultimate = number_format(($total+$iva), 2, '.', ',');
        $total = number_format($total, 2, '.', ',');  

        $table = "<table class='table table-striped'><thead><th>ID</th><th>".__('messages._productdescription') ."</th><th>".__('messages.sellstable_unitprice') ."</th><th>Qty</th><th>".__('messages.sellstable_sobtotal') ."</th></thead><tbody>".$finalResults."<tr><td <td colspan='4'><strong>".__('messages.sellstable_sobtotal') ."(MZN)</strong></td><td>".$total."</td></tr><tr><td colspan='4'><strong>IVA(MZN)</strong></td><td>".$comiva."</td></tr><tr><td colspan='4'><strong>".__('messages.sellstable_total') ."(MZN)</strong></td><td>".$ultimate."</td><tr></tbody>";


        Session::put('CURRENT_INV_CONTENT', $table);
        echo $finalResults;


    }

    public function isAlreadyInCart($id_product) {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

       if ( Session::exists('cart')) {

       		$carts = Session::get('cart');

       		 foreach($carts as $cart) {

	            if ($cart['id'] == $id_product) {

	                return true;

	            }

	        }


       }

        return false;

    }

    public function addrow(Request $request, $id_product) {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        $produto = products::find($id_product);

        $qty = 0;

        $cont = 0;

        
        if (!$this->isAlreadyInCart($id_product)) {


            $new = [


                'id' => $produto->id,
                'description' => $produto->descricao,
                'price' => $produto->precounitario,
                'qty' => $qty,
                'sobtotal' => $qty*$produto->precounitario,
                'id_user' => Session::get('id_user') ?? 2,
                'id_cliente' => Session::get('id_cliente') ?? 4

            ];

            $newcart = array();

            $newcart[0] = $new;

            if (Session::exists("cart")) {

                $carts = Session::get('cart');

                foreach ($carts as $cart) {

                    $newcart[] = $cart;
                        
                }

                Session::put('cart', $newcart);


            } else {

                    Session::put('cart', $newcart);


            }

           $this->displayRows();


        } else {

           	echo 0;

        }

                

    }

    public function removerow(Request $request,$id) {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        $oldcarts = Session::get('cart');

        $finalResults = '';

        $newcart = array();

        foreach ($oldcarts as $cart) {
            
            if ($cart['id'] != $id) {

                $newcart[] = $cart;

            }

        }

        Session::put('cart', $newcart);

        $this->displayRows();


    }

    public function updategain($id_product, $unitprice, $qty) {

        $from = date('Y');
        $month = date('m');
        $today = date('d');

        $gainorlosses = DB::table('gainorlosses')
                        ->where('id_product', $id_product)
                        ->whereYear('updated_at', $from)
                        ->whereDay('updated_at', $today)
                        ->whereMonth('updated_at', $month)
                        ->get();
     
        $products = DB::table('products')->where('products.id', $id_product)->get();
        $currentprice = $products[0]->precounitario;

        if ($products[0]->istributable == 1) {

            $currentprice = $currentprice*1.17;

        } 

        $ourgain = ($currentprice - $unitprice)*$qty;

        if (count($gainorlosses) > 0) {

            $id = $gainorlosses[0]->id;

            $gainorloss = gainorloss::find($id);
            $newgain = $gainorloss->gainorloss + $ourgain;

            $gainorloss->gainorloss = $newgain;

            $gainorloss->save();


        } else {

            $gainorloss = new gainorloss([

                'id_product' => $id_product,
                'gainorloss' => $ourgain

            ]);

            $gainorloss->save();

        }


    }

    public function updatentryqueue($id_product, $qty) {

        try{

            DB::beginTransaction();

            $fila = DB::table('entryqueues')->where('id_product', $id_product)->where('entryqty', '>', 0)->get()->first();
            
            $filaid= $fila->id;
            
            $filaqty = $fila->entryqty;
            $filaprice = $fila->unitprice;

            if ($filaqty >= $qty) {

                $newqty = $filaqty- $qty;

                $oldfile = entryqueue::find($filaid);
                $oldfile->entryqty = $newqty;

                $oldfile->save();

                $this->updategain($id_product, $filaprice, $newqty);


            } else {

                $oldfile = entryqueue::find($filaid);
                $oldfile->entryqty = 0;

                $oldfile->save();

                $newqty = $qty - $filaqty;

                $this->updategain($id_product, $filaprice, $newqty);

                $this->updatentryqueue($id_product, $newqty);

            }

            DB::commit();


        } catch(Exception $ex) {

            DB::rollBack();

        }


    }

    public function isTributable($id_product) {

        $product = products::find($id_product);

        if ($product->istributable == 1) {

            return true;

        } else {

            return false;

        }

    }

    public function isthereregisteredmap($id_product) {

        $from = date('Y');
        $month = date('m');
        $today = date('d');

        $results = array();
        $results = DB::table('maps')
            ->join('products', 'maps.id_product', '=', 'products.id')
            ->where('maps.id_product', $id_product)
            ->whereYear('maps.updated_at', $from)
            ->whereDay('maps.updated_at', $today)
            ->whereMonth('maps.updated_at', $month)
            ->get([
                'maps.id AS id',
                'products.descricao as description',
                'maps.quantidadeentrada as entryqty',
                'maps.quantidadesaida as sellqty',
                'maps.created_at as date'

                        ]);

        $count = count($results);

        if ($count > 0) {

            return true;

        } else {

            return false;

        }

    }

    public function processSell() {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        $carts = Session::get('cart');

        foreach ($carts as $cart) {
            
            $this->decrement($cart['id'], $cart['qty']);

        }

        $this->registSell();


    }

    private function decrement($id_product, $quantity) {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        try {

            DB::beginTransaction();
            $produto = products::find($id_product);

            $newqty = $produto->quantidade - $quantity;

            $produto->quantidade = $produto->quantidade - $quantity;

            
            $produname = $produto->descricao;
            $imagurl = $produto->imgURL;

            $produto->save();

            if ($newqty < 10 AND $newqty> 0) {

                $notification = new notifications([

                      'name' => $produname,
                      'imgurl' => $imagurl,
                      'object' => 'product',
                      'state' => 'has very low quantity'

                  ]);

                  $notification->save();

            } else if ($newqty < 0) {

                $notification = new notifications([

                      'name' => $produname,
                      'imgurl' => $imagurl,
                      'object' => 'product',
                      'state' => 'has negative quantity'

                  ]);

                  $notification->save();


            }

            DB::commit();


        } catch(Exception $ex) {

            DB::rollBack();

        }

    }

    function notUsedReference( ) {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        $reference = Date('m'). Date('d'). rand(1, 9999);

        $cots = DB::table('sells')
                ->where('reference', $reference)->get();

        if (count($cots) > 0) {

            $this->notUsedReference();            

        } else {

            return $reference;

        }

    }

    public function registSell() {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        try {

            $carts = Session::get('cart');

            $reference = $this->notUsedReference();

            Session::put('CURRENT_INVNR', $reference) ;

            DB::beginTransaction();

            foreach ($carts as $cart) {

                $this->updatentryqueue($cart['id'], $cart['qty']);

                $sellCar = new sells([

                    'id_user' => $cart['id_user'],
                    'id_id_products' => $cart['id'],
                    'id_cliente' => $cart['id_cliente'],
                    'valor_liquido' => $cart['sobtotal'],
                    'valor_total' => $cart['sobtotal'] + Session::get('iva'),
                    'quantidade' => $cart['qty'],
                    'reference' => $reference

                ]);

                if ($this->isthereregisteredmap($cart['id'])) {

                    //update the map row
                    $from = date('Y');
                    $month = date('m');
                    $today = date('d');

                    $mapse = array();
                    $mapse = DB::table('maps')
                    ->join('products', 'maps.id_product', '=', 'products.id')
                    ->where('products.id', $cart['id'])
                    ->whereYear('maps.updated_at', $from)
                    ->whereDay('maps.updated_at', $today)
                    ->whereMonth('maps.updated_at', $month)
                    ->get([
                        'maps.id as id',
                        'products.descricao as description',
                        'maps.quantidadeentrada as entryqty',
                        'maps.quantidadesaida as sellqty',
                        'maps.created_at as date'
        
                                ])->first();
                    
                    $iden = $mapse->id;
                    
                    $ourmap = maps::find($iden);
                    $oldsell = $ourmap->quantidadesaida;
                    $oldentry = $ourmap->quantidadeentrada;
                    $ourmap->quantidadesaida = $oldsell + $cart['qty'];

                    $ourmap->save();

                } else {

                    $ourmaponeone = new maps([

                        'id_product' => $cart['id'],
                        'quantidadeentrada' => 0,
                        'quantidadesaida' => $cart['qty']

                    ]);

                    $ourmaponeone->save();

                }

                $sellCar->save();

            }

            DB::commit();

        } catch(Exception $e) {

            DB::rollBack();

        }

    }

    public function generatepdf($invoicetype)
    {


        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        $_ENV['COMPANY_LOGO'] = asset('public/img/newadaext.png') ;
        $_ENV['COMPANY_NAME'] = 'Adatec Technology E.I';
        $_ENV['COMPANY_LOCATION'] = 'Maputo, Mozambique';
        $_ENV['COMPANY_ADDRESS'] = 'Avenida das FPLM , Rua 3454, Codigo postal 2462';
        $_ENV['COMPANY_TELEPHONE'] =  '+258 84 722 67 32';
        $_ENV['COMPANY_TELEFAX'] =  '';
        $_ENV['COMPANY_NUIT'] =  '11310834';

        $this->processSell();

        $title = __('messages._selltitle') . Session::get('CURRENT_INVNR');
        $simplecontent =Session::get('CURRENT_INV_CONTENT');
        
        if ($invoicetype == 0) {

            $header = $this->getSimpleHeader();
            $content = $this->getSimpleReport($title, $simplecontent);

        } else {

            $header = $this->getExtendedHeader();
            $content = $this->getSimpleReport($title, $simplecontent);

        }

        
        $olperatedby = Session::get('username');
        Session::forget('cart');
        Session::forget('clientname');
        Session::forget('clientcontacts');
        Session::forget('clientdocid');
        Session::forget('total');
        Session::forget('iva');
        Session::forget('totaliquido');

        $pdf = \PDF::loadHtml($content);
        $pdf->setOption('margin-top', '30mm');
        $pdf->setOption('margin-bottom', '15mm');
        $pdf->setOption('margin-left', '20mm');
        $pdf->setOption('header-html', $header);
        $pdf->setOption('footer-center', 'Designed by : adaptableman@gmail.com');
        $pdf->setOption('footer-font-size', '6');
        $pdf->setOption('footer-line', true);
        $pdf->setOption('footer-right', 'Page[page] of [toPage]');
        $pdf->setOption('footer-left', $olperatedby);

        $filename = time().'.pdf';

        $filepath = public_path('pdf/' . $filename);

        if( Session::has('currentfilepath')) {

            unlink(public_path('pdf/' . Session::get('currentfilename')));

            Session::forget('currentfilename');
            Session::forget('currentfilepath');

        }


        Session::put('currentfilename', $filename);

        Session::put('currentfilepath', url('/') . '/pdf/' . $filename);

        $pdf->save($filepath);

        $data = array(
            
            'url' => url('/') . '/public/pdf/' . $filename
            
        );
        
        echo json_encode($data);
    }

    public function getSimpleHeader() {

        $header = <<<HTML
            <!DOCTYPE html>
            <html>
            <head>
            <meta charset="utf-8">
            <style type="text/css">

                p {

                    font-size: 10pt; font-family: 'Segoe UI Light'; text-align: center

                }


            </style>
            </head>
            <body>
            
                       
                <P> {$_ENV['COMPANY_NAME']}</P>
                <p> {$_ENV['COMPANY_LOCATION']} </p>
                <p> {$_ENV['COMPANY_ADDRESS']} </p>
                <p>Tel.: {$_ENV['COMPANY_TELEPHONE']}  Fax: {$_ENV['COMPANY_TELEFAX']}</p>
                <p>NUIT:{$_ENV['COMPANY_NUIT']}</p> 

            
            </body>
            </html>
            HTML;

        return $header;

    }

    public function getSimpleReport($title, $content) {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        $username = Session::get('username');

        $operatedbylabel = __('messages._operatedby');

        $simplecontent = <<<HTML
        <!DOCTYPE html>
        <html>
        <head>
        <meta charset="utf-8">
        <style type="text/css">

            table{border-collapse:collapse}
            caption{padding-top:.25rem;padding-bottom:.25rem;color:#6c757d;text-align:left;caption-side:bottom}
            th{text-align:inherit}
            .table{ width:100%;margin-bottom:1rem;background-color:transparent}.table td,.table th{font-family: 'Segoe UI Light'; font-size: 9pt; padding:.25rem;vertical-align:top; text-align:left; border-top:1px solid #dee2e6}.table thead th{vertical-align:bottom;border-bottom:2px solid #dee2e6}.table tbody+tbody{border-top:2px solid #dee2e6}.table .table{background-color:#fff}.table-sm td,.table-sm th{}.table-bordered{border:1px solid #dee2e6}.table-bordered td,.table-bordered th{border:1px solid #dee2e6}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-borderless tbody+tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0}.table-striped tbody tr:nth-of-type(odd){background-color:rgba(0,0,0,.05)}

            button{

                display: none;

            }

            input[type='text']{

                width: 80px;
                border: 0;
                text-align: left;
                background: transparent;


            }

        </style>
        </head>
        <body>

        </br>
        <p align="center" style="text-align: right; border-bottom: 1px solid #ccc; padding: 6pt;font-family: 'Segoe UI Light';">{$title}</p>
        
        {$content}

        </table>

        <p style="border: 1px solid #ccc; padding: 6pt;font-family: 'Segoe UI Light'; font-size: 8pt;"><strong>{$operatedbylabel}</strong> {$username}</p>
        </body>
        </html>
        HTML;

        return $simplecontent;

    }

    public function getExtendedHeader() {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        $currentid =  Session::get('CURRENT_INVNR');
        $clientnamelabel = __('messages.sellstable_clientname');
        $clientname = Session::get('clientname') ?? 'Anounimous';
        $clientidlabel = __('messages._nuit');
        $clientdocid = Session::get('clientdocid')  ?? 'no ID';
        $clientcontactslabel = __('messages.sellstable_clientcontacts');
        $clientcontacts = Session::get('clientcontacts') ?? 'no concts';
        $datelabel = __('messages._date');
        $myday = date('Y-m-d h:m:sa');

        $header = <<<HTML
        <!DOCTYPE html>
        <html>
        <head>
        <meta charset="utf-8">
        <style type="text/css">

            #firstlist {

                margin-top: 20mm;

            }
            
            #firstlist, #secondlist {

               list-style: none; 

            }

            #firstlist li {

                display: inline-block;

            }

            #thirdlist div, #secondlist div {

                display: block;
                font-family: 'Segoe UI Light';

            }

            div strong {

                width: 6cm;
                font-size: 10pt;
                text-align: left;

            }


        </style>
        </head>
        <body>
        <table cellspacing="3" width="100%" style="font-size: 10pt; font-family: 'Segoe UI Light';">
            
            <td valign="top" width="5%"><img src="{$_ENV['COMPANY_LOGO']}" width="80" height="80"  /></td>
            <td id="secondlist" width="45%">
                   
                <div> {$_ENV['COMPANY_NAME']}</div>
                <div> {$_ENV['COMPANY_LOCATION']} </div>
                <div> {$_ENV['COMPANY_ADDRESS']} </div>
                <div>Tel.: {$_ENV['COMPANY_TELEPHONE']}  Fax: {$_ENV['COMPANY_TELEFAX']}</div>
                <div>NUIT:{$_ENV['COMPANY_NUIT']}</div>

            </td>
            <td width="15%">&nbsp;</td>
            <td id="thirdlist" style="" width="35%">
                   
                <div><strong > {$clientnamelabel} : </strong>{$clientname}</div>
                <div><strong> {$clientcontactslabel}  : </strong> {$clientcontacts} </div>
                <div><strong> {$clientidlabel} : </strong> {$clientdocid} </div>
                <div><strong> {$datelabel}: </strong>{$myday} </div>

            </td> 

        </table>
        </body>
        </html>
        HTML;

        return $header;

    }

    public function getPrimeHeader($title, $content) {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        $header = <<<HTML
            <!DOCTYPE html>
            <html>
            <head>
            <meta charset="utf-8">
            <style type="text/css">

                #secondlist div {

                    display: block;

                }


            </style>
            </head>
            <body>
            <table cellspacing="3" style="font-size: 10pt; font-family: 'Segoe UI Light';">
                
                <tr>
                    
                    <td valign="top"><img src="{$_ENV['COMPANY_LOGO']}" width="80" height="80"  /></td>
                    <td id="secondlist">
                           
                        <div> {$_ENV['COMPANY_NAME']}</div>
                        <div> {$_ENV['COMPANY_LOCATION']} </div>
                        <div> {$_ENV['COMPANY_ADDRESS']} </div>
                        <div>Tel.: {$_ENV['COMPANY_TELEPHONE']}  Fax: {$_ENV['COMPANY_TELEFAX']}</div>
                        <div>NUIT:{$_ENV['COMPANY_NUIT']}</div>

                    </td>


                </tr>

            </table>
            </body>
            </html>
            HTML;

        return $header;

    }

    public function computechanges($paidvalue) {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        $changes = $paidvalue-Session::get('total');

        if ($changes >= 0) {

            $btnname = __('messages.btn_processsell') ;

            echo "<div class='row'><div class='col-lg-12'><div class='input-group'><label for='invoicetype'>".__('messages._invoicetype').":</label><select class='form-control' name='invoicetype' id='invoicetype'><option value='0' selected>".__('messages._userlevel_normal')."</option><option value='1'>". __('messages._complete') ."</option></select></div></div><div class='row'><div class='col-lg-12'><button type='button'  class='form-control btn col-lg-12' onclick='processsell()' style='background:#ccc, color:#fff;'><span class='now-ui-icons ui-2_disk'></span> " . $btnname . "</button></div></div></div><p>" . __('messages._changes') . " : ". $changes ."</p>";

        } else {

            return "<p>" . __('messages._changes') . " : ". $changes ."</p>";

        }

    }

    public function getinvoicecontent() {
        
        $url = Session::get('currentfilepath');
        
        $finalResults = '<div class="sidebutton">';

            $finalResults .= '<button class="btn d-lg-none d-md-none d-sm-none d-inline" style="position:fixed; top:15%; right:0;">MMS</button>';

        $finalResults .= '</div>';

        $finalResults .= '<button class="closebuttonpdfreader  btn btn-just-icon btn-round" style="position:fixed; z-index: 9999999999999999; top:-45px; right:0px; color:white;border:1px solid white; text-align:center; background:transparent;"><span class="now-ui-icons ui-1_simple-remove"></span> </button>';

        $finalResults .= '<div class="container justify-content-center" style="font-size:10px; max-height:99%; ">';

            $finalResults .= '<div class="row p-0">';

              $finalResults .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-0">';

                $finalResults .= '<div class="pdfreaderContainer col-lg-12 col-md-12 col-sm-12 col-xs-12 justify-content-center p-0 m-0" >';
                
                    $finalResults .= '<div class="row col-lg-12">';
                        $finalResults .= '<span class="crudn_bar_title">';
                            $finalResults .= '<span class="crudn_bar_title_container col-lg-6" id="crudn_bar_title_container" >title around here</span>';
                                $finalResults .= '<span class="crudn_bar_nextPreiew col-lg-3">';
                                    $finalResults .= '<span id="prevbutton" class="btn-just-icon ml-2 p-0" style="font-size:16px;color:white;"><span class="now-ui-icons arrows-1_circle-left-38"></span></span>';
                                    $finalResults .= '<span id="nextbutton" class="btn-just-icon ml-2 p-0 mr-3" style="font-size:16px; color:white;"><span class="now-ui-icons arrows-1_circle-right-37"></span></span>';
                                $finalResults .= '</span>';
                            $finalResults .= '<span class="col-lg-3 pulls-right crudn_bar_pagesOf pulls-right" style="font-size:14px;"><span id="current_page">0</span> of <span id="total_page" style="text-align:left;">0</span></span>';
                        $finalResults .= '</span>';
                    $finalResults .= '</div>';

                  $finalResults .= '<div class="row">';

                    $finalResults .= '<div class="for_pdfc col-lg-9 col-md-9 col-sm-12">';

                        $finalResults .= '<canvas  id="crudn_pdf_container" class="col-lg-12 col-md-12 col-sm-12" width="100%" height="100%">';

                        $finalResults .= '</canvas>';

                    $finalResults .= '</div>';
                    $finalResults .= '<div class="col-lg-3 col-sm-12 col-md-4 col-xs-12 pl-3 pr-3" style="">';

                      $finalResults .= '<div class="row">';
                      
                        $finalResults .= '<div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12 d-lg-inline d-md-inline d-sm-inline d-block bg-white" style="min-height:100px;font-size:10px;">';

                          $finalResults .= '<button type="button" id="printbutton" class="btn btn-round btn-sm col-lg-12 d-block mb-3" style="background:#fff; border:1px solid #f96332; color:#f96332;font-size:9px;" onclick ="printPdf('.'\'' . $url . '\'' .')"><span class="now-ui-icons tech_print-fold"></span> Imprimir </button>';
                          $finalResults .= '<input type="email" id="forinvoiceemail" name="email_invoice" class="col-lg-12 form-control mt-3 mb-0" placeholder="email..." style="border:1px solid #f96332; color:#f96332;font-size:11px;">';
                          $finalResults .= '<button class="btn btn-round btn-sm col-lg-12 d-block mb-1 mt-1" onclick="sendInvoice();" style="background:#fff; border:1px solid #f96332; color:#f96332;font-size:9px;"><span class="now-ui-icons ui-1_send" style=""></span> Enviar</button>';

                        $finalResults .= '</div>';

                      $finalResults .= '</div>';

                    $finalResults .= '</div>';

                  $finalResults .= '</div>';

                $finalResults .= '</div>';

              $finalResults .= '</div>';

            $finalResults .= '</div>';

        $finalResults .= '</div>';
        
        $data = array(
            
            'information' => $finalResults,
            'url' => $url
            
        );
        
        echo json_encode($data);
        
    } 

    public function updatetotal() {

        $comiva = Session::get('total');
        $iva = Session::get('iva');
        $total = Session::get('totaliquido');
        $carts = Session::get('cart') ?? array(); 
        $countcarts = count($carts);

        $data = array(

            'totaliquido' => number_format($total, 2, '.', ',') ?? 0.00,
            'iva' => number_format($iva, 2, '.', ',') ?? 0.00,
            'comiva' => number_format($comiva, 2, '.', ',') ?? 0.00,
            'countcart' => $countcarts


        );

        echo json_encode($data);

    }

    public function updatetable() {

        $this->displayRows();

    }


}
