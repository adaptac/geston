<?php

namespace App\Http\Controllers;

use DB;

use App\suppliers;

use App\entries;

use App\products;

use App\entryqueue;

use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

use App\maps;

class entriesController extends Controller
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
        
        $entries = DB::table('entries')
                    ->join('users', 'entries.id_user', '=', 'users.id')
                    ->join('suppliers', 'entries.id_suppliers', '=', 'suppliers.id')
                    ->join('products', 'entries.id_products', '=', 'products.id')
                    ->get([

                        'entries.created_at AS date',
                        'users.nome_completo AS user',
                        'suppliers.nome_completo AS supplier',
                        'suppliers.telefone AS suppliercontact',
                        'products.descricao AS product',
                        'entries.quantity AS quantity',
                        'entries.buy_price AS price'


                    ]);
        return view('entries.index', compact('entries'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }
        
        $products = products::all();
        $suppliers = suppliers::all();

        $data = array(

            'products' => $products,
            'suppliers' => $suppliers

        );

        $html = view('entries.add', compact('data'))->render();

        echo $html;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }
        
         $rules = [

            'id_products' => 'required',
            'id_suppliers' => 'required',
            'quantity' => 'required',
            'buy_price' => 'required'

        ];

        $messages = [

            'id_products.required' => 'Insert the <b>product id</b>',
            'id_suppliers.required' => 'Choose the <b>Supplier</b>',
            'quantity.required' => 'Insert <b>quantity</b>',
            'buy_price.required' => 'insert the <b>buying price</b>'

        ];

        $form = $request->request;

        $validator = Validator::make($request->all(), $rules, $messages);

        $errors = $validator->errors()->all();

        try{

            if(count($errors) > 0) {

                $allerro = '<ul> Please :';
                foreach ($errors as $message) {
                    
                    $allerro .= '<li style="color:red;">' . $message . '</li>';

                }
                $allerro .= '</ul>';

                $content = [

                    'status' => 1,
                    'message' => $allerro

                ];

                echo json_encode($content);

            } else {

                $entries = new entries([

                'id_user'  => Session::get('id_user') ?? 2,
                'id_products' => $form->get('id_products'),
                'id_suppliers' => $form->get('id_suppliers'),
                'quantity' => $form->get('quantity'),
                'buy_price' => $form->get('buy_price')

               ]);

                DB::beginTransaction();

                $produto = products::find($form->get('id_products'));

                if ($produto->quantidade > 0) {

                    $produto->quantidade = $produto->quantidade + $form->get('quantity');

                } else {

                    $produto->quantidade = $form->get('quantity');

                }

                $entryqueue = new entryqueue([

                    'id_product'=> $form->get('id_products'),
                    'entryqty' => $form->get('quantity'),
                    'unitprice' => $form->get('buy_price')

                ]);


                $produto->save();

                $entries->save();

                $entryqueue->save();

                DB::commit();


                $content = [

                    'status' => 0,
                    'message' => __('messages._entrysaved')

                ];

                echo json_encode($content);

            }


        } catch(Exception $ex) {

            DB:rollBack();
            echo $ex;

        }
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

    public function updatetable() {

        $finalResults = "";

        $entries = DB::table('entries')
                    ->join('users', 'entries.id_user', '=', 'users.id')
                    ->join('suppliers', 'entries.id_suppliers', '=', 'suppliers.id')
                    ->join('products', 'entries.id_products', '=', 'products.id')
                    ->get([

                        'entries.created_at AS date',
                        'users.nome_completo AS user',
                        'suppliers.nome_completo AS supplier',
                        'suppliers.telefone AS suppliercontact',
                        'products.descricao AS product',
                        'entries.quantity AS quantity',
                        'entries.buy_price AS price'


                    ]);

        if (count($entries) > 0) {

            foreach ($entries as $entry) {

                $finalResults .= '<tr>';

                $finalResults .= '<td>' . $entry->date . '</td>';
                $finalResults .= '<td>' . $entry->user . '</td>';
                $finalResults .= '<td>' . $entry->supplier . '</td>';
                $finalResults .= '<td>' . $entry->suppliercontact . '</td>';
                $finalResults .= '<td>' . $entry->product . '</td>';
                $finalResults .= '<td>' . $entry->quantity . '</td>';
                $finalResults .= '<td>' . number_format($entry->price,2,'.', ',') . '</td>';
                $finalResults .= '<td>' . number_format($entry->price*$entry->quantity,2,'.', ',') . '</td>';

                $finalResults .= '</tr>';

            }

        } 


        return $finalResults;

    }

}
