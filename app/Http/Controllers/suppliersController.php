<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\suppliers;

class suppliersController extends Controller
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
        
        $suppliers = suppliers::all();
        return view('suppliers.index', compact('suppliers'));


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
        
        $html = view('suppliers.add')->render();

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

            'nome' => 'required',
            'email' => 'email|required',
            'telefone' => 'required',
            'nuit' => 'required'

        ];

        $messages = [

            'nome.required' => 'Insert the <b>full name</b>',
            'email.required' => 'Insert the <b>email</b>',
            'email.email' => 'Insert correct <b>email</b>',
            'telefone.required' => 'Insert <b>phone number</b>',
            'nuit.required' => 'insert the <b>username</b>'

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

                $fornecedor = new suppliers([

                'nome_completo'  => $form->get('nome'),
                'email' => $form->get('email'),
                'telefone' => $form->get('telefone'),
                'nuit' => $form->get('nuit')

               ]);

                $fornecedor->save();

                $content = [

                    'status' => 0,
                    'message' => __('messages._suppliersaved')

                ];

                echo json_encode($content);

            }


        } catch(Exception $ex) {

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

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }
        
        $supplier = suppliers::find($id);
        $html = view('suppliers.edit', compact('supplier'))->render();

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

            'nome' => 'required',
            'email' => 'email|required',
            'telefone' => 'required',
            'nuit' => 'required'

        ];

        $messages = [

            'nome.required' => 'Insert the <b>full name</b>',
            'email.required' => 'Insert the <b>email</b>',
            'email.email' => 'Insert correct <b>email</b>',
            'telefone.required' => 'Insert <b>phone number</b>',
            'nuit.required' => 'insert the <b>username</b>'

        ];

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

            $fornecedor = suppliers::find($id);

            $fornecedor->nome_completo  = $form['nome'];
            $fornecedor->email = $form['email'];
            $fornecedor->telefone = $form['telefone'];
            $fornecedor->nuit = $form['nuit'];


            $fornecedor->save();

            $content = [

                'status' => 0,
                'message' => __('messages._supplierupdated')

            ];

            echo json_encode($content);


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
        
        $supplier = suppliers::find($id);
        $supplier->delete();

        echo __('messages._supplierdeleted');

    }

    public function updatetable() {

        $finalResults = "";

        $suppliers = suppliers::all();

        if (count($suppliers) > 0) {

            foreach ($suppliers as $supplier) {

                $finalResults .= '<tr>';

                $finalResults .= '<td>' . $supplier->id . '</td>';
                $finalResults .= '<td>' . $supplier->nome_completo . '</td>';
                $finalResults .= '<td>' . $supplier->email . '</td>';
                $finalResults .= '<td>' . $supplier->telefone . '</td>';
                $finalResults .= '<td>' . $supplier->nuit . '</td>';

                $finalResults .= '<td align="right">@csrf @method("DELETE")<button  data-toggle="tooltip" data-placement="left" title="' . __('messages.supplierstable_deletetips') . '" class="btn btn-round btn-xs mr-1" onclick="confirmRemotion(' . "'" . "suppliers" . "'" . ', ' . $supplier->id .')" style="border-color:red; color:red;"><span class="now-ui-icons ui-1_trash"></span> </button><button  data-toggle="tooltip" data-placement="left" title="' .__('messages.supplierstable_edittips') . '" class="btn btn-round btn-xs mr-1" onclick="getForm(' . "'" . "suppliers" . "'" . ',' . $supplier->id.')"><span class="now-ui-icons ui-1_edit-74"></span> </button></td></tr>';

            }

        } else {

            $finalResults .= '<tr><td>Tabela esta vazia!</td></tr>';

        }


        return $finalResults;

    }
}
