<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Session;

class CompanyInfoExport implements FromArray, WithHeadings, ShouldAutoSize
{
	/**
	* @return \Illuminate\Support\Collection
	*/
	public function array(): array
	{
		return Session::get('company_infos');
	}

	public function headings(): array
	{
		return [
			'Company Name',
			'URL',
			'Date Of Establishment',
			'Number Of Members',
			'Address',
		];
	}
}
