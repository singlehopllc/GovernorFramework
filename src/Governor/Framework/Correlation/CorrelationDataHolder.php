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

namespace Governor\Framework\Correlation;

/**
 * Description of CorrelationDataHolder
 *
 * @author david
 */
final class CorrelationDataHolder
{
    
    /**     
     * @var array
     */
    private static $correlationData = array();

    private function __construct()
    {
        
    }

    /**
     * Returns the correlation data attached to the current thread. If no correlation data is available, this method
     * returns an empty Map.
     *
     * @return the correlation data attached to the current process
     */
    public static function getCorrelationData()
    {
        return self::$correlationData;
    }

    /**
     * Attaches the given <code>data</code> as correlation data to the current process. Any data already attached is
     * replaced with given <code>data</code>.
     *
     * @param array $data the correlation data to attach to the current thread
     */
    public static function setCorrelationData(array $data)
    {
        self::$correlationData = $data;
    }

    /**
     * Clears the correlation data from the current process.
     */
    public static function clear()
    {
        self::$correlationData = array();
    }

}
