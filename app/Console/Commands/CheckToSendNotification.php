<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Notifications\Text;
use App\Notifications\Email;
use Illuminate\Console\Command;

class CheckToSendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check notifications and processe as needed';

    protected $text, $email;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Text $text, Email $email)
    {
        $this->text = $text;
        $this->email = $email;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $stop = Carbon::now()->addMinute(1)->toDateTimeString();

        $emailsCount = $this->email->checkAndSend($stop);

        if($emailsCount > 0) {
            $this->info('Have '.$emailsCount.' to run');
        }

        $textsCount = $this->text->checkAndSend($stop);

        if($textsCount > 0) {
            $this->info('Have '.$textsCount.' to run');
        }

        return $this->line('Done, '. $emailsCount . ' emails and '. $textsCount .' texts run');
    }
}
