<?php
// CRUD operations for todos entity

/**
 * @OA\Get(path="/gear", tags={"Gear"}, security={{"ApiKeyAuth": {}}},
 *         summary="Return all gear from the API. ",
 *         @OA\Response( response=200, description="List of gear.")
 * )
 */
Flight::route('GET /gear', function(){
  Flight::json(Flight::gearService()->get_all());
});

/**
 * @OA\Get(path="/gear/photographer/{id}", tags={"Gear"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(in="path", name="id", example=1, description="Id of photographer whose gear we need"),
 *     @OA\Response(response="200", description="Fetch a particular photographer's gear")
 * )
 */
Flight::route('GET /gear/photographer/@id', function($id){
  Flight::json(Flight::gearService()->get_gear_by_photographer_id($id));
});

Flight::route('POST /gear', function(){
  Flight::json(Flight::gearService()->add(Flight::request()->data->getData()));
});

?>
