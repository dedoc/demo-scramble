<?php

namespace App\Support\Documentation;

use Dedoc\Scramble\Extensions\OperationExtension;
use Dedoc\Scramble\Support\Generator\Operation;
use Dedoc\Scramble\Support\RouteInfo;
use Illuminate\Support\Str;

class GoToDefinitionOperationExtension extends OperationExtension
{
    const REPO_URL = 'https://github.com/dedoc/demo-scramble/tree/main';

    public function handle(Operation $operation, RouteInfo $routeInfo)
    {
        $url = static::REPO_URL.Str::replace(base_path(), '', $routeInfo->reflectionMethod()->getFileName());

        $line = $routeInfo->reflectionMethod()->getStartLine();

        $methodLineUrl = "$url#L$line";

        $operation->description(
            $operation->description . " [Open on GitHub]($methodLineUrl)"
        );
    }
}
