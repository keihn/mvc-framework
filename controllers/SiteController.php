<?php

namespace app\controllers;

use app\core\Request;
use app\core\Application;
use app\core\Controller ;

class SiteController extends Controller
{
    public function contact()
    {
        return $this->render('contact');
    }


    public function handleContact(Request $request)
    {
        $body = $request->getBody();
        return 'Handling submited data';
    }

    public function home(){
        $params = [
            'name' => 'Abel Otugeme'
        ];

        return $this->render('home', $params);
    }


}