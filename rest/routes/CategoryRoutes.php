<?php
// CRUD operations for category entity

/**
 * @OA\Get(path="/categories", tags={"Categories"}, security={{"ApiKeyAuth": {}}},
 *         summary="Return all categories from the API. ",
 *         @OA\Response( response=200, description="List of categories.")
 * )
 */
Flight::route('GET /categories', function(){
  Flight::json(Flight::categoryService()->get_all());
});

/**
 * @OA\Get(path="/categories/photographer/{id}", tags={"Categories"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(in="path", name="id", example=1, description="Id of photographer whose category we need"),
 *     @OA\Response(response="200", description="Fetch a particular photographer's category")
 * )
 */
Flight::route('GET /categories/photographer/@id', function($id){
  Flight::json(Flight::categoryService()->get_category_by_photographer_id($id));
});


?>
