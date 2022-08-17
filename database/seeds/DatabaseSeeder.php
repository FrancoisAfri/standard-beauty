<?php

use Illuminate\Database\Seeder;
use App\User;
use App\HRPerson;
use App\Country;
use App\Province;
use App\modules;
use App\module_ribbons;
use App\DivisionLevel;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //insert default user
        $user = new User;
        $user->email = 'francois@afrixcel.co.za';
        $user->password = Hash::make('CharlesNgameni2035!@');
        $user->type = 3;
        $user->status = 1;
        $user->save();

        //insert default user's hr record
        $person = new HRPerson();
        $person->first_name = 'Francois';
        $person->surname = 'keou';
        $person->email = 'francois@afrixcel.co.za';
        $person->status = 1;
        $user->addPerson($person);

        //insert default country
        $country = new Country;
        $country->name = 'South Africa';
        $country->a2_code = 'ZA';
        $country->a3_code = 'ZAF';
        $country->numeric_code = 710;
        $country->dialing_code = '27';
        $country->abbreviation = 'RSA';
        $country->save();

        //insert default country's provinces
        $province = new Province();
        $province->name = 'Eastern Cape';
        $country->addProvince($province);

        $province = new Province();
        $province->name = 'Free State';
        $country->addProvince($province);

        $province = new Province();
        $province->name = 'Gauteng';
        $province->abbreviation = 'GP';
        $country->addProvince($province);

        $province = new Province();
        $province->name = 'KwaZulu-Natal';
        $province->abbreviation = 'KZN';
        $country->addProvince($province);

        $province = new Province();
        $province->name = 'Limpopo';
        $country->addProvince($province);

        $province = new Province();
        $province->name = 'Mpumalanga';
        $country->addProvince($province);

        $province = new Province();
        $province->name = 'North West';
        $country->addProvince($province);
//
        $province = new Province();
        $province->name = 'Northern Cape';
        $country->addProvince($province);

        $province = new Province();
        $province->name = 'Western Cape';
        $country->addProvince($province);

        //
        //insert marital statuses
        DB::table('marital_statuses')->insert([
            'value' => 'Single',
            'status' => 1,
        ]);
        DB::table('marital_statuses')->insert([
            'value' => 'Married',
            'status' => 1,
        ]);
        DB::table('marital_statuses')->insert([
            'value' => 'Divorced',
            'status' => 1,
        ]);
        DB::table('marital_statuses')->insert([
            'value' => 'Widower',
            'status' => 1,
        ]);

        //insert ethnicity
        DB::table('ethnicities')->insert([
            'value' => 'African',
            'status' => 1,
        ]);
        DB::table('ethnicities')->insert([
            'value' => 'Asian',
            'status' => 1,
        ]);
        DB::table('ethnicities')->insert([
            'value' => 'Caucasian',
            'status' => 1,
        ]);
        DB::table('ethnicities')->insert([
            'value' => 'Coloured',
            'status' => 1,
        ]);
        DB::table('ethnicities')->insert([
            'value' => 'Indian',
            'status' => 1,
        ]);
		DB::table('ethnicities')->insert([
            'value' => 'White',
            'status' => 1,
        ]);
        //insert public Holidays
        DB::table('public_holidays')->insert([
            'day' => 1482789600,
            'country_id' => 197,
            'year' => 0,
            'name' => 'Public Holiday',
        ]);
        DB::table('public_holidays')->insert([
            'day' => 1293228000,
            'country_id' => 197,
            'year' => 0,
            'name' => 'Christmas Day',
        ]);
        DB::table('public_holidays')->insert([
            'day' => 1285279200,
            'country_id' => 197,
            'year' => 0,
            'name' => 'Heritage Day',
        ]);
        DB::table('public_holidays')->insert([
            'day' => 1293314400,
            'country_id' => 197,
            'year' => 0,
            'name' => 'Day of Goodwill',
        ]);
        DB::table('public_holidays')->insert([
            'day' => 1269122400,
            'country_id' => 197,
            'year' => 0,
            'name' => 'Human Rights Day',
        ]);
        DB::table('public_holidays')->insert([
            'day' => 1272319200,
            'country_id' => 197,
            'year' => 0,
            'name' => 'Freedom Day',
        ]);
        DB::table('public_holidays')->insert([
            'day' => 1272664800,
            'country_id' => 197,
            'year' => 0,
            'name' => 'Workers Day',
        ]);
        DB::table('public_holidays')->insert([
            'day' => 1276639200,
            'country_id' => 197,
            'year' => 0,
            'name' => 'Youth Day',
        ]);
        DB::table('public_holidays')->insert([
            'day' => 1281304800,
            'country_id' => 197,
            'year' => 0,
            'name' => "National Women's Day",
        ]);
        DB::table('public_holidays')->insert([
            'day' => 1292450400,
            'country_id' => 197,
            'year' => 0,
            'name' => 'Day of Reconciliation',
        ]);
        DB::table('public_holidays')->insert([
            'day' => 1262296800,
            'country_id' => 197,
            'year' => 0,
            'name' => "New Year's Day",
        ]);
        DB::table('public_holidays')->insert([
            'day' => 1399413600,
            'country_id' => 197,
            'year' => 2014,
            'name' => 'Voting Day',
        ]);

        //insert the employees group levels (division departments)
        $groupLevel = new DivisionLevel();
        $groupLevel->level = 1;
        $groupLevel->active = 0;
        $groupLevel->save();

        $groupLevel = new DivisionLevel();
        $groupLevel->level = 2;
        $groupLevel->active = 0;
        $groupLevel->save();

        $groupLevel = new DivisionLevel();
        $groupLevel->level = 3;
        $groupLevel->active = 0;
        $groupLevel->save();

        $groupLevel = new DivisionLevel();
        $groupLevel->level = 4;
        $groupLevel->name = 'Department';
        $groupLevel->plural_name = 'Departments';
        $groupLevel->active = 1;
        $groupLevel->save();

        $groupLevel = new DivisionLevel();
        $groupLevel->level = 5;
        $groupLevel->name = 'Division';
        $groupLevel->plural_name = 'Divisions';
        $groupLevel->active = 1;
        $groupLevel->save();
		
        $module = new modules(); // Security
        $module->active = 1;
        $module->name = 'Security';
        $module->code_name = 'security';
        $module->path = 'users';
        $module->font_awesome = 'fa-lock';
        $module->save();

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 1;
        $ribbon->ribbon_name = 'Create User';
        $ribbon->description = 'Add User';
        $ribbon->ribbon_path = 'users/create';
        $ribbon->access_level = 3;
        $module->addRibbon($ribbon);

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 2;
        $ribbon->ribbon_name = 'Search Users';
        $ribbon->description = 'Search Users';
        $ribbon->ribbon_path = 'users';
        $ribbon->access_level = 4;
        $module->addRibbon($ribbon);

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 3;
        $ribbon->ribbon_name = 'Modules';
        $ribbon->description = 'Modules';
        $ribbon->ribbon_path = 'users/modules';
        $ribbon->access_level = 5;
        $module->addRibbon($ribbon);

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 4;
        $ribbon->ribbon_name = 'Users Access';
        $ribbon->description = 'Users Access';
        $ribbon->ribbon_path = 'users/users-access';
        $ribbon->access_level = 5;
        $module->addRibbon($ribbon);
		
		$ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 5;
        $ribbon->ribbon_name = 'Public Holidays Management';
        $ribbon->description = 'Public Holidays Management';
        $ribbon->ribbon_path = 'users/public-holiday';
        $ribbon->access_level = 4;
        $module->addRibbon($ribbon);
		
        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 6;
        $ribbon->ribbon_name = 'Setup';
        $ribbon->description = 'Setup';
        $ribbon->ribbon_path = 'users/setup';
        $ribbon->access_level = 5;
        $module->addRibbon($ribbon);

        $module = new modules(); //Employee Records
        $module->active = 1;
        $module->name = 'Company Setup';
        $module->code_name = 'hr';
        $module->path = 'hr ';
        $module->font_awesome = 'fa-users';
        $module->save();

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 1;
        $ribbon->ribbon_name = 'Company Setup';
        $ribbon->description = 'Company Setup';
        $ribbon->ribbon_path = 'hr/company_setup';
        $ribbon->access_level = 4;
        $module->addRibbon($ribbon);

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 2;
        $ribbon->ribbon_name = 'Setup';
        $ribbon->description = 'Setup';
        $ribbon->ribbon_path = 'hr/setup';
        $ribbon->access_level = 4;
        $module->addRibbon($ribbon);

        $module = new modules();//Audit Management
        $module->active = 1;
        $module->name = 'Audit Management';
        $module->code_name = 'audit';
        $module->path = 'audit';
        $module->font_awesome = 'fa-eye';
        $module->save();

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 1;
        $ribbon->ribbon_name = 'Audit Report';
        $ribbon->description = 'Audit Report';
        $ribbon->ribbon_path = 'audit/reports';
        $ribbon->access_level = 4;
        $module->addRibbon($ribbon); 
    }
}