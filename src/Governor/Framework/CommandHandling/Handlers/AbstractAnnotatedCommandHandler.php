<?php

/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * The software is based on the Axon Framework project which is
 * licensed under the Apache 2.0 license. For more information on the Axon Framework
 * see <http://www.axonframework.org/>.
 * 
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.governor-framework.org/>.
 */

namespace Governor\Framework\CommandHandling\Handlers;

use Doctrine\Common\Annotations\AnnotationReader;
use Governor\Framework\Common\ParameterResolverFactoryInterface;
use Governor\Framework\Common\PayloadParameterResolver;
use Governor\Framework\Domain\MessageInterface;
use Governor\Framework\CommandHandling\CommandHandlerInterface;

/**
 * Description of AbstractAnnotatedCommandHandler
 *
 * @author david
 */
abstract class AbstractAnnotatedCommandHandler implements CommandHandlerInterface
{

    /**
     * @var \ReflectionMethod 
     */
    private $method;

    /**
     * @var array
     */
    private $annotations;

    /**
     * @var ParameterResolverFactoryInterface
     */
    private $parameterResolver;

    function __construct($className, $methodName,
            ParameterResolverFactoryInterface $parameterResolver)
    {        
        $this->method = new \ReflectionMethod($className, $methodName);

        $reader = new AnnotationReader();
        
        $this->annotations = $reader->getMethodAnnotations($this->method);
        $this->parameterResolver = $parameterResolver;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getAnnotations()
    {
        return $this->annotations;
    }

    public function getParameterResolver()
    {
        return $this->parameterResolver;
    }

    protected function resolveArguments(MessageInterface $message)
    {
        $arguments = array();
        $parameters = $this->method->getParameters();
                
        for ($cc = 0; $cc < count($parameters); $cc++) {            
            if ($cc === 0) {
                $resolver = new PayloadParameterResolver($message->getPayloadType());
                $arguments[] = $resolver->resolveParameterValue($message);
            } else {                
                $resolver = $this->parameterResolver->createInstance($this->annotations,
                        $parameters[$cc]);
                                                
                $arguments[] = $resolver->resolveParameterValue($message);                
            }
        }

        return $arguments;
    }

}
