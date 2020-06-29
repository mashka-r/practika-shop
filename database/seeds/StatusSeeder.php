<?php

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status1 = new Status();
        $status1->description = 'в обработке';
        $status1->save();

        $status2 = new Status();
        $status2->description = 'в пути';
        $status2->save();

        $status3 = new Status();
        $status3->description = 'доставлен';
        $status3->save();

        $status4 = new Status();
        $status4->description = 'получен';
        $status4->save();

        $status5 = new Status();
        $status5->description = 'отменен';
        $status5->save();

        $status6 = new Status();
        $status6->description = 'возврат';
        $status6->save();
    }
}
