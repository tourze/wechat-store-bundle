<?php

declare(strict_types=1);

namespace WechatStoreBundle\Exception;

final class InvalidClassException extends \RuntimeException
{
    public static function classNotFound(string $className): self
    {
        return new self(sprintf('Class "%s" does not exist.', $className));
    }
}
