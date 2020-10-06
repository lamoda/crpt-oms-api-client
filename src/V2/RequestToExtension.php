<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\V2;

use Lamoda\OmsClient\Exception\OmsGeneralErrorException;
use Lamoda\OmsClient\V2\Dto\CreateOrderForEmissionICRequest;
use Lamoda\OmsClient\V2\Dto\CreateOrderForEmissionICRequestLight;
use Lamoda\OmsClient\V2\Dto\CreateOrderForEmissionICRequestLp;
use Lamoda\OmsClient\V2\Dto\CreateOrderForEmissionICRequestPerfum;
use Lamoda\OmsClient\V2\Dto\CreateOrderForEmissionICRequestShoes;

final class RequestToExtension
{
    private $requestToExtension;

    public function __construct()
    {
        $this->requestToExtension = [
            CreateOrderForEmissionICRequestLight::class => Extension::light(),
            CreateOrderForEmissionICRequestLp::class => Extension::lp(),
            CreateOrderForEmissionICRequestPerfum::class => Extension::perfum(),
            CreateOrderForEmissionICRequestShoes::class => Extension::shoes(),
        ];
    }

    public function getExtensionByCreateOrderForEmissionICRequest(CreateOrderForEmissionICRequest $request): Extension
    {
        $className = get_class($request);

        if (!isset($this->requestToExtension[$className])) {
            throw new OmsGeneralErrorException(sprintf('Cannot convert request %s to extension', $className));
        }

        return $this->requestToExtension[$className];
    }
}