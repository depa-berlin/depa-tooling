<?php


namespace Depa\Tooling\ActiveRecord;

/**
 * Class CreateActiveRecord
 * @package Depa\Tooling\ActiveRecord
 */
class CreateActiveRecord
{

    public const CLASS_SKELETON = <<< 'EOS'
<?php
declare(strict_types=1);
namespace %namespace%;
use Depa\ActiveRecord;

class %class% extends ActiveRecord
{
    public $tablename = \'%tableName%\';
        
    public $primaryKeys = [' . $this->primarysString . "\n" . '];
        
     public $attributes = [' . "\n" . $this->attributesString . '];
        
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        // $response = $handler->handle($request);
    }
}
EOS;


    public function process(
        string $class,
        string $projectRoot = null,
        string $classSkeleton = self::CLASS_SKELETON
    ) : string
    {
        $projectRoot = $projectRoot ?: getcwd();

        $path = $this->getClassPath($class, $projectRoot);

        list($namespace, $class) = $this->getNamespaceAndClass($class);

        $content = str_replace(
            ['%namespace%', '%class%'],
            [$namespace, $class],
            $classSkeleton
        );

        if (is_file($path)) {
            throw CreateMiddlewareException::classExists($path, $class);
        }

        file_put_contents($path, $content);
        return $path;

    }




}