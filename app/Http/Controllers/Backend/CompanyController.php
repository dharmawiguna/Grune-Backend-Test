<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Company;
use App\Models\Prefecture;
use App\Models\Postcode;
use Config;

class CompanyController extends Controller
{

	private function getRoute() {
        return 'companies';
    }


    protected function validator( array $data, $type) {
        
        return Validator::make($data, [
                'name' => 'required|string|max:255|',

                'email' => 'required|email|max:255',
                // 'email' => 'required|email|max:255|regex:/(.*)@'.$emailDomain.'/i',
                'postcode' => 'required|string|max:255',
                'prefecture_id' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'local' => 'required|string|max:255',
                'image' => 'required',
                // (update: not required, create: required)
        ]);
    }

    public function index() {
        return view('backend.companies.index');
    }

    public function add(Request $request) {
    	$companies = new Company();
        $companies->form_action = $this->getRoute() . '.create';
        $companies->page_title = 'Companies Add Page';
        $companies->page_type = 'create';
        
        // $prefecture
        $prefectures = Prefecture::all();
        $select = [];
        foreach($prefectures as $prefecture){
            $select[$prefecture->id] = $prefecture->name;
        }
        
        return view('backend.companies.form', [
            'companies' => $companies,

            'select' => $select,
        ]);
    }

    
    public function create(Request $request) {
        $newCompany = $request->all();
        
        // Validate input, indicate this is 'create' function
        $this->validator($newCompany, 'create')->validate();
        
        try {
            $companies = Company::create($newCompany);
            $company_id = $companies['id'];
            $extension = $newCompany['image']->getClientOriginalExtension();
            $customName = 'Image_'.$company_id.'.'.$extension;
            $newCompany['image'] = $request->file('image')->storeAs('', $customName);
            // dd($company_id);
            if ($companies) {
                // Create is successful, back to list

                return redirect()->route($this->getRoute())->with('success', Config::get('const.SUCCESS_CREATE_MESSAGE'));
            } else {
                // Create is failed

                return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_CREATE_MESSAGE'));
            }
        } catch (Exception $e) {
            // Create is failed
            return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_CREATE_MESSAGE'));
        }
    }

    public function edit($id) {
        $companies = Company::with(['prefecture'])->find($id);
        $companies->form_action = $this->getRoute() . '.update';
        $companies->page_title = 'Company Edit Page';
        // Add page type here to indicate that the form.blade.php is in 'edit' mode
        $companies->page_type = 'edit';

        return view('backend.companies.form', [
            'companies' => $companies
        ]);
    }

    public function update(Request $request) {
        $newCompany = $request->all();
        $company_id = $newCompany['id'];
        $extension = $newCompany['image']->getClientOriginalExtension();
        $customName = 'Image_'.$company_id.'.'.$extension;
        $newCompany['image'] = $request->file('image')->storeAs('', $customName);
        
        try {
            $currentCompany = Company::find($request->get('id'));
            if ($currentCompany) {
                // If password input is empty this means we take the old password value as is from DB
                if (!$newCompany['name']) {
                    $newCompany['name'] = $currentCompany['name'];
                }
                if (!$newCompany['email']) {
                    $newCompany['email'] = $currentCompany['email'];
                }
                if (!$newCompany['postcode']) {
                    $newCompany['postcode'] = $currentCompany['postcode'];
                }
                if (!$newCompany['prefecture_id']) {
                    $newCompany['prefecture_id'] = $currentCompany['prefecture_id'];
                }
                if (!$newCompany['city']) {
                    $newCompany['city'] = $currentCompany['city'];
                }
                if (!$newCompany['local']) {
                    $newCompany['local'] = $currentCompany['local'];
                }
                if (!$newCompany['street_address']) {
                    $newCompany['street_address'] = $currentCompany['street_address'];
                }
                if (!$newCompany['business_hour']) {
                    $newCompany['business_hour'] = $currentCompany['business_hour'];
                }
                if (!$newCompany['regular_holiday']) {
                    $newCompany['regular_holiday'] = $currentCompany['regular_holiday'];
                }
                if (!$newCompany['phone']) {
                    $newCompany['phone'] = $currentCompany['phone'];
                }
                if (!$newCompany['fax']) {
                    $newCompany['fax'] = $currentCompany['fax'];
                }
                if (!$newCompany['url']) {
                    $newCompany['url'] = $currentCompany['url'];
                }
                if (!$newCompany['license_number']) {
                    $newCompany['license_number'] = $currentCompany['license_number'];
                }
                if (!$newCompany['image']) {
                    $newCompany['image'] = $currentCompany['image'];
                }
                // Validate input only after getting password, because if not validator will keep complaining that password does not meet validation rules
                // Hashed password from DB will always have length of 60 characters so it will pass validation
                // Also indicate this is 'update' function
                $this->validator($newCompany, 'update')->validate();

                // Only hash the password if it needs to be hashed

                // Update user
                $currentCompany->update($newCompany);
                // dd($newCompany);
                // If update is successful
                return redirect()->route($this->getRoute())->with('success', Config::get('const.SUCCESS_UPDATE_MESSAGE'));
            } else {
                // If update is failed
                return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_UPDATE_MESSAGE'));
            }
        } catch (Exception $e) {
            // If update is failed
            return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_UPDATE_MESSAGE'));
        }
    }

    public function delete(Request $request) {
        try {
            // Get user by id
            $companies = Company::find($request->get('id'));
            // If to-delete user is not the one currently logged in, proceed with delete attempt
            if (Auth::id() != $companies->id) {

                // Delete user
                $companies->delete();

                // If delete is successful
                return redirect()->route($this->getRoute())->with('success', Config::get('const.SUCCESS_DELETE_MESSAGE'));
            }
            // Send error if logged in user trying to delete himself
            return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_DELETE_SELF_MESSAGE'));
        } catch (Exception $e) {
            // If delete is failed
            return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_DELETE_MESSAGE'));
        }
    }


}
