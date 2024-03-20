<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

use App\user_notifications;

use App\notifications;

use DB;

class notificationController extends Controller
{
    

    public function index() {

    	if(!\Session::has('username')) {

            return redirect('/users/login');
            
        }
        
        $notificationsaux = notifications::all();

        $notifications = array();

        foreach ($notificationsaux as $aux) {

        	if (Session::get('username') != $aux->name AND $aux->object != 'user' ) {

				$notifications[] = $aux;

			}


        }

        Session::put('notificationcount', count($notifications));

        
        return view('notification.index', compact('notifications'));

    }
	public function getnotification() {

		if(!\Session::get('level') != 1) {

            return redirect('/');
            
        }

		$userid = Session::get('id_user');

		$data = 0;

		$notifications = DB::table('notifications')
							->get();

		$myloggednots = DB::table('notifications')
							->where('notifications.object', 'LIKE', 'user')
							->get();



		$myidlogged = array(0);


		foreach ($myloggednots as $ids) {

			if (Session::get('username') == $ids->name ) {

				$myidlogged[] = $ids->id;

			}

		}


		$usernots = DB::table('user_notifications')
							->where('id_user', $userid)
							->get();

		$notseens = array();
		$firstnotification = array();

		foreach ($usernots as $idy) {


			$notseens[] = $idy->id_notification;


		}


		if (count($notifications) > 0) {

			foreach ($notifications as $note) {

				if (count($notseens) > 0) {

					if (in_array($note->id, $notseens)) {

						continue;
						

					} else {

						if (Session::get('username') == $note->name ) {

							continue;

						}

						$idnotification = $note->id;



						$finalResults = '<div class="container m-0 m-0">';

		                    $finalResults .= '<div class="row m-0 p-0">';

		                        $finalResults .= '<div class="col-lg-4 p-0 m-0">';
		                        
		                            $finalResults .= '<img src="' . $note->imgurl . '" width="80" height="80" class="img-circle">'; 
		                        
		                        $finalResults .= '</div>';
		                        $finalResults .= '<div class="col-lg-8 p-0 m-0">';

		                            $finalResults .= '<h7>NOTIFICATION</h7>';
		                            $finalResults .= '<p style="font-size:12px; margin-top:0;">'. 'The ' . $note->object .' <span style="color:red;">' . $note->name . '</span> ' . $note->state .'</p>';

		                        $finalResults .= '</div>';

		                    $finalResults .= '</div>';

		                $finalResults .= '</div>';

						$data = array(

							'info' => $finalResults

						);

						$user_notifications = new user_notifications([

							'id_user' => $userid,
							'id_notification' => $idnotification

						]);

						$user_notifications->save();

						break;
						
					}

				} else {

					if (Session::get('username') == $note->name ) {

						continue;

					} else {

						$idnotification = $note->id;

						$finalResults = '<div class="m-0 m-0">';

		                    $finalResults .= '<div class="row m-0 p-0">';

		                        $finalResults .= '<div class="col-lg-3 p-0 m-0">';
		                        
		                            $finalResults .= '<img src="' . $note->imgurl . '" width="80" height="80" class="img-circle">'; 
		                        
		                        $finalResults .= '</div>';
		                        $finalResults .= '<div class="col-lg-8 p-0 m-0">';

		                            $finalResults .= '<h7>NOTIFICATION</h7>';
		                            $finalResults .= '<p style="font-size:14px; margin-top:0;">'. 'The ' . $note->object .' <span style="color:red;">' . $note->name . '</span> ' . $note->state .'</p>';

		                        $finalResults .= '</div>';

		                    $finalResults .= '</div>';

		                $finalResults .= '</div>';

						$data = array(

							'info' => $finalResults

						);

						$user_notifications = new user_notifications([

							'id_user' => $userid,
							'id_notification' => $idnotification

						]);

						$user_notifications->save();

						break;

					}

				}

			}

		} 



		echo json_encode($data);


	}


}
