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

namespace Governor\Framework\EventHandling\Amqp;

use Governor\Framework\Domain\EventMessageInterface;

/**
 * Interface toward a mechanism that provides the AMQP Routing Key for a given EventMessage. AMQP Message Brokers use
 * the routing key to decide which Queues will receive a copy of eah message, depending on the type of Exchange used.
 */
interface RoutingKeyResolverInterface
{

    /**
     * Returns the Routing Key to use when sending the given <code>eventMessage</code> to the Message Broker.
     *
     * @param EventMessageInterface $eventMessage The EventMessage to resolve the routing key for
     * @return string The routing key for the event message.
     */
    public function resolveRoutingKey(EventMessageInterface $eventMessage);
}
