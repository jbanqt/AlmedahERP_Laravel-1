<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = \App\Models\Employee::class;

    public function definition()
    {
        $gender = ["Male", "Female"];
        $salaryTerm = ["Weekly", "Monthly"];
        return [
            'employee_id'=>"EMP-" . $this->faker->unique()->ean13,
            'last_name'=>$this->faker->lastName,
            'first_name'=>$this->faker->firstName,
            'position'=>$this->faker->jobTitle,
            'gender'=>$gender[rand(0,1)],
            'contact_number'=>$this->faker->phoneNumber,
            'email'=> $this->faker->unique()->safeEmail,
            'date_of_birth'=>$this->faker->dateTime($max = 'now', $timezone = null),
            'department_id'=>"DEPT-001",
            'employment_id'=>"EMP-FT",
            'hired_date'=>$this->faker->dateTime($max = 'now', $timezone = null),
            'salary'=>rand(1,100),
            'salary_term'=>$salaryTerm[rand(0,1)],
            'role_id'=>"ROLE-001",
            'is_admin'=>rand(0,1),
            'address'=>$this->faker->address,
            'status'=>"Active",
        ];
    }
}
