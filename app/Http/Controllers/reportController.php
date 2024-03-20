<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

use DB;


class reportController extends Controller
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

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        if (Session::get('level') == 2) {

            return redirect('/entries');

        }
        
        return view('report.index');

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
     * Store a newly updated resource in storage.
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


    public function displayTable($columns, $data){

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        if (Session::get('level') == 2) {

            return redirect('/entries');

        }

        $finalResults = "<table class='table table-stripped'>";

        $finalResults .= '<thead>';


            $finalResults .= '<tr>';

            if (count($columns) > 0) {

                foreach($columns as $column) {

                    $finalResults .= '<th>' . $column . '</th>';

                }

            } 
            $finalResults .= '</tr>';
        $finalResults .= '</thead>';
        $finalResults .= '<tbody id="hollowedtable">';

            if (count($data) > 0) {

                foreach ($data as $onedata) {

                    $finalResults .= '<tr>';

                    

                    for($i = 0; $i < count($columns) ; $i++) {

                        $finalResults .= '<td>' . $onedata[$i] . '</td>';

                    }

                    $finalResults .= '</tr>';

                }

            }
        $finalResults .= '</tbody>';
        $finalResults .= '</table>';

        Session::put('currentreporttable', $finalResults);

        return $finalResults;

    }

    public function isthereregisteredmap($id_product) {

        $from = date('Y');
        $month = date('m');
        $today = date('d');

        $results = array();
        $results = DB::table('maps')
            ->join('products', 'maps.id_products', '=', 'products.id')
            ->whereYear('maps.updated_at', $from)
            ->whereDay('maps.updated_at', $today)
            ->whereMonth('maps.updated_at', $month)
            ->get([

                'products.descricao as description',
                'maps.quantidade as entryqty',
                'maps.valor_total as sellqty',
                'maps.created_at as date'

                        ]);

        if (count(results) > 0) {

            return true;

        }

        return false;

    }

    public function getentriesstats($from, $to, $month) {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        if (Session::get('level') == 2) {

            return redirect('/entries');

        }

        $finalResults = '';

        $columns = [

            __('messages._operatedby'),
            __('messages._date'),
            __('messages.tabproducts_suplliers'),
            __('messages._supplierscontacts'),
            __('messages._productdescription'),
            __('messages._qty'),
            __('messages._unitbuyprice')

            ];

        $data = array();

        $results = array();

        if ($from != 'false' AND $to != 'false' AND $month != 'false') {

            Session::put('reporttitle', __('messages._titleentriesfromtomonth') .' ' . $from  . '/' . $month . ' and ' . $to . '/' . $month);

            $results = DB::table('entries')
                        ->join('users', 'entries.id_user', '=', 'users.id')
                        ->join('suppliers', 'entries.id_suppliers', '=', 'suppliers.id')
                        ->join('products', 'entries.id_products', '=', 'products.id')
                        ->whereYear('entries.updated_at', '>=', $from)
                        ->whereYear('entries.updated_at', '<=', $to)
                        ->whereMonth('entries.updated_at', $month)
                        ->get([

                            'users.nome_completo as operator',
                            'entries.updated_at AS date',
                            'suppliers.nome_completo AS supplier',
                            'suppliers.telefone AS contact',
                            'products.descricao AS description',
                            'entries.quantity AS quantity',
                            'entries.buy_price AS price'

                        ]);


        } else if ($from != 'false' AND $to != 'false' AND $month == 'false') {

            Session::put('reporttitle', __('messages._titleentriesfromto') . ' ' . $from  . ' and ' . $to);

            $results = DB::table('entries')
                        ->join('users', 'entries.id_user', '=', 'users.id')
                        ->join('suppliers', 'entries.id_suppliers', '=', 'suppliers.id')
                        ->join('products', 'entries.id_products', '=', 'products.id')
                        ->whereYear('entries.updated_at', '>=', $from)
                        ->whereYear('entries.updated_at', '<=', $to)
                        ->get([

                            'users.nome_completo as operator',
                            'entries.updated_at AS date',
                            'suppliers.nome_completo AS supplier',
                            'suppliers.telefone AS contact',
                            'products.descricao AS description',
                            'entries.quantity AS quantity',
                            'entries.buy_price AS price'

                        ]);            

        } else if ($from != 'false' AND $to == 'false' AND $month == 'false') {

            Session::put('reporttitle', __('messages._titleentriesfrom') . ' ' . $from );

            $results = DB::table('entries')
                        ->join('users', 'entries.id_user', '=', 'users.id')
                        ->join('suppliers', 'entries.id_suppliers', '=', 'suppliers.id')
                        ->join('products', 'entries.id_products', '=', 'products.id')
                        ->whereYear('entries.updated_at', '=', $from)
                        ->get([

                            'users.nome_completo as operator',
                            'entries.updated_at AS date',
                            'suppliers.nome_completo AS supplier',
                            'suppliers.telefone AS contact',
                            'products.descricao AS description',
                            'entries.quantity AS quantity',
                            'entries.buy_price AS price'

                        ]);

        } else if ($from != 'false' AND $to == 'false' AND $month != 'false') {

            Session::put('reporttitle', __('messages._titleentriesfrommonth') . ' ' . $from . '/' . $month);

           $results = DB::table('entries')
                        ->join('users', 'entries.id_user', '=', 'users.id')
                        ->join('suppliers', 'entries.id_suppliers', '=', 'suppliers.id')
                        ->join('products', 'entries.id_products', '=', 'products.id')
                        ->whereYear('entries.updated_at', '=', $from)
                        ->whereMonth('entries.updated_at', $month)
                        ->get([

                            'users.nome_completo as operator',
                            'entries.updated_at AS date',
                            'suppliers.nome_completo AS supplier',
                            'suppliers.telefone AS contact',
                            'products.descricao AS description',
                            'entries.quantity AS quantity',
                            'entries.buy_price AS price'

                        ]);

        } else if ($from == 'false' AND $to == 'false' AND $month == 'false') {

            Session::put('reporttitle', __('messages._titleentries'));

            $results = DB::table('entries')
                        ->join('users', 'entries.id_user', '=', 'users.id')
                        ->join('suppliers', 'entries.id_suppliers', '=', 'suppliers.id')
                        ->join('products', 'entries.id_products', '=', 'products.id')
                        ->get([

                            'users.nome_completo as operator',
                            'entries.updated_at AS date',
                            'suppliers.nome_completo AS supplier',
                            'suppliers.telefone AS contact',
                            'products.descricao AS description',
                            'entries.quantity AS quantity',
                            'entries.buy_price AS price'

                        ]);

        }

        foreach ($results as $result) {

                $aux = array(

                    $result->operator,
                    $result->date,
                    $result->supplier,
                    $result->contact,
                    $result->description,
                    $result->quantity,
                    number_format($result->price, 2, '.', ',')

                );

                $data[] = $aux;

            }


        $finalResults .= $this->displayTable($columns, $data);

        echo $finalResults;


    }

    public function getCurrentsellsstats() {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        if (Session::get('level') == 2) {

            return redirect('/entries');

        }

        $finalResults = '';

        $columns = [

                __('messages._operatedby'),
                __('messages._date'),
                __('messages.sellstable_clientname'),
                __('messages._productdescription'),
                __('messages._qty'),
                __('messages._paidvalue')

            ];

        $data = array();

        $results = array();

        $from = date('Y');
        $month = date('m');
        $today = date('d');

            Session::put('reporttitle', __('messages._titlepresentsells') . ' ' . $from  . '/' . $month . '/' . $today );

            $results = DB::table('sells')
                        ->join('users', 'sells.id_user', '=', 'users.id')
                        ->join('clients', 'sells.id_cliente', '=', 'clients.id')
                        ->join('products', 'sells.id_id_products', '=', 'products.id')
                        ->whereYear('sells.updated_at', $from)
                        ->whereDay('sells.updated_at', $today)
                        ->whereMonth('sells.updated_at', $month)
                        ->get([

                            'users.nome_completo as operator',
                            'sells.updated_at as date',
                            'clients.nome_completo as clientname',
                            'products.descricao as description',
                            'sells.quantidade as qty',
                            'sells.valor_total as total'

                        ]);


        foreach ($results as $result) {

                $aux = array(

                    $result->operator,
                    $result->date,
                    $result->clientname,
                    $result->description,
                    $result->qty,
                    number_format($result->total, 2, '.', ',')

                );

                $data[] = $aux;

            }


        $finalResults .= $this->displayTable($columns, $data);

        echo $finalResults;


    }

    public function getsellsstats($from, $to, $month) {

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        if (Session::get('level') == 2) {

            return redirect('/entries');

        }

        $finalResults = '';

        $columns = [

                __('messages._operatedby'),
                __('messages._date'),
                __('messages.sellstable_clientname'),
                __('messages._productdescription'),
                __('messages._qty'),
                __('messages._paidvalue')

            ];

        $data = array();

        $results = array();

        if ($from != 'false' AND $to != 'false' AND $month != 'false') {

            Session::put('reporttitle', __('messages._titlesellsfromtomonth') . ' ' . $from  . '/' . $month . ' and ' . $to . '/' . $month);

            $results = DB::table('sells')
                        ->join('users', 'sells.id_user', '=', 'users.id')
                        ->join('clients', 'sells.id_cliente', '=', 'clients.id')
                        ->join('products', 'sells.id_id_products', '=', 'products.id')
                        ->whereYear('sells.updated_at', '>=', $from)
                        ->whereYear('sells.updated_at', '<=', $to)
                        ->whereMonth('sells.updated_at', $month)
                        ->get([

                            'users.nome_completo as operator',
                            'sells.updated_at as date',
                            'clients.nome_completo as clientname',
                            'products.descricao as description',
                            'sells.quantidade as qty',
                            'sells.valor_total as total'

                        ]);


        } else if ($from != 'false' AND $to != 'false' AND $month == 'false') {

            Session::put('reporttitle', __('messages._titlesellsfromtomonth') . ' ' . $from  . ' and ' . $to);

            $results = DB::table('sells')
                        ->join('users', 'sells.id_user', '=', 'users.id')
                        ->join('clients', 'sells.id_cliente', '=', 'clients.id')
                        ->join('products', 'sells.id_id_products', '=', 'products.id')
                        ->whereYear('sells.updated_at', '>=', $from)
                        ->whereYear('sells.updated_at', '<=', $to)
                        ->get([

                            'users.nome_completo as operator',
                            'sells.updated_at as date',
                            'clients.nome_completo as clientname',
                            'products.descricao as description',
                            'sells.quantidade as qty',
                            'sells.valor_total as total'

                        ]);

        } else if ($from != 'false' AND $to == 'false' AND $month == 'false') {

            Session::put('reporttitle', __('messages._titlesellsfrom') . ' ' . $from );

            $results = DB::table('sells')
                        ->join('users', 'sells.id_user', '=', 'users.id')
                        ->join('clients', 'sells.id_cliente', '=', 'clients.id')
                        ->join('products', 'sells.id_id_products', '=', 'products.id')
                        ->whereYear('sells.updated_at', $from)
                        ->get([

                            'users.nome_completo as operator',
                            'sells.updated_at as date',
                            'clients.nome_completo as clientname',
                            'products.descricao as description',
                            'sells.quantidade as qty',
                            'sells.valor_total as total'

                        ]);

        } else if ($from != 'false' AND $to == 'false' AND $month != 'false') {

            Session::put('reporttitle', __('messages._titlesellsfrommonth') . ' ' . $from . '/' . $month);

            $results = DB::table('sells')
                        ->join('users', 'sells.id_user', '=', 'users.id')
                        ->join('clients', 'sells.id_cliente', '=', 'clients.id')
                        ->join('products', 'sells.id_id_products', '=', 'products.id')
                        ->whereYear('sells.updated_at', $from)
                        ->whereMonth('sells.updated_at', $month)
                        ->get([

                            'users.nome_completo as operator',
                            'sells.updated_at as date',
                            'clients.nome_completo as clientname',
                            'products.descricao as description',
                            'sells.quantidade as qty',
                            'sells.valor_total as total'

                        ]);

        } else if ($from == 'false' AND $to == 'false' AND $month == 'false') {

            Session::put('reporttitle', __('messages._titlesells'));

            $results = DB::table('sells')
                        ->join('users', 'sells.id_user', '=', 'users.id')
                        ->join('clients', 'sells.id_cliente', '=', 'clients.id')
                        ->join('products', 'sells.id_id_products', '=', 'products.id')
                        ->get([

                            'users.nome_completo as operator',
                            'sells.updated_at as date',
                            'clients.nome_completo as clientname',
                            'products.descricao as description',
                            'sells.quantidade as qty',
                            'sells.valor_total as total'

                        ]);

        }

        foreach ($results as $result) {

                $aux = array(

                    $result->operator,
                    $result->date,
                    $result->clientname,
                    $result->description,
                    $result->qty,
                    number_format($result->total, 2, '.', ',')

                );

                $data[] = $aux;

            }


        $finalResults .= $this->displayTable($columns, $data);

        echo $finalResults;


    }

    public function getloansstats($from, $to, $month) {

        if (Session::get('level') == 3) {

            return redirect('/loans');

        }

        if (Session::get('level') == 2) {

            return redirect('/entries');

        }

        $finalResults = '';

        $columns = [

                __('messages._operatedby'),
                __('messages._date'),
                __('messages.sellstable_clientname'),
                __('messages.sellstable_clientid'),
                __('messages._moneytopay'),
                __('messages._debt')

            ];

        $data = array();

        $results = array();

        if ($from != 'false' AND $to != 'false' AND $month != 'false') {

            Session::put('reporttitle', __('messages._titleloansfromtomonth') . ' ' . $from  . '/' . $month . ' and ' . $to . '/' . $month);

            $results = DB::table('loans')
                        ->join('users', 'loans.id_user', '=', 'users.id')
                        ->join('clients', 'loans.id_client', '=', 'clients.id')
                        ->whereYear('loans.updated_at', '>=', $from)
                        ->whereYear('loans.updated_at', '<=', $to)
                        ->whereMonth('loans.updated_at', $month)
                        ->get([

                            'users.nome_completo as operator',
                            'loans.updated_at as date',
                            'clients.nome_completo as clientname',
                            'clients.nuitORbi as clientid',
                            'loans.moneytopay as moneytopay',
                            'loans.debt as debt'

                        ]);


        } else if ($from != 'false' AND $to != 'false' AND $month == 'false') {

            Session::put('reporttitle', __('messages._titleloansfromtomonth') . ' ' . $from  . ' and ' . $to);

            $results = DB::table('loans')
                        ->join('users', 'loans.id_user', '=', 'users.id')
                        ->join('clients', 'loans.id_client', '=', 'clients.id')
                        ->whereYear('loans.updated_at', '>=', $from)
                        ->whereYear('loans.updated_at', '<=', $to)
                        ->get([

                            'users.nome_completo as operator',
                            'loans.updated_at as date',
                            'clients.nome_completo as clientname',
                            'clients.nuitORbi as clientid',
                            'loans.moneytopay as moneytopay',
                            'loans.debt as debt'

                        ]);

        } else if ($from != 'false' AND $to == 'false' AND $month == 'false') {

            Session::put('reporttitle', __('messages._titleloansfrom') . ' ' . $from );

            $results = DB::table('loans')
                        ->join('users', 'loans.id_user', '=', 'users.id')
                        ->join('clients', 'loans.id_client', '=', 'clients.id')
                        ->whereYear('loans.updated_at', '>=', $from)
                        ->get([

                            'users.nome_completo as operator',
                            'loans.updated_at as date',
                            'clients.nome_completo as clientname',
                            'clients.nuitORbi as clientid',
                            'loans.moneytopay as moneytopay',
                            'loans.debt as debt'

                        ]);

        } else if ($from != 'false' AND $to == 'false' AND $month != 'false') {

            Session::put('reporttitle', __('messages._titleloansfrommonth') . ' ' . $from . '/' . $month);

            $results = DB::table('loans')
                        ->join('users', 'loans.id_user', '=', 'users.id')
                        ->join('clients', 'loans.id_client', '=', 'clients.id')
                        ->whereYear('loans.updated_at', '>=', $from)
                        ->whereMonth('loans.updated_at', $month)
                        ->get([

                            'users.nome_completo as operator',
                            'loans.updated_at as date',
                            'clients.nome_completo as clientname',
                            'clients.nuitORbi as clientid',
                            'loans.moneytopay as moneytopay',
                            'loans.debt as debt'

                        ]);

        } else if ($from == 'false' AND $to == 'false' AND $month == 'false') {

            Session::put('reporttitle', __('messages._titleloans'));

            $results = DB::table('loans')
                        ->join('users', 'loans.id_user', '=', 'users.id')
                        ->join('clients', 'loans.id_client', '=', 'clients.id')
                        ->get([

                            'users.nome_completo as operator',
                            'loans.updated_at as date',
                            'clients.nome_completo as clientname',
                            'clients.nuitORbi as clientid',
                            'loans.moneytopay as moneytopay',
                            'loans.debt as debt'

                        ]);

        }

        foreach ($results as $result) {

                $aux = array(

                    $result->operator,
                    $result->date,
                    $result->clientname,
                    $result->clientid,
                    number_format($result->moneytopay, 2, '.', ','),
                    number_format($result->debt, 2, '.', ',')

                );

                $data[] = $aux;

            }


        $finalResults .= $this->displayTable($columns, $data);

        echo $finalResults;


    }

    public function getdevolutionsstats($from, $to, $month) {

        if (Session::get('level') == 3) {

            return redirect('/devolution');

        }

        if (Session::get('level') == 2) {

            return redirect('/entries');

        }

        $finalResults = '';

        $columns = [

                __('messages._operatedby'),
                __('messages._date'),
                __('messages.sellstable_clientname'),
                __('messages.sellstable_clientid'),
                __('messages._productdescription'),
                __('messages._payback'),
                __('messages._takenbackqty')

            ];

        $data = array();

        $results = array();

        if ($from != 'false' AND $to != 'false' AND $month != 'false') {

            Session::put('reporttitle', __('messages._titledevolutionsfromtomonth') . ' ' . $from  . '/' . $month . ' and ' . $to . '/' . $month);

            $results = DB::table('devolutions')
                        ->join('users', 'devolutions.id_users', '=', 'users.id')
                        ->join('clients', 'devolutions.id_clients', '=', 'clients.id')
                        ->join('products', 'devolutions.id_products', '=', 'products.id')
                        ->whereYear('devolutions.updated_at', '>=', $from)
                        ->whereYear('devolutions.updated_at', '<=', $to)
                        ->whereMonth('devolutions.updated_at', $month)
                        ->get([

                            'users.nome_completo as operator',
                            'devolutions.updated_at as date',
                            'clients.nome_completo as clientname',
                            'clients.nuitORbi as clientid',
                            'products.descricao as description',
                            'devolutions.payback as payback',
                            'devolutions.takenback_qty as takenbackqty'

                        ]);


        } else if ($from != 'false' AND $to != 'false' AND $month == 'false') {

            Session::put('reporttitle', __('messages._titledevolutionsfromtomonth') . ' ' . $from  . ' and ' . $to);

            $results = DB::table('devolutions')
                        ->join('users', 'devolutions.id_users', '=', 'users.id')
                        ->join('clients', 'devolutions.id_clients', '=', 'clients.id')
                        ->join('products', 'devolutions.id_products', '=', 'products.id')
                        ->whereYear('devolutions.updated_at', '>=', $from)
                        ->whereYear('devolutions.updated_at', '<=', $to)
                        ->get([

                            'users.nome_completo as operator',
                            'devolutions.updated_at as date',
                            'clients.nome_completo as clientname',
                            'clients.nuitORbi as clientid',
                            'products.descricao as description',
                            'devolutions.payback as payback',
                            'devolutions.takenback_qty as takenbackqty'

                        ]);

        } else if ($from != 'false' AND $to == 'false' AND $month == 'false') {

            Session::put('reporttitle', __('messages._titledevolutionsfrom') . ' ' . $from );

            $results = DB::table('devolutions')
                        ->join('users', 'devolutions.id_users', '=', 'users.id')
                        ->join('clients', 'devolutions.id_clients', '=', 'clients.id')
                        ->join('products', 'devolutions.id_products', '=', 'products.id')
                        ->whereYear('devolutions.updated_at', '>=', $from)
                        ->get([

                            'users.nome_completo as operator',
                            'devolutions.updated_at as date',
                            'clients.nome_completo as clientname',
                            'clients.nuitORbi as clientid',
                            'products.descricao as description',
                            'devolutions.payback as payback',
                            'devolutions.takenback_qty as takenbackqty'

                        ]);

        } else if ($from != 'false' AND $to == 'false' AND $month != 'false') {

            Session::put('reporttitle', __('messages._titledevolutionsfrommonth') . ' ' . $from . '/' . $month);

            $results = DB::table('devolutions')
                        ->join('users', 'devolutions.id_users', '=', 'users.id')
                        ->join('clients', 'devolutions.id_clients', '=', 'clients.id')
                        ->join('products', 'devolutions.id_products', '=', 'products.id')
                        ->whereYear('devolutions.updated_at', '>=', $from)
                        ->whereMonth('devolutions.updated_at', $month)
                        ->get([

                            'users.nome_completo as operator',
                            'devolutions.updated_at as date',
                            'clients.nome_completo as clientname',
                            'clients.nuitORbi as clientid',
                            'products.descricao as description',
                            'devolutions.payback as payback',
                            'devolutions.takenback_qty as takenbackqty'

                        ]);

        } else if ($from == 'false' AND $to == 'false' AND $month == 'false') {

            Session::put('reporttitle', __('messages._titledevolutions'));

            $results = DB::table('devolutions')
                        ->join('users', 'devolutions.id_users', '=', 'users.id')
                        ->join('clients', 'devolutions.id_clients', '=', 'clients.id')
                        ->join('products', 'devolutions.id_products', '=', 'products.id')
                        ->get([

                            'users.nome_completo as operator',
                            'devolutions.updated_at as date',
                            'clients.nome_completo as clientname',
                            'clients.nuitORbi as clientid',
                            'products.descricao as description',
                            'devolutions.payback as payback',
                            'devolutions.takenback_qty as takenbackqty'

                        ]);

        }

        foreach ($results as $result) {

                $aux = array(

                    $result->operator,
                    $result->date,
                    $result->clientname,
                    $result->clientid,
                    $result->description,
                    number_format($result->payback, 2, '.', ','),
                    $result->takenbackqty,

                );

                $data[] = $aux;

            }


        $finalResults .= $this->displayTable($columns, $data);

        echo $finalResults;


    }

    private function getuserstats($from, $to, $month) {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        if (Session::get('level') == 2) {

            return redirect('/entries');

        }

        $finalResults = '';

        $columns = [

                __('messages._vreatedat'),
                __('messages._fullname'),
                __('messages._usernae'),
                'Email',
                __('messages._mobile')

            ];

        $data = array();

        $results = array();

        if ($from != 'false' AND $to != 'false' AND $month != 'false') {

            Session::put('reporttitle', __('messages._titleusersfromtomonth') . '  ' . $from  . '/' . $month . ' and ' . $to . '/' . $month);

            $results = DB::table('users')
                        ->whereYear('updated_at', '>=', $from)
                        ->whereYear('updated_at', '<=', $to)
                        ->whereMonth('updated_at', $month)
                        ->get();


        } else if ($from != 'false' AND $to != 'false' AND $month == 'false') {

            Session::put('reporttitle', __('messages._titleusersfromto') . '  ' . $from  . ' and ' . $to);

            $results = DB::table('users')
                        ->whereYear('updated_at', '>=', $from)
                        ->whereYear('updated_at', '<=', $to)
                        ->get();

        } else if ($from != 'false' AND $to == 'false' AND $month == 'false') {

            Session::put('reporttitle', __('messages._titleusersfrom') . '  ' . $from );

            $results = DB::table('users')
                        ->whereYear('updated_at', '=', $from)
                        ->get();

        } else if ($from != 'false' AND $to == 'false' AND $month != 'false') {

            Session::put('reporttitle', __('messages._titleusersfrommonth') . '  ' . $from . '/' . $month);

            $results = DB::table('users')
                        ->whereYear('updated_at', '=', $from)
                        ->whereMonth('updated_at', $month)
                        ->get();

        } else if ($from == 'false' AND $to == 'false' AND $month == 'false') {

            Session::put('reporttitle', __('messages._titleusers'));

           $results = DB::table('users')
                        ->get();

        }

        foreach ($results as $result) {

                $aux = array(

                    $result->updated_at,
                    $result->nome_completo,
                    $result->username,
                    $result->email,
                    $result->telemovel

                );

                $data[] = $aux;

            }


        $finalResults .= $this->displayTable($columns, $data);

        echo $finalResults;

    }

    private function getmapstats($from, $to, $month, $id_product = false) {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        if (Session::get('level') == 2) {

            return redirect('/entries');

        }

        $finalResults = '';

        $columns = [

                __('messages._date'),
                __('messages._productdescription'),
                __('messages.btn_entries'),
                __('messages.btn_sells')

            ];

        $data = array();

        $results = array();

        if ($from != 'false' AND $to != 'false' AND $month != 'false') {

            Session::put('reporttitle', __('messages._titlemapsfromtomonth') . ' ' . $from  . '/' . $month . ' and ' . $to . '/' . $month);

            if ($id_product != 'false') {

                $results = DB::table('maps')
                    ->join('products', 'maps.id_product', '=', 'products.id')
                    ->where('products.id', $id_product)
                    ->whereYear('maps.updated_at', $from)
                    ->whereDay('maps.updated_at', $to)
                    ->whereMonth('maps.updated_at', $month)
                    ->get([
                        'maps.id as id',
                        'products.descricao as description',
                        'maps.quantidadeentrada as entryqty',
                        'maps.quantidadesaida as sellqty',
                        'maps.created_at as date'
        
                                ]);

            } else {

                $results = DB::table('maps')
                    ->join('products', 'maps.id_product', '=', 'products.id')
                    ->whereYear('maps.updated_at', $from)
                    ->whereDay('maps.updated_at', $to)
                    ->whereMonth('maps.updated_at', $month)
                    ->get([
                        'maps.id as id',
                        'products.descricao as description',
                        'maps.quantidadeentrada as entryqty',
                        'maps.quantidadesaida as sellqty',
                        'maps.created_at as date'
        
                                ]);

            }
             


        } else if ($from != 'false' AND $to != 'false' AND $month == 'false') {

            Session::put('reporttitle', __('messages._titlemapsfromto') . ' ' . $from  . ' and ' . $to);

            if ($id_product != 'false') {

                $results = DB::table('maps')
                    ->join('products', 'maps.id_product', '=', 'products.id')
                    ->where('products.id', $id_product)
                    ->whereYear('maps.updated_at', $from)
                    ->whereDay('maps.updated_at', $to)
                    ->get([
                        'maps.id as id',
                        'products.descricao as description',
                        'maps.quantidadeentrada as entryqty',
                        'maps.quantidadesaida as sellqty',
                        'maps.created_at as date'
        
                                ]);

            } else {

                $results = DB::table('maps')
                    ->join('products', 'maps.id_product', '=', 'products.id')
                    ->whereYear('maps.updated_at', $from)
                    ->whereDay('maps.updated_at', $to)
                    ->get([
                        'maps.id as id',
                        'products.descricao as description',
                        'maps.quantidadeentrada as entryqty',
                        'maps.quantidadesaida as sellqty',
                        'maps.created_at as date'
        
                                ]);

            }

        } else if ($from != 'false' AND $to == 'false' AND $month == 'false') {

            Session::put('reporttitle', __('messages._titlemapsfrom') . ' ' . $from );

            if ($id_product != 'false') {

                $results = DB::table('maps')
                    ->join('products', 'maps.id_product', '=', 'products.id')
                    ->where('products.id', $id_product)
                    ->whereYear('maps.updated_at', $from)
                    ->get([
                        'maps.id as id',
                        'products.descricao as description',
                        'maps.quantidadeentrada as entryqty',
                        'maps.quantidadesaida as sellqty',
                        'maps.created_at as date'
        
                                ]);

            } else {

                $results = DB::table('maps')
                    ->join('products', 'maps.id_product', '=', 'products.id')
                    ->whereYear('maps.updated_at', $from)
                    ->get([
                        'maps.id as id',
                        'products.descricao as description',
                        'maps.quantidadeentrada as entryqty',
                        'maps.quantidadesaida as sellqty',
                        'maps.created_at as date'
        
                                ]);

            }
            
        } else if ($from != 'false' AND $to == 'false' AND $month != 'false') {

            Session::put('reporttitle', __('messages._titlemapsfrommonth') . ' ' . $from . '/' . $month);

            if ($id_product != 'false') {

                $results = DB::table('maps')
                    ->join('products', 'maps.id_product', '=', 'products.id')
                    ->where('products.id', $id_product)
                    ->whereYear('maps.updated_at', $from)
                    ->whereMonth('maps.updated_at', $month)
                    ->get([
                        'maps.id as id',
                        'products.descricao as description',
                        'maps.quantidadeentrada as entryqty',
                        'maps.quantidadesaida as sellqty',
                        'maps.created_at as date'
        
                                ]);

            } else {

                $results = DB::table('maps')
                    ->join('products', 'maps.id_product', '=', 'products.id')
                    ->whereYear('maps.updated_at', $from)
                    ->whereMonth('maps.updated_at', $month)
                    ->get([
                        'maps.id as id',
                        'products.descricao as description',
                        'maps.quantidadeentrada as entryqty',
                        'maps.quantidadesaida as sellqty',
                        'maps.created_at as date'
        
                                ]);

            }

        } else if ($from == 'false' AND $to == 'false' AND $month == 'false') {

            Session::put('reporttitle', __('messages._titlemaps'));

            $results = DB::table('maps')
                    ->join('products', 'products.id', '=', 'maps.id_product')
                    ->get([
                        'maps.id as id',
                        'products.descricao as description',
                        'maps.quantidadeentrada as entryqty',
                        'maps.quantidadesaida as sellqty',
                        'maps.created_at as date'
        
                                ]);

           if ($id_product != 'false') {

                $results = DB::table('maps')
                ->join('products', 'products.id', '=', 'maps.id_product')
                    ->where('maps.id_product', $id_product)
                    ->get([
                        'maps.id as id',
                        'products.descricao as description',
                        'maps.quantidadeentrada as entryqty',
                        'maps.quantidadesaida as sellqty',
                        'maps.created_at as date'
        
                                ]);

            } 

        }

        foreach ($results as $result) {

                $aux = array(

                    $result->date,
                    $result->description,
                    $result->entryqty,
                    $result->sellqty

                );

                $data[] = $aux;

            }


        $finalResults .= $this->displayTable($columns, $data);

        echo $finalResults;

    }

    private function getprodstats($from, $to, $month) {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        if (Session::get('level') == 2) {

            return redirect('/entries');

        }

        $finalResults = '';

        $columns = [

                __('messages._updatedat'),
                __('messages._productdescription'),
                __('messages._quantity'),
                __('messages.sellstable_unitprice')

            ];

        $data = array();

        $results = array();

        if ($from != 'false' AND $to != 'false' AND $month != 'false') {

            Session::put('reporttitle', __('messages._titleproductsfromtomonth') . ' ' . $from  . '/' . $month . ' and ' . $to . '/' . $month);

            $results = DB::table('products')
                        ->whereYear('products.updated_at', '>=', $from)
                        ->whereYear('products.updated_at', '<=', $to)
                        ->whereMonth('products.updated_at', $month)
                        ->get();


        } else if ($from != 'false' AND $to != 'false' AND $month == 'false') {

            Session::put('reporttitle', __('messages._titleproductsfromto') . ' ' . $from  . ' and ' . $to);

            $results = DB::table('products')
                        ->whereYear('products.updated_at', '>=', $from)
                        ->whereYear('products.updated_at', '<=', $to)
                        ->get();

        } else if ($from != 'false' AND $to == 'false' AND $month == 'false') {

            Session::put('reporttitle', __('messages._titleproductsfrom') . ' ' . $from );

            $results = DB::table('products')
                        ->whereYear('products.updated_at', $from)
                        ->get();
            
        } else if ($from != 'false' AND $to == 'false' AND $month != 'false') {

            Session::put('reporttitle', __('messages._titleproductsfrommonth') . ' ' . $from . '/' . $month);

            $results = DB::table('products')
                        ->whereYear('products.updated_at', '=', $from)
                        ->whereMonth('products.updated_at', $month)
                        ->get();

        } else if ($from == 'false' AND $to == 'false' AND $month == 'false') {

            Session::put('reporttitle', __('messages._titleproducts'));

           $results = DB::table('products')
                        ->get();

        }

        foreach ($results as $result) {

                $aux = array(

                    $result->updated_at,
                    $result->descricao,
                    $result->quantidade,
                    number_format($result->precounitario, 2, '.', ',')

                );

                $data[] = $aux;

            }


        $finalResults .= $this->displayTable($columns, $data);

        echo $finalResults;

    }

    private function getnegativeprodstats($from, $to, $month) {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        if (Session::get('level') == 2) {

            return redirect('/entries');

        }

        $finalResults = '';

        $columns = [

                __('messages._updatedat'),
                __('messages._productdescription'),
                __('messages._quantity'),
                __('messages.sellstable_unitprice')

            ];

        $data = array();

        $results = array();

        if ($from != 'false' AND $to != 'false' AND $month != 'false') {

            Session::put('reporttitle', __('messages._titlenegativeproductsfromtomonth') . ' ' . $from  . '/' . $month . ' and ' . $to . '/' . $month);

            $results = DB::table('products')
                        ->whereYear('products.updated_at', '>=', $from)
                        ->whereYear('products.updated_at', '<=', $to)
                        ->whereMonth('products.updated_at', $month)
                        ->where('products.quantidade', '<', 0)
                        ->get();


        } else if ($from != 'false' AND $to != 'false' AND $month == 'false') {

            Session::put('reporttitle', __('messages._titlenegativeproductsfromto') . ' ' . $from  . ' and ' . $to);

            $results = DB::table('products')
                        ->whereYear('products.updated_at', '>=', $from)
                        ->whereYear('products.updated_at', '<=', $to)
                        ->where('products.quantidade', '<', 0)
                        ->get();

        } else if ($from != 'false' AND $to == 'false' AND $month == 'false') {

            Session::put('reporttitle', __('messages._titlenegativeproductsfrom') . ' ' . $from );

            $results = DB::table('products')
                        ->whereYear('products.updated_at', '=', $from)
                        ->where('products.quantidade', '<', 0)
                        ->get();
            
        } else if ($from != 'false' AND $to == 'false' AND $month != 'false') {

            Session::put('reporttitle', __('messages._titlenegativeproductsfrommonth') . ' ' . $from . '/' . $month);

            $results = DB::table('products')
                        ->whereYear('products.updated_at', '=', $from)
                        ->whereMonth('products.updated_at', $month)
                        ->where('products.quantidade', '<', 0)
                        ->get();

        } else if ($from == 'false' AND $to == 'false' AND $month == 'false') {

            Session::put('reporttitle', __('messages._titlenegativeproducts') . ' ');

           $results = DB::table('products')
                        ->where('products.quantidade', '<', 0)
                        ->get();

        }

        foreach ($results as $result) {

                $aux = array(

                    $result->updated_at,
                    $result->descricao,
                    $result->quantidade,
                    number_format($result->precounitario, 2, '.', ',')

                );

                $data[] = $aux;

            }


        $finalResults .= $this->displayTable($columns, $data);

        echo $finalResults;

    }

    private function getclientsstats($from, $to, $month){

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        if (Session::get('level') == 2) {

            return redirect('/entries');

        }

        $finalResults = '';

        $columns = [

                __('messages._updatedat'),
                __('messages._fullname'),
                __('messages._mobile'),
                __('messages._documentid')

            ];

        $data = array();

        $results = array();

        if ($from != 'false' AND $to != 'false' AND $month != 'false') {

            Session::put('reporttitle', __('messages._titleclientsfromtomonth') . ' ' . $from  . '/' . $month . ' and ' . $to . '/' . $month);

            $results = DB::table('clients')
                        ->whereYear('updated_at', '>=', $from)
                        ->whereYear('updated_at', '<=', $to)
                        ->whereMonth('updated_at', $month)
                        ->get();


        } else if ($from != 'false' AND $to != 'false' AND $month == 'false') {

            Session::put('reporttitle', __('messages._titleclientsfromto') . ' ' . $from  . ' and ' . $to);

            $results = DB::table('clients')
                        ->whereYear('updated_at', '>=', $from)
                        ->whereYear('updated_at', '<=', $to)
                        ->get();

        } else if ($from != 'false' AND $to == 'false' AND $month == 'false') {

            Session::put('reporttitle', __('messages._titleclientsfrom') . ' ' . $from );

            $results = DB::table('clients')
                        ->whereYear('updated_at', '=', $from)
                        ->get();

        } else if ($from != 'false' AND $to == 'false' AND $month != 'false') {

            Session::put('reporttitle', __('messages._titleclientsfrommonth') . ' ' . $from . '/' . $month);

            $results = DB::table('clients')
                        ->whereYear('updated_at', $from)
                        ->whereMonth('updated_at', $month)
                        ->get();

        } else if ($from == 'false' AND $to == 'false' AND $month == 'false') {

            Session::put('reporttitle', __('messages._titleclients') );

           $results = DB::table('clients')
                        ->get();

        }

        foreach ($results as $result) {

                $aux = array(

                    $result->updated_at,
                    $result->nome_completo,
                    $result->contacto,
                    $result->nuitORbi,

                );

                $data[] = $aux;

            }


        $finalResults .= $this->displayTable($columns, $data);

        echo $finalResults;

    }

    public function getstattable($aims,$from, $to, $month, $id_product = false) {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        if (Session::get('level') == 2) {

            return redirect('/entries');

        }

        switch($aims) {

            case 'maps' :

                $this->getmapstats($from, $to, $month, $id_product);

            break;

            case 'sells' :

                $this->getsellsstats($from, $to, $month);

            break;

            case 'loans' :

                $this->getloansstats($from, $to, $month);

            break;

            case 'devolutions' :

                $this->getdevolutionsstats($from, $to, $month);

            break;

            case 'entries' :

                $this->getentriesstats($from, $to, $month);

            break;

            case 'users':

                $this->getuserstats($from, $to, $month);

            break;

            case 'products' :

                $this->getprodstats($from, $to, $month);

            break;

            case 'negativeprods':

                $this->getnegativeprodstats($from, $to, $month);

            break;

            case 'clients' :

                $this->getclientsstats($from, $to, $month);

            break;

            case 'currentsells':

                $this->getCurrentsellsstats();

            break;

            default:

            break;

        }

    }

    public function getstats($aims) {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        if (Session::get('level') == 2) {

            return redirect('/entries');

        }

        $data = array();
        $auarray = array();

        switch ($aims) {

            case 'topbestseldproducts':

            $allprods = DB::table('products')
                            ->get();

            foreach ($allprods as $prod) {

                $allsells = DB::table('sells')
                                ->where('id_id_products', $prod->id)
                                ->count();

                $auarray[] = [

                    'description' => $prod->descricao,
                    'n_sells' => $allsells

                ];

                
            }

            usort($auarray, function($a, $b) {

                return $b['n_sells'] <=> $a['n_sells'];

            });

            $topten = array_slice($auarray, 0, 10);

            $data = array(

                'title' => 'Top 10 most sold products',
                'content' => $auarray,
                'y_title' => 'sells'

            );

            break;

            case 'toplesssoldprods':

            $allprods = DB::table('products')
                            ->get();

            foreach ($allprods as $prod) {

                $allsells = DB::table('sells')
                                ->where('id_id_products', $prod->id)
                                ->count();

                $auarray[] = [

                    'description' => $prod->descricao,
                    'n_sells' => $allsells

                ];

                
            }

            usort($auarray, function($a, $b) {

                return $a['n_sells'] <=> $b['n_sells'];

            });

            $topten = array_slice($auarray, 0, 10);

            $data = array(

                'title' => 'Top 10 less sold products',
                'content' => $auarray,
                'y_title' => 'sells'

            );

            break;

            case 'topbestclients':

            $allcliens = DB::table('clients')
                            ->get();

            foreach ($allcliens as $clien) {

                $allsells = DB::table('sells')
                                ->where('id_cliente', $clien->id)
                                ->count();

                $auarray[] = [

                    'name' => $prod->nome_completo,
                    'n_sells' => $allsells

                ];

                
            }

            usort($auarray, function($a, $b) {

                return $a['n_sells'] <=> $b['n_sells'];

            });

            $topten = array_slice($auarray, 0, 10);

            $data = array(

                'title' => 'Top 10 best clients',
                'content' => $auarray,
                'y_title' => 'sells'

            );

            break;

            case 'sellspermonth':

                 $thisyear = date('Y');

                 for($i = 1; $i<13; $i++) {

                    $allsells = DB::table('sells')
                                ->whereYear('updated_at', $thisyear)
                                ->whereMonth('updated_at', $i)
                                ->count();

                    $months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
                    $cont = $i - 1;
                    $auarray[$months[$cont]] = $allsells;

                 }

                 $data = array(

                    'title' => 'Sells per month',
                    'content' => $auarray,
                    'y_title' => 'sells'

                );

            break;

            case 'sellsperyear':

                $allyears = DB::table('sells')
                                ->select(DB::raw('distinct YEAR(sells.updated_at) AS year'))
                                ->get();

                 foreach($allyears as $year) {

                    $allsells = DB::table('sells')
                                ->whereYear('updated_at', $year->year)
                                ->count();

                    $auarray[$year->year] = $allsells;

                 }

                 $data = array(

                    'title' => 'Sells per month',
                    'content' => $auarray,
                    'y_title' => 'sells'

                );
            break;

            case 'entriespermonth':

                $thisyear = date('Y');

                 for($i = 1; $i<13; $i++) {

                    $allsells = DB::table('entries')
                                ->whereYear('updated_at', $thisyear)
                                ->whereMonth('updated_at', $i)
                                ->count();

                    $months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
                    $cont = $i - 1;
                    $auarray[$months[$cont]] = $allsells;

                 }

                 $data = array(

                    'title' => 'Sells per month',
                    'content' => $auarray,
                    'y_title' => 'entries'

                );

            break;

            case 'entriesperyear':

                $allyears = DB::table('entries')
                                ->select(DB::raw('distinct YEAR(entries.updated_at) AS year'))
                                ->get();

                 foreach($allyears as $year) {

                    $allsells = DB::table('entries')
                                ->whereYear('updated_at', $year->year)
                                ->count();

                    $auarray[$year->year] = $allsells;

                 }

                 $data = array(

                    'title' => 'Sells per month',
                    'content' => $auarray,
                    'y_title' => 'entries'

                );

            break;
            case 'loanspermonth':

                $thisyear = date('Y');

                 for($i = 1; $i<13; $i++) {

                    $allsells = DB::table('loans')
                                ->whereYear('updated_at', $thisyear)
                                ->whereMonth('updated_at', $i)
                                ->count();

                    $months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
                    $cont = $i - 1;
                    $auarray[$months[$cont]] = $allsells;

                 }

                 $data = array(

                    'title' => 'Loans per month',
                    'content' => $auarray,
                    'y_title' => 'loans'

                );

            break;
            
            default:
                # code...
                break;
        }

       
        echo json_encode($data);

    }

    function notUsedReference( ) {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        if (Session::get('level') == 2) {

            return redirect('/entries');

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




    public function printreport(){

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        if (Session::get('level') == 2) {

            return redirect('/entries');

        }

        $currenttable = Session::get('currentreporttable');

        $title = Session::get("reporttitle");
        
        $_ENV['COMPANY_LOGO'] = asset('/img/glogon.png') ;
        $_ENV['COMPANY_NAME'] = 'Adatec Technology E.I';
        $_ENV['COMPANY_LOCATION'] = 'Maputo, Mozambique';
        $_ENV['COMPANY_ADDRESS'] = 'Avenida das FPLM , Rua 3454, Codigo postal 2462';
        $_ENV['COMPANY_TELEPHONE'] =  '+258 84 722 67 32';
        $_ENV['COMPANY_TELEFAX'] =  '';
        $_ENV['COMPANY_NUIT'] =  '11310834';

        var_dump($_ENV['COMPANY_LOGO']);

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

            #secondlist div {

                display: block;

            }


        </style>
        </head>
        <body>
        <table cellspacing="3" style="font-size: 10pt; font-family: 'Segoe UI Light';">
            
            <td valign="top"><img src="{$_ENV['COMPANY_LOGO']}" width="80" height="80"  /></td>
            <td id="secondlist">
                   
                <div> {$_ENV['COMPANY_NAME']}</div>
                <div> {$_ENV['COMPANY_LOCATION']} </div>
                <div> {$_ENV['COMPANY_ADDRESS']} </div>
                <div>Tel.: {$_ENV['COMPANY_TELEPHONE']}  Fax: {$_ENV['COMPANY_TELEFAX']}</div>
                <div>NUIT:{$_ENV['COMPANY_NUIT']}</div>

            </td> 

        </table>
        </body>
        </html>
        HTML;

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
            input{

                border: 0;
                width: 80px;
                text-align: left;
                background: transparent;

            }

            button {

                display: none;

            }

        </style>
        </head>
        <body>

        </br>
        <p align="center" style="border: 1px solid #ccc; padding: 6pt;font-family: 'Segoe UI Light';">{$title}</p>
        
        {$currenttable}

        </table>
        </body>
        </html>
        HTML;

        $pdf = \PDF::loadHtml($content);
        $pdf->setOption('margin-top', '30mm');
        $pdf->setOption('margin-bottom', '15mm');
        $pdf->setOption('margin-left', '20mm');
        $pdf->setOption('header-html', $header);
        $pdf->setOption('footer-center', 'my company name here');
        $pdf->setOption('footer-font-size', '6');
        $pdf->setOption('footer-line', true);
        $pdf->setOption('footer-right', 'Page[page] of [toPage]');
        $pdf->setOption('footer-left', 'number of');
        return $pdf->stream('generadto.pdf');

    }

}
