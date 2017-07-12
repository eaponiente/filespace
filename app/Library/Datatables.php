<?php
namespace App\Library;

class Datatables {

	/**
	 * undocumented function
	 *
	 * @return void
	 **/

	public static function create($query, $get, $sortBy)
	{
        $iTotalRecords = $query->count();


        $iDisplayLength = self::getLength($_POST['length'], $iTotalRecords);

        $iDisplayStart =  intval($_POST['start']);


        $sEcho = intval($_POST['draw']);

        $recs = $query->take( $iDisplayLength )->skip( $iDisplayStart )->orderBy($sortBy[0], $sortBy[1])->get();

        $records = array();

        $records["data"] = array(); 

        $end = $iDisplayStart + $iDisplayLength;


        return [
        	'output' => [
        		'sEcho' => $sEcho,
	        	'iTotalRecords' => $iTotalRecords,
	        	'data' => $records,
        	],
        	
        	'result' => $recs
        ];


	}

	public static function generateJSON($records)
	{

		if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
            $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
            $records["customActionMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
         }

        $records["draw"] = $records['sEcho'];
        $records["recordsTotal"] = $records['iTotalRecords'];
        $records["recordsFiltered"] = $records['iTotalRecords'];
          
        return response()->json($records);
	}


	/**
	 * get all the variables pass from querystring
	 *
	 * @return int
	 **/
	public static function getLength($length, $total)
	{
		$length = intval($length);

		$length = $length < 0 ? $total : $length;

		return $length;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function cleanArray($get) 
	{
		return array_map('trim', $get);
	}



}