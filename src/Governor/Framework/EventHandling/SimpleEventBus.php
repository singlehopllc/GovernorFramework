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

namespace Governor\Framework\EventHandling;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerAwareInterface;
use Governor\Framework\Common\Logging\NullLogger;

/**
 * Simple in memory event bus implementation.
 *
 * @author    "David Kalosi" <david.kalosi@gmail.com>  
 * @license   <a href="http://www.opensource.org/licenses/mit-license.php">MIT License</a> 
 */
class SimpleEventBus implements EventBusInterface, LoggerAwareInterface
{

    /**
     * @var \SplObjectStorage
     */
    private $listeners;

    /**
     * @var LoggerInterface 
     */
    private $logger;

    function __construct()
    {
        $this->listeners = new \SplObjectStorage();
        $this->logger = new NullLogger();
    }

    public function publish(array $events)
    {
        foreach ($events as $event) {
            $this->listeners->rewind();

            while ($this->listeners->valid()) {
                $listener = $this->listeners->current();

                $this->logger->debug("Dispatching Event {event} to EventListener {listener}",
                        array("event" => $event->getPayloadType(), "listener" => $this->getClassName($listener)));
                $listener->handle($event);

                $this->listeners->next();
            }
        }
    }

    public function subscribe(EventListenerInterface $eventListener)
    {
        if (!$this->listeners->contains($eventListener)) {
            $this->listeners->attach($eventListener);
        }
    }

    public function unsubscribe(EventListenerInterface $eventListener)
    {
        if ($this->listeners->contains($eventListener)) {
            $this->listeners->detach($eventListener);
        }
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    private function getClassName(EventListenerInterface $eventListener)
    {
        if ($eventListener instanceof EventListenerProxyInterface) {
            $listenerType = $eventListener->getTargetType();
        } else {
            $listenerType = get_class($eventListener);
        }

        return $listenerType;
    }

}
