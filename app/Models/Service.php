<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Service
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property float|null $cost
 * @property int $company_id
 *
 * @property Company $company
 * @property Collection|Employee[] $employees
 * @property Collection|Schedule[] $schedules
 *
 * @package App\Models
 */
class Service extends Model
{
	protected $table = 'services';
	public $timestamps = false;

	protected $casts = [
		'cost' => 'float',
		'employee_id' => 'int'
	];

	protected $fillable = [
		'name',
		'description',
		'cost',
		'employee_id'
	];

	public function employee()
	{
		return $this->belongsTo(Employee::class);
	}

	public function employees()
	{
		return $this->belongsToMany(Employee::class, 'employees_services');
	}

	public function schedules()
	{
		return $this->hasMany(Schedule::class);
	}
}
