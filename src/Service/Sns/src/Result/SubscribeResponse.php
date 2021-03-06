<?php

namespace AsyncAws\Sns\Result;

use AsyncAws\Core\Response;
use AsyncAws\Core\Result;

class SubscribeResponse extends Result
{
    /**
     * The ARN of the subscription if it is confirmed, or the string "pending confirmation" if the subscription requires
     * confirmation. However, if the API request parameter `ReturnSubscriptionArn` is true, then the value is always the
     * subscription ARN, even if the subscription requires confirmation.
     */
    private $SubscriptionArn;

    public function getSubscriptionArn(): ?string
    {
        $this->initialize();

        return $this->SubscriptionArn;
    }

    protected function populateResult(Response $response): void
    {
        $data = new \SimpleXMLElement($response->getContent());
        $data = $data->SubscribeResult;

        $this->SubscriptionArn = ($v = $data->SubscriptionArn) ? (string) $v : null;
    }
}
