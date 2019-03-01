<?php

namespace Jerodev\PhpIrcClient\Messages;

use Jerodev\PhpIrcClient\IrcClient;

class IrcMessage
{
    /** @var string */
    private $rawMessage;

    /** @var string */
    public $command;

    /** @var string */
    public $commandsuffix;
    
    /** @var bool */
    protected $handled;

    /** @var string */
    public $payload;

    /** @var string */
    public $source;

    public function __construct(string $message)
    {
        $this->handled = false;
        $this->rawMessage = $message;

        if (preg_match('/^(?::(?<source>[^\s]+)\s*)?(?<command>[^\s]+)\s*(?<commandsuffix>[^:$]+)?\s*(?::(?<payload>.*?))?$/', $message, $matches)) {
            $this->source = $matches['source'] ?? null;
            $this->command = $matches['command'] ?? null;
            $this->commandsuffix = trim($matches['commandsuffix'] ?? null);
            $this->payload = $matches['payload'] ?? null;
        }
    }

    /**
     *  Get the raw message line.
     *
     *  @return string
     */
    public function getRaw(): string
    {
        return $this->rawMessage;
    }
    
    /**
     *  This function is always called after the message is parsed.
     *  The handle will only be executed once unless forced.
     *
     *  @param IrcClient $client A reference to the irc client object
     *  @param bool $force Force handling this message even if already handled.
     */
    public function handle(IrcClient $client, bool $force = false): void
    {
        if ($this->handled && !$force) {
            return;
        }
    }
}
