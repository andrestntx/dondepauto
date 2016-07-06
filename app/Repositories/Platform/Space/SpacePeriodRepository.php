<?php 

namespace App\Repositories\Platform\Space;

/**
* 
*/
class SpacePeriodRepository
{
	
	public function listsSelect()
	{
		return collect([
			['name' => 'Mes'],
			['name' => '15 días'],
			['name' => 'Semana'],
			['name' => 'FDS'],
			['name' => 'Día'],
			['name' => 'Bimestre'],
			['name' => 'Trimestre'],
			['name' => 'Semestre'],
			['name' => 'Año']
		])->sortBy('name')
			->lists('name', 'name')
			->all();
	}
}

