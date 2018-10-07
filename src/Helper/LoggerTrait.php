<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018-10-06
 * Time: 오후 12:58
 */

namespace App\Helper;

use Psr\Log\LoggerInterface;

trait LoggerTrait
{
    private $logger;

    /**
     * @required
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function logInfo(string $message, array $context = [])
    {
        if($this->logger){
            $this->logger->info($message, $context);
        }
    }
}