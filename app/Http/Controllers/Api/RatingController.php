<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rating;

class RatingController extends Controller
{
    public function createReviewForProduct(Request $request)
    {
        if ($request->method() == 'GET') {
            return response()->json([
                'status' => 400,
                'message' => 'Method not allowed'
            ], 400);
        }
        $validator = Validator::make($request->all(), [
            'product_id' => 'nullable|numeric',
            'rating' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid data',
                'errors' => $validator->errors()
            ], 400);
        }

        $rating = (new Rating())->createNewRating($request->only('product_id', 'rating', 'comment'), 'product');

        return response()->json([
            'status' => $rating->getData()->status,
            'message' => $rating->getData()->message
        ], $rating->getData()->status);
    }

    public function createReviewForUser(Request $request)
    {
        if ($request->method() == 'GET') {
            return response()->json([
                'status' => 400,
                'message' => 'Method not allowed'
            ], 400);
        }
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|numeric',
            'rating' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid data',
                'errors' => $validator->errors()
            ], 400);
        }

        $rating = (new Rating())->createNewRating($request->only('user_id', 'rating', 'comment'), 'user');

        return response()->json([
            'status' => $rating->getData()->status,
            'message' => $rating->getData()->message
        ], $rating->getData()->status);
    }

    public function getAllProductRatings(Request $request)
    {
        if ($request->method() == 'POST') {
            return response()->json([
                'status' => 400,
                'message' => 'Method not allowed'
            ], 400);
        }
        $data['pagination'] = isset($request->pagination) ? true : false;
        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $ratings = (new Rating())::getAllRatings($request->all(), $data['pagination'], $data['page_limit'], 'product');

        return response()->json([
            'status' => 200,
            'product_ratings' => $ratings
        ], 200);
    }

    public function getAllUserRatings(Request $request)
    {
        if ($request->method() == 'POST') {
            return response()->json([
                'status' => 400,
                'message' => 'Method not allowed'
            ], 400);
        }
        $data['pagination'] = isset($request->pagination) ? true : false;
        $data['page_limit'] = isset($request->page_limit) ? $request->page_limit : 10;
        $ratings = (new Rating())::getAllRatings($request->all(), $data['pagination'], $data['page_limit'], 'user');

        return response()->json([
            'status' => 200,
            'user_ratings' => $ratings
        ], 200);
    }
}
