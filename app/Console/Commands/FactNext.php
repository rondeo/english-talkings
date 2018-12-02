<?php

namespace App\Console\Commands;

use App\Fact;
use Illuminate\Console\Command;

class FactNext extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fact:next';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show the next fact';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $fact = Fact::where('is_published', true)->first();
        $nextId = Fact::where('id', '>', $fact->id)->min('id');

        $next = Fact::find($nextId);
        $this->info($next);

        if (!is_null($next)) {
            $next->is_published = true;
            $next->save();

            $fact->is_published = false;
            $fact->save();
        }
    }
}
