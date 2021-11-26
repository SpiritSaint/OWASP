<?php

namespace App\Console\Commands;

use App\Models\Vulnerability;
use Illuminate\Console\Command;
use Goutte\Client;

class Extract extends Command
{
    /**
     * The Goutte Http Client.
     *
     * @var Client
     */
    protected $client;

    /**
     * Selector of titles
     *
     * @var string
     */
    protected $titles = "#sec-main > ul > li > a";


    /**
     * Selector of descriptions
     *
     * @var string
     */
    protected $descriptions = "#sec-main > ul > li";


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'owasp:extract';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extract information from OWASP site.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->client = new Client();
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $crawler = $this->client->request('GET', 'https://owasp.org/www-project-top-ten/');

        $titles = collect();
        $descriptions = collect();

        $crawler->filter($this->titles)->each(function ($node) use ($titles) {
            $titles->push($node->text());
        });


        $crawler->filter($this->descriptions)->each(function ($node) use ($descriptions) {
            $descriptions->push($node->text());
        });


        for ($i = 0; $i < $descriptions->count(); $i++)
        {
            Vulnerability::query()->create([
                'title' => $titles->get($i),
                'description' => $descriptions->get($i),
            ]);
        }

        return Command::SUCCESS;
    }
}
