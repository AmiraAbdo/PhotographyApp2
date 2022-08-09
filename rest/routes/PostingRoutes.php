<?php
// CRUD operations for todos entity

/**
 * @OA\Get(path="/postings", tags={"Postings"}, security={{"ApiKeyAuth": {}}},
 *         summary="Return all postings from the API. ",
 *         @OA\Response( response=200, description="List of postings.")
 * )
 */
Flight::route('GET /postings', function(){
  Flight::json(Flight::postingService()->get_all());
});

/**
 * @OA\Get(path="/postings/{id}", tags={"Postings"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(in="path", name="id", example=1, description="Id of posting"),
 *     @OA\Response(response="200", description="Fetch individual posting")
 * )
 */
Flight::route('GET /postings/@id', function($id){
  Flight::json(Flight::postingService()->get_by_id($id));
});

/**
 * @OA\Get(path="/postings/{id}/photographer", tags={"Postings"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(in="path", name="id", example=1, description="Id of photographer whose postings we want to get"),
 *     @OA\Response(response="200", description="Fetch a list of a particular photographer's postings")
 * )
 */
Flight::route('GET /postings/@id/photographer', function($id){
  Flight::json(Flight::postingService()->get_postings_by_photographer_id($id));
});

/**
* @OA\Post(
*     path="/postings", security={{"ApiKeyAuth": {}}},
*     description="Add user posting",
*     tags={"Postings"},
*     @OA\RequestBody(description="Basic posting info", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*    				@OA\Property(property="title", type="string", example="Looking for work in Sarajevo",	description="Title of the posting"),
*    				@OA\Property(property="description", type="string", example="Looking for bookings, I offer high quality and low prices",	description="Short posting description" ),
*           @OA\Property(property="tier_id", type="string", example="1",	description="Foreign key to tier table - specify the pricing tier"),
*           @OA\Property(property="photographer_id", type="string", example="1",	description="Foreign key to photographers table - specify the photographer who posted")
*        )
*     )),
*     @OA\Response(
*         response=200,
*         description="Posting that has been created"
*     ),
*     @OA\Response(
*         response=500,
*         description="Error"
*     )
* )
*/
Flight::route('POST /postings', function(){
  Flight::json(Flight::postingService()->add(Flight::request()->data->getData()));
});

/**
* @OA\Delete(
*     path="/postings/{id}", security={{"ApiKeyAuth": {}}},
*     description="Soft delete user posting",
*     tags={"Postings"},
*     @OA\Parameter(in="path", name="id", example=1, description="Posting ID"),
*     @OA\Response(
*         response=200,
*         description="Posting deleted"
*     ),
*     @OA\Response(
*         response=500,
*         description="Error"
*     )
* )
*/
Flight::route('DELETE /postings/@id', function($id){
  Flight::postingService()->delete($id);
  Flight::json(["message" => "deleted"]);
});

?>
