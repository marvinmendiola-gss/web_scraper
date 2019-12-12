<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Exports\CompanyInfoExport;
use Session;
use Excel;

class ScraperController extends Controller
{
	public function index()
	{
		return view('scrape');
	}

	public function scraper(Request $request)
	{
		$request->session()->forget('company_infos');
		$request->session()->forget('name');
		$result = [];
		$page = $request->page_first;
		
		for($page; $page <= $request->page_last; $page++){
			$client = new Client();
			$web_request = $client->get('https://en-jp.wantedly.com/projects?type=mixed&page='.$page);
			$body = $web_request->getBody()->getContents();
			$pattern = '/<a href="(.*?)\?filter_params[^>]+">/';
			preg_match_all($pattern, $body, $matches);

			foreach($matches[1] as $matched){
				$links[] = $matched;
			}
		}

		foreach($links as $link){
			$single_request = $client->get('https://en-jp.wantedly.com' . $link);
			$response = $single_request->getBody()->getContents();
			$pattern_name = "/<div class='company-name'>\n(.*?)\n<\/div>/s";
			$pattern_url = "/<div class='company-icon wt-icon wt-icon-link'><\/div>\n<div class='company-description'>\n(.*?)\n<\/div>/i";
			$pattern_founded = "/<div class='company-icon icon-flag'><\/div>\n<div class='company-description'>\n(.*?)\n<\/div>/i";
			$pattern_members = "/<div class='company-icon icon-group'><\/div>\n<div class='company-description'>\n(.*?)\n<\/div>/i";
			$pattern_address = "/<div class='company-icon wt-icon wt-icon-location'><\/div>\n<div class='company-description'>\n(.*?)\n<\/div>/i";

			preg_match_all($pattern_name, $response, $company_names);
			preg_match_all($pattern_url, $response, $company_url);
			preg_match_all($pattern_founded, $response, $company_founded);
			preg_match_all($pattern_members, $response, $company_members);
			preg_match_all($pattern_address, $response, $company_address);

			$result[] = [
				'company_name'	=> $company_names[1][0],
				'url'			=> explode('"', $company_url[1][0])[3],
				'founded' 		=> empty($company_founded[1]) ? '': $company_founded[1][0],
				'members'		=> empty($company_members[1]) ? '': $company_members[1][0],
				'address'		=> empty($company_address[1]) ? '': $company_address[1][0],
			];
        }

		Session::put('name', 'Wantedly_' . $request->page_first . ' to '. $request->page_last);
		Session::push('company_infos', $result);
		return view('scrape', compact('result'))->with([

		]);
	}

	public function export(Request $request){

		$name = Session::get('name');
		return Excel::download(new CompanyInfoExport(), $name.'.' . $request->extension);
	}
}
