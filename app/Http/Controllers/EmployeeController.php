<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Company;
use Illuminate\Http\Request;
use DataTables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		if ($request->ajax()) {
			$data = Employee::select('id', 'company_id', 'name', 'email', 'phone')->get();
			return Datatables::of($data)
					->addColumn('company_name', function($row) {
						return Company::find($row->company_id)->name;
					})
					->addColumn('actions', function($row) {
						$btns = '<form class="m-0" action="'.route('employees.destroy', $row->id).'" method="POST">';
						$btns .= csrf_field();
						$btns .= method_field('DELETE');
						$btns .= '<center>';
						$btns .= '<div class="btn-group">';
						$btns .= '<a href="'.route('employees.show', $row->id).'" class="btn btn-light btn-sm"><i class="fa fa-eye"></i></a>';
						$btns .= '<a href="'.route('employees.edit', $row->id).'" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>';
						$btns .= '<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
						$btns .= '</div">';
						$btns .= '</center>';
						$btns .= '</form>';
						return $btns;
					})
					->rawColumns(['actions'])
					->make(true);
		}
		return view('employees.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employees.create')->with('companies', Company::select('id', 'name')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
			'company_id' => 'required',
			'name' => 'required|max:255',
			'email' => 'required|email|max:255',
			'phone' => 'required|max:255'
		]);
		
		$employee = new Employee();
		$employee->company_id = $validated['company_id'];
		$employee->name = $validated['name'];
		$employee->email = $validated['email'];
		$employee->phone = $validated['phone'];
		$employee->save();
		
		return redirect(route('employees.index'))
			->with('message', 'Сотрудник создан');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return view('employees.show')
			->with('employee', $employee)
			->with('company_name', Company::find($employee->company_id)->name);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        return view('employees.edit')
			->with('employee', $employee)
			->with('companies', Company::select('id', 'name')->get());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
			'company_id' => 'required',
			'name' => 'required|max:255',
			'email' => 'required|email|max:255',
			'phone' => 'required|max:255'
		]);
		
		$employee->company_id = $validated['company_id'];
		$employee->name = $validated['name'];
		$employee->email = $validated['email'];
		$employee->phone = $validated['phone'];
		$employee->save();
		
		return redirect(route('employees.index'))
			->with('message', 'Сотрудник изменен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
		
		return redirect(route('employees.index'))
			->with('message', 'Сотрудник удален');
    }
}
