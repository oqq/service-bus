<?php
/**
 * This file is part of the prooph/service-bus.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Prooph\ServiceBus\Exception;

use Prooph\Common\Event\ActionEvent;

/**
 * Class MessageDispatchException
 *
 * @package Prooph\ServiceBus\Exception
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class MessageDispatchException extends RuntimeException
{
    /**
     * @var ActionEvent
     */
    protected $actionEvent;

    /**
     * @param ActionEvent $actionEvent
     * @param \Exception $previousException
     * @return MessageDispatchException
     */
    public static function failed(ActionEvent $actionEvent, \Exception $previousException = null)
    {
        $ex = new static(
            sprintf(
                "Message dispatch failed during %s phase.%s",
                $actionEvent->getName(),
                (null === $previousException) ? '' : ' Error: ' . $previousException->getMessage()
            ),
            422,
            $previousException
        );

        $ex->setFailedDispatch($actionEvent);

        return $ex;
    }

    /**
     * @return ActionEvent
     */
    public function getFailedDispatchEvent()
    {
        return $this->actionEvent;
    }

    protected function setFailedDispatch(ActionEvent $actionEvent)
    {
        $this->actionEvent = $actionEvent;
    }
}
