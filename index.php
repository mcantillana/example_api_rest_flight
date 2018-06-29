<?php
require "system/library/flight/Flight.php";
include "system/library/mysqli.php";
require_once "config.php";

// include "controller/ontour_controller.php";
// include "model/ontour_model.php";

// Flight::route('POST /', 'init_transaction');
// Flight::route('/callback', 'callback');
// Flight::route('/success', 'success');
// Flight::route('/failure', 'failure');


// Flight::route('/', function(){
//     $data = array();
//     $db = Flight::db();
//     $query = $db->query("SELECT * FROM `user`") ;
//     $results = $query->rows ;
//     print_r($results) ;
//     // Flight::render('test.php', $data);
// });
// Flight::json(array('id' => 123));


Flight::route('GET /auth', function(){
    $data = array();

    // $db = Flight::db();
    // $query = $db->query("SELECT * FROM `user`") ;
    // $results = $query->rows ;
    
    $data['message'] = 'Forbiben' ;

    Flight::json($data);

});


Flight::route('POST /auth', function(){
    $data = array();
    $db = Flight::db();

    $request_body = file_get_contents('php://input');
    $user = json_decode($request_body);
    
    $sql = "SELECT * FROM `user` WHERE email = '" . $user->email . "' AND password = '" . $user->password . "'";
    $query = $db->query($sql) ;

    if($query->num_rows) {
        $data['message'] = 'Login success';
        $data['code'] = 200;
        
    } else {
        $data['message'] = 'Login and password incorrect';
        $data['code'] = 500;
    }
    
    Flight::json($data);

});



# register class
Flight::register('db', 'DBMySQLi', array(
    $hostname = DB_HOSTNAME, 
    $username = DB_USER, 
    $password = DB_PASS, 
    $database = DB_DB)
);


Flight::start();
