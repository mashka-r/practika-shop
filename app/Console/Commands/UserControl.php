<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Basket;
use Carbon;

class UserControl extends Command
{
    protected $signature = 'control:user';

    protected $description = 'Чистить устаревшие пустые записи в корзине пользователей категории гость';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Basket::where('updated_at', '<', Carbon::now()->Month())->whereNull('user_id')->delete();
    }
}
