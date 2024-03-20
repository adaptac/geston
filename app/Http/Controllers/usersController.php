<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Illuminate\Routing\UrlGenerator;

use Illuminate\Support\Facades\Session;

use DB;

use App\users;

use App\notifications;

class usersController extends Controller
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
        
        $usuarios = users::all();
        return view('users.index', compact('usuarios'));

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

        if (Session::get('level') == 2) {

            return redirect('/entries');

        }

        $html = view('users.add')->render();

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

        if (Session::get('level') == 2) {

            return redirect('/entries');

        }

        
        $rules = [

            'nome' => 'required',
            'email' => 'email|required',
            'telemovel' => 'required|min:9',
            'username' => 'required',
            'password' => 'required'

        ];

        $messages = [

            'nome.required' => 'Insert the <b>full name</b>',
            'email.required' => 'Insert the <b>email</b>',
            'email.email' => 'Insert correct <b>email</b>',
            'telemovel.required' => 'Insert <b>mobile number</b>',
            'username.required' => 'insert the <b>username</b>',
            'password.required' => 'insert the <b>password</b>'

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

                $filepath = '';

                if ($file = $request->file("archive")) {

                    $destination_path = public_path('/img/users');
                    $filename = date("YmdHis");
                    $file->move($destination_path, $filename);

                    $filepath = url('/') . '/img/users/' .$filename;

                }

                $usuario = new users([

                'nome_completo'  => $form->get('nome'),
                'email' => $form->get('email'),
                'telemovel' => $form->get('telemovel'),
                'username' => $form->get('username'),
                'password' => $form->get('password'),
                'imgURL' => $filepath,
                'level' => $form->get('level')

               ]);

                $usuario->save();

                $content = [

                    'status' => 0,
                    'message' => __('messages._usersaved')

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

        if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        if (Session::get('level') == 2) {

            return redirect('/entries');

        }
        
        $usuario = users::find($id);
        $html = view('users.details', compact('usuario'))->render();

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

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        if (Session::get('level') == 2) {

            return redirect('/entries');

        }

        $usuario = users::find($id);
        $html = view('users.edit', compact('usuario'))->render();

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

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        if (Session::get('level') == 2) {

            return redirect('/entries');

        }

        $rules = [

            'nome' => 'required',
            'email' => 'email|required',
            'telemovel' => 'required|min:9',
            'username' => 'required',
            'password' => 'required'

        ];

        $messages = [

            'nome.required' => 'Insert the <b>full name</b>',
            'email.required' => 'Insert the <b>email</b>',
            'email.email' => 'Insert correct <b>email</b>',
            'telemovel.required' => 'Insert <b>mobile number</b>',
            'username.required' => 'insert the <b>username</b>',
            'password.required' => 'insert the <b>password</b>'

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

            $usuario = users::find($id);

            $usuario->nome_completo  = $form['nome'];
            $usuario->email = $form['email'];
            $usuario->telemovel = $form['telemovel'];
            $usuario->username = $form['username'];
            $usuario->password = $form['password'];
            
            $usuario->level = $form['level'];

            if ($file = $request->file("archive")) {

                $destination_path = public_path("/img/users");
                $filename = date("YmdHis");
                $file->move($destination_path, $filename);
                $usuario->imgURL = url('/') . '/img/users/' .$filename;

            }

            $usuario->save();

            $content = [

                'status' => 0,
                'message' => __('messages._userupdated')

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

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        if (Session::get('level') == 2) {

            return redirect('/entries');

        }

        $usuario = users::find($id);
        $usuario->delete();

        echo __('messages._userdeleted');

    }

    public function login()
    {    

        Session::put('locale', app()->getlocale());

        if(!Session::has('username')) {

            return view('users.login');
            
        }  

        if (Session::get('level') == 3) {

            return redirect('/sells');

        }

        if (Session::get('level') == 2) {

            return redirect('/entries');

        } 
        
        return redirect('/report');

    }

    /**
     * Checks the user credentials.
     *
     * @return \Illuminate\Http\Response
     */
    public function useraccess(Request $request)
    {
        
        $password = $request->password;
        $username = $request->username;

        $loans = DB::table('loans')->where('status', 1)->get();

        $countloans = count($loans);

        Session::put('totalloans', $countloans);

        $data = DB::table('users')
        ->where('username', 'LIKE', "{$username}")
        ->where('password', 'LIKE', "{$password}")
        ->get();

        if (count($data) > 0) {

            //set

            Session::put('id_user', $data[0]->id);
            Session::put('level', $data[0]->level);
            Session::put('useremail', $data[0]->email);
            Session::put('username', $data[0]->nome_completo);
            Session::put('perfil_photo', $data[0]->imgURL);

            $notification = new notifications([

              'name' => $data[0]->nome_completo,
              'imgurl' => $data[0]->imgURL,
              'object' => 'user',
              'state' => 'is logged in'

            ]);

            $notification->save();

            if ($data[0]->level == 3) {

                return redirect('/sells');

            }

            if ($data[0]->level == 2) {

                return redirect('/entries');

            }

            return redirect('/report');
            
        } else {


            $response = __('messages._loginresponse');
            return view('users.login', compact('response'));

        }

    }

    public function logout() {

      $notification = new notifications([

          'name' => Session::get('username'),
          'imgurl' => Session::get('perfil_photo'),
          'object' => 'user',
          'state' => 'has logged out!'

      ]);

      $notification->save();

      Session::flush();

      return redirect('users/login');

    }

    public function changelan($newlang) {

        Session::put('locale', $newlang);

        config(['app.locale' => $newlang]);


    }

    public function updatetable() {

        $finalResults = "";

        $usuarios = users::all();

        if (count($usuarios) > 0) {

            foreach ($usuarios as $usuario) {

                $finalResults .= '<tr>';

                $finalResults .= '<td>' . $usuario->id . '</td>';
                $finalResults .= '<td>' . $usuario->nome_completo . '</td>';
                $finalResults .= '<td>' . $usuario->email . '</td>';
                $finalResults .= '<td>' . $usuario->telemovel . '</td>';
                $finalResults .= '<td>' . $usuario->username . '</td>';

                if( $usuario->level == 1) {

                    $finalResults .= '<td>Admin</td>';

                }else if( $usuario->level == 2) {

                    $finalResults .= '<td>Senior</td>';

                }else if( $usuario->level == 3) {

                    $finalResults .= '<td>Junior</td>';

                }
                $finalResults .= '<td align="right"><button  onclick="getDetails(' . "'" . "users" . "'" . ' , ' . $usuario->id .')"  title="' . __('messages.userstable_detailstips') . '" class="btn btn-round btn-xs mr-1" data-toggle="tooltip" data-placement="left"><span class="now-ui-icons design_bullet-list-67"></span> </button><button  data-toggle="tooltip" data-placement="left" title="' . __('messages.userstable_deletetips') . '" class="btn btn-round btn-xs mr-1" onclick="confirmRemotion(' . "'" . "users" . "'" . ', ' . $usuario->id .')" style="border-color:red; color:red;"><span class="now-ui-icons ui-1_trash"></span> </button><button  data-toggle="tooltip" data-placement="left" title="' .__('messages.userstable_edittips') . '" class="btn btn-round btn-xs mr-1" onclick="getForm(' . "'" . "users" . "'" . ',' . $usuario->id .')"><span class="now-ui-icons ui-1_edit-74"></span> </button></td></tr>';

            }

        }


        return $finalResults;

    }


}


