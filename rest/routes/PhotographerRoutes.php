<?php
// CRUD operations for todos entity

/**
 * @OA\Get(path="/notes", tags={"todo"}, security={{"ApiKeyAuth": {}}},
 *         summary="Return all user notes from the API. ",
 *         @OA\Response( response=200, description="List of notes.")
 * )
 */
Flight::route('GET /photographers', function(){
  Flight::json(Flight::photographerService()->get_all());
});

/**
 * @OA\Get(path="/notes/{id}", tags={"todo"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(in="path", name="id", example=1, description="Id of note"),
 *     @OA\Response(response="200", description="Fetch individual note")
 * )
 */
Flight::route('GET /photographers/@id', function($id){
  Flight::json(Flight::photographerService()->get_by_id($id));
});

/**
 * @OA\Get(path="/notes/{id}/todos", tags={"todo"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(in="path", name="id", example=1, description="List todos"),
 *     @OA\Response(response="200", description="Fetch note's todos")
 * )
 */
Flight::route('GET /@id/photographers', function($id){
  Flight::json(Flight::photographerService()->get_photographer_by_posting_id($id));
});


/**
* add notes
*/
Flight::route('POST /notes', function(){
  Flight::json(Flight::noteService()->add(Flight::request()->data->getData()));
});

/**
* update notes
*/
Flight::route('PUT /notes/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::noteService()->update($id, $data));
});

/**
* delete notes
*/
Flight::route('DELETE /notes/@id', function($id){
  Flight::noteService()->delete($id);
  Flight::json(["message" => "deleted"]);
});

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
* @OA\Post(
*     path="/login",
*     description="Login to the system",
*     tags={"todo"},
*     @OA\RequestBody(description="Basic user info", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*    				@OA\Property(property="email", type="string", example="dino.keco@gmail.com",	description="Email"),
*    				@OA\Property(property="password", type="string", example="1234",	description="Password" )
*        )
*     )),
*     @OA\Response(
*         response=200,
*         description="JWT Token on successful response"
*     ),
*     @OA\Response(
*         response=404,
*         description="Wrong Password | User doesn't exist"
*     )
* )
*/
Flight::route('POST /login', function(){
    $login = Flight::request()->data->getData();
    $user = Flight::photographerDao()->get_photographer_by_email($login['email']);
    if (isset($user['id'])){
      if($user['password'] == md5($login['password'])){
        unset($user['password']);
        $jwt = JWT::encode($user, Config::JWT_SECRET(), 'HS256');
        Flight::json(['token' => $jwt]);
      }else{
        Flight::json(["message" => "Wrong password"], 404);
      }
    }else{
      Flight::json(["message" => "User doesn't exist"], 404);
    }
});

/**
* @OA\Post(
*     path="/public/register",
*     description="Register a user into the app",
*     tags={"users"},
*     @OA\RequestBody(description="Basic user register info", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*           @OA\Property(property="user_mail", type="string", example="testing@test.t",	description="User email"),
*           @OA\Property(property="password", type="string", example="weakpassword",	description="User password"),
*           @OA\Property(property="phone_number", type="string", example="123123123",	description="User phonenumber"),
*           @OA\Property(property="city", type="string", example="City",	description="User city"),
*           @OA\Property(property="municipality", type="string", example="Municipality",	description="User municipality"),
*        )
*     )),
*     @OA\Response(
*         response=200,
*         description="JWT Token"
*     ),
*     @OA\Response(
*         response=404,
*         description="User not found"
*     ),
* )
*/
Flight::route('POST /register', function () {

  $data = Flight::request()->data->getData();
  unset($data['repeatpassword']);
  $data['password'] = md5($data['password']);

  $catch = Flight::photographerService()->add($data);
  unset($catch['password']);



  $jwt = JWT::encode($catch, Config::JWT_SECRET(), 'HS256');
  Flight::json(['token' => $jwt]);

});

?>
