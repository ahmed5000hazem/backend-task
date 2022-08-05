<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

use Illuminate\Auth\Events\Validated;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Html\Builder;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        if (request()->ajax()) {
            return DataTables::of(Company::query())
            ->addColumn('action', function ($row) {
                $html = '<a href="/companies/' . $row->id . '/edit" class="btn btn-sm btn-info"> Edit </a>';
                $html .= "<form action='/companies/" . $row->id . "/delete' method='POST'>";
                $html .= csrf_field() . '<button class="btn btn-xs mt-2 btn-danger">Delete</button>';
                $html .= "</form>";
                return $html;
            })
            ->toJson();
        }

        $companies = $builder->columns([
            ['data' => 'id'],
            ['data' => 'name'],
            ['data' => 'logo'],
            ['data' => 'address'],
            ['data' => 'created_at'],
            ['data' => 'updated_at'],
            ['data' => 'action'],
        ]);
        
        return view("company.index", compact("companies"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("company.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "address" => "required|string",
            "logo" => "mimes:jpg,bmp,png",
        ]);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $logoName = time() . "_" . $request->file("logo")->getClientOriginalName();
        
        $company = new Company();
        $company->name = $request->name;
        $company->address = $request->address;
        $company->logo = $logoName;
        $company->save();
        
        $request->file("logo")->storeAs("/public/company", $logoName);
        return redirect("/companies");
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::find($id);
        return view("company.edit", [
            "company" => $company
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "address" => "required|string",
            "logo" => "mimes:jpg,bmp,png|nullable",
        ]);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $company = Company::find($id);

        if ($request->hasFile("logo")){
            $logoName = time() . "_" . $request->file("logo")->getClientOriginalName();
            unlink(storage_path('app/public/company/'.$company->logo));
            $request->file("logo")->storeAs("/public/company", $logoName);
            $company->logo = $logoName;
        }
        
        $company->name = $request->name;
        $company->address = $request->address;
        $company->save();
        return redirect("/companies");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return redirect()->back();
    }
}
