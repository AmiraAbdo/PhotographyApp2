<?php
// CRUD operations for todos entity

/**
 * @OA\Get(path="/tiers", tags={"Tiers"}, security={{"ApiKeyAuth": {}}},
 *         summary="Return all tiers from the API. ",
 *         @OA\Response( response=200, description="List of tiers.")
 * )
 */
Flight::route('GET /tiers', function(){
  Flight::json(Flight::tierService()->get_all());
});

/**
 * @OA\Get(path="/tiers/{id}", tags={"Tiers"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(in="path", name="id", example=1, description="Id of tier"),
 *     @OA\Response(response="200", description="Fetch individual tier")
 * )
 */
Flight::route('GET /tiers/@id', function($id){
  Flight::json(Flight::tierService()->get_by_id($id));
});

/**
 * @OA\Get(path="/postings/{id}/tiers", tags={"Tiers"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(in="path", name="id", example=1, description="Id of posting whose tier we need"),
 *     @OA\Response(response="200", description="Fetch a particular posting's tier")
 * )
 */
Flight::route('GET /postings/@id/tiers', function($id){
  Flight::json(Flight::tierService()->get_tier_by_posting_id($id));
});

?>
