<?php

namespace Gwaps4nlp\Core\Repositories;

use Gwaps4nlp\Core\Models\Trophy;

class TrophyRepository extends BaseRepository
{

	/**
	 * Create a new TrophyRepository instance.
	 *
	 * @param  Gwaps4nlp\Core\Models\Trophy $trophy
	 * @return void
	 */
	public function __construct(
		Trophy $trophy)
	{
		$this->model = $trophy;
	}

	/**
	 * Get all the trophies
	 *
	 * @return Collection of Trophy
	 */
	public function getAll()
	{
		return $this->model->get();
	}

}
