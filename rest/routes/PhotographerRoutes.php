<?php
// CRUD operations for todos entity

/**
 * @OA\Get(path="/photographers", tags={"Photographers"}, security={{"ApiKeyAuth": {}}},
 *         summary="Return all photographers from the API. ",
 *         @OA\Response( response=200, description="List of photographers.")
 * )
 */
Flight::route('GET /photographers', function(){
  Flight::json(Flight::photographerService()->get_all());
});

/**
 * @OA\Get(path="/photographers/{id}", tags={"Photographers"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(in="path", name="id", example=1, description="Id of photographer"),
 *     @OA\Response(response="200", description="Fetch individual photographer")
 * )
 */
Flight::route('GET /photographers/@id', function($id){
  Flight::json(Flight::photographerService()->get_by_id($id));
});

/**
 * @OA\Get(path="/{id}/photographers", tags={"Photographers"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(in="path", name="id", example=1, description="Id of posting whose photographer we want to get"),
 *     @OA\Response(response="200", description="Fetch posting's photographer")
 * )
 */
Flight::route('GET /@id/photographers', function($id){
  Flight::json(Flight::photographerService()->get_photographer_by_posting_id($id));
});



use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
* @OA\Post(
*     path="/login",
*     description="Login to the system",
*     tags={"Photographers"},
*     @OA\RequestBody(description="Basic user info", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*    				@OA\Property(property="email", type="string", example="test@test.com",	description="Email"),
*    				@OA\Property(property="password", type="string", example="123",	description="Password" )
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
*     path="/register",
*     description="Register a user into the app",
*     tags={"Photographers"},
*     @OA\RequestBody(description="Basic user register info", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*           @OA\Property(property="name", type="string", example="AmiraAbdo",	description="Username"),
*           @OA\Property(property="email", type="string", example="amira.abdo@stu.ibu.edu.ba",	description="User's email"),
*           @OA\Property(property="contact", type="string", example="123123123",	description="User's phone number"),
*           @OA\Property(property="about", type="string", example="Something a user wants to share about themselves :)",	description="Some info about the user"),
*           @OA\Property(property="password", type="string", example="password123",	description="User's password"),
*           @OA\Property(property="category", type="string", example="Wildlife",	description="User's category"),
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
