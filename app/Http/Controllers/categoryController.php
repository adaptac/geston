<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\category;

class categoryController extends Controller
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
        
        $categories = category::all();
        return view('category.index', compact('categories'));

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
        $html = view('category.add')->render();

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

            'descricao' => 'required'

        ];

        $messages = [

            'descricao.required' => 'Insert the <b>Description</b>'

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

            $categoria = new category([

                'descricao'  => $form['descricao']

            ]);


            $categoria->save();

            $content = [

                'status' => 0,
                'message' => __('messages._categorysaved')

            ];

            echo json_encode($content);

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
        
        $category = category::find($id);
        $html = view('category.edit', compact('category'))->render();

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

            'descricao' => 'required'

        ];

        $messages = [

            'descricao.required' => 'Insert the <b>Description</b>'

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

            $categoria = category::find($id);

            $categoria->descricao  = $form['descricao'];


            $categoria->save();

            $content = [

                'status' => 0,
                'message' => __('messages._categoryupdated')

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
        //
    }

    public function updatetable() {

        $finalResults = "";

        $categories = category::all();

        if (count($categories) > 0) {

            foreach ($categories as $category) {

                $finalResults .= '<tr>';

                $finalResults .= '<td>' . $category->id . '</td>';
                $finalResults .= '<td>' . $category->descricao . '</td>';

                $finalResults .= '<td align="right"><button  data-toggle="tooltip" data-placement="left" title="' .__('messages.categoriesstable_edittips') . '" class="btn btn-round btn-xs mr-1" onclick="getForm(' . "'" . "category" . "'" . ',' . $category->id.')"><span class="now-ui-icons ui-1_edit-74"></span> </button></td></tr>';

            }

        } 


        return $finalResults;

    }

}
