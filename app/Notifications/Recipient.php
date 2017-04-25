<?php

namespace App\Notifications;

use Storage;
use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    
    public function upload($file)
    {
    	$path = $file->storeAs('public/notifications/csvs', $file->getClientOriginalName()); 	
		$response = preg_split('/\n|\r\n?/', Storage::get($path), -1, PREG_SPLIT_NO_EMPTY);
		$location = [];
		$count = 0;
		$items = [];

		foreach(explode(',', $response[0]) as $row) {
			if($row == 'name') {
				$location[$count] = 'name';
			} elseif($row == 'email') {
				$location[$count] = 'email';
			} elseif($row == 'phone') {
				$location[$count] = 'phone';
			}
			$count++;
		}

		$remove = array_shift($response);


		foreach($response as $row) {
			$count = 0;
			$collect = [];
			foreach($location as $key => $item) {
				if($item == 'name') {
					$collect = array_add($collect, 'name', explode(',', $row)[$key]);
				} elseif($item == 'email') {
					$collect = array_add($collect, 'email', explode(',', $row)[$key]);
				} elseif($item == 'phone') {
					$collect = array_add($collect, 'phone', explode(',', $row)[$key]);
				}
				$count++;
			}

			$items[] = $collect;	
		}


		return $items;
    }
}