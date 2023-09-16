<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use stdClass;

class CustomerController extends Controller
{
    // Add Customer Page

    public function index()
    {
        return view('customer.index');
    }



    // Edit Customer Page

    public function editCustomerView($customerUrl)
    {
        $customer = Customer::where('customUrl', $customerUrl)->first();

        if($customer == null)
        {
            return view('customer.404');
        }
        return view('customer.edit', ['customer' => $customer]);
    }


    public function editCustomer(Request $request)
    {

        $id = $request->id;
        $personalData = $request->about;
        $editCode = $request->editCode;
        $newEditCode = $request->newEditCode;
        $newCustomUrl = $request->newCustomUrl;

        $error = new stdClass;


        // Null Validation 

        if ($personalData == null) {
            $error->about = "Personal Data Required";
        }

        if ($editCode == null) {
            $error->editCode = "Edit Code Required";
        }

        if(!empty(get_object_vars($error)))
        {
            return response()->json(['errorMessage' => 'Data Not saved successfully.','error'=> $error],400);
        }

        
        // Get Old Data

        $oldCustomer = Customer::where('id', $id)->first();

        // print_r(strtolower($oldCustomer->editCode));
        // print_r(strtolower($editCode));
        // print_r(strtolower($oldCustomer->editCode) === strtolower($editCode));

        // Validation 

        if(strtolower($oldCustomer->editCode) !== strtolower($editCode))
        {   
            $error->editCode = "Please Enter Valid Edit Code";
            return response()->json(['errorMessage' => 'Data Not Update Successfully.','error'=> $error],400);
        }


        $oldCustomer->personalData = $request->about;

        $oldCustomer->customUrl = $newCustomUrl ? $newCustomUrl : $oldCustomer->customUrl;
        $oldCustomer->editCode = $newEditCode ? $newEditCode :  $oldCustomer->editCode;


        // dd($oldCustomer);
        $oldCustomer->save();

        
        // dd($request);

        $newCustomerData = Customer::where('id', $id)->first();


        // return view('customer.edit',['customer' => $customer ]);
        return response()->json(['success' => 'Data updated successfully.', 'url' => $newCustomerData->customUrl]);
    }

    public function saveCustomerImage(Request $request)
    {

        // Validate the uploaded file
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the file types and size limit as needed
        ]);

        // Store the uploaded file
        $imagePath = $request->file('image')->store('images', 'public');
        $imageUrl = asset('storage/' . $imagePath);

        return response()->json(['success' => 'Data updated successfully.', 'url' => $imageUrl]);
    
    }


    public function deleteCustomer(Request $request)
    {



        $customer = Customer::where('id', $request->id)->first();

      
        if($customer == null)
        {
            return view('customer.404');
        }

        $customer->delete();

        return response()->json(['success' => 'Post Deleted successfully.', 'url' => '/']);
    }


    // Add Customer Function 

    public function addCustomer(Request $request)
    {

        $customer =  new Customer;
        $customer->personalData = $request->about;

        $customer->customUrl = $request->customUrl;
        $customer->editCode = $request->customEditCode;

        $customer->save();
        return response()->json(['success' => 'Post saved successfully.', 'url' => $customer->customUrl]);
    }


    // Get Customer Data 

    public function getCustomer($customerUrl)
    {

        $customer = Customer::where('customUrl', $customerUrl)->first();

      
        if($customer == null)
        {
            return view('customer.404');
        }

        $customer->increment('viewCount'); // Increase 'quantity' column by 1
        $customer->save();

        // dd($customer);

        return view('customer.view', ['customer' => $customer]);
    }
}
