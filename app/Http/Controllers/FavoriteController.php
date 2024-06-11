<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use App\Models\FavoriteItem;
use App\Helpers\AppHelper;
use Illuminate\Support\Facades\Validator;


class FavoriteController extends Controller
{
    public function addItemToFavorites(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'property_id'      => 'required|integer',
        ]);

        if ($validator->fails()) {
            return AppHelper::sendError('Validation Error!', $validator->errors());
        }
        $user = Auth::user();
        $fav = Favorite::where('user_id', $user->id)->first();

        // return $fav;
        $existing_item = FavoriteItem::where(['favorite_id' => $fav->id, 'property_id' => $request->input('property_id')])->first();

        if (!$existing_item) {
            $item = new FavoriteItem;
            $item->favorite_id = $fav->id;
            $item->property_id = $request->input('property_id');
            $success = $item->save();

            $prop = Property::find($request->input('property_id'));

            if ($success) {
                return AppHelper::sendResponse("Property $prop->property_id bookmarked", 'Property Bookmarked Successfully');
            }else{
                return AppHelper::sendError('Property Bookmark Failed', ['Property Bookmarked Failed, Try Again'], 400);
            }
        }else{
            return AppHelper::sendResponse("Property bookmarked already", 'Property Already Bookmarked');
        }
    }


    public function deleteItemFromFavorites(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'property_id'      => 'required|integer',
        ]);

        if ($validator->fails()) {
            return AppHelper::sendError('Validation Error!', $validator->errors());
        }
        $user = Auth::user();
        $favorites = Favorite::where('user_id', $user->id)->first();

        $existing_item = FavoriteItem::where(['Favorite_id' => $favorites->id, 'property_id' => $request->input('property_id')])->first();
        $existing_item->delete();

        return AppHelper::sendResponse("Bookmarks updated", 'Bookmarks updated successfully');
    }

    public function getUserFavorites(Request $request)
    {
        $user = Auth::user();
        $favorites = Favorite::where('user_id', $user->id)->select(['id'])->with(['items:id,favorite_id', 'properties'])->first();

        return AppHelper::sendResponse($favorites, 'Bookmarks Fetched Successfully');
    }
}
