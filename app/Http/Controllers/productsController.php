<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Illuminate\Routing\UrlGenerator;

use DB;

use App\category;

use App\products;

use App\suppliers;

use App\products_suppliers;

use App\products_category;

class productsController extends Controller
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
        
        $produtos = products::all();
        return view('products.index', compact('produtos'));
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
        
        $cats = category::all();
        $suppliers = suppliers::all();

        $data = array(

            'cats' => $cats,
            'suppliers' => $suppliers

        );

        $html = view('products.add', compact('data'))->render();

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
        
        $rules = [

            'descricao' => 'required',
            'quantidade' => 'required',
            'precounitario' => 'required'

        ];

        $messages = [

            'descricao.required' => 'Insert the <b>Description</b>',
            'quantidade.required' => 'Insert <b>quantity</b> value',
            'precounitario.required' => 'Insert <b>unit price</b> value'

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

                DB::beginTransaction();

                $filepath = '';

                if ($file = $request->file("archive")) {

                    $destination_path = public_path('/img');
                    $filename = date("YmdHis");
                    $file->move($destination_path, $filename);

                    $filepath = url('/') . '/img/' .$filename;

                }

                $produto = [

                'descricao'  => $form->get('descricao'),
                'precounitario' => $form->get('precounitario'),
                'quantidade' => $form->get('quantidade'),
                'istributable' => $form->get('istributable'),
                'codigobarra' => $form->get('codigobarra'),
                'imgURL' => $filepath

               ];

                DB::table('products')->insert($produto);

                

                $lastid = DB::getPdo()->lastInsertId();
             
                $prod_cat = [

                    'id_products' => $lastid,
                    'id_categoria' => $form->get('category')

                ];

                DB::table('products_categories')->insert($prod_cat);

                foreach ($form->get('suppliers') as $sup) {

                    $prod_sup = [

                        'id_products' => $lastid,
                        'id_suppliers' => $sup

                    ];

                    DB::table('products_suppliers')->insert($prod_sup);
                    
                }

                DB::commit();

                $content = [

                    'status' => 0,
                    'message' => __('messages._productsaved')

                ];

                echo json_encode($content);

            }


        } catch(Exception $ex) {

            DB::rollBack();

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

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }
        
        $produto = products::find($id);
        $html = view('products.details', compact('produto'))->render();

        echo $html;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }
        
        $produto = products::find($id);

        $cats = category::all();

        $suppliers = suppliers::all();

        $selectcat = DB::table('products_categories')
                    ->select('id_categoria')
                    ->where('id_products', $id)
                    ->get();

        $selectup = DB::table('products_suppliers')
                    ->select('id_suppliers')
                    ->where('id_products', $id)
                    ->get();

        if(count($selectcat) > 0) {

            $idcat = $selectcat[0]->id_categoria;

        } else {

            $idcat =0;

        }

        $idsups = array();

        $cont = 0;

        if(count($selectup) > 0) {

            foreach ($selectup as $lilsup) {
            
                $idsups[$cont] = $lilsup->id_suppliers;

                $cont++;

            }

        }

        $data = array(

            'produto' => $produto,
            'suppliers' => $suppliers,
            'cats' => $cats,
            'selectedcategory' => $idcat,
            'selectedsups' => $idsups

        );
        $html = view('products.edit', compact('data'))->render();

        echo $html;

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

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }
        
        $rules = [

            'descricao' => 'required',
            'quantidade' => 'required',
            'precounitario' => 'required',
            'suppliers' => 'required'

        ];

        $messages = [

            'descricao.required' => 'Insert the <b>Description</b>',
            'quantidade.required' => 'Insert <b>quantity</b> value',
            'precounitario.required' => 'Insert <b>unit price</b> value',
            'suppliers.required' => ' Select the supplier of the product'

        ];

        try {

            $form = $request->all();

            $validator = Validator::make($request->all(), $rules, $messages);

            $errors = $validator->errors()->all();

            if(count($errors) > 0 ) {

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

                DB::beginTransaction();

                $produto = products::find($id);

                $produto->descricao  = $form['descricao'];
                $produto->precounitario = $form['precounitario'];
                $produto->istributable = $form['istributable'];
                $produto->quantidade = $form['quantidade'];
                $produto->codigobarra = $form['codigobarra'];

                if ($file = $request->file("archive")) {

                    $destination_path = public_path("/img");
                    $filename = date("YmdHis");
                    $file->move($destination_path, $filename);
                    $produto->imgURL = url('/') . '/img/' .$filename;

                }

                $produto->save();

                $catp = DB::table('products_categories')
                            ->select('id')
                            ->where('id_products', $id)
                            ->get();

                $supp = DB::table('products_suppliers')
                            ->select('id')
                            ->where('id_products', $id)
                            ->get();

                    

                if (count($catp) > 0) {

                    $oldcatp = DB::table('products_categories')
                            ->where('id_products', $id)
                            ->get();

                    DB::table('products_categories')
                            ->where('id', $catp[0]->id)
                            ->delete();

                }


                $prod_cat = new products_category([

                    'id_products' => $id,
                    'id_categoria' => $form['category']

                ]);

                $prod_cat->save();

                if (count($supp) > 0) {

                    foreach ($form['suppliers'] as $sup) {

                        $oldsupp = DB::table('products_suppliers')
                            ->select('id')
                            ->where('id_products', $id)
                            ->get();

                        DB::table('products_suppliers')
                            ->where('id',$oldsupp[0]->id)
                            ->delete();
                            
                    }
                        

                }

                    
                if (count($form['suppliers'])> 0) {

                    foreach ($form['suppliers'] as $sup) {

                        $prod_sup = new products_suppliers([

                            'id_products' => $id,
                            'id_suppliers' => $sup

                        ]);

                    $prod_sup->save();
                            
                    }

                }
                    

                DB::commit();

                $content = [

                    'status' => 0,
                    'message' => __('messages._productupdated')

                ];

                echo json_encode($content);
            }
            
        } catch (Exception $e) {

            DB::rollBack();

            echo $e;
            
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }
        
        $produti = products::find($id);
        $produti->delete();

        echo __('messages._productdeleted');

    }


    function fetch(Request $request)
    {

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }
        
     if($request->get('query'))
     {
      $query = $request->get('query');
      $data = DB::table('products')
        ->where('descricao', 'LIKE', "%{$query}%")
        ->orwhere('codigobarra', $query)
        ->get();
      $output = '<ul class="dropdown-menu" style="display:block;">';
      foreach($data as $row)
      {
       $output .= '
       <li onclick="addRow('.$row->id.')">'.$row->id.':::'.$row->descricao.'</li>
       ';
      }
      $output .= '</ul>';
      echo $output;
     }
    }

    public function updatetable() {

        $finalResults = "";

        $allprods = products::all();

        if (count($allprods) > 0) {

            foreach ($allprods as $produto) {

                $finalResults .= '<tr>';

                $finalResults .= '<td>' . $produto->id . '</td>';
                $finalResults .= '<td>' . $produto->descricao . '</td>';
                $finalResults .= '<td>' . number_format($produto->precounitario,2,'.', ',') . '</td>';
                $finalResults .= '<td>' . $produto->quantidade . '</td>';

                if( $produto->istributable == 1) {

                    $finalResults .= '<td>' . __('messages._istributableyes') . '</td>';

                }else if( $produto->istributable == 0) {

                    $finalResults .= '<td>'  . __('messages._istributableno') . '</td>';

                }
                $finalResults .= '<td align="right"><button  onclick="getDetails(' . "'" . "products" . "'" . ' , ' . $produto->id .')"  title="' . __('messages.productstable_detailstips') . '" class="btn btn-round btn-xs mr-1" data-toggle="tooltip" data-placement="left"><span class="now-ui-icons design_bullet-list-67"></span> </button><button  data-toggle="tooltip" data-placement="left" title="' . __('messages.productstable_deletetips') . '" class="btn btn-round btn-xs mr-1" onclick="confirmRemotion(' . "'" . "products" . "'" . ', ' . $produto->id .')" style="border-color:red; color:red;"><span class="now-ui-icons ui-1_trash"></span> </button><button  data-toggle="tooltip" data-placement="left" title="' .__('messages.productstable_edittips') . '" class="btn btn-round btn-xs mr-1" onclick="getForm(' . "'" . "products" . "'" . ',' . $produto->id .')"><span class="now-ui-icons ui-1_edit-74"></span> </button></td></tr>';

            }

        }


        return $finalResults;

    }

}
