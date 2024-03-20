<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\clients;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;

use Illuminate\Routing\UrlGenerator;

use DB;

class clientsController extends Controller
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
        
        $clientes = clients::all();

        return view('clients.index', compact('clientes'));

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
        
        $html = view('clients.add')->render();

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
            'contacto' => 'required',
            'nuitORbi' => 'required'

        ];

        $messages = [

            'nome.required' => 'Insert the <b>full name</b>',
            'contacto.required' => 'Insert <b>contact</b>',
            'nuitORbi.required' => 'insert the <b>username</b>'

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


                $cliente = new clients([

                'nome_completo'  => $form->get('nome'),
                'contacto' => $form->get('contacto'),
                'nuitORbi' => $form->get('nuitORbi')

               ]);

                $cliente->save();

                $content = [

                    'status' => 0,
                    'message' => __('messages._clientsaved')

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
        
        $cliente = clients::find($id);
        $html = view('clients.edit', compact('cliente'))->render();

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
            'contacto' => 'required',
            'nuitORbi' => 'required'

        ];

        $messages = [

            'nome.required' => 'Insert the <b>full name</b>',
            'contacto.required' => 'Insert <b>contact</b>',
            'nuitORbi.required' => 'insert the <b>username</b>'

        ];

        $form = $request->all();

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


                $cliente = clients::find($id);

                $cliente->nome_completo  = $form['nome'];
                $cliente->contacto = $form['contacto'];
                $cliente->nuitORbi = $form['nuitORbi'];

                $cliente->save();

                $content = [

                    'status' => 0,
                    'message' => __('messages._clientupdated')

                ];

                echo json_encode($content);

            }


        } catch(Exception $ex) {

            echo $ex;

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
        
        $cliente = clients::find($id);
        $cliente->delete();

        echo __('messages._clientdeleted');

    }

    function fetch(Request $request)
    {


        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

     if($request->get('query'))
     {
      $query = $request->get('query');
      $data = DB::table('clients')
        ->where('nuitORbi', $query)
        ->get();
      $finalResults = 'Info: </br>';

      Session::put('id_cliente', $data[0]->id);

       $finalResults .= "<div class=' row col-lg-12'>";

        $finalResults .= "<table border='0'>";

        $finalResults .= "<tr>";

        $finalResults .= "<td>".__('messages._fullname').":</td>";
        $finalResults .= "<td>" . $data[0]->nome_completo . "</td>";

        $finalResults .= "</tr>";

        $finalResults .= "<tr>";

        $finalResults .= "<td>".__('messages._contacts').":: </td>";
        $finalResults .= "<td>" . $data[0]->contacto . "</td>";

        $finalResults .= "</tr>";

        $finalResults .= "<tr>";

        $finalResults .= "<td>".__('messages._documentid').": </td>";
        $finalResults .= "<td>" . $data[0]->nuitORbi . "</td>";

        $finalResults .= "</tr>";

        $finalResults .= "</table>";

        $finalResults .="</div>";

        Session::put('clientname', $data[0]->nome_completo );
        Session::put('clientcontacts', $data[0]->contacto);
        Session::put('clientdocid', $data[0]->nuitORbi);

     
     }
    }

    public function updatetable() {

        $finalResults = "";

        $clientes = clients::all();

        if (count($clientes) > 0) {

            foreach ($clientes as $cliente) {

                $finalResults .= '<tr>';

                $finalResults .= '<td>' . $cliente->id . '</td>';
                $finalResults .= '<td>' . $cliente->nome_completo . '</td>';
                $finalResults .= '<td>' . $cliente->contacto . '</td>';
                $finalResults .= '<td>' . $cliente->nuitORbi . '</td>';

                $finalResults .= '<td align="right"><button  data-toggle="tooltip" data-placement="left" title="' . __('messages.clientstable_deletetips') . '" class="btn btn-round btn-xs mr-1" onclick="confirmRemotion(' . "'" . "clients" . "'" . ', ' . $cliente->id .')" style="border-color:red; color:red;"><span class="now-ui-icons ui-1_trash"></span> </button><button  data-toggle="tooltip" data-placement="left" title="' .__('messages.clientstable_edittips') . '" class="btn btn-round btn-xs mr-1" onclick="getForm(' . "'" . "clients" . "'" . ',' . $cliente->id .')"><span class="now-ui-icons ui-1_edit-74"></span> </button></td></tr>';

            }

        }


        return $finalResults;

    }

    public function setCurrentClient() {

        $data= array(

            'clientname' => Session::get('clientname') ?? 'Anonimous',
            'clientcontact' => Session::get('clientcontacts') ?? '0000',
            'clientdocid' => Session::get('clientdocid') ?? '0000'

        ); 

        echo json_encode($data);

    }


}
