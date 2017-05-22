<?php

namespace App\Collections;

class UserData
{
	public function reply($user)
	{
		foreach($user->followed as $follow) {
			if (str_contains($follow->followable_type, 'Thread')) {
				$following['threads'][] = $follow->followable_id;
			} elseif (str_contains($follow->followable_type, 'Channel')) {
				$following['channels'][] = $follow->followable_id;
			}
		}

		return [
			'id' => $user->id,
			'name' => $user->name,
			'company' => $user->company,
			'type' => $user->type,
			'job' => $user->job,
			'followed' => $following,
		];
	}
}