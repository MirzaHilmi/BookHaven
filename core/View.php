<?php
namespace Saphpi\Core;

class View {
    public string $title;

    public function error(\Throwable $e, bool $suppress): string {
        $code = !empty($e->getCode()) ? $e->getCode() : 500;
        Application::response()->setHttpStatus($code);

        $codeStr = substr("{$code}", 0, 1);
        if ($suppress) {
            return $this->renderView("errors/{$codeStr}xx");
        }
        return $this->renderView("layouts/default>errors/{$codeStr}xx", [
            'code'    => $code,
            'message' => $e->getMessage(),
        ], 'Ooops.. there\'s something wrong');
    }

    public function renderView(string $name, array $props = [], string $title = 'Page'): string {
        if (count($template = explode('>', $name)) !== 1) {
            $layout = $this->getLayout($template[0], $title);
            $content = $this->getContent($template[1], $props);
            return str_replace('<Content></Content>', $content, $layout);
        }

        $view = $this->getContent($name, $props);
        return $view;
    }

    private function getLayout(string $name, string $title): string {
        ob_start();
        @require_once Application::$ROOT_DIR . "/views/{$name}.sapi.php";
        return ob_get_clean();
    }

    private function getContent(string $name, array $props): string {
        foreach ($props as $key => $value) {
            $$key = $value;
        }
        ob_start();
        @require_once Application::$ROOT_DIR . "/views/{$name}.sapi.php";
        return ob_get_clean();
    }
}
