<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018-10-06
 * Time: 오후 12:13
 */

namespace App\Service;

use App\Helper\LoggerTrait;
use Nexy\Slack\Client;


class SlackClient
{

    use LoggerTrait;
    /**
     * @var Client
     */
    private $slack;



    /**
     * SlackClient constructor.
     */
    public function __construct(Client $slack)
    {
        $this->slack = $slack;
    }

    public function sendMessage(string $from, string $message)
    {

        $this->logInfo('test to Slack23333!!', [
           'message' => $message
        ]);

        $slackMessage = $this->slack->createMessage()
            ->from($from)
            ->withIcon(':ghost:')
            ->setText($message);

        $this->slack->sendMessage($slackMessage);
    }


}