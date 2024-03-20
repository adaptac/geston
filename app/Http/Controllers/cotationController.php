<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

use DB;

use App\users;

use App\cotation;

use App\clients;

class cotationController extends Controller
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

        $cotations = DB::table('cotations')
        ->join('clients', 'cotations.id_cliente', '=', 'clients.id')
        ->join('users', 'cotations.id_user', '=', 'users.id')
        
        ->get([
            'cotations.id',
            'users.nome_completo AS name',
            'clients.nuitORbi',
            'clients.nome_completo',
            'cotations.created_at',
            'cotations.valor_total',
            'cotations.reference'

        ]);

        return view('cotation.index', compact('cotations'));

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

    function notUsedReference( ) {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        $reference = Date('m'). Date('d'). rand(1, 9999);

        $cots = DB::table('cotations')
                ->where('reference', $reference)->get();

        if (count($cots) > 0) {

            $this->notUsedReference();            

        } else {

            return $reference;

        }

    }

    public function processcotation($id_cotation) {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        $cartsex = DB::table('cotations')
                    ->join('products','cotations.id_id_products', '=', 'products.id')
                    ->get([

                        'cotations.id_id_products AS id',
                        'products.descricao AS description',
                        'products.precounitario AS price',
                        'cotations.quantidade AS qty',
                        'cotations.valor_total AS sobtotal',
                        'cotations.id_user AS id_user',
                        'cotations.id_cliente AS id_cliente'

                    ]);

        $carts = array();

        foreach ($cartsex as $exes) {

            $aux = [

                'id' => $exes->id,
                'description' => $exes->description,
                'price' => $exes->price,
                'qty' => $exes->qty,
                'sobtotal' => $exes->sobtotal,
                'id_user' => $exes->id_user,
                'id_cliente' => $exes->id_cliente

            ];

            $carts[] = $aux;

        }

        Session::put('cart', $carts);

        return redirect("sells");


    }

    public function processSell() {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        try {

            $carts = Session::get('cart');
            $refence = $this->notUsedReference( );

            $idclient = $carts[0]['id_cliente'];
            $data = DB::table('clients')
            ->where('id', $idclient)
            ->get();

            DB::beginTransaction();

            foreach ($carts as $cart) {

                $cots = new cotation([

                    'id_user' => $cart['id_user'],
                    'id_id_products' => $cart['id'],
                    'id_cliente' => $cart['id_cliente'],
                    'valor_liquido' => $cart['sobtotal'],
                    'valor_total' => $cart['sobtotal'] + $cart['sobtotal']*0.17,
                    'quantidade' => $cart['qty'],
                    'reference' => $refence

                ]);

                $cots->save();

            }

            Session::put('clientname', $data[0]->nome_completo );
            Session::put('clientcontacts', $data[0]->contacto);
            Session::put('clientdocid', $data[0]->nuitORbi);
            Session::put('CURRENT_INVNR', $refence);

            DB::commit();

        } catch(Exception $e) {

            DB::rollBack();

        }

    }

    public function generatepdf()
    {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        $_ENV['COMPANY_LOGO'] = asset('public/img/glogon.png') ;
        $_ENV['COMPANY_NAME'] = 'Adatec Technology E.I';
        $_ENV['COMPANY_LOCATION'] = 'Maputo, Mozambique';
        $_ENV['COMPANY_ADDRESS'] = 'Avenida das FPLM , Rua 3454, Codigo postal 2462';
        $_ENV['COMPANY_TELEPHONE'] =  '+258 84 722 67 32';
        $_ENV['COMPANY_TELEFAX'] =  '';
        $_ENV['COMPANY_NUIT'] =  '11310834';


        $this->processsell();

        $title = __('messages._cotationtitle') . Session::get('CURRENT_INVNR');

        $operatedbylabel = __('messages._operatedby');

        $current_content = Session::get('CURRENT_INV_CONTENT');
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
                <div><strong> {$datelabel}: </strong>{$myday} </span></div>

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

        $data = array(
            
            'url' => url('/') . '/public/pdf/' . $filename
            
        );
        
        echo json_encode($data);

    }


}
