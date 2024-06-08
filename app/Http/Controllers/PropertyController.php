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
        $code = rand(10000, 99999);
        $time = date_create()->getTimestamp();

        $prop = new Property;
        $prop->apartment_type = htmlentities($request->input('apartment_type'));
        $prop->description = htmlentities($request->input('description'));
        $prop->rent =  htmlentities($request->input('rent'));
        $prop->unit_type = htmlentities($request->input('unit_type'));
        $prop->unit_floor = htmlentities($request->input('unit_floor'));
        $prop->current_link = htmlentities($request->input('current_link'));

        $prop->unit_size = htmlentities($request->input('unit_size'));
        $prop->no_of_bedrooms = htmlentities($request->input('no_of_bedrooms'));
        $prop->no_of_bathrooms =  htmlentities($request->input('no_of_bathrooms'));
        $prop->cover_image = htmlentities($request->input('cover_image'));
        $prop->payment_schedule = htmlentities($request->input('payment_schedule'));

        $prop->location = htmlentities($request->input('location'));
        $prop->other_images =  $request->other_images;
        $prop->basic_amenities = $request->basic_amenities;
        $prop->house_rules = $request->house_rules;
        $prop->safety_amenities =  $request->safety_amenities;
        $prop->building_amenities = $request->building_amenities;

        $prop->utility_deposit = htmlentities($request->input('utility_deposit'));
        $prop->security_deposit = htmlentities($request->input('security_deposit'));

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
        $code = rand(10000, 99999);
        $time = date_create()->getTimestamp();

        $prop = Property::find($id);
        $prop->apartment_type = htmlentities($request->input('apartment_type'));
        $prop->description = htmlentities($request->input('description'));
        $prop->rent =  htmlentities($request->input('rent'));
        $prop->unit_type = htmlentities($request->input('unit_type'));
        $prop->unit_floor = htmlentities($request->input('unit_floor'));
        $prop->current_link = htmlentities($request->input('current_link'));

        $prop->unit_size = htmlentities($request->input('unit_size'));
        $prop->no_of_bedrooms = htmlentities($request->input('no_of_bedrooms'));
        $prop->no_of_bathrooms =  htmlentities($request->input('no_of_bathrooms'));
        $prop->cover_image = htmlentities($request->input('cover_image'));
        $prop->payment_schedule = htmlentities($request->input('payment_schedule'));

        $prop->location = htmlentities($request->input('location'));
        $prop->other_images =  $request->other_images;
        $prop->basic_amenities = $request->basic_amenities;
        $prop->house_rules = $request->house_rules;
        $prop->safety_amenities =  $request->safety_amenities;
        $prop->building_amenities = $request->building_amenities;
        $prop->published = $request->published;


        $prop->utility_deposit = htmlentities($request->input('utility_deposit'));
        $prop->security_deposit = htmlentities($request->input('security_deposit'));

        $prop_success = $prop->save();

        if ($prop_success) {
            return AppHelper::sendResponse($prop, 'Property Updated Successfully');
        }else{
            return AppHelper::sendError('Property update failed', ['Property update failed'], 400);
        }
    }

    public function deleteProperty(Request $request, $id)
    {
        $user = Auth::user();
        $prop = Property::where('user_id', $user->id)->where('id', $id)->first();

        $prop_success = $prop->delete();

        if ($prop_success) {
            return AppHelper::sendResponse($prop, 'Property Deleted Successfully');
        }else{
            return AppHelper::sendError('Property delete failed, ensure you are deleting your property', ['Property delete failed'], 400);
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

    public function getAllUserProperty(Request $request)
    {
        $prop = Auth::user()->properties;

        if ($prop) {
            return AppHelper::sendResponse($prop, 'Properties Fetched Successfully');
        }else{
            return AppHelper::sendError('Property not found', ['Property not found'], 400);
        }
    }

    public function getAllProperties(Request $request)
    {
        $prop = Property::all();
        return AppHelper::sendResponse($prop, 'Properties Fetched Successfully');
    }

    public function searchProperty(Request $request)
    {
        $rent = trim($request->input('rent'));
        $type = trim($request->input('type'));
        $location = trim($request->input('location'));

        if(strlen($rent)  && strlen($type) && strlen($location)){
            $props =  Property::where('unit_type', 'like', "%$type%")->orWhere('rent', 'like', "%$rent%")->orWhere('location', 'like', "%$location%")->get();
            $yes = 'all';
        }elseif(strlen($rent)  && strlen($type)){
            $props =  Property::where('unit_type', 'like', "%$type%")->orWhere('rent', 'like', "%$rent%")->get();
            $yes = 'rent&type';
        }elseif(strlen($type)  && strlen($location)){
            $props =  Property::where('unit_type', 'like', "%$type%")->orWhere('location', 'like', "%$location%")->get();
            $yes = 'location&type';
        }elseif(strlen($rent)  && strlen($location)){
            $props =  Property::where('rent', 'like', "%$rent%")->orWhere('location', 'like', "%$location%")->get();
            $yes = 'location&rent';
        }elseif(strlen($rent)){
            $props =  Property::where('rent', 'like', "%$rent%")->get();
            $yes = 'rent';
        }elseif(strlen($type)){
            $props =  Property::where('unit_type', 'like', "%$type%")->get();
            $yes = 'type';
        }elseif(strlen($location)){
            $props =  Property::where('location', 'like', "%$location%")->get();
            $yes = 'location';
        }else{
            $props =  Property::all();
            $yes = 'none';
        }
        return AppHelper::sendResponse($props, 'Properties Fetched Successfully');
    }

}
