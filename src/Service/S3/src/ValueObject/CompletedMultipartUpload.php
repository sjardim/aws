<?php

namespace AsyncAws\S3\ValueObject;

final class CompletedMultipartUpload
{
    /**
     * Array of CompletedPart data types.
     */
    private $Parts;

    /**
     * @param array{
     *   Parts?: null|\AsyncAws\S3\ValueObject\CompletedPart[],
     * } $input
     */
    public function __construct(array $input)
    {
        $this->Parts = isset($input['Parts']) ? array_map([CompletedPart::class, 'create'], $input['Parts']) : null;
    }

    public static function create($input): self
    {
        return $input instanceof self ? $input : new self($input);
    }

    /**
     * @return CompletedPart[]
     */
    public function getParts(): array
    {
        return $this->Parts ?? [];
    }

    /**
     * @internal
     */
    public function requestBody(\DomElement $node, \DomDocument $document): void
    {
        if (null !== $v = $this->Parts) {
            foreach ($v as $item) {
                $node->appendChild($child = $document->createElement('Part'));

                $item->requestBody($child, $document);
            }
        }
    }
}
