<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use phpseclib3\Crypt\RSA;

class GenerateRSAKeys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:rsakeys';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate RSA private and public keys';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Generate a new private (and public) key pair
        $rsa = RSA::createKey(2048); // 2048 is the key size

        // Extract the private and public keys
        $privateKey = $rsa->toString('PKCS8'); // Save private key in PKCS8 format
        $publicKey = $rsa->getPublicKey()->toString('PKCS8'); // Save public key in PKCS8 format

        // Save the private key to a file
        file_put_contents(storage_path('rsa_private.pem'), $privateKey);

        // Save the public key to a file
        file_put_contents(storage_path('rsa_public.pem'), $publicKey);

        $this->info("RSA keys generated and saved to storage path as rsa_private.pem and rsa_public.pem");

        return 0;
    }
}
