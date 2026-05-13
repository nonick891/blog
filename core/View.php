<?php

namespace Core;

use Smarty\Smarty;

class View
{
    private static ?Smarty $smarty = null;

    private static function getSmarty(): Smarty
    {
        if (self::$smarty === null) {
            $smarty = new Smarty();
            $smarty->setTemplateDir(__DIR__ . '/../app/Views/templates');
            $smarty->setCompileDir(__DIR__ . '/../app/Views/compiled');
            $smarty->setCacheDir(__DIR__ . '/../app/Views/cache');
            $smarty->setConfigDir(__DIR__ . '/../app/Views/configs');

            self::$smarty = $smarty;
        }

        return self::$smarty;
    }

    /** @param array<string, mixed> $data */
    public static function render(string $template, array $data = []): void
    {
        $smarty = self::getSmarty();

        foreach ($data as $key => $value) {
            $smarty->assign($key, $value);
        }

        $smarty->display($template);
    }
}
