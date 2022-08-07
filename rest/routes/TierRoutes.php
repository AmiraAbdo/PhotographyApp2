<?php
// CRUD operations for todos entity

/**
 * @OA\Get(path="/notes", tags={"todo"}, security={{"ApiKeyAuth": {}}},
 *         summary="Return all user notes from the API. ",
 *         @OA\Response( response=200, description="List of notes.")
 * )
 */
Flight::route('GET /tiers', function(){
  Flight::json(Flight::tierService()->get_all());
});

/**
 * @OA\Get(path="/notes/{id}", tags={"todo"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(in="path", name="id", example=1, description="Id of note"),
 *     @OA\Response(response="200", description="Fetch individual note")
 * )
 */
Flight::route('GET /tiers/@id', function($id){
  Flight::json(Flight::tierService()->get_by_id($id));
});

?>
