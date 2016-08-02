<?php

namespace App\Console\Commands;

use App\Repositories\Platform\UserRepository;
use Illuminate\Console\Command;

class EmailAutomation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:automation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send all emails automation';

    protected $userRepository;

    /**
     * Create a new command instance.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Log::info($this->userRepository->getPublisherInComplete(3));
        \Log::info($this->userRepository->getPublisherNotOffers(3));
        \Log::info($this->userRepository->getPublisherNotSigned(3));
        \Log::info($this->userRepository->getPublisherHasOffers(3));

        \Log::info('automation');
    }
}
