<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

use Illuminate\Routing\UrlGenerator;

use App\products;

use App\sells;

use App\devolutions;

use DB;

class devolutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if(!\Session::has('username') ) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        if(Session::has('currentfilename')) {

            unlink(public_path('pdf/' . Session::get('currentfilename')));

            Session::forget('currentfilename');
            Session::forget('currentfilepath');
            Session::forget('devolutionreference');

            return redirect('/devolution');

        }

        if ( Session::has('devolutionreference')) {

            $carts = $this->findcart(Session::get('devolutionreference'));

            return view('devolution.index', compact('carts'));

        } else {

            return view('devolution.index');

        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function getdevolutiontable() {

        if(!\Session::has('username') ) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        $reference = Session::get('devolutionreference');

        $devolutions = DB::table('devolutions')
                            ->join('users', 'devolutions.id_users', 'users.id')
                            ->join('clients', 'devolutions.id_clients', 'clients.id')
                            ->join('products', 'devolutions.id_products', 'products.id')
                            ->where('reference', $reference)
                            ->get([

                                'devolutions.reference AS reference',
                                'devolutions.payback AS payback',
                                'devolutions.takenback_qty AS qty',
                                'products.descricao AS description',
                                'clients.nome_completo AS clientname',
                                'clients.nuitORbi AS clientid',
                                'clients.contacto AS contact',
                                'users.nome_completo AS operator'


                            ]);

        $finalResults = '';

        if (count($devolutions) > 0) {

            Session::put('clientname', $devolutions[0]->clientname );
            Session::put('clientcontacts', $devolutions[0]->contact);
            Session::put('clientdocid', $devolutions[0]->clientid);
            Session::put('CURRENT_INVNR', $devolutions[0]->reference);

            $finalResults .= "<table class='table striped-table'>";
            $finalResults .= '<thead>';
            $finalResults .= '<tr>';
            $finalResults .= '<th>'.__('messages.sellscotationtable_operator').'</th>';
            $finalResults .= '<th>'.__('messages._productdescription').'</th>';
            $finalResults .= '<th>'.__('messages._takenbackqty').'</th>';
            $finalResults .= '<th>'.__('messages._payback').'</th>';
            $finalResults .= '</tr>';
            $finalResults .= '</thead>';
            $finalResults .= '<tbody>';

            foreach($devolutions as $element) {

                $finalResults .= '<tr>';

                $finalResults .= '<td>' . $element->operator . '</td>';
                $finalResults .= '<td>' . $element->description . '</td>';                
                $finalResults .= '<td>' . $element->qty . '</td>';
                $finalResults .= '<td>' . $element->payback . '</td>';

                $finalResults .= '</tr>';

            }

            $finalResults .= '</tbody>';
            $finalResults .= '<table>';

        } else {

            $finalResults .= '<tr><h3>No products left!</h3></tr>';

        }


        return $finalResults;

    }

    public function findcart($reference, $state = false) {

        if(!\Session::has('username') ) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        $devolutioncart = array();

        Session::put('devolutionreference', $reference);

        $carts = DB::table('sells')
                    ->join('products', 'sells.id_id_products', 'products.id')
                    ->join('clients', 'sells.id_cliente', 'clients.id')
                    ->join('users', 'sells.id_user', 'users.id')
                    ->where('sells.reference',$reference)
                    ->where('sells.quantidade', '>', 0)
                    ->get([

                        'users.nome_completo AS operator',
                        'products.id as id',
                        'clients.nome_completo AS clientname',
                        'clients.nuitORbi AS clientid',
                        'products.descricao AS description',
                        'products.id AS productsid',
                        'sells.quantidade AS systemqty',
                        'sells.reference AS reference',
                        'products.precounitario AS unitprice',
                        'sells.id AS idsells'

                    ]);


        if (count($carts) > 0) {

            foreach ( $carts as $cart) {

                $qty = Session::get($cart->id) ?? 0;

                $aux['id'] = $cart->id;
                $aux['operator'] = $cart->operator;
                $aux['clientname'] = $cart->clientname;
                $aux['clientid'] = $cart->clientid;
                $aux['description'] = $cart->description;
                $aux['systemqty'] = $cart->systemqty;
                $aux['reference'] = $cart->reference;
                $aux['idsells'] = $cart->idsells;
                $aux['productsid'] = $cart->productsid;
                $aux['unitprice'] = $cart->unitprice;
                $aux['takeback'] = $qty*$cart->unitprice;
                $aux['takebackqty'] = $qty;

                Session::forget($cart->id);

                $devolutioncart[] = $aux;


            }

        }

        if ($state) {

            echo $this->displayupdatedtable($devolutioncart);

        } else {

            return $devolutioncart;

        }


    }


    public function displayupdatedtable($cart) {

        if(!\Session::has('username') ) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        $finalResults = '';

        if (count($cart) > 0) {

            foreach ( $cart as $element) {

                $finalResults .= '<tr>';

                $finalResults .= '<td>' .$element['id']. '</td>';
                $finalResults .= '<td>' .$element['operator']. '</td>';
                $finalResults .= '<td>' .$element['clientname']. '</td>';
                $finalResults .= '<td>' .$element['clientid']. '</td>';
                $finalResults .= '<td>' .$element['description']. '</td>';
                $finalResults .= '<td>' .$element['systemqty']. '</td>';
                $finalResults .= "<td><input type='text' name='takebackqty' value='" .$element['takebackqty']. "'  onchange='takeback(" . $element['idsells'] . ','  . $element['productsid'] . ',' . $element['unitprice'] . ")'></td>";
                $finalResults .= '<td>' .$element['takeback']. '</td>';
                $finalResults .= '<td><button onclick="takebackall( ' . $element['idsells'] . ','  . $element['productsid'] . ',' . $element['unitprice'] . ')" class="btn btn-round btn-xs mr-1" style="border-color:red; color:red;"><span class="now-ui-icons ui-1_trash"></span> </button></td>';

                $finalResults .= '</tr>';

            }


        } else {

            $finalResults .= "<tr style='color:red;'><h3>NO results was found!</h3></tr>";

        }

        return $finalResults;

    }

    public function takeback($idsells, $id_product, $unitprice, $qty) {

        if(!\Session::has('username') ) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        $sells = sells::find($idsells);

        $reference = $sells->reference;
        $actualqty = $sells->quantidade - $qty;
        $actualvalorliquido = $actualqty*$unitprice;
        $actualvalortotal = $actualqty*$unitprice*1.17;
        $devolution = $qty*$unitprice*1.17;

        Session::put($id_product, $qty);

        $devolutionqty = $sells->quantidade;
        $sells->quantidade= $actualqty;
        $sells->valor_liquido = $actualvalorliquido;
        $sells->valor_total = $actualvalortotal;

        if (Session::has('devolutiontotal')) {

            $newval = Session::get('devolutiontotal') + $devolution;

            Session::put('devolutiontotal', $newval);


        } else {

            Session::put('devolutiontotal', $devolution);

        }

        

        $devolutions = new devolutions([

            'id_users' => Session::get('userid') ?? 3,
            'id_clients' => $sells->id_cliente,
            'id_products' => $id_product,
            'payback' => $devolution,
            'takenback_qty' => $qty,
            'reference' => $sells->reference

        ]);

        $sells->save();

        $devolutions->save();

        $rows = $this->findcart($reference, false);
        $total = Session::get('devolutiontotal');

        $data = array(

            'rows' => $rows,
            'total' => $total

        );

        echo json_encode($data);

    }

    public function takebackall($idsells, $id_product, $unitprice) {

        if(!\Session::has('username') ) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        $sells = sells::find($idsells);

        $reference = $sells->reference;
        $actualqty = 0;
        $actualvalorliquido = 0;
        $actualvalortotal = 0;
        $devolution = $sells->quantidade*$unitprice*1.17;

        Session::put($id_product, $sells->quantidade);

        $devolutionqty = $sells->quantidade;
        $sells->quantidade= $actualqty;
        $sells->valor_liquido = $actualvalorliquido;
        $sells->valor_total = $actualvalortotal;

        if (Session::has('devolutiontotal')) {

            $newval = Session::get('devolutiontotal') + $devolution;

            Session::put('devolutiontotal', $newval);


        } else {

            Session::put('devolutiontotal', $devolution);

        }

        $devolutions = new devolutions([

            'id_users' => Session::get('userid') ?? 3,
            'id_clients' => $sells->id_cliente,
            'id_products' => $id_product,
            'payback' => $devolution,
            'takenback_qty' => $devolutionqty,
            'reference' => $sells->reference

        ]);

        $sells->save();

        $devolutions->save();

        $rows = $this->findcart($reference, false);
        $total = Session::get('devolutiontotal');

        $data = array(

            'rows' => $rows,
            'total' => $total

        );

        echo json_encode($data);

    }


    public function generatepdf()
    {

        if(!\Session::has('username') ) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        $current_content = $this->getdevolutiontable();

        $title = ___('messages._devolutiontitle') . Session::get('CURRENT_INVNR');

        $operatedbylabel = ___('messages._operatedby');

        $_ENV['COMPANY_LOGO'] = asset('public/img/glogon.png') ;
        $_ENV['COMPANY_NAME'] = 'Adatec Technology E.I';
        $_ENV['COMPANY_LOCATION'] = 'Maputo, Mozambique';
        $_ENV['COMPANY_ADDRESS'] = 'Avenida das FPLM , Rua 3454, Codigo postal 2462';
        $_ENV['COMPANY_TELEPHONE'] =  '+258 84 722 67 32';
        $_ENV['COMPANY_TELEFAX'] =  '';
        $_ENV['COMPANY_NUIT'] =  '11310834';


        $currentid =  Session::get('CURRENT_INVNR');
        $clientnamelabel = __('messages.sellstable_clientname');
        $clientname = Session::get('clientname') ?? 'Anounimous';
        $clientidlabel = __('messages.sellstable_clientcontacts');
        $clientdocid = Session::get('clientdocid')  ?? 'no ID';
        $clientcontactslabel = __('messages._documentid');
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
            <td width="5%">&nbsp;</td>
            <td id="thirdlist" style="" width="50%">
                   
                <div><strong > {$clientnamelabel} : </strong>{$clientname}</div>
                <div><strong> {$clientidlabel}  : </strong> {$clientcontacts} </div>
                <div><strong> {$clientidlabel} : </strong> {$clientdocid} </div>
                <div><strong> {$datelabel}: </strong>{$myday} </div>

            </td> 

        </table>
        </body>
        </html>
        HTML;

        $username = Session::get('username');

        $content = <<<HTML
        <!DOCTYPE html>
        <html>
        <head>
        <meta charset="utf-8">
        <style type="text/css">

            table{border-collapse:collapse}
            caption{padding-top:.25rem;padding-bottom:.25rem;color:#6c757d;text-align:left;caption-side:bottom}
            th{text-align:inherit}
            .table{ width:100%;margin-bottom:1rem;background-color:transparent}.table td,.table th{font-family: 'Segoe UI Light'; font-size: 9pt; padding:.25rem;vertical-align:top; text-align:left; border-top:1px solid #dee2e6}.table thead th{vertical-align:bottom;border-bottom:2px solid #dee2e6}.table tbody+tbody{border-top:2px solid #dee2e6}.table .table{background-color:#fff}.table-sm td,.table-sm th{}.table-bordered{border:1px solid #dee2e6}.table-bordered td,.table-bordered th{border:1px solid #dee2e6}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-borderless tbody+tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0}.table-striped tbody tr:nth-of-type(odd){background-color:rgba(0,0,0,.05)}

            input {

                border: 0;
                text-align: left;
                background: transparent;
                margin-left: 0;

            }

            button{

                display: none;

            }

        </style>
        </head>
        <body>

        </br>
        <p align="center" style="border: 1px solid #ccc; padding: 6pt;font-family: 'Segoe UI Light';">{$title}</p>
        
        {$current_content}

        </table>

        <p style="border: 1px solid #ccc; padding: 6pt;font-family: 'Segoe UI Light'; font-size: 8pt;"><strong>{$operatedbylabel} </strong> {$username}</p>
        </body>
        </html>
        HTML;

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

        if( Session::has('currentfilepath')) {

            unlink(public_path('pdf/' . Session::get('currentfilename')));

            Session::forget('currentfilename');
            Session::forget('currentfilepath');

        }
        
        $filename = time().'.pdf';

        $filepath = public_path('pdf/' . $filename);

        Session::put('currentfilename', $filename);

        Session::put('currentfilepath', url('/') . '/pdf/' . $filename);

        $pdf->save($filepath);

        Session::forget('devolutiontotal');
        Session::forget('devolutionreference');

        $data = array(
            
            'url' => url('/') . '/public/pdf/' . $filename
            
        );
        
        echo json_encode($data);

        

    }


}
