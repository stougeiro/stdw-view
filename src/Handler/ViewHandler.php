<?php declare(strict_types=1);

    namespace STDW\View\Handler;

    use STDW\Contract\ViewHandlerInterface;
    use STDW\View\Exception\ViewFileNotFoundException;


    class ViewHandler implements ViewHandlerInterface
    {
        public function __construct()
        { }


        public function compile(string $filepath, array $data = []): string
        {
            if ( ! file_exists($filepath)) {
                throw new ViewFileNotFoundException("View: '{$filepath}' not found");
            }

            ob_start();
                foreach ($data as $key => $value) {
                    $$key = $value;
                }

                include $filepath;

                $output = ob_get_contents();
            ob_end_clean();

            return $output;
        }

        public function render(string $filepath, array $data = []): void
        {
            echo $this->compile($filepath, $data);
        }
    }