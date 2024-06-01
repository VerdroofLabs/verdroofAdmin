<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AppHelper;
use Illuminate\Support\Facades\Validator;


class PropertyController extends Controller
{
    public function createProperty(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'      => 'required|string|max:255',
            'description'      => 'required|string',
            'price'     => 'required',
            'rate'  => 'required|string',
            'location'      => 'required|string|max:255',
            'images'      => 'required',
        ]);

        if ($validator->fails()) {
            return AppHelper::sendError('Validation Error!', $validator->errors());
        }
        $code = rand(10000, 99999);
        $time = date_create()->getTimestamp();

        $prop = new Property;
        $prop->title = htmlentities($request->input('title'));
        $prop->description = htmlentities($request->input('description'));
        $prop->price =  htmlentities($request->input('price'));
        $prop->rate = htmlentities($request->input('rate'));
        $prop->location = htmlentities($request->input('location'));
        $prop->images =  $request->images;
        $prop->amenities = $request->amenities;
        $prop->rules = $request->rules;
        $prop->landmark = htmlentities($request->input('landmark'));
        $prop->mins_away = htmlentities($request->input('mins_away'));
        $prop->user_id = Auth::user()->id;
        $prop->property_id = "prop_".$time.$code;
        $prop_success = $prop->save();

        if ($prop_success) {
            return AppHelper::sendResponse($prop, 'Property Created Successfully');
        }else{
            return AppHelper::sendError('Property creation failed', ['Property creation failed'], 400);
        }
    }

    public function updateProperty(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'      => 'required|string|max:255',
            'description'      => 'required|string',
            'price'     => 'required',
            'rate'  => 'required|string',
            'location'      => 'required|string|max:255',
            'images'      => 'required',
        ]);

        if ($validator->fails()) {
            return AppHelper::sendError('Validation Error!', $validator->errors());
        }
        $code = rand(10000, 99999);
        $time = date_create()->getTimestamp();

        $prop = Property::find($id);
        $prop->title = htmlentities($request->input('title'));
        $prop->description = htmlentities($request->input('description'));
        $prop->price =  htmlentities($request->input('price'));
        $prop->rate = htmlentities($request->input('rate'));
        $prop->location = htmlentities($request->input('location'));
        $prop->images =  $request->images;
        $prop->amenities = $request->amenities;
        $prop->rules = $request->rules;
        $prop->landmark = htmlentities($request->input('landmark'));
        $prop->mins_away = htmlentities($request->input('mins_away'));
        $prop->property_id = "prop_".$time.$code;
        $prop_success = $prop->save();

        if ($prop_success) {
            return AppHelper::sendResponse($prop, 'Property Updated Successfully');
        }else{
            return AppHelper::sendError('Property update failed', ['Property update failed'], 400);
        }
    }

    public function getProperty(Request $request, $id)
    {
        $prop = Property::find($id);

        if ($prop) {
            return AppHelper::sendResponse($prop, 'Property Fetched Successfully');
        }else{
            return AppHelper::sendError('Property not found', ['Property not found'], 400);
        }
    }

    public function getAllProperty(Request $request)
    {
        $prop = Auth::user()->properties;

        if ($prop) {
            return AppHelper::sendResponse($prop, 'Property Fetched Successfully');
        }else{
            return AppHelper::sendError('Property not found', ['Property not found'], 400);
        }
    }

}
