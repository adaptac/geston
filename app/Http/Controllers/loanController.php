<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

use Illuminate\Routing\UrlGenerator;

use App\products;

use App\sells;

use DB;

use App\loans;

use App\loanslogs;

use App\notifications;

class loanController extends Controller
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
        
        $activeloans = DB::table('loans')
                    ->join('clients', 'loans.id_client', 'clients.id')
                    ->join('users', 'loans.id_user', 'users.id')
                    ->where('loans.status', 1)
                    ->get([

                        'loans.id AS id',
                        'loans.reference AS reference',
                        'clients.nome_completo AS clientname',
                        'clients.nuitORbi AS clientid',
                        'users.nome_completo AS operator',
                        'loans.moneytopay AS moneytopay',
                        'loans.debt AS debt'

                    ]);

        return view('loan.index', compact('activeloans'));

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
    public function showlogs($id_loan) {

        if(!\Session::has('username') ) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        $finalResults = '';

        $loanlogs = DB::table('loanslogs')
                        ->where('id_loan', $id_loan)->get();

        if (count($loanlogs) > 0) {

            $finalResults .= "<table class='table table-striped' style='font-size:8pt;'>";

            $finalResults .= '<thead>';

            $finalResults .= '<tr>';

            $finalResults .= '<th>'.__('messages._dateoftransaction').'</th>';

            $finalResults .= '<th>'.__('messages._paidvalue').' (MZN)</th>';

            $finalResults .= '<tr>';

            $finalResults .= '</thead>';

            $finalResults .= '<tbody>';

            foreach ( $loanlogs as $log) {

                $finalResults .= '<tr>';

                $finalResults .= '<td>' . $log->created_at . '</td>';

                $finalResults .= '<td>' . $log->paidmoney . '</td>';

                $finalResults .= '</tr>';

            }

            $finalResults .= '</tbody>';

            $finalResults .= '</table>';

        } else {

            $finalResults .= "<h3 style='color:red;'>No payment yet!!!</h3>";

        }


        echo $finalResults;

    }

    public function processSell() {

        if(!\Session::has('username') ) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        $carts = Session::get('cart');

        foreach ($carts as $cart) {
            
            $this->decrement($cart['id'], $cart['qty']);

        }

        $this->registSell();


    }

    private function decrement($id_product, $quantity) {

        if(!\Session::has('username') ) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

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

        if(!\Session::has('username') ) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

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

        if(!\Session::has('username') ) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        try {

            $carts = Session::get('cart');

            $reference = $this->notUsedReference();

            Session::put('CURRENT_INVNR', $reference) ;

            $totally = 0;

            DB::beginTransaction();

            foreach ($carts as $cart) {

                $totally = $totally + $cart['sobtotal'];

                $sellCar = new sells([

                    'id_user' => $cart['id_user'],
                    'id_id_products' => $cart['id'],
                    'id_cliente' => $cart['id_cliente'],
                    'valor_liquido' => $cart['sobtotal'],
                    'valor_total' => $cart['sobtotal'] + $cart['sobtotal']*0.17,
                    'quantidade' => $cart['qty'],
                    'reference' => $reference

                ]);

                $sellCar->save();

            }

            
            $loan = new loans([

                'reference' => $reference,
                'id_client' => $cart['id_cliente'],
                'id_user' => $cart['id_user'],
                'moneytopay' => $totally  + $totally*0.17,   
                'debt' => $totally  + $totally *0.17,
                'status' => 1

            ]);

            $loan->save();

            DB::commit();

            $loans = DB::table('loans')->where('status', 1)->get();

            $countloans = count($loans);

            Session::put('totalloans', $countloans);

        } catch(Exception $e) {

            DB::rollBack();

        }

    }

    public function pay($id_loan, $paidmoney) {

        if(!\Session::has('username') ) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        try{

            DB::beginTransaction();

            $loan = loans::find($id_loan);

            $new_debt = $loan->debt - $paidmoney;

            $loan->debt = $new_debt;

            $data = array(

                'code' => 1,
                'message' => 'Registered successfully!'

            );

            if ($new_debt <= 0) {

                $loan->status = 0;

                $data = array(

                    'code' => 1,
                    'message' => 'The loan is fully paid!'

                );

            }

            $loan->save();

            $loanlog = new loanslogs([

                'id_loan' => $id_loan,
                'paidmoney' => $paidmoney

            ]);

            $loanlog->save();

            DB::commit();

            $loans = DB::table('loans')->where('status', 1)->get();

            $countloans = count($loans);

            Session::put('totalloans', $countloans);

            echo json_encode($data);


        } catch(Exception $ex) {

            DB::rollBack();

            $data = array(

                'code' => 0,
                'message' => 'unabled to registre the loan payment!'

            );

            echo json_encode($data);

        }
  
    }

    public function generatepdf()
    {


        if(!\Session::has('username') ) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        $loans = DB::table('loans')->where('status', 1)->get();

        $countloans = count($loans);

        Session::put('totalloans', $countloans);

        $_ENV['COMPANY_LOGO'] = asset('public/img/glogon.png') ;
        $_ENV['COMPANY_NAME'] = 'Adatec Technology E.I';
        $_ENV['COMPANY_LOCATION'] = 'Maputo, Mozambique';
        $_ENV['COMPANY_ADDRESS'] = 'Avenida das FPLM , Rua 3454, Codigo postal 2462';
        $_ENV['COMPANY_TELEPHONE'] =  '+258 84 722 67 32';
        $_ENV['COMPANY_TELEFAX'] =  '';
        $_ENV['COMPANY_NUIT'] =  '11310834';


        $this->processSell();

        $title = ___('messages._loantitle') . Session::get('CURRENT_INVNR');
        $operatedbylabel = ___('messages._operatedby');
        $simplecontent =Session::get('CURRENT_INV_CONTENT');
        
        $header = $this->getExtendedHeader();
        $content = $this->getSimpleReport($title, $simplecontent);

        
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

    public function getSimpleReport($title, $content) {

        if(!\Session::has('username') ) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        $username = Session::get('username');

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
        <p align="center" style="border: 1px solid #ccc; padding: 6pt;font-family: 'Segoe UI Light';">{$title}</p>
        
        {$content}

        </table>

        <p style="border: 1px solid #ccc; padding: 6pt;font-family: 'Segoe UI Light'; font-size: 8pt;"><strong>{$operatedbylabel} </strong> {$username}</p>
        </body>
        </html>
        HTML;

        return $simplecontent;

    }

    public function getExtendedHeader() {

        if(!\Session::has('username') ) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

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
            <td width="15%">&nbsp;</td>
            <td id="thirdlist" style="" width="35%">
                   
                <div><strong > {$clientnamelabel} : </strong>{$clientname}</div>
                <div><strong> {$clientidlabel}  : </strong> {$clientcontacts} </div>
                <div><strong> {$clientidlabel} : </strong> {$clientdocid} </div>
                <div><strong> {$datelabel}: </strong>{$myday} </div>

            </td> 

        </table>
        </body>
        </html>
        HTML;

        return $header;

    }

}
