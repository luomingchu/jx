<?php

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->call('AdminTableSeeder');
        $this->call('RegionTableSeeder');
        $this->call('ManagersTableSeeder');
        $this->call('MembersTableSeeder');
        $this->call('EnterprisesTableSeeder');
        $this->call('VstoresTableSeeder');
    }
}
