<?php

namespace App\Extensions;

class MariaSessionHandler implements \SessionHandlerInterface
{
    public function open($savePath, $sessionName)
    {
        // Implementation for opening a session
    }

    public function close()
    {
        // Implementation for closing a session
    }

    public function read($sessionId)
    {
        // Implementation for reading session data
    }

    public function write($sessionId, $data)
    {
        // Implementation for writing session data
    }

    public function destroy($sessionId)
    {
        // Implementation for destroying a session
    }

    public function gc($maxLifetime)
    {
        // Implementation for garbage collection
    }
}
