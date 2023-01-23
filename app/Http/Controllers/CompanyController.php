<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		if ($request->ajax()) {
			$data = Company::select('id', 'name', 'email', 'address')->get();
			return Datatables::of($data)
					->addColumn('actions', function($row) {
						$btns = '<form class="m-0" action="'.route('companies.destroy', $row->id).'" method="POST">';
						$btns .= csrf_field();
						$btns .= method_field('DELETE');
						$btns .= '<center>';
						$btns .= '<div class="btn-group">';
						$btns .= '<a href="'.route('companies.show', $row->id).'" class="btn btn-light btn-sm"><i class="fa fa-eye"></i></a>';
						$btns .= '<a href="'.route('companies.edit', $row->id).'" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>';
						$btns .= '<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
						$btns .= '</div">';
						$btns .= '</center>';
						$btns .= '</form>';
						return $btns;
					})
					->rawColumns(['actions'])
					->make(true);
		}
		return view('companies.index');
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.create');
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
			'name' => 'required|max:255',
			'email' => 'required|email|max:255',
			'logo' => 'required|image|mimes:png,jpg,jpeg|dimensions:min_width=100,min_height=100|max:2048',
			'address' => 'required|max:255'
		]);

		$logoName = $this->uploadLogo($request->file('logo'));

		$company = new Company();
		$company->name = $validated['name'];
		$company->email = $validated['email'];
		$company->logo = $logoName;
		$company->address = $validated['address'];
		$company->save();
		
		return redirect(route('companies.index'))
			->with('message', 'Компания создана');
	}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
		$yaMapsApiKey = env('YA_MAPS_API_KEY');
		$url = 'https://geocode-maps.yandex.ru/1.x';
		$query = [
			'geocode' => '$company->address',
			'apikey' => $yaMapsApiKey,
			'format' => 'json',
			'results' => 1
		];
				
		$response = Http::withOptions([
			'verify' => false,
		])->get($url, $query);
		$responseBody = json_decode($response->body());

		if (isset($responseBody->error)) {
			return view('companies.show')
			->with('company', $company)
			->withErrors(['msg' => $responseBody->message]);
		}
		
		$latLng = $responseBody
				->metaDataProperty
				->GeocoderResponseMetaData
				->Point
				->pos;
		list($latitude, $longitude) = explode(' ', $latLng);

		return view('companies.show')
			->with('company', $company)
			->with('yaMapsApiKey', $yaMapsApiKey)
			->with('latitude', $latitude)
			->with('longitude', $longitude);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('companies.edit')->with('company', $company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
			'name' => 'required|max:255',
			'email' => 'required|email',
			'logo' => 'sometimes|nullable|image|mimes:png,jpg,jpeg|dimensions:min_width=100,min_height=100|max:2048',
			'address' => 'required|max:255'
		]);
		
		if ($request->hasFile('logo')) {
			Storage::disk('public')->delete('logos/'.$company->logo);
			$logoName = $this->uploadLogo($request->file('logo'));
			$company->logo = $logoName;
		}

		$company->name = $validated['name'];
		$company->email = $validated['email'];
		$company->address = $validated['address'];
		$company->save();
		
		return redirect(route('companies.index'))
			->with('message', 'Компания изменена');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
		Storage::disk('public')->delete('logos/'.$company->logo);
        $company->delete();
		
		return redirect(route('companies.index'))
			->with('message', 'Компания удалена');
    }

	private function uploadLogo($logo): string {
		$logoName = time().'.'.$logo->Extension();
        $logo->storeAs('logos', $logoName, 'public');
		
		return $logoName;
	}
}
