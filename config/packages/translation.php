<?php
declare(strict_types=1);

use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $framework): void {
    $framework->defaultLocale('en');
    $framework->translator()
        ->defaultPath('%kernel.project_dir%/translations')
        ->fallbacks(['en']);
};
