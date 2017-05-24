<?php

namespace App\Collections;

class UserData
{
	public function reply($user)
	{
		$following = ['threads', 'channels'];

		foreach($user->followed as $follow) {
			if (str_contains($follow->followable_type, 'Thread')) {
				$following['threads'][] = $follow->followable_id;
			} elseif (str_contains($follow->followable_type, 'Channel')) {
				$following['channels'][] = $follow->followable_id;
			}
		}

		return [
			'id' => $user->id,
			'nav_id' => $user->nav_id,
			'name' => $user->name,
			'company' => $user->company,
			'type' => $user->type,
			'job' => $user->job,
			'followed' => $following,
		];
	}
}