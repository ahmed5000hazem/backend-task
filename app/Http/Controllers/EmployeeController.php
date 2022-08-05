<?php

namespace App\Http\Controllers;

use App\Events\SayWelcomeEvent;
use App\Models\Company;
use App\Models\Employee;

use Illuminate\Http\Request;

use DataTables;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Html\Builder;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        
        $companies = Company::select("id", "name")->get();

        if (request()->ajax()) {
            $employee = "";
            if ($request->query("company_id")) $employee = Employee::where("company_id", $request->query("company_id"));
            else $employee = Employee::query();
            
            return DataTables::of($employee)
            ->addColumn('action', function ($row) {
                $html = '<a href="/employees/' . $row->id . '/edit" class="btn btn-sm btn-info"> Edit </a>';
                $html .= "<form action='/employees/" . $row->id . "/delete' method='POST'>";
                $html .= csrf_field() . '<button class="btn btn-xs mt-2 btn-danger">Delete</button>';
                $html .= "</form>";
                return $html;
            })
            ->toJson();
        }

        $employees = $builder->columns([
            ["data" => "id"],
            ["data" => "name"],
            ["data" => "email"],
            ["data" => "company_id"],
            ["data" => "image"],
            ['data' => 'created_at'],
            ['data' => 'updated_at'],
            ['data' => 'action'],
        ]);
        
        return view("employee.index", compact("employees", "companies"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("employee.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "email" => "required|email",
            "password" => "required|confirmed",
            "company_id" => "required",
            "image" => "mimes:jpg,bmp,png",
        ]);

        if ($validator->fails()){
            dd($validator->errors());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $imageName = time() . "_" . $request->file("image")->getClientOriginalName();
        
        $employee = new Employee();
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->password = bcrypt($request->password);
        $employee->company_id = $request->company_id;
        $employee->image = $imageName;
        $employee->save();
        
        $request->file("image")->storeAs("/public/employee", $imageName);

        event(new SayWelcomeEvent($request->email));

        return redirect("/employees");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view("employee.edit", [
            "employee" => $employee
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
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "email" => "required|email",
            "password" => "nullable|confirmed",
            "company_id" => "required",
            "image" => "mimes:jpg,bmp,png|nullable",
        ]);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $employee = Employee::find($id);
        if ($request->hasFile("image")) {
            dd($employee);
            $imageName = time() . "_" . $request->file("image")->getClientOriginalName();
            $request->file("image")->storeAs("/public/employee", $imageName);
            $employee->image = $imageName;
        }

        if ($request->password) {
            $employee->password = bcrypt($request->password);
        }
        
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->company_id = $request->company_id;
        $employee->save();
        
        return redirect("/employees");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        $employee->delete();
        return redirect("/employees");
    }
}
