<?php

namespace App\Console\Commands;

use App\Helpers\LineHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;

class TimeNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'linebot:time';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var LineHelper
     */
    private LineHelper $lineHelper;

    /**
     * Create a new command instance.
     *
     * @param LineHelper $lineHelper
     */
    public function __construct(LineHelper $lineHelper)
    {
        $this->lineHelper = $lineHelper;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $userIds = [
            'Ud7a58ed5efb8a8f8eb845bf7e1b2c958',
            'U1a4f2cb47ed3c5eef0fa8656d9611274'
        ];

        $multicast = $this->lineHelper->multicast($userIds, new TextMessageBuilder('This is scheduled multicast message from Son Tran\'s bot'));

        if (!$multicast->isSucceeded()) {
            Log::channel('single')->info('Broadcast message:' . $multicast->getHTTPStatus() . ' ' . $multicast->getRawBody());
        }
    }
}
