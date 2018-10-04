<?php

namespace App\Service;

use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class MarkdownHelper
{


    /**
     * @var AdapterInterface
     */
    private $cache;
    /**
     * @var MarkdownParserInterface
     */
    private $markdown;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var bool
     */
    private $isDebug;

    public function __construct(AdapterInterface $cache, MarkdownParserInterface $markdown, LoggerInterface $markdownLogger, bool $isDebug)
    {

        $this->cache = $cache;
        $this->markdown = $markdown;
        $this->logger = $markdownLogger;
        $this->isDebug = $isDebug;
    }

    public function parse(string $Source): string
    {
        if(stripos($Source, 'bacon') !== false){
            $this->logger->info('They are talking about bacon again!');
        }

        if($this->isDebug){
            return $this->markdown->transformMarkdown($Source);
        }

        $item = $this->cache->getItem('markdown_'.md5($Source));
        if(!$item->isHit()){
            $item->set($this->markdown->transformMarkdown($Source));
            $cache->save($item);
        }

        return $item->get();
    }
}