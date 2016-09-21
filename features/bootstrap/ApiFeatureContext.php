<?php

use Behat\Behat\Definition\Call\Then;
use Behat\Behat\Hook\Scope\BeforeFeatureScope;
use Behat\WebApiExtension\Context\WebApiContext;
use GuzzleHttp\Client;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Behat\Context\SnippetAcceptingContext;
use PHPUnit_Framework_Assert as Assertions;

class ApiFeatureContext extends WebApiContext implements KernelAwareContext, SnippetAcceptingContext
{
    /**
     * @var string
     */
    private static $feature;

    /**
     * @param string $baseUri
     */
    public function __construct($baseUri)
    {
        $parameters['base_uri'] = $baseUri;
        $this->setClient(new Client($parameters));
    }

    /**
     * @param \Symfony\Component\HttpKernel\KernelInterface $kernel
     */
    public function setKernel(\Symfony\Component\HttpKernel\KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * Returns Container instance.
     *
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    public function getContainer()
    {
        return $this->kernel->getContainer();
    }

    /**
     * @BeforeFeature
     */
    public static function setupFeatureName(BeforeFeatureScope $scope)
    {
        self::$feature = basename($scope->getFeature()->getFile(), '.feature');
    }

    /** @BeforeSuite */
    public static function before()
    {
        shell_exec('php app/console doctrine:schema:drop --force -e test');
        shell_exec('php app/console doctrine:schema:create -e test');
        shell_exec('php app/console doctrine:fixtures:load -e test --no-interaction');
    }

    /**
     * @AfterStep
     *
     * @param \Behat\Behat\Hook\Scope\AfterStepScope $scope
     */
    public function printResponseForFailedStep(\Behat\Behat\Hook\Scope\AfterStepScope $scope)
    {
        if ($this->response && !$scope->getTestResult()->isPassed()) {
            $this->printResponse();
        }
    }

    /**
     * Checks that response OK.
     *
     * @throws \RuntimeException
     *
     * @Then /^(?:the )?response should be OK$/
     */
    public function theResponseShouldBeOk()
    {
        $this->theResponseCodeShouldBe(200);
    }

    /**
     * Checks that response Json.
     *
     * @throws \RuntimeException
     *
     * @Then /^(?:the )?response should be JSON$/
     */
    public function theResponseShouldBeJson()
    {
        $this->theResponseHeaderShouldBe('content-type', 'application/json');
    }

    /**
     * Checks that response header have valid header and value.
     *
     * @param string $header
     * @param string $value
     *
     * @throws \RuntimeException
     *
     * @Then /^(?:the )?response header "([^"]+)" should be "([^"]+)"$/
     */
    public function theResponseHeaderShouldBe($header, $value)
    {
        if (!$this->response->getHeader($header)) {
            throw new \RuntimeException(sprintf("Can't find header with name: %s", $header));
        }

        Assertions::assertEquals($value, $this->response->getHeader($header)[0]);
    }

    /**
     * Debug method to examine last response.
     */
    public function printResponse()
    {
        $response = $this->response;

        echo sprintf(
            "%s %s => %d:\n%s",
            $this->request->getMethod(),
            $this->request->getUri(),
            $response->getStatusCode(),
            json_encode(json_decode($response->getBody()), JSON_PRETTY_PRINT)
        );
    }

    /**
     * Checks that response body contains specific text.
     *
     * @param string $text
     *
     * @Then /^(?:the )?response should contain '([^']+)'$/
     */
    public function theResponseShouldContain2($text)
    {
        parent::theResponseShouldContain($text);
    }
}
